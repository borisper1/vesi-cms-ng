<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Carousel_model extends CI_Model
{
    function get_render_data($id)
    {
        $query = $this->db->get_where('contents', array('id' => $id));
        if ($query->num_rows() > 0) {
            $row = $query->row();

            $path=FCPATH.$row->content;
        } else {
            return false;
        }
        $files = array_diff(scandir($path), array('..', '.'));
        foreach($files as &$file)
        {
            if(is_file($path.'/'.$file))
            {
                $file = in_array(pathinfo($path.'/'.$file,PATHINFO_EXTENSION),array('jpg','jpeg','png','gif')) ? base_url($row->content.'/'.$file) : null;
            }
        }
        $data=[];
        $data['id']=$id;
        $data['files']=array_filter($files);
        return $data;
    }
}