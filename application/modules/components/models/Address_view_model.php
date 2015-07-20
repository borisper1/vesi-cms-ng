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
}