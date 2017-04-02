<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class File_conversion extends MX_Controller
{
    protected $extension_array = array('docx' => '.docx', 'html' => '.html', 'odt' => '.odt', 'pdf' => '.pdf');

    function export_from_text(){
        if(!$this->check_enabled())
        {
            return;
        }
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
        if(!isset($this->extension_array[$extension]))
        {
            $this->output->set_status_header(403);
            $this->output->set_output('The extensions indicated do not match valid pandoc types or are blocked.');
            return;
        }
        $file_input = APPPATH.'tmp/'.uniqid().$this->extension_array[$extension];
        if (move_uploaded_file($_FILES['to_convert']['tmp_name'], $file_input)) {
            $output = $this->convert_document('file', $file_input, null, $extension, 'html');
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

    function convert_document($input_mode, $input, $out_name, $from, $to)
    {
        if(!$this->check_enabled())
        {
            return;
        }
        if($input_mode === 'text')
        {
            $temp_input = APPPATH.'tmp/'.uniqid().$this->extension_array[$from];
            file_put_contents($temp_input, $input);
            $input = $temp_input;
        }
        elseif($input_mode === 'file')
        {
            if(!file_exists($input))
            {
                return false;
            }
        }
        else
        {
            return false;
        }
        if($to == 'pdf' and in_array($from, array('html', 'html5')))
        {
            $output_file = $this->execute_tcpdf($input);
        }
        else
        {
            if ($this->db_config->get('file_conversion', 'pandoc_execute_on_remote')) {
                $output_file = $this->execute_pandoc_remote($input, $from, $to);
            } else {
                $output_file = $this->execute_pandoc($input, $from, $to);
            }
        }
        if($output_file === false)
        {
            return false;
        }
        if($out_name!==null){
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
        else
        {
            return $output_file;
        }

    }

    protected function execute_tcpdf($input)
    {
        require_once(APPPATH.'third_party/TCPDF/tcpdf.php');

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $output = APPPATH.'tmp/'.uniqid().'pdf';

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor($this->db_config->get('general', 'website_name'));
        $pdf->SetTitle('');
        $pdf->SetSubject('');
        $pdf->SetKeywords('');

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $this->db_config->get('file_conversion', 'pdf_header_title'), $this->db_config->get('file_conversion', 'pdf_header_text'));

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        $pdf->SetFont('helvetica', '', 11);

        $pdf->AddPage();
        $pdf->writeHTML(file_get_contents($input), true, false, true, false, '');
        $pdf->lastPage();

        $pdf->Output($output, 'F');
        return $output;
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

    protected function execute_pandoc_remote($input, $from, $to)
    {
        $transaction_id = base64_encode($this->security->get_random_bytes(32));
        $url = $this->db_config->get('file_conversion', 'remote_server_url');
        $token = $this->db_config->get('file_conversion', 'remote_server_token');
        $hmac_key = base64_decode($this->db_config->get('file_conversion', 'hmac_key'));
        $digest = hash_hmac_file('sha256', $input, $hmac_key);
        $finfo = new finfo(FILEINFO_MIME);
        $cfile = new CURLFile($input, $finfo->file($input),'to_convert');
        $post_data = array('to_convert' => $cfile, 'type' => $from, 'covert_to' => $to, 'digest' => $digest, 'token' => $token, 'transaction_id' => $transaction_id);
        //Request the file
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($curl, CURLOPT_URL, $url.'execute_conversion');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $file_data = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        $output = APPPATH.'tmp/'.uniqid().$this->extension_array[$to];
        if($httpcode === 200)
        {
            $fp = fopen($output, 'w');
            fwrite($fp, $file_data);
            fclose($fp);
        }
        else
        {
            return false;
        }
        unlink($input);
        if(!file_exists($output))
        {
            return false;
        }
        //Request HMAC for message authentication
        $post_data = array('token' => $token, 'transaction_id' => $transaction_id);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($curl, CURLOPT_URL, $url.'get_digest');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $response_digest = curl_exec($curl);
        curl_close($curl);
        $digest = hash_hmac_file('sha256', $output, $hmac_key);
        return $response_digest === $digest ? $output : false;
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