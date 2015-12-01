<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Group_handler extends CI_Model
{
    function get_group_list()
    {
        $query = $this->db->get('admin_groups');
        $grouplist=[];
        foreach ($query->result() as $row)
        {
            $group=[];
            $group['name']=$row->name;
            $group['active']=(boolean)$row->active;
            $group['description']=$row->fullname;

            $group['permissions']=$this->get_permissions_string($row->code);
            $group['users']= $this->get_group_users($row->name);
            $grouplist[]=$group;
        }
        return $grouplist;
    }

    function get_permissions_string($code)
    {
        $code = json_decode($code);
        $output="";
        foreach($code->allowed_interfaces as $interface)
        {
            $output.="<span class=\"label label-info\">$interface</span> ";
        }
        return $output;
    }

    function get_group_users($group)
    {
        $query = $this->db->get_where('admin_users',array('group' => $group));
        $users = [];
        foreach($query->result() as $row)
        {
            $users[]=$row->username;
        }
        return $users;
    }

    function get_group_data($id)
    {
        $query = $this->db->get_where('admin_groups', array('name' => $id));
        $row = $query->row();
        if (isset($row))
        {
            $data['description'] = $row->fullname;
            $data['active'] = (bool)$row->active;
            $processed_code = json_decode($row->code);
            $data['allowed_interfaces_csv'] = implode(',', $processed_code->allowed_interfaces);
            $data['use_content_filter'] = $processed_code->use_content_filter;
            $data['content_filter_mode'] = $processed_code->content_filter_mode;
            $data['content_filter_directives'] = implode(',', $processed_code->content_filter_directives);
        }
        return $data;
    }
}