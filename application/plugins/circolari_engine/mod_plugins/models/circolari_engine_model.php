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
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get_where('plugin_circolari_engine_articles', array('category' => $category));
        foreach ($query->result() as $row) {
            $circolari[] = array(
                'id' => $row->id,
                'number' => $row->number,
                'suffix' => $row->suffix,
                'title' => $row->title,
                'preview' => substr(strip_tags($row->content), 0, 45) . '&hellip;'
            );
        }
        return $circolari;
    }

    function get_circolare_data($id)
    {
        $query = $this->db->get_where('plugin_circolari_engine_articles', array('id' => $id));
        $row = $query->row();
        return (array)$row;
    }

    function save($id, $category, $title, $number, $suffix, $content)
    {
        $this->load->library('validation');
        $content = $this->validation->filter_html($content, false);
        $data = array(
            'category' => $category,
            'number' => $number,
            'suffix' => $suffix,
            'title' => $title,
            'content' => $content
        );
        //create a new content if the id does not exists
        $query = $this->db->get_where('plugin_circolari_engine_articles', array('id' => $id));
        if ($query->num_rows() > 0) {
            $this->db->where('id', $id);
            return $this->db->update('plugin_circolari_engine_articles', $data);
        } else {
            $data['id'] = $id;
            return $this->db->insert('plugin_circolari_engine_articles', $data);
        }
    }

    function get_next_number($category)
    {
        $this->db->where('category', $category);
        $this->db->select_max('number', 'max_number');
        $query = $this->db->get('plugin_circolari_engine_articles');
        $row = $query->row();
        return $row->max_number + 1;
    }

    function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('plugin_circolari_engine_articles');
    }

    function delete_cat($name)
    {
        $this->db->where('category', $name);
        return $this->db->delete('plugin_circolari_engine_articles');
    }
}