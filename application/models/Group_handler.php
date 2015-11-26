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
}