<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pdf_view_model extends CI_Model
{
    function get_render_data($id)
    {
        $this->load->library('file_handler');
        $query = $this->db->get_where('contents', array('id' => $id));
        if ($query->num_rows() > 0) {
            $row = $query->row();
        } else {
            return false;
        }
        $data=[];
        $data['url']=base_url($row->content);
        return $data;
    }
}