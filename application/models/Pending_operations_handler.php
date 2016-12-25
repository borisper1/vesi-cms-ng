<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pending_operations_handler extends CI_Model
{

    function __construct()
    {
        $this->db->where('expires <', date("Y-m-d H:i:s"));
        $this->db->delete('pending_operations');
        parent::__construct();
    }

    function register_new_operation($id, $time, $expires, $module, $operation, $data)
    {
        $data = array(
            'id' => $id,
            'date' => $time,
            'expires' => $expires,
            'module' => $module,
            'operation' => $operation,
            'data' => $data
        );
        return $this->db->insert('pending_operations', $data);
    }

    function get_pending_operations($module, $operation)
    {
        $query = $this->db->get_where('pending_operations', array('module' => $module, 'operation' => $operation));
        return $query->result_array();
    }

    function get_operation_by_id($id)
    {
        $query = $this->db->get_where('pending_operations', array('id' => $id));
        if ($query->num_rows() > 0) {
            $row = $query->row();
        } else {
            return false;
        }
        $out_array = array(
            'date' => $row->date,
            'module' => $row->module,
            'operation' => $row->operation,
            'expires' => $row->expires,
            'data' => json_decode($row->data),
        );
        if ($out_array['expires'] < date("Y-m-d H:i:s")) {
            return false;
        }
        return $out_array;
    }

    function remove_operation_by_id($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('pending_operations');
    }


}