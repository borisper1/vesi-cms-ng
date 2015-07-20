<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Modal_model extends CI_Model
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
        $data['id']=$id;
        $data['content']=$row->content;
        $data['title']=htmlspecialchars($row->displayname);
        $settings = json_decode($row->settings);
        $data['trigger_class']=$settings->trigger_class;
        $data['close']=$settings->close;
        $data['large']=$settings->close;
        return $data;
    }
}