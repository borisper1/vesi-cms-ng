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
                $data['preview']=$row->displayname!='' ? $row->displayname : substr(strip_tags($row->content), 0, 30).'&hellip;';
            }
            else
            {
                $data['preview']=substr(htmlspecialchars($row->content), 0, 30).'...';
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
                array_push($contents, $content);
            }
            return $contents;
        }
        else
        {
            return false;
        }
    }

    function get_contents_list_with_usages()
    {
        $contents = $this->get_contents_list();
        foreach($contents as &$content)
        {
            $content['usages']= $this->find_usages($content['id']);
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
            return $content;
        }
        else;
        {
            return false;
        }
    }

    function get_component_info($type)
    {
        $output = false;
        $modules=json_decode(file_get_contents(APPPATH.'config/modules.json'));
        foreach($modules->components as $component){
            if($component->name == $type){
                $output = $component;
            }
        }
        return $output;
    }

    function save($id, $type, $content, $settings, $displayname)
    {
        $component_info = $this->get_component_info($type);
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
            'type' => $type,
            'content'=> $content
        );
        if($component_info->has_options)
        {
            if(! $this->validation->check_json($settings)) {
                echo '500-2 - Settings input is invalid';
                return 3;
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
            $data['id'] = uniqid();
            return $this->db->insert('contents', $data) ? 0 : 1;
        }
    }
}