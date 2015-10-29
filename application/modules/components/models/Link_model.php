<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Link_model extends CI_Model
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
        $data['url']=$row->content;
        $data['title']=htmlspecialchars($row->displayname);
        $settings = json_decode($row->settings);
        $data['class']=$settings->class;
        $data['target']=$settings->target;
        return $data;
    }

    function get_edit_data($id)
    {
        $query = $this->db->get_where('contents', array('id' => $id));
        if ($query->num_rows() > 0) {
            $row = $query->row();
        } else {
            return false;
        }
        $data=[];
        $data['url']=$row->content;
        $data['title']=htmlspecialchars($row->displayname);
        $settings = json_decode($row->settings);
        $data['class']=$settings->class;
        $data['target']= isset($settings->target) ? $settings->target : '';
        return $data;
    }

    function get_new_data()
    {
        $data['url']='';
        $data['title']='';
        $data['class']='';
        $data['target']= '';
        return $data;
    }
}