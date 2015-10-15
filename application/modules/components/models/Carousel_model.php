<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Carousel_model extends CI_Model
{
    function get_render_data($id)
    {
        $query = $this->db->get_where('contents', array('id' => $id));
        if ($query->num_rows() > 0)
        {
            $row = $query->row();
        }
        else
        {
            return false;
        }
        $data['id']=$id;
        $data['files']= $this->get_files_array($row->content);
        return $data;
    }

    function get_files_array($path)
    {
        $full_path=FCPATH.$path;
        if(file_exists($full_path))
        {
            $files = array_diff(scandir($full_path), array('..', '.'));
            foreach($files as &$file)
            {
                if(is_file($full_path.'/'.$file))
                {
                    $file = in_array(pathinfo($full_path.'/'.$file,PATHINFO_EXTENSION),array('jpg','jpeg','png','gif')) ? base_url($path.'/'.$file) : null;
                }
            }
            return array_filter($files);
        }
        else
        {
            return null;
        }
    }

    function get_edit_data($id)
    {
        $query = $this->db->get_where('contents', array('id' => $id));
        if ($query->num_rows() > 0) {
            $row = $query->row();
        } else {
            return false;
        }
        $data['path'] = $row->content;
        $data['files'] = $this->get_files_array($row->content);
        $data['path_exists'] = $data['files']!==null;
        $data['id']=$id;
        return $data;
    }

    function get_preview_data($data)
    {
        $data = json_decode($data, true);
        $data['files']= $this->get_files_array($data['path']);
        return $data['files']===null ? false : $data;
    }
}