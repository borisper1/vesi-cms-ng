<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Circolari_engine_feed_model extends CI_Model
{
    function get_render_data($id)
    {
        $query = $this->db->get_where('contents', array('id' => $id));
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $content = json_decode($row->content, true);
            $categories = array_keys($content);
            $settings = json_decode($row->settings, true);
            $display_name = $row->displayname;
        } else {
            return false;
        }
        $this->db->where_in('category', $categories);
        $this->db->order_by('id', 'DESC');
        $this->db->limit($settings['limit']);
        $this->db->select('id, category, number, suffix, title');
        $query = $this->db->get('plugin_circolari_engine_articles');
        $data['class'] = $settings['class'];
        $data['list'] = [];
        $data['title'] = $display_name;
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data['list'][] = array(
                    'id' => $row->id,
                    'full_title' => $row->number . $row->suffix . ' &mdash; ' . $row->title,
                    'link_to' => base_url($content[$row->category]) . '#' . $row->id,
                );
            }
            return $data;
        } else {
            return false;
        }
    }

    function get_edit_data($id)
    {
        $categories = [];
        $this->db->distinct();
        $this->db->select('category');
        $query = $this->db->get('plugin_circolari_engine_articles');
        $data['all_cats']=[];
        foreach ($query->result() as $row) {
            $data['all_cats'][]=$row->category;
        }
        $query = $this->db->get_where('contents', array('id' => $id));
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $settings = json_decode($row->settings);
            $data['content'] = json_decode($row->content, true);
            $data['title'] = $row->displayname;
            $data['limit'] = $settings->limit;
            $data['class'] = $settings->class;
            return $data;
        } else {
            return false;
        }
    }

    function get_new_data()
    {
        $data['content'] = [];
        $data['title'] = '';
        $data['limit'] = 10;
        $data['class'] = 'panel-default';
        return $data;
    }
}