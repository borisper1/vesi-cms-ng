<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Modal_model extends CI_Model
{
    function get_render_data($id)
    {
        $query = $this->db->get_where('contents', array('id' => $id));
        if ($query->num_rows() > 0) {
            $row = $query->row();
        } else {
            return false;
        }
        $data=[];
        $data['content']=$row->content;
        $data['title']=htmlspecialchars($row->displayname);
        $settings = json_decode($row->settings);
        $data['trigger_class']=$settings->trigger_class;
        $data['close']=$settings->close;
        $data['large']=$settings->large;
        return $data;
    }

    function get_edit_data($id)
    {
        //This is not the correct place to do it, but will load js files required for the module here anyway
        $this->resources->load_aux_js_file('assets/third_party/ckeditor/ckeditor.js');
        return $this->get_render_data($id);
    }

    function get_new_data()
    {
        //This is not the correct place to do it, but will load js files required for the module here anyway
        $this->resources->load_aux_js_file('assets/third_party/ckeditor/ckeditor.js');
        $data['content']='';
        $data['title']='';
        $data['trigger_class']='';
        $data['close']=false;
        $data['large']=false;
        return $data;
    }
}