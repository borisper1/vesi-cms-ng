<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class File_upload extends MX_Controller
{
    function index()
    {
        $target = rawurldecode($this->input->post('target'));
        if ($this->is_path_unsafe($target)) {
            $this->output->set_status_header(403);
            $this->output->set_output('{"files":[{"error":"not authorized to write on target path"}]}');
        }

        if (strpos($target, 'img') === 0) {
            $options = [
                'script_url' => base_url('services/file_upload/index'),
                'upload_dir' => FCPATH . $target . '/',
                'upload_url' => base_url($target . '/'),
                'inline_file_types' => '/\.(?!(php|js|pl|cgi|html|css|xml|json|swf|jar|class|py|rb|sh|bat|fcgi|inc|exe)).+$/i', //impedisci l'esecuzione file eseguibili da un browser o da un server web
                'accept_file_types' => '/\.(?=(jpg|jpeg|png|gif|bmp|svg)).+$/i', //consenti solo i file di tipo immagine
                'image_versions' => array(),
                'delete_type' => 'POST',
                'print_response' => false
            ];
        } elseif (strpos($target, 'files') === 0) {
            $options = [
                'script_url' => base_url('services/file_upload/index'),
                'upload_dir' => FCPATH . $target . '/',
                'upload_url' => base_url($target . '/'),
                'inline_file_types' => '/\.(?!(php|js|pl|cgi|html|css|xml|json|swf|jar|class|py|rb|sh|bat|fcgi|inc|exe|cmd|dll|ocx)).+$/i', //impedisci l'esecuzione file eseguibili da un browser o da un server web
                'accept_file_types' => '/\.(?!(php|pl|cgi|sh|fcgi|inc|py|bat|exe|cmd|dll|ocx)).+$/i', //escludi file eseguibili dal server web in uso (non caricabili)
                'image_versions' => array(),
                'delete_type' => 'POST',
                'print_response' => false
            ];
        }
        require(APPPATH . 'third_party/jquery-file-upload/UploadHandler.php');
        $upload_handler = new UploadHandler($options);
        $this->output->set_status_header(200);
        $this->output->set_output(json_encode($upload_handler->response));
    }

    protected function is_path_unsafe($path)
    {
        $path_array = explode('/', $path);
        return (!in_array($path_array[0], array('files', 'img'))) or in_array('..', $path_array);
    }
}