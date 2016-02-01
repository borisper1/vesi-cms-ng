<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{
    function get_data()
    {
        $data['pages'] = $this->db->count_all('pages');
        $data['contents'] = $this->db->count_all('contents');
        $this->db->where('new', 1);
        $data['unread_errors'] = $this->db->count_all_results('error_log');
        return $data;
    }
}