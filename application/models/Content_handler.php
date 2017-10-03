<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Content_handler extends CI_Model
{
    function get_symbol_array($id)
    {
        $query = $this->db->get_where('contents', array('id' => $id));
        $row = $query->row();
        if (isset($row))
        {
            $data['exists']=true;
            $data['id']=$id;
            $data['type']=$row->type;
            if($row->type !=='html-field')
            {
                $data['preview'] = $row->displayname != '' ? $row->displayname : substr(strip_tags($row->content), 0, 35) . '&hellip;';
            }
            else
            {
                $data['preview'] = substr(htmlspecialchars($row->content), 0, 35) . '&hellip;';
            }
        }
        else
        {
            $data['exists']=false;
            $data['id']=$id;
            $data['type']='?';
            $data['preview']='';
        }
        return $data;
    }

    function are_orphans($id)
    {
        $output=[];
        foreach($id as $this_id)
        {
            //May produce out of sync error (will indicate it is an orphan even if it has just been added in the page via js (must use js checking for this)
            $this->db->like('code', $this_id);
            $query = $this->db->get('pages');
            if($query->num_rows() <= 1)
            {
                $this->db->select('id');
                $query = $this->db->get_where('contents',array('id'=>$this_id));
                if($query->num_rows() > 0)
                {
                    $output[]=$this_id;
                }
            }
        }
        return $output;
    }

    function delete_contents($id_array)
    {
        $this->db->where_in('id', $id_array);
        return $this->db->delete('contents');
    }

    function get_contents_list()
    {
        $query = $this->db->get('contents');
        $contents=[];
        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
            {
                $content['id'] = $row->id;
                $content['type'] = $row->type;
                if($row->type !=='html-field')
                {
                    $content['preview']=$row->displayname!='' ? $row->displayname : substr(strip_tags($row->content), 0, 50).'&hellip;';
                }
                else
                {
                    $content['preview']=substr(htmlspecialchars($row->content), 0, 50).'...';
                }
				$dec_settings = $row->settings != '' ? json_decode($row->settings, true): [];
                $content['restricted'] = ((boolean)$this->db_config->get('authentication', 'enable_content_permissions') and isset($dec_settings['allowed_groups']));
                array_push($contents, $content);
            }
            return $contents;
        }
        else
        {
            return [];
        }
    }

    function get_contents_list_with_usages($cfilter = false)
    {
        $contents = $this->get_contents_list();
        foreach($contents as &$content)
        {
            $content['usages']= $this->find_usages($content['id']);
        }
        if($cfilter!==false){
            //Separate directives in container level and page level.
            $directives_containers =[];
            $directives_pages = [];
            foreach($cfilter['directives'] as &$directive)
            {
                if(strpos($directive, '::')===false)
                {
                    $directives_containers[]=$directive;
                }
                else
                {
                    $directives_pages[]=$directive;
                }
            }
            foreach($contents as $key => &$content)
            {
                $containers=[];
                $pages=[];
                foreach($content['usages'] as &$usage)
                {
                    $containers[]=$usage['container'];
                    $pages[]=$usage['container'].'::'.$usage['name'];
                }
                if(array_intersect($containers, $directives_containers)!=[] or array_intersect($pages, $directives_pages)!=[])
                {
                    if($cfilter['mode']==='blacklist')
                    {
                        unset($contents[$key]);
                    }
                }
                else
                {
                    if($cfilter['mode']==='whitelist')
                    {
                        unset($contents[$key]);
                    }
                }
            }
        }
        return $contents;
    }

    function find_usages($id)
    {
        $this->db->like('code', $id);
        $query = $this->db->get('pages');
        $usages=[];
        foreach ($query->result() as $row)
        {
            $usages[]=array('id'=> $row->id, 'container' => $row->container, 'name' => $row->name);
        }
        return $usages;
    }

    function get_content_data($id)
    {
        $query = $this->db->get_where('contents', array('id' => $id));
        if ($query->num_rows() > 0)
        {
            $row = $query->row();
            $content['id'] = $row->id;
            $content['type'] = $row->type;
            $content['preview'] = $row->displayname!='' ? $row->displayname : substr(trim(strip_tags($row->content)), 0, 25).'&hellip;';
            $content['preview'] = trim($content['preview'])=='&hellip;' ? substr(htmlspecialchars($row->content), 0, 25).'&hellip;' : $content['preview'];
			$dec_settings = $row->settings != '' ? json_decode($row->settings, true): [];
			$content['restricted_access'] = ((boolean)$this->db_config->get('authentication', 'enable_content_permissions') and isset($dec_settings['allowed_groups']));
			$content['allowed_groups'] = $content['restricted_access'] ? $dec_settings['allowed_groups'] : [];
			$content['restriction_mode'] = isset($dec_settings['restriction_mode']) ? $dec_settings['restriction_mode'] : 'standard';
            return $content;
        }
        else
        {
            return false;
        }
    }

    function save($id, $type, $content, $settings, $displayname)
    {
        $component_info = $this->modules_handler->get_component_info($type);
        $this->load->library('validation');
        $valid = false;
        if ($component_info->save_type=='html')
        {
            $content = $this->validation->filter_html($content, $component_info->allow_iframe);
            $valid = true;
        }
        elseif($component_info->save_type=='json')
        {
            $valid = $this->validation->check_json($content);
        }
        elseif($component_info->save_type=='path')
        {
            $valid = $this->validation->check_path($content);
        }
        elseif($component_info->save_type=='url')
        {
            $valid = $this->validation->check_url($content);
        }
        if(!$valid)
        {
            return 2;
        }
        $data = array(
            'type' => strip_tags($type),
            'content'=> $content
        );
        if($component_info->has_options or (boolean)$this->db_config->get('authentication', 'enable_content_permissions')) //Setting are always used for permission controls
        {
        	if($settings != '')
			{
				if(! $this->validation->check_json($settings)) {
					echo '500-2 - Settings input is invalid';
					return 3;
				}
			}
			$data['settings'] = $settings;
        }
        if($component_info->has_displayname)
        {
            $data['displayname'] = strip_tags($displayname);
        }
        //create a new content if the id does not exists
        $query=$this->db->get_where('contents',array('id'=> $id));
        if ($query->num_rows() > 0)
        {
            $this->db->where('id', $id);
            return $this->db->update('contents', $data) ? 0 : 1;
        }
        else
        {
            $data['id'] = strip_tags($id);
            return $this->db->insert('contents', $data) ? 0 : 1;
        }
    }

    function filter_all()
    {
        $this->load->library('validation');
        $query = $this->db->get('contents');
        $contents=[];
        foreach ($query->result() as $row)
        {
            $component_info = $this->modules_handler->get_component_info($row->type);
            if ($component_info and $component_info->save_type == 'html') {
                $content['id'] = $row->id;
                $content['type'] = $row->type;
                $content['filtered_content'] = $this->validation->filter_html($row->content, $component_info->allow_iframe);
                $content['old_digest'] = md5($row->content);
                $content['digest'] = md5($content['filtered_content']);
                $content['changed'] = $content['old_digest'] !== $content['digest'];
                if ($content['changed']) {
                    $this->db->where('id', $content['id']);
                    $content['update_result'] = $this->db->update('contents', array('content' => $content['filtered_content']));
                    array_push($contents, $content);
                }
            }
        }
        return $contents;
    }

    function rebase_website($mode, $url)
    {
        $this->load->library('validation');
        $query = $this->db->get('contents');
        $contents=[];
        foreach ($query->result() as $row)
        {
            $component_info = $this->modules_handler->get_component_info($row->type);
            if ($component_info and $component_info->save_type == 'html') {
                $content['id'] = $row->id;
                $content['type'] = $row->type;
                $content['old_digest'] = md5($row->content);
                $content['filtered_content'] = $row->content;
                if($mode==='after')
                {
                    $content['filtered_content'] = str_replace('href="'.$url, 'href="'.base_url(), $content['filtered_content']);
                    $content['filtered_content'] = str_replace('src="'.$url, 'src="'.base_url(), $content['filtered_content']);
                }
                $content['filtered_content'] = $this->validation->filter_html($content['filtered_content'], $component_info->allow_iframe);
                if($mode==='before')
                {
                    $content['filtered_content'] = str_replace('href="'.base_url(), 'href="'.$url, $content['filtered_content']);
                    $content['filtered_content'] = str_replace('src="'.base_url(), 'src="'.$url, $content['filtered_content']);
                }
                $content['digest'] = md5($content['filtered_content']);
                $content['changed'] = $content['old_digest'] !== $content['digest'];
                if ($content['changed']) {
                    $this->db->where('id', $content['id']);
                    $content['update_result'] = $this->db->update('contents', array('content' => $content['filtered_content']));
                    array_push($contents, $content);
                }
            }
            elseif ($component_info and $component_info->save_type == 'url')
            {
                $content['id'] = $row->id;
                $content['type'] = $row->type;
                $content['old_digest'] = md5($row->content);
                $content['filtered_content'] = $row->content;
                if ($mode === 'after') {
                    $content['filtered_content'] = str_replace($url, base_url(), $content['filtered_content']);
                } elseif ($mode === 'before') {
                    $content['filtered_content'] = str_replace(base_url(), $url, $content['filtered_content']);
                }
                $content['digest'] = md5($content['filtered_content']);
                $content['changed'] = $content['old_digest'] !== $content['digest'];
                if ($content['changed']) {
                    $this->db->where('id', $content['id']);
                    $content['update_result'] = $this->db->update('contents', array('content' => $content['filtered_content']));
                    array_push($contents, $content);
                }
            }
        }
        return $contents;
    }

    function update_lock($id)
    {
        $lock = [];
        $lock['user'] = $this->session->username;
        $lock['time'] = time();
        $lock_text = json_encode($lock);
        $this->db->where('id', $id);
        return $this->db->update('contents', array('lock' => $lock_text));
    }

    function check_lock($id)
    {
        $query = $this->db->get_where('contents', array('id' => $id));
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $lock_struct = json_decode($row->lock, true);
            if (time() < ($lock_struct['time'] + 95) and $lock_struct['user'] !== $this->session->username) {
                return array('result' => true, 'user' => $lock_struct['user']);
            }
        }
        return array('result' => false, 'user' => '');
    }
}