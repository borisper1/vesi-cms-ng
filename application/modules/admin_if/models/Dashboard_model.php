<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{
    function get_data()
    {
        $data['pages'] = $this->db->count_all('pages');
        $data['contents'] = $this->db->count_all('contents');
        return $data;
    }
}