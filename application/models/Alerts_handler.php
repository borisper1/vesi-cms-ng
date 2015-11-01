<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alerts_handler extends CI_Model
{
    function get_alerts_list()
    {
        $query = $this->db->get('alerts');
        $alerts=[];
        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
            {
                $alert['id'] = $row->id;
                $alert['type'] = $row->type;
                $alert['dismissible'] = $row->dismissible == 1;
                $alert['preview']=substr(strip_tags($row->content), 0, 50).'&hellip;';
                if($row->display_on == 'all')
                {
                    $alert['rules']='all';
                }
                else
                {
                    $alert['rules']=[];
                    $display_on = explode(',', $row->display_on);
                    foreach($display_on as $page)
                    {
                        $page_data = explode('::', $page);
                        $alert['rules'][]=array('container' => $page_data[0], 'name' => $page_data[1]);
                    }
                }
                array_push($alerts, $alert);
            }
            return $alerts;
        }
        else
        {
            return [];
        }
    }
    
    function get_alert_data($id)
    {
        $query = $this->db->get_where('alerts', array('id' => $id));
        if ($query->num_rows() > 0)
        {
            $row = $query->row();
            $alert['id'] = $row->id;
            $alert['type'] = $row->type;
            $alert['preview'] = substr(trim(strip_tags($row->content)), 0, 50).'&hellip;';
            $alert['content'] = $row->content;
            $alert['display_on'] = $row->display_on;
            $alert['dismissible'] = $row->dismissible == 1;
            return $alert;
        }
        else;
        {
            return false;
        }
    }

    function save($id, $type, $dismissible, $display_on, $content)
    {
        $this->load->library('validation');
        $content = $this->validation->filter_html($content, false);
        $data = array(
            'type' => $type,
            'dismissible' => $dismissible,
            'display_on' => $display_on,
            'content'=> $content
        );
        //create a new content if the id does not exists
        $query=$this->db->get_where('alerts',array('id'=> $id));
        if ($query->num_rows() > 0)
        {
            $this->db->where('id', $id);
            return $this->db->update('alerts', $data);
        }
        else
        {
            $data['id'] = $id;
            return $this->db->insert('alerts', $data);
        }
    }

    function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('alerts');
    }

}