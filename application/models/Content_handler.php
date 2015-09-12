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

    function are_orphans($id)
    {
        //WARNING: Can't use FULLTEXT functionality, need compatibility with Inno DB on MySQL 5.5 (change when 5.6+ becomes available on server)
        //This is compatibility code that does a single id at a time, add enhanced code when performance optimizations are added
        $output=[];
        foreach($id as $this_id)
        {
            //May produce out of sync error (will indicate it is an orphan even if it has just been added in the page via js (must use js checking for this)
            $this->db->like('code', $this_id);
            $query = $this->db->get('pages');
            if($query->num_rows() <= 1)
            {
                $this->db->select('id');
                $query = $this->db->get_where('contents',array('id'=>$this_id));
                if($query->num_rows() > 0)
                {
                    $output[]=$this_id;
                }
            }
        }
        return $output;
    }

    function delete_contents($id_array)
    {
        $this->db->where_in('id', $id_array);
        return $this->db->delete('contents');
    }

    function get_contents_list()
    {;
        $query = $this->db->get('contents');
        $contents=[];
        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
            {
                $content['id'] = $row->id;
                $content['type'] = $row->type;
                if($row->type !=='html-field')
                {
                    $content['preview']=$row->displayname!='' ? $row->displayname : substr(strip_tags($row->content), 0, 50).'&hellip;';
                }
                else
                {
                    $content['preview']=substr(htmlspecialchars($row->content), 0, 50).'...';
                }
                array_push($contents, $content);
            }
            return $contents;
        }
        else
        {
            return false;
        }
    }
}