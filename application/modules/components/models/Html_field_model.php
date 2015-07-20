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
            //TODO: Maybe add HTML filtering (It is done on input, but filtering also the output has better security, but makes things slower).
            $data['content']=$row->content;
            return $data;
        }
        else
        {
            return false;
        }
    }
}