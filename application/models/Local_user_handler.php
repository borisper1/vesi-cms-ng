<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Local_user_handler extends CI_Model
{
    private $username, $database_structure;

    function load_user($username)
    {
        $this->username = $username;
        $query = $this->db->get_where('users', array('username' => $username));
        if ($query->num_rows() > 0) {
            $this->database_structure = $query->row();
            return true;
        } else {
            return false;
        }
    }

    function get_auth_type()
    {
        return intval($this->database_structure->auth_method);
    }

    function check_credentials($password)
    {
        if (password_verify($password, $this->database_structure->password)) {
            // Check if a newer hashing algorithm is available or the cost has changed
            if (password_needs_rehash($this->database_structure->password, PASSWORD_DEFAULT)) {
                // If so, create a new hash, and replace the old one
                $newHash = password_hash($password, PASSWORD_DEFAULT);
                $this->db->where('username', $this->username);
                $this->db->update('users', array('password' => $newHash));
            }
            $this->db->where('username', $this->username);
            $this->db->update('users', array('failed_access' => 0, 'last_login' => date("Y-m-d H:i:s")));
            return true;
        } else {
            $this->db->where('username', $this->username);
            $this->db->update('users', array('failed_access' => $this->database_structure->failed_access + 1));
            return false;
        }
    }

    function is_active()
    {
        if (intval($this->database_structure->active) != 1) {
            return 1;
        }
        if (intval($this->database_structure->failed_access) >= 5) {
            return 2;
        }
        return 0;
    }

    function get_full_name()
    {
        return $this->database_structure->full_name;
    }

    function get_admin_group()
    {
        return (strpos($this->database_structure->admin_group, 'ldap::') === 0) ? substr($this->database_structure->admin_group, 6) : $this->database_structure->admin_group;
    }

    function get_full_user_data()
    {
        return $this->database_structure;
    }

    function get_full_user_db_list()
    {
        $query = $this->db->get('users');
        return $query->result();
    }

    function save_edit($username, $write_data)
    {
        $this->db->where('username', $username);
        return $this->db->update('users', $write_data);
    }

    function unlock_user()
    {
        if ($this->database_structure->failed_access >= 5) {
            $this->db->where('username', $this->username);
            return $this->db->update('users', array('failed_access' => 0));
        } else {
            return false;
        }
    }

    function request_password_reset()
    {

    }


}