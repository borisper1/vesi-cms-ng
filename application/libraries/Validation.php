<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Validation
{

    function filter_html($data, $allow_iframe)
    {
        $htmLawed_settings = array(
            'safe' => 1,
            'abs_url' => 1,
            'base_url' => base_url(),
            'elements' => $allow_iframe ? '*+iframe' : null
        );
        include_once(APPPATH.'third_party/htmLawed/htmLawed.php');
        return trim(htmLawed($data, $htmLawed_settings));
    }

    function check_json($code)
    {
        json_decode($code);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    function check_path($path)
    {
        return file_exists(FCPATH.$path);
    }

    function check_url($url)
    {
        if(strpos($url,'http://')===0 or strpos($url,'https://')===0 or strpos($url,'ftp://')===0)
        {
            $headers = @get_headers($url);
            return (strpos($headers[0],'404') === false);
        }
        else
        {
            return file_exists(FCPATH.$url);
        }
    }
}