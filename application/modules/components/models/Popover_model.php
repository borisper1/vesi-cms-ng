<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Popover_model extends CI_Model
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
        $data['content']=htmlspecialchars($row->content);
        $data['name']=htmlspecialchars($row->displayname);
        $settings = json_decode($row->settings);
        $data['class']=$settings->class;
        $data['placement']=$settings->placement;
        $data['title']=$settings->title;
        $data['linebreak']=$settings->linebreak;
        $data['dismissable']=$settings->dismissable;
        return $data;
    }

    function get_edit_data($id)
    {
        //This is not the correct place to do it, but will load js files required for the module here anyway
        $this->resources->load_aux_js_file('assets/third_party/ckeditor/ckeditor.js');
        return $this->get_render_data($id);
    }

}