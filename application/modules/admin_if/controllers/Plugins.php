<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Plugins extends MX_Controller
{
    function index()
    {
        $this->load->view('plugins/main');
    }

    function load_registered_components()
    {
        $name = $this->input->post('name');
        $data = $this->modules_handler->get_plugin_data($name);
        $view_data['registered_components'] = [];
        foreach ($data['admin_interfaces'] as $interface) {
            $view_data['registered_components'][] = array('type' => 'admin_interface',
                'icon' => $interface->icon,
                'title' => $interface->label,
                'name' => $interface->name,
                'description' => $interface->description);
        }
        foreach ($data['config_interfaces'] as $interface) {
            $view_data['registered_components'][] = array('type' => 'config_interface',
                'icon' => $interface->icon,
                'title' => $interface->label,
                'name' => $interface->name,
                'description' => 'N/A');
        }
        foreach ($data['services'] as $service) {
            $view_data['registered_components'][] = array('type' => 'service',
                'icon' => $service->icon,
                'title' => $service->label,
                'name' => $service->name,
                'description' => 'N/A');
        }
        foreach ($data['components'] as $component) {
            $view_data['registered_components'][] = array('type' => 'component',
                'icon' => 'fa-cube',
                'title' => $component->name,
                'name' => $component->name,
                'description' => $component->description);
        }
        foreach ($data['files'] as $file) {
            $view_data['files'][] = array('path' => $file,
                'installed' => file_exists(FCPATH . $file));
        }
        $this->load->view('plugins/components_modal', $view_data);
    }

    function unpack_zip_plugin()
    {
        if($_FILES['zip_install']['name'] == ''){
            $this->output->set_status_header(400);
            $this->output->set_output('Expected a file upload');
            return;
        }
        $extension = pathinfo($_FILES['zip_install']['name'], PATHINFO_EXTENSION);
        if($extension==='.zip')
        {
            $this->output->set_status_header(403);
            $this->output->set_output('Expected a zip file package');
            return;
        }
        $file_input = APPPATH.'tmp/'.uniqid().'.zip';
        $folder_id = uniqid();
        $this->load->library('file_handler');
        if (move_uploaded_file($_FILES['zip_install']['tmp_name'], $file_input)) {
            mkdir(APPPATH.'tmp/'.$folder_id);
            $zip = new ZipArchive;
            $res = $zip->open($file_input);
            if ($res === TRUE) {
                $zip->extractTo(APPPATH.'tmp/'.$folder_id.'/');
                $zip->close();
            } else {
                $this->output->set_status_header(500);
                $this->output->set_output('Can\'t extract archive');
                unlink($file_input);
                return;
            }
            if (!file_exists(APPPATH . 'tmp/' . $folder_id . '/descriptor.json')) {
                $this->output->set_status_header(500);
                $this->output->set_output('Can\'t find plugin descriptor, terminating');
                $this->file_handler->delete_path('application/tmp/'.$folder_id);
                unlink($file_input);
                return;
            }
            $descriptor_data = json_decode(file_get_contents(APPPATH.'tmp/'.$folder_id.'/descriptor.json'));
            $json_data['name'] = $descriptor_data->name;
            $json_data['title'] = $descriptor_data->title;
            $json_data['version'] = $descriptor_data->version;
            $json_data['author'] = $descriptor_data->author;
            $json_data['description'] = $descriptor_data->description;
            $json_data['md5'] = md5_file($file_input);
            $json_data['sha1'] = sha1_file($file_input);
            $json_data['folder_id'] = $folder_id;
            $is_upgrade = $this->modules_handler->get_plugin_data($descriptor_data->name);
            if ($is_upgrade) {
                $json_data['update'] = true;
                $json_data['installed_version'] = $is_upgrade['version'];
            } else {
                $json_data['update'] = false;
            }
            $this->output->set_status_header(200);
            $this->output->set_output(json_encode($json_data,  JSON_FORCE_OBJECT));
            unlink($file_input);
        }
        else
        {
            $this->output->set_status_header(403);
            $this->output->set_output('The uploaded file can\'t be processed for security reasons');
        }
    }

    function install_uploaded_plugin()
    {
        $folder_id = $this->input->post('folder_id');
        if (!file_exists(APPPATH . 'tmp/' . $folder_id . '/descriptor.json')) {
            $this->output->set_status_header(500);
            $this->output->set_output('Can\'t find plugin descriptor, terminating');
            return;
        }
        $descriptor_data = json_decode(file_get_contents(APPPATH . 'tmp/' . $folder_id . '/descriptor.json'));
        //Update the install store
        $this->load->library('file_handler');
        if (file_exists(APPPATH . 'plugins/' . $descriptor_data->name)) {
            //TODO: Uninstall (no data removal) the previous version
            $this->file_handler->delete_path('application/plugins/' . $descriptor_data->name);
        }
        rename(APPPATH . 'tmp/' . $folder_id, APPPATH . 'plugins/' . $descriptor_data->name);
        //Execute the install procedure
        $this->modules_handler->install_plugin($descriptor_data->name);
    }
}