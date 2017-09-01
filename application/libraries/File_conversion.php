<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class File_conversion
{
    protected $CI;
    public $format_table = array(
        'winword' => array('extension' => '.docx', 'converter' => 'pandoc', 'pandoc_format' => 'docx'),
        'opendocumenttext' => array('extension' => '.odt', 'converter' => 'pandoc', 'pandoc_format' => 'odt'),
        'pdf' => array('extension' => '.pdf', 'converter' => 'tcpdf')
    );

    public function __construct()
    {
        $this->CI = &get_instance();
    }

    public function get_available_conversions()
    {
        if($this->CI->db_config->get('file_conversion', 'enable_file_conversion') == 0)
        {
            return [];
        }
        $this->CI->load->library('file_handler');
        $capabilities = [];
        if($this->CI->db_config->get('file_conversion', 'enable_tcpdf') == 1)
        {
            $capabilities['export'][] = 'pdf';
        }
        if($this->CI->db_config->get('file_conversion', 'enable_pandoc') == 1)
        {
            if($this->CI->file_handler->command_exists('pandoc') or $this->CI->db_config->get('file_conversion', 'pandoc_execute_on_remote'))
            {
                $capabilities['export'][] = 'winword';
                $capabilities['export'][] = 'opendocumenttext';
                $capabilities['import'][] = 'winword';
                $capabilities['import'][] = 'opendocumenttext';
            }
        }
        return $capabilities;
    }

    function convert_document($input_mode, $input, $out_name, $from, $to)
    {
        if ($this->CI->db_config->get('file_conversion', 'enable_file_conversion') == 0)
        {
            return;
        }
        if ($input_mode === 'text')
        {
            $temp_input = APPPATH . 'tmp/' . uniqid() . $this->format_table[$from]['extension'];
            file_put_contents($temp_input, $input);
            $input = $temp_input;
        }
        else if ($input_mode === 'file')
        {
            if (!file_exists($input))
            {
                return false;
            }
        }
        else
        {
            return false;
        }
        if ($from == 'html')
        {
            $converter = $this->format_table[$to]['converter'];
            if ($converter == 'tcpdf')
            {
                $output_file = $this->execute_tcpdf($input);
            }
            else if ($converter == 'pandoc')
            {
                if ($this->db_config->get('file_conversion', 'pandoc_execute_on_remote'))
                {
                    $output_file = $this->execute_pandoc_remote($input, 'html', $this->format_table[$to]['pandoc_format']);
                }
                else
                {
                    $output_file = $this->execute_pandoc($input, 'html', $this->format_table[$to]['pandoc_format']);
                }
            }
        }
        else if ($to == 'html')
        {
            $converter = $this->format_table[$from]['converter'];
            if ($converter == 'pandoc')
            {
                if ($this->db_config->get('file_conversion', 'pandoc_execute_on_remote'))
                {
                    $output_file = $this->execute_pandoc_remote($input, $this->format_table[$to]['pandoc_format'], 'html5');
                }
                else
                {
                    $output_file = $this->execute_pandoc($input, $this->format_table[$to]['pandoc_format'], 'html5');
                }
            }
        }
        if ($output_file === false)
        {
            return false;
        }
        if ($out_name !== null)
        {
            rename($output_file, FCPATH . 'files/converted_files/' . $out_name . $this->format_table[$to]['extension']);
            if (file_exists(FCPATH . 'files/converted_files/' . $out_name . $this->format_table[$to]['extension']))
            {
                return base_url('files/converted_files/' . $out_name . $this->format_table[$to]['extension']);
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
        require_once(APPPATH . 'third_party/TCPDF/tcpdf.php');

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $output = APPPATH . 'tmp/' . uniqid() . 'pdf';

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor($this->CI->db_config->get('general', 'website_name'));
        $pdf->SetTitle('');
        $pdf->SetSubject('');
        $pdf->SetKeywords('');

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $this->CI->db_config->get('file_conversion', 'pdf_header_title'), $this->CI->db_config->get('file_conversion', 'pdf_header_text'));

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
        $output = APPPATH . 'tmp/' . uniqid() . '.' . $to;
        $command = 'pandoc -f ' . escapeshellarg($from) . ' -t ' . escapeshellarg($to) . ' -o ' . escapeshellarg($output) . ' -i ' . escapeshellarg($input);
        exec($command);
        if (!file_exists($output))
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
        $cfile = new CURLFile($input, $finfo->file($input), 'to_convert');
        $post_data = array('to_convert' => $cfile, 'type' => $from, 'covert_to' => $to, 'digest' => $digest, 'token' => $token, 'transaction_id' => $transaction_id);
        //Request the file
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($curl, CURLOPT_URL, $url . 'execute_conversion');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $file_data = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        $output = APPPATH . 'tmp/' . uniqid() . $this->extension_array[$to];
        if ($httpcode === 200)
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
        if (!file_exists($output))
        {
            return false;
        }
        //Request HMAC for message authentication
        $post_data = array('token' => $token, 'transaction_id' => $transaction_id);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($curl, CURLOPT_URL, $url . 'get_digest');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $response_digest = curl_exec($curl);
        curl_close($curl);
        $digest = hash_hmac_file('sha256', $output, $hmac_key);
        return $response_digest === $digest ? $output : false;
    }
}