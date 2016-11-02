<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pending_operations_handler extends CI_Model
{
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

}