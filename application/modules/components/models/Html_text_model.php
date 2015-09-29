<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Html_text_model extends CI_Model
{
    function get_render_data($id)
    {
        $query = $this->db->get_where('contents',array('id' => $id));
        if ($query->num_rows() > 0)
        {
            $row = $query->row();

            $data=[];
            //TODO: Maybe add HTML filtering (It is done on input, but filtering also the output has better security, but makes things slower).
            $data['content']=$row->content;
            return $data;
        }
        else
        {
            return false;
        }
    }

    function get_edit_data($id)
    {
        $this->resources->load_aux_js_file('assets/third_party/ckeditor/ckeditor.js');
        $query = $this->db->get_where('contents',array('id' => $id));
        if ($query->num_rows() > 0)
        {
            $row = $query->row();

            $data=[];
            $data['content']=$row->content;
            return $data;
        }
        else
        {
            return false;
        }
    }
}