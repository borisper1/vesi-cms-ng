<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Circolari_engine_model extends CI_Model
{
    function get_circolari_list($category)
    {
        $circolari = [];
        $query = $this->db->get_where('plugin_circolari_engine_articles', array('category' => $category));
        foreach ($query->result() as $row) {
            $circolari[] = array(
                'id' => $row->id,
                'number' => $row->number,
                'suffix' => $row->suffix,
                'title' => $row->title,
            );
        }
        return $circolari;
    }

}