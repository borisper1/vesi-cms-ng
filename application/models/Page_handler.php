<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page_handler extends CI_Model
{
    public function get_page_obj($id){
        $query=$this->db->get_where('pages',array('id'=> $id));
        if ($query->num_rows() > 0)
        {
            $row = $query->row();
        }
        else
        {
            return false;
        }
        $page = new stdClass();
        $page->id = $id;
        $page->container = $row->container;
        $page->page_name = $row->name;

        $page->title = $row->title;
        $descriptor=json_decode($row->code);
        $page->restrict_access = isset($descriptor->allowed_groups);
        $page->allowed_groups = $page->restrict_access ? $descriptor->allowed_groups : [];
        $page->layout=$descriptor->layout;
        $page->elements = $descriptor->elements;
        if(strpos($descriptor->layout,'sidebar')!==false)
        {
            $page->sidebar_elements = $descriptor->sidebar_elements;
        }
        return $page;
    }

    public function get_true_page_id($container,$page){
        $this->db->select('id, container_redirect');
        $query=$this->db->get_where('pages',array('container'=> $container, 'name' => $page));
        if ($query->num_rows() > 0)
        {
            $row = $query->row();
        }
        else
        {
            return false;
        }
        if(isset($row->container_redirect) and $row->container_redirect!="")
        {
            $container=$row->container_redirect;
            $this->db->select('id, container_redirect');
            $query=$this->db->get_where('pages',array('container'=> $container, 'name' => $page));
            if ($query->num_rows() > 0)
            {
                $row = $query->row();
            }
            else
            {
                return false;
            }
        }
        return $row->id;
    }

    public function get_containers_list(){
        $this->db->select('container');
        $this->db->distinct();
        $query=$this->db->get('pages');
        $containers=[];
        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
            {
                array_push($containers,$row->container);
            }
            return $containers;
        }
        else
        {
            return false;
        }
    }

    public function get_pages_in_container($container)
    {
        $this->db->select('name');
        $query=$this->db->get_where('pages', array('container' =>  $container));
        $pages=[];
        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
            {
                array_push($pages,$row->name);
            }
            return $pages;
        }
        else
        {
            return false;
        }
    }

    public function get_page_status($container, $page)
    {
        $query=$this->db->get_where('pages', array('container' =>  $container, 'name' => $page));
        if ($query->num_rows() > 0)
        {
            $row = $query->row();
            $response=[];
            $response['redirect'] = $row->container_redirect=='' ? false : $row->container_redirect;
            return $response;
        }
        else
        {
            return false;
        }
    }

    public function save($id, $name, $container, $title, $json)
    {
        $this->load->library('validation');
        if (!$this->validation->check_json($json))
        {
            return false;
        }
        $data=array(
            'name' => strip_tags($name),
            'container' => strip_tags($container),
            'title' => strip_tags($title),
            'code' => $json,
        );
        $query=$this->db->get_where('pages',array('id'=> $id));
        if ($query->num_rows() > 0)
        {
            $this->db->where('id', $id);
            return $this->db->update('pages', $data);
        }
        else
        {
            $data['id'] = strip_tags($id);
            return $this->db->insert('pages', $data);
        }
    }

    function get_pages_container_list($container)
    {
        $query=$this->db->get_where('pages', array('container' =>  $container));
        $pages=[];
        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
            {
                $data_array['id'] = $row->id;
                $data_array['name'] = $row->name;
                $data_array['container_redirect'] = $row->container_redirect;
                if($row->container_redirect!='')
                {
                    $query2=$this->db->get_where('pages', array('container' => $row->container_redirect, 'name' => $row->name));
                    if ($query2->num_rows() > 0)
                    {
                        $data_array['title'] = $query2->row()->title;
                    }
                    else
                    {
                        $data_array['title'] = '<span class="text-danger"><i fa class="fa fa-exclamation-triangle"></i> Destinazione inesistente</span>';
                    }
                }
                else
                {
                    $data_array['title'] = $row->title;
                    $json_code = json_decode($row->code);
                    $data_array['layout'] = $json_code->layout;
                    $data_array['restricted'] = isset($json_code->allowed_groups);
                }
                $data_array['tags'] = $row->tags;
                $data_array['home'] = ($row->container.'::'.$row->name)===$this->db_config->get('general','home_page');
                array_push($pages,$data_array);
            }
            return $pages;
        }
        else
        {
            return false;
        }
    }

    function get_page_contents($id)
    {
        $query = $this->db->get_where('pages', array('id' => $id));
        if ($query->num_rows() > 0)
        {
            $row = $query->row();
            $structure = json_decode($row->code);
            $ids = $this->get_section_ids($structure->elements);
            return $ids;
        }
        else
        {
            return false;
        }
    }

    protected function get_section_ids($structure)
    {
        $ids = [];
        foreach ($structure as $element) {
            if ($element->type === 'content') {
                array_push($ids, $element->id);
            }
            else
            {
                if (in_array($element->type, $this->modules_handler->installed_structures)) {
                    foreach ($element->views as $view) {
                        $ids = array_merge($ids, $this->get_section_ids($view->elements));
                    }
                }
            }
        }
        return $ids;
    }

    function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('pages');
    }

    function set_tags($id, $tag_string)
    {
        $this->db->where('id', $id);
        return $this->db->update('pages', array('tags' => $tag_string));
    }

    function set_home($id)
    {
        $this->db->select('name, container');
        $query = $this->db->get_where('pages', array('id' => $id));
        if ($query->num_rows() > 0)
        {
            $row = $query->row();
            $this->db_config->set('general', 'home_page', $row->container.'::'.$row->name);
            $this->db_config->save();
            return true;
        }
        else
        {
            return false;
        }
    }

    function new_redirect($container,$target,$page)
    {
        $data = array(
            'id' => uniqid(),
            'container' => $container,
            'name' => $page,
            'container_redirect' => $target
        );
        return $this->db->insert('pages', $data);
    }

    function edit_redirect($id,$container,$target,$page)
    {
        $data = array(
            'container' => $container,
            'name' => $page,
            'container_redirect' => $target
        );
        $this->db->where('id', $id);
        return $this->db->update('pages', $data);
    }

    function update_lock($id)
    {
        $lock = [];
        $lock['user'] = $this->session->username;
        $lock['time'] = time();
        $lock_text = json_encode($lock);
        $this->db->where('id', $id);
        return $this->db->update('pages', array('lock' => $lock_text));
    }

    function check_lock($id)
    {
        $query = $this->db->get_where('pages', array('id' => $id));
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $lock_struct = json_decode($row->lock, true);
            if($lock_struct != null) {
                if (time() < ($lock_struct['time'] + 95) and $lock_struct['user'] !== $this->session->username) {
                    return array('result' => true, 'user' => $lock_struct['user']);
                }
            }
        }
        return array('result' => false, 'user' => '');
    }
}