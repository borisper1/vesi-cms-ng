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
            $group['active']=intval($row->active);
            $group['fullname']=$row->fullname;
            $grouplist[]=$group;
        }
        return $grouplist;
    }
}