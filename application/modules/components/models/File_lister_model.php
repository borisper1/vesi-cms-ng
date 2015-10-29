<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class File_lister_model extends CI_Model
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
        $data['files'] = $this->get_files_array($row->content);
        return $data;
    }

    function get_files_array($path)
    {
        $this->load->library('file_handler');
        $full_path = FCPATH . $path;
        if(file_exists($full_path))
        {
            $files = array_diff(scandir($full_path), array('..', '.'));
            foreach ($files as &$file) {
                if (is_file($full_path . '/' . $file)) {
                    $file = (substr($file, 0, 1) !== '.') ? $path . '/' . $file : null;
                }
            }
            $files_final = [];
            $files = array_filter($files);
            foreach ($files as $file) {
                $d_file = new stdClass();
                $d_file->name = basename($file);
                $d_file->url = base_url($file);
                $d_file->icon = $this->file_handler->get_fa_icon(FCPATH . $file);
                $d_file->size = $this->file_handler->get_file_size(FCPATH . $file, 1);
                $d_file->date = date("d/m/Y", filemtime(FCPATH . $file));
                $files_final[] = $d_file;
            }
            return $files_final;
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
        $data['path']=$row->content;
        $data['files'] = $this->get_files_array($row->content);
        $data['path_exists'] = $data['files']!==null;
        return $data;
    }

    function get_new_data()
    {
        $data['path']='';
        $data['files'] = [];
        $data['path_exists'] = false;
        return $data;
    }

    function get_preview_data($data)
    {
        $data = json_decode($data, true);
        $data['files']= $this->get_files_array($data['path']);
        return $data['files']===null ? false : $data;
    }
}