<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class File_conversion extends MX_Controller
{

    function convert_document($input_mode, $from, $to)
    {
        //TODO: Create temp file with convert request: from upload or content HTML code
        //TODO: Get convert mode (extension to/from)
        if($convert_mode === 'local')
        {
            //TODO: Lanuch local conversion
        }
        elseif($convert_mode === 'remote')
        {
            //TODO: Lanuch remote conversion
        }
    }
}