<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Group_handler extends CI_Model
{
    function get_admin_group_list()
    {
        $query = $this->db->get('admin_groups');
        $grouplist=[];
        foreach ($query->result() as $row)
        {
            $group=[];
            $group['name']=$row->name;
            $group['active']=(boolean)$row->active;
            $group['description'] = $row->full_name;
            $code = json_decode($row->code);
            $group['permissions'] = $code->allowed_interfaces;
            $group['users'] = $this->get_admin_group_users($row->name);
            $group['ldap_groups'] = explode(',', $row->ldap_groups);
            $grouplist[]=$group;
        }
        return $grouplist;
    }

    function get_admin_group_users($group)
    {
        $query = $this->db->get_where('users', array('admin_group' => $group));
        $users = [];
        foreach ($query->result() as $row)
        {
            $users[] = $row->username;
        }
        return $users;
    }

    function get_frontend_group_list()
    {
        $query = $this->db->get('frontend_groups');
        $grouplist = [];
        foreach ($query->result() as $row) {
            $group = [];
            $group['name'] = $row->name;
            $group['active'] = (boolean)$row->active;
            $group['description'] = $row->full_name;
            $code = json_decode($row->code);
            $group['permissions'] = $code->allowed_permissions;
            $group['users'] = $this->get_frontend_group_users($row->name);
            $group['ldap_groups'] = explode(',', $row->ldap_groups);
            $grouplist[] = $group;
        }
        return $grouplist;
    }

    function get_frontend_group_users($group)
    {
        $query = $this->db->get_where('users', array('frontend_group' => $group));
        $users = [];
        foreach($query->result() as $row)
        {
            $users[]=$row->username;
        }
        return $users;
    }


    function get_admin_group_data($group)
    {
        $query = $this->db->get_where('admin_groups', array('name' => $group));
        $row = $query->row();
        if (isset($row))
        {
            $data['description'] = $row->full_name;
            $processed_code = json_decode($row->code);
            $data['allowed_interfaces_csv'] = implode(',', $processed_code->allowed_interfaces);
            $data['use_content_filter'] = $processed_code->use_content_filter;
            $data['content_filter_mode'] = $processed_code->content_filter_mode;
            $data['content_filter_directives'] = implode(',', $processed_code->content_filter_directives);
            $data['ldap_linked_groups'] = json_decode($row->ldap_groups, true)['ldap_groups'];
        }
        return $data;
    }

    function get_frontend_group_data($group)
    {
        $query = $this->db->get_where('frontend_groups', array('name' => $group));
        $row = $query->row();
        if (isset($row)) {
            $data['description'] = $row->full_name;
            $processed_code = json_decode($row->code);
            $data['allowed_permissions_csv'] = implode(',', $processed_code->allowed_permissions);
            $data['ldap_linked_groups'] = json_decode($row->ldap_groups, true)['ldap_groups'];
        }
        return $data;
    }

    function save($name, $type, $description, $code, $ldap_groups)
    {
        $this->load->library('validation');
        if (!$this->validation->check_json($code))
        {
            return false;
        }
        if (!$this->validation->check_json($ldap_groups)) {
            return false;
        }
        $data = array(
            'full_name' => $description,
            'code' => $code,
            'ldap_groups' => $ldap_groups
        );

        $table = $type == 'admin' ? 'admin_groups' : 'frontend_groups';
        //create a new content if the id does not exists
        $query = $this->db->get_where($table, array('name' => $name));
        if ($query->num_rows() > 0)
        {
            $this->db->where('name', $name);
            return $this->db->update($table, $data);
        }
        else
        {
            $data['name'] = $name;
            $data['active'] = 0;
            return $this->db->insert($table, $data);
        }
    }

    /*
    function delete_groups($groups)
    {
        $this->db->where_in('name',$groups);
        return $this->db->delete('admin_groups');
    }

    function enable_groups($groups)
    {
        $this->db->where_in('name',$groups);
        return $this->db->update('admin_groups', array('active' => 1));
    }

    function disable_groups($groups)
    {
        $this->db->where_in('name',$groups);
        return $this->db->update('admin_groups', array('active' => 0));
    }
    */

    private function parse_group($group)
    {
        $query = $this->db->get_where('admin_groups', array('name' => $group));
        if ($query->num_rows() > 0) {
            $row = $query->row();
            if ($row->active == 1) {
                return json_decode($row->code);
            }
        }
        return false;
    }

    function check_interface_permissions($group, $interface)
    {
        if ($group === 'super-users' or $interface === 'dashboard') {
            return true;
        } else {
            $group = $this->parse_group($group);
            if ($group === false) {
                return false;
            }
            return in_array($interface, $group->allowed_interfaces);
        }
    }

    function check_content_filter($group)
    {
        if ($group === 'super-users') {
            return false;
        } else {
            $source = $this->parse_group($group);
            if ($source->use_content_filter) {
                $data['mode'] = $source->content_filter_mode;
                $data['directives'] = $source->content_filter_directives;
                return $data;
            } else {
                return false;
            }

        }
    }
}