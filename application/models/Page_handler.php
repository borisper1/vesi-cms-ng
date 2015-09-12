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
        $data=array(
            'name' => $name,
            'container' => $container,
            'title' => $title,
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
            $data['id']=$id;
            return $this->db->insert('pages', $data);
        }
    }

}