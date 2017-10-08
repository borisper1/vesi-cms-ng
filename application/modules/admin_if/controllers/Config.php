<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Config extends MX_Controller
{
    function load_interface($name)
    {
        $base_data['interfaces'] = $this->modules_handler->get_config_interfaces_array();
        $base_data['active_interface'] = $name;
        $model_name = $name.'_model';
        $this->load->model('config/'.$model_name);
        $data = $this->$model_name->get_data();
        $base_data['rendered_interface'] = $this->load->view('config/'.$name, $data, true);
        $this->load->view('config/base', $base_data);
        $this->resources->load_aux_js_file('assets/administration/interfaces/config/'.$name.'.js');
    }

    function index()
    {
        $this->load_interface('general');
    }


    function save()
    {
        $data = rawurldecode($this->input->post('code'));
        $decoded = json_decode($data, true);
        $sections = array_keys($decoded);
        foreach($sections as $section)
        {
            $keys = array_keys($decoded[$section]);
            foreach($keys as $key)
            {
            	if($this->encrypt_data($section,  $key))
				{
					$this->load->library('encryption');
					$encrypted = $this->encryption->encrypt((string)$decoded[$section][$key]);
					$this->db_config->set($section, $key, $encrypted);
				}
				else
				{
					$this->db_config->set($section, $key, (string)$decoded[$section][$key]);
				}

            }
        }
        $this->db_config->save();
        echo "success";
    }

    private function encrypt_data($section, $key)
	{
    	$encrypted_keys = [
    		'email::smtp_password',
			'authentication::ldap_password'
    		];
    	return in_array($section.'::'.$key, $encrypted_keys);
	}

    function is_writable()
    {
        $path = rawurldecode($this->input->post('path'));
        return is_writable($path) ? 'yes' : 'no';
    }
}
