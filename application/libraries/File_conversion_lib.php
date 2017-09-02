<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class File_conversion_lib
{
    protected $CI;
    public $format_table = array(
        'winword' => array('extension' => '.docx', 'converter' => 'pandoc', 'pandoc_format' => 'docx'),
        'opendocumenttext' => array('extension' => '.odt', 'converter' => 'pandoc', 'pandoc_format' => 'odt'),
        'pdf' => array('extension' => '.pdf', 'converter' => 'tcpdf'),
        'html' => array('extension' => '.html', 'converter' => null, 'pandoc_format' => 'html5')
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

    public function convert_from_html_text($input, $public_name, $to)
    {
        $temp_input = APPPATH . 'tmp/' . uniqid() . '.html';
        file_put_contents($temp_input, $input);
        $result = $this->convert_from_html_file($temp_input, $public_name, $to);
        unlink($temp_input);
        return $result;
    }

    public function convert_from_html_file($input, $public_name, $to)
    {
        if ($this->CI->db_config->get('file_conversion', 'enable_file_conversion') == 0 or  !file_exists($input))
            return false;
        $format_prop = $this->format_table[$to];
        if($format_prop['converter'] === 'tcpdf')
        {
            $output_temp = $this->execute_tcpdf($input);
        }
        else if($format_prop['converter'] === 'pandoc')
        {
            $output_temp = $this->execute_pandoc($input, 'html', $to);
        }
        if($output_temp == false)
            return false;
        if ($public_name !== null)
        {
            rename($output_temp, FCPATH . 'files/converted_files/' . $public_name . $format_prop['extension']);
            if (file_exists(FCPATH . 'files/converted_files/' . $public_name . $format_prop['extension']))
                return base_url('files/converted_files/' . $public_name . $format_prop['extension']);
            else
                return false;
        }
        else
        {
            return $output_temp;
        }
    }

    public function convert_to_html($input, $format)
    {
        if ($this->CI->db_config->get('file_conversion', 'enable_file_conversion') == 0 or $this->CI->db_config->get('file_conversion', 'enable_pandoc') == 0 or !file_exists($input))
            return false;
        $format_prop = $this->format_table[$format];
        if($format_prop['converter'] !== 'pandoc' or '.'.pathinfo($input,PATHINFO_EXTENSION) !== $format_prop['extension'])
            return false;
        //TODO: export_images = true causes pandoc import process to fail completely so for the moment image import is disabled (possible permission issue)
        $output_temp = $this->execute_pandoc($input, $format_prop['pandoc_format'], 'html', false);
        //Post conversion fixes: table classes
		if(!file_exists($output_temp))
			return false;
		//HTML post-processor: fix table classes
		$output_html = file_get_contents($output_temp);
		$output_html = str_replace('<table>', '<table class="table">',$output_html);
		//HTML post-processor: import image files
		//OK: list all image files in application/tmp/media folder: then move them to img/autoimported and link them to
		//the HTML document
		if(file_exists(APPPATH.'tmp/media'))
		{
			$this->CI->load->library('file_handler');
			$fs_array=array_diff(scandir(APPPATH.'tmp/media'),array('..', '.', '.DS_Store'));
			foreach($fs_array as $fs)
			{
				if(is_file(APPPATH.'tmp/media/'.$fs))
				{
					$type = $this->CI->file_handler->preview_mode(APPPATH.'tmp/media/'.$fs);
					if($type == 'image')
					{
						//OK move the image to the autoimported folder
						if(!file_exists(FCPATH.'img/autoimported'))
							mkdir(FCPATH.'img/autoimported');
						$extension = '.'.pathinfo(APPPATH.'tmp/media/'.$fs,PATHINFO_EXTENSION);
						$new_path = 'img/autoimported/'.uniqid().$extension;
						copy(FCPATH.'application/tmp/media/'.$fs, FCPATH.$new_path);
						$output_html = str_replace('src="'.APPPATH.'tmp/media/'.$fs.'"', 'src="'.base_url($new_path).'"', $output_html);
					}
				}
			}
		}

		file_put_contents($output_temp, $output_html);
        return $output_temp;
    }

    private function execute_tcpdf($input)
    {
        if($this->CI->db_config->get('file_conversion', 'enable_tcpdf') == 0)
            return false;
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

    private function execute_pandoc($input, $from, $to, $export_images = false)
    {
        if ($this->CI->db_config->get('file_conversion', 'pandoc_execute_on_remote') == 1)
        {
            return $output_file = $this->execute_pandoc_remote($input, $from, $to);
        }
        $output = APPPATH . 'tmp/' . uniqid() . $this->format_table[$to]['extension'];
        $command = 'pandoc -f ' . escapeshellarg($from) . ' -t ' . escapeshellarg($this->format_table[$to]['pandoc_format']) . ' -o ' . escapeshellarg($output) . ' -i ' . escapeshellarg($input) . ' --mathjax';
        if($export_images)
		{
			$this->CI->load->helper('file');
			if(file_exists(APPPATH.'tmp/media'))
				delete_files(APPPATH.'tmp/media', true);
			$command .= ' --extract-media ' . escapeshellarg(APPPATH.'tmp');
		}
		exec($command);
        if (!file_exists($output))
        {
            $output = false;
        }
        return $output;
    }

    private function execute_pandoc_remote($input, $from, $to)
    {
        $transaction_id = base64_encode($this->security->get_random_bytes(32));
        $url = $this->CI->db_config->get('file_conversion', 'remote_server_url');
        $token = $this->CI->db_config->get('file_conversion', 'remote_server_token');
        $hmac_key = base64_decode($this->CI->db_config->get('file_conversion', 'hmac_key'));
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