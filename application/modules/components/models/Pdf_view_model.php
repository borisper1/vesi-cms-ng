<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pdf_view_model extends CI_Model
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
        if(strpos($row->content,'http://')===0 or strpos($row->content,'https://')===0 or strpos($row->content,'ftp://')===0)
        {
            $data['url'] = $row->content;
        }
        else
        {
            $data['url'] = base_url($row->content);
        }
        return $data;
    }

    function get_edit_data($id){
        $this->load->library('file_handler');
        $query = $this->db->get_where('contents', array('id' => $id));
        if ($query->num_rows() > 0) {
            $row = $query->row();
        } else {
            return false;
        }
        $data['path'] = $row->content;
        if(strpos($row->content,'http://')===0 or strpos($row->content,'https://')===0 or strpos($row->content,'ftp://')===0)
        {
            $data['is_external_server'] = true;
            $headers = @get_headers($row->content);
            $data['file_exists'] = (strpos($headers[0],'404') === false);
            $data['true_path'] = $row->content;
        }
        else
        {
            $data['is_external_server'] = false;
            $data['file_exists'] = file_exists(FCPATH.$row->content);
            $data['true_path'] = base_url($row->content);
        }
        return $data;
    }

    function get_new_data()
    {
        $data['path']='';
        $data['is_external_server'] = false;
        $data['file_exists'] = false;
        $data['true_path'] = '';
        return $data;
    }
}