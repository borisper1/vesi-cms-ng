<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Popover_model extends CI_Model
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
        $data['content']=htmlspecialchars($row->content);
        $data['name']=htmlspecialchars($row->displayname);
        $settings = json_decode($row->settings);
        $data['class']=$settings->class;
        $data['html']=$settings->html ? "true" : "false";
        $data['placement']=$settings->placement;
        $data['title']=$settings->title;
        $data['linebreak']=$settings->linebreak;
        $data['dismissable']=$settings->dismissable;
        return $data;
    }
}