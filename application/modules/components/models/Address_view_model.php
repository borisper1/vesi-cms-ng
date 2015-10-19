<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Address_view_model extends CI_Model
{
    function get_render_data($id)
    {
        $query = $this->db->get_where('contents',array('id' => $id));
        if ($query->num_rows() > 0) {
            $row = $query->row();

            $data = [];
            $structure=json_decode($row->content);
            $data['road_address']=$structure->address_road;
            $data['emails']=$structure->email;
            $data['phones']=$structure->phone;
            return $data;
        }
        else
        {
            return false;
        }
    }

    function get_edit_data($id)
    {
        //This is not the correct place to do it, but will load js files required for the module here anyway
        $this->resources->load_aux_js_file('assets/third_party/ckeditor/ckeditor.js');
        return $this->get_render_data($id);
    }
}