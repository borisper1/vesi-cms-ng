<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class File_conversion extends MX_Controller
{
    protected $extension_array = array('docx' => '.docx', 'html' => '.html', 'pdf' => '.pdf', 'odt' => '.odt');

    function export_from_text(){
        $input = rawurldecode($this->input->post('text'));
        $from = $this->input->post('text_format');
        $to = $this->input->post('output_format');
        $out_name = $this->input->post('output_name');
        if(!isset($this->extension_array[$from]) or !isset($this->extension_array[$to]))
        {
            $this->output->set_status_header(403);
            $this->output->set_output('The extensions indicated do not match valid pandoc types or are blocked.');
        }
        else
        {
            $output = $this->convert_document('text', $input, $out_name, $from, $to); //returns converted document public URL
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

    function convert_document($input_mode, $input, $out_name, $from, $to)
    {
        if($input_mode === 'text')
        {
            $temp_input = APPPATH.'tmp/'.uniqid().$this->extension_array[$from];
            file_put_contents($temp_input, $input);
            $input = $temp_input;
        }
        else
        {
            return false;
        }

        if($this->db_config->get('file_conversion', 'execute_on_remote'))
        {

        }
        else
        {
            //Execute local conversion
            $output_file = $this->execute_pandoc($input, $from, $to);
        }
        if($output_file === false)
        {
            return false;
        }
        rename($output_file,FCPATH.'files/converted_files/'.$out_name.$this->extension_array[$to]);
        if(file_exists(FCPATH.'files/converted_files/'.$out_name.$this->extension_array[$to]))
        {
            return base_url('files/converted_files/'.$out_name.$this->extension_array[$to]);
        }
        else
        {
            return false;
        }
    }

    protected function execute_pandoc($input, $from, $to)
    {
        $output = APPPATH.'tmp/'.uniqid().$this->extension_array[$to];
        $command = 'pandoc -f '.escapeshellarg($from).' -t '.escapeshellarg($to).' -o '.escapeshellarg($output).' -i '.escapeshellarg($input);
        exec($command);
        if(!file_exists($output))
        {
            $output = false;
        }
        unlink($input);
        return $output;
    }
}