<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Circolari_engine_model extends CI_Model
{
    function get_categories_list()
    {
        $categories = [];
        $this->db->distinct();
        $this->db->select('category');
        $query = $this->db->get('plugin_circolari_engine_articles');
        foreach ($query->result() as $row) {
            $this->db->where('category', $row->category);
            $this->db->from('plugin_circolari_engine_articles');
            $articles = $this->db->count_all_results();

            $categories[] = array(
                'name' => $row->category,
                'articles' => $articles,
            );
        }
        return $categories;
    }

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