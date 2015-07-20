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
        $page->title = $row->title;
        $descriptor=json_decode($row->code);
        $page->layout=$descriptor->layout;
        $page->elements = $descriptor->elements;
        if(strpos($descriptor->layout,'sidebar')!==false)
        {
            $page->sidebar_elements = $descriptor->sidebar_elements;
        }
        $page->container_class= $this->db_config->get('style','use_fluid_containers') ? 'container-fluid' : 'container';
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
}