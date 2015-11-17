<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Db_config
{
    protected $CI, $config=[], $cache=[];

    public function __construct()
    {
        $this->CI = &get_instance();
        $query = $this->CI->db->get('configuration');
        foreach ($query->result() as $row)
        {
            $this->config[$row->section][$row->key]=$row->value;
        }
        $this->cache=$this->config;
    }

    public function get($section,$key)
    {
        return $this->config[$section][$key];
    }

    public function update()
    {
        $query = $this->CI->db->get('configuration');
        foreach ($query->result() as $row)
        {
            $config[$row->section][$row->key]=$row->value;
        }
    }

    public function set($section,$key,$value)
    {
        $this->config[$section][$key]=$value;
    }

    public function save()
    {
        $sql_u="UPDATE configuration SET value = ? WHERE (section = ? AND `key` = ?);";
        $sql_i="INSERT INTO configuration (section,`key`,value) VALUES (?,?,?);";
        foreach($this->config as $section => $options)
        {
            $save = $this->array_diff_manual($options, $this->cache[$section]); //Array diff sembra non funzionare, implementata manualmente
            foreach($save as $key => $value)
            {
                if(isset($this->cache[$section][$key]))
                {
                    $this->CI->db->query($sql_u,array($value,$section,$key));
                }
                else
                {
                    $this->CI->db->query($sql_i,array($section,$key,$value));
                }
            }
        }
    }

    private function array_diff_manual($actual, $cache){
        $output = [];
        foreach($actual as $key => $value)
        {
            if($cache[$key] !== $value)
            {
                $output[$key] = $value;
            }
        }
        return $output;
    }
}