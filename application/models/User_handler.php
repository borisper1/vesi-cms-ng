<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_handler extends CI_Model
{
    function check_admin_login($username,$password)
    {
        $query = $this->db->get_where('admin_users',array('username' => $username));
        if ($query->num_rows() > 0)
        {
            $row = $query->row();
        }
        else
        {
            return array(false, 'invalid_credentials');
        }

        if(intval($row->active)!==1){
            return array(false, 'user_revoked');
        }

        if(intval($row->failed_access)>=5)
        {
            return array(false, 'user_locked');
        }

        if (password_verify($password, $row->password)) {
            // Check if a newer hashing algorithm is available or the cost has changed
            if (password_needs_rehash($row->password, PASSWORD_DEFAULT)) {
                // If so, create a new hash, and replace the old one
                $newHash = password_hash($password, PASSWORD_DEFAULT);
                $this->db->where('username', $username);
                $this->db->update('admin_users', array('password' => $newHash));
            }
            $this->db->where('username', $username);
            $this->db->update('admin_users', array('failed_access' => 0));
            return array(true, $username);
        }
        else
        {
            $this->db->where('username', $username);
            $this->db->update('admin_users', array('failed_access' => $row->failed_access+1));
            return array(false, 'invalid_credentials');
        }
    }

    function check_admin_session()
    {
        if($this->session->type!=='administrative')
        {
            return false;
        }
        $query = $this->db->get_where('admin_users',array('username' => $this->session->username));
        if ($query->num_rows() > 0)
        {
            $row = $query->row();
            if(intval($row->active)===1 and intval($row->failed_access)<5)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    function get_admin_full_name()
    {
        $query = $this->db->get_where('admin_users',array('username' => $this->session->username));
        if ($query->num_rows() > 0)
        {
            $row = $query->row();
            return $row->name;
        }else{
            return false;
        }
    }

    function get_users_list()
    {
        $query = $this->db->get('admin_users');
        $userlist=[];
        foreach ($query->result() as $row)
        {
            $user=[];
            $user['username']=$row->username;
            $user['fullname']=$row->name;
            $user['email']=$row->email;
            $user['group']=$row->group; //TODO: Allow non-system names if they are implemented
            $user['status']= intval($row->active)===1 ? (intval($row->failed_access)<5 ? 1 : 2) : 0; // 0 = disabled, 1 = active, 2 = locked.
            $userlist[]=$user;
        }
        return $userlist;
    }

    function get_user_data($username)
    {
        $query = $this->db->get_where('admin_users',array('username' => $username));
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $user = [];
            $user['username'] = $row->username;
            $user['fullname'] = $row->name;
            $user['email'] = $row->email;
            $user['group'] = $row->group;
            $user['active'] = intval($row->active);
            return $user;
        }
        else
        {
            return false;
        }
    }

    function save_user($username,$fullname,$email,$password,$group,$active)
    {
        //Check if the user already exists
        $data = array(
            'group' => $group,
            'name' => $fullname,
            'email' => $email,
            'active' => $active,
            'failed_access' => 0
        );
        $query = $this->db->get_where('admin_users',array('username' => $username));
        if($query->num_rows() > 0)
        {
            //UPDATE mode
            if($password!==null)
            {
                $data['password']=password_hash($password,  PASSWORD_DEFAULT);
            }
            $this->db->where('username', $username);
            return $this->db->update('admin_users', $data);
        }
        else
        {
            //INSERT mode
            $data['password']=password_hash($password,  PASSWORD_DEFAULT);
            $data['username']=$username;
            return $this->db->insert('admin_users', $data);
        }
    }

    function delete_users($users){
        $this->db->where_in('username',$users);
        return $this->db->delete('admin_users');
    }

    function enable_users($users){
        $this->db->where_in('username',$users);
        return $this->db->update('admin_users', array('active' => 1));
    }

    function disable_users($users){
        $this->db->where_in('username',$users);
        return $this->db->update('admin_users', array('active' => 0));
    }

    private function get_group()
    {
        if($this->session->type!=='administrative')
        {
            return false;
        }
        $query = $this->db->get_where('admin_users',array('username' => $this->session->username));
        if ($query->num_rows() > 0)
        {
            $row = $query->row();
            if(intval($row->active)===1 and intval($row->failed_access)<5)
            {
                return $row->group;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    private function parse_group($group)
    {
        $query = $this->db->get_where('admin_groups',array('name' => $group));
        if ($query->num_rows() > 0)
        {
            $row = $query->row();
            if($row->active==1)
            {
                return json_decode($row->code);
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    function check_interface_permissions($interface)
    {
        $group = $this->get_group();
        if($group==='super-users' or $group===false)
        {
            return true;
        }
        else
        {
            $group = $this->parse_group($group);
            if($group===false)
            {
                return false;
            }
            return in_array($interface, $group->allowed_interfaces);
        }
    }

    function check_content_filter()
    {
        $group = $this->get_group();
        if($group==='super-users')
        {
            return false;
        }
        else
        {
            $source =  $this->parse_group($group);
            if($source->use_content_filter)
            {
                $data['mode'] = $source->content_filter_mode;
                $data['directives'] = $source->content_filter_directives;
                return $data;
            }
            else
            {
                return false;
            }

        }
    }


}