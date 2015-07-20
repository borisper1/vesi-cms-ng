<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_handler extends CI_Model
{

    public function get_menu_array($id,$container,$page)
    {
        $query=$this->db->get_where('menus',array('id'=> $id));
        if ($query->num_rows() > 0)
        {
            $row = $query->row();
        }
        else
        {
            return false;
        }
        $structure=json_decode($row->content);
        $submenus=$structure->items;
        $menu=[];
        foreach($submenus as &$submenu)
        {
            $submenu_a=[];
            $submenu_a['type']=$submenu->type;
            if($submenu->type=='dropdown')
            {
                $submenu_a['title']=$submenu->title;
                $submenu_a['active']=$submenu->container===$container ? true : false;
                $submenu_a['container']=$submenu->container;
                $submenu_a['items']=[];
                foreach($submenu->items as &$item)
                {
                    $items_a=[];
                    $items_a['title']=$item->title;
                    $items_a['link']=site_url($submenu->container.'/'.$item->page);
                    $items_a['active']=$submenu_a['active'] ? ($item->page===$page ? true : false) : false;
                    array_push($submenu_a['items'],$items_a);
                }
            }
            elseif($submenu->type=='link')
            {
                $submenu_a['title']=$submenu->title;
                $submenu_a['link']=site_url($submenu->container.'/'.$submenu->page);
                $submenu_a['active']=($submenu->container===$container and $submenu->page===$page) ? true : false;
            }
            array_push($menu,$submenu_a);
        }
        $class = $this->db_config->get('style','menu_class');
        return array('main_menu' => $menu, 'class' => $class);
    }

    public function get_menu_edit_array($id){
        $query=$this->db->get_where('menus',array('id'=> $id));
        if ($query->num_rows() > 0)
        {
            $row = $query->row();
        }
        else
        {
            return false;
        }
        $structure=json_decode($row->content);
        $submenus=$structure->items;
        $menu=[];
        foreach($submenus as &$submenu)
        {
            $submenu_a=[];
            $submenu_a['type']=$submenu->type;
            if($submenu->type=='dropdown')
            {
                $submenu_a['title']=$submenu->title;
                $submenu_a['container']=$submenu->container;
                $submenu_a['items']=[];
                foreach($submenu->items as &$item)
                {
                    $items_a=[];
                    $items_a['title']=$item->title;
                    $items_a['page']=$item->page;
                    array_push($submenu_a['items'],$items_a);
                }
            }
            elseif($submenu->type=='link')
            {
                $submenu_a['title']=$submenu->title;
                $submenu_a['container']=$submenu->container;
                $submenu_a['page']=$submenu->page;
            }
            array_push($menu,$submenu_a);
        }
        return array('main_menu' => $menu);
    }

    function get_main_menu_id(){
        $query=$this->db->get_where('menus',array('class'=> 'main'));
        if ($query->num_rows() > 0)
        {
            $row = $query->row();
            return $row->id;
        }
        else
        {
            return false;
        }
    }
}