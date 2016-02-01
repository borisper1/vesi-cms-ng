<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Error_logger extends CI_Model
{
    function log_no_content_error($id)
    {
        $data = array(
            'id' => uniqid(),
            'severity' => 'error',
            'new' => 1,
            'origin' => $GLOBALS['p_container'].'::'.$GLOBALS['p_name'],
            'date' => date("Y-m-d H:i:s"),
            'summary' => 'CONTENT_NOT_FOUND',
            'message' => 'Il contenuto con id '.$id.' non è stato trovato nel database. Controllare che il contenuto esista.'
    );
        $this->db->insert('error_log', $data);
    }

    function log_no_menu_error($id)
    {
        $data = array(
            'id' => uniqid(),
            'severity' => 'error',
            'new' => 1,
            'origin' => $GLOBALS['p_container'].'::'.$GLOBALS['p_name'],
            'date' => date("Y-m-d H:i:s"),
            'summary' => 'SEC_MENU_NOT_FOUND',
            'message' => 'Il menu secondario con id '.$id.' non è stato trovato nel database. Controllare che il menu esista.'
        );
        $this->db->insert('error_log', $data);
    }

    function log_no_component_error($id, $type)
    {
        $data = array(
            'id' => uniqid(),
            'severity' => 'error',
            'new' => 1,
            'origin' => $GLOBALS['p_container'].'::'.$GLOBALS['p_name'],
            'date' => date("Y-m-d H:i:s"),
            'summary' => 'RENDER_COMPONENT_NOT_FOUND',
            'message' => 'Il contenuto con id '.$id.' richiede il componente non installato '.$type.' per la visualizzazione. Controllare che il componente sia installato.'
        );
        $this->db->insert('error_log', $data);
    }

    function log_no_plugin_error($name)
    {
        $data = array(
            'id' => uniqid(),
            'severity' => 'error',
            'new' => 1,
            'origin' => $GLOBALS['p_container'].'::'.$GLOBALS['p_name'],
            'date' => date("Y-m-d H:i:s"),
            'summary' => 'RENDER_PLUGIN_NOT_FOUND',
            'message' => 'Il componente aggiuntivo '.$name.' è integrato in una pagina, ma il componente aggiuntivo non è installato oppure è disabilitato. Controllare che il componente aggiuntivo sia integro'
        );
        $this->db->insert('error_log', $data);
    }

    function log_404_error($referrer)
    {
        $data = array(
            'id' => uniqid(),
            'new' => 1,
            'date' => date("Y-m-d H:i:s")
        );
        if(isset($GLOBALS['p_container']))
        {
            $data['origin'] = $GLOBALS['p_container'].'::'.$GLOBALS['p_name'];
        }
        else
        {
            $data['origin'] =  '/'.uri_string();
        }
        if(strpos($referrer, base_url())===0)
        {
            $data['severity'] = 'warning';
            $data['summary'] = 'INTERNAL_404_ERROR';
            $data['message'] = 'Impossibile trovare la pagina richiesta. Sembra che un link interno rimandi a questa pagina (REFERRER: '.$referrer.')';
        }
        else
        {
            $data['severity'] = 'info';
            $data['summary'] = 'EXTERNAL_404_ERROR';
            $data['message'] = 'Impossibile trovare la pagina richiesta. La richiesta sembra provenga da un sito esterno (REFERRER: '.$referrer.')';
        }
        $this->db->insert('error_log', $data);
    }

    function get_syserror_data()
    {
        $query = $this->db->get('error_log');
        $events = [];
        foreach ($query->result_array() as $row)
        {
            $row['severity_bclass'] = $row['severity']==='error' ?  'danger' : $row['severity'];
            $events[] = $row;
        }
        return $events;
    }

    function mark_all_as_read()
    {
        $this->db->where('new', 1);
        $this->db->update('error_log', array('new' => 0));
    }

    function delete_all()
    {
        $this->db->empty_table('error_log');
    }
}