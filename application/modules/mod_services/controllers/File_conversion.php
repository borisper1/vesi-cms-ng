<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class File_conversion extends MX_Controller
{
    public function __construct()
    {
        $this->load->library('file_conversion');
    }

    function export_from_html()
    {
        if(!$this->check_enabled())
        {
            return;
        }
        $input = rawurldecode($this->input->post('code'));
        $to = $this->input->post('output_format');
        $out_name = $this->input->post('output_name');
        if (!isset($this->file_conversion->format_table[$to]))
        {
            $this->output->set_status_header(403);
            $this->output->set_output('The extensions indicated do not match valid pandoc types or are blocked.');
        }
        else
        {
            $output = $this->file_conversion->convert_document('text', $input, $out_name, 'html', $to); //returns converted document public URL
            if($output)
            {
                $this->output->set_status_header(200);
                $this->output->set_output($output);
            }
            else
            {
                $this->output->set_status_header(500);
                $this->output->set_output('The file conversion service encountered an unexpected error or the conversion mode is invalid, the data can\'t be accessed or there is a file permissions error');
            }
        }
    }

    function import_file_to_html(){
        if(!$this->check_enabled())
        {
            return;
        }
        if($_FILES['to_convert']['name'] == ''){
            $this->output->set_status_header(400);
            $this->output->set_output('Expected a file upload');
            return;
        }
        $extension = pathinfo($_FILES['to_convert']['name'], PATHINFO_EXTENSION);
        $format = $this->input->post('format');
        if(!isset($this->file_conversion->format_table[$format]) or $this->file_conversion->format_table[$format]['extension'] != $extension)
        {
            $this->output->set_status_header(403);
            $this->output->set_output('The extensions indicated do not match valid conversion types or are blocked.');
            return;
        }
        $file_input = APPPATH.'tmp/'.uniqid().$this->extension_array[$extension];
        if (move_uploaded_file($_FILES['to_convert']['tmp_name'], $file_input)) {
            $output = $this->convert_document('file', $file_input, null, $extension, 'html5');
            if($output)
            {
                $this->output->set_status_header(200);
                $this->output->set_output(file_get_contents($output));
                unlink($output);
            }
            else
            {
                $this->output->set_status_header(500);
                $this->output->set_output('The file conversion service encountered an unexpected error or the conversion mode is invalid, the data can\'t be accessed or there is a file permissions error');
            }
        }
        else
        {
            $this->output->set_status_header(403);
            $this->output->set_output('The uploaded file can\'t be processed for security reasons');
        }
    }

    protected function check_enabled()
    {
        if($this->db_config->get('file_conversion', 'enable_file_conversion'))
        {
            return true;
        }
        else
        {
            $this->output->set_status_header(403);
            $this->output->set_output('The file conversion service is disabled - please enable it in the configuration');
            return false;
        }
    }
}