<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class File_lister_model extends CI_Model
{
    function get_render_data($id)
    {
        $this->load->library('file_handler');
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
                $file = (substr($file, 0, 1) !== '.') ? $row->content.'/'.$file : null;
            }
        }
        $data=[];
        $data['files']=[];
        $files=array_filter($files);
        foreach($files as $file)
        {
            $d_file = new stdClass();
            $d_file->name = basename($file);
            $d_file->url=base_url($file);
            $d_file->icon = $this->file_handler->get_fa_icon(FCPATH.$file);
            $d_file->size = $this->file_handler->get_file_size(FCPATH.$file,1);
            $d_file->date = date("d/m/Y",filemtime(FCPATH.$file));
            $data['files'][]=$d_file;
        }
        return $data;
    }
}