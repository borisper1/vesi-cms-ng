<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Circolari_engine_feed_model extends CI_Model
{
    function get_render_data($id)
    {
        $query = $this->db->get_where('contents', array('id' => $id));
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $categories = explode(',', $row->content);
            $settings = json_decode($row->settings, true);
        } else {
            return false;
        }
        $this->db->where_in('category', $categories);
        $this->db->order_by('id', 'DESC');
        $this->db->limit($settings['limit']);
        $this->db->select('id', 'category', 'number', 'suffix', 'title');
        $query = $this->db->get('plugin_circolari_engine_articles');
        $list = [];
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $list[] = array(
                    'id' => $row->id,
                    'full_title' => $row->number . $row->suffix . ' &mdash; ' . $row->title,
                    'link_to' => base_url($settings['remapping'][$row->category]) . '#' . $row->id,
                );
            }
            return $list;
        } else {
            return false;
        }
    }

    function get_edit_data($id)
    {

    }

    function get_new_data()
    {

    }
}