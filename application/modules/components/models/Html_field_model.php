<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Html_field_model extends CI_Model
{
    function get_render_data($id)
    {
        $query = $this->db->get_where('contents',array('id' => $id));
        if ($query->num_rows() > 0)
        {
            $row = $query->row();

            $data=[];
            $data['content']=$row->content;
            $js_array =  explode(',', $row->settings != '' ? json_decode($row->settings)->addjs : '');
            foreach($js_array as $js_file){
                $this->resources->load_aux_js_file('assets/'.$js_file);
            }
            return $data;
        }
        else
        {
            return false;
        }
    }

    function get_edit_data($id)
    {
        $query = $this->db->get_where('contents',array('id' => $id));
        if ($query->num_rows() > 0)
        {
            $row = $query->row();

            $data=[];
            $data['content']=htmlspecialchars($row->content);
            $data['js_enabled'] = $row->settings != '';
            $data['js_string'] = $data['js_enabled'] ? json_decode($row->settings)->addjs : '';
            return $data;
        }
        else
        {
            return false;
        }
    }
    function get_new_data()
    {
        $data['content']='';
        $data['js_enabled'] = false;
        $data['js_string'] = '';
        return $data;
    }

}