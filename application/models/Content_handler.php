<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Content_handler extends CI_Model
{
    function get_symbol_array($id)
    {
        $query = $this->db->get_where('contents', array('id' => $id));
        $row = $query->row();
        if (isset($row))
        {
            $data['exists']=true;
            $data['id']=$id;
            $data['type']=$row->type;
            if($row->type !=='html-field')
            {
                $data['preview']=$row->displayname!='' ? $row->displayname : substr(strip_tags($row->content), 0, 30).'&hellip;';
            }
            else
            {
                $data['preview']=substr(htmlspecialchars($row->content), 0, 30).'...';
            }
        }
        else
        {
            $data['exists']=false;
            $data['id']=$id;
            $data['type']='?';
            $data['preview']='';
        }
        return $data;
    }
}