<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class File_handler
{
    function get_fa_icon($path)
    {
        if(!file_exists($path))
        {
            return false;
        }
        $extension = pathinfo($path,PATHINFO_EXTENSION);
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $content_type=finfo_file($finfo, $path);
        switch($extension)
        {
            case '.docx':
                return 'fa-file-word-o';
            case '.xlsx':
                return 'fa-file-excel-o';
            case '.pptx':
                return 'fa-file-powerpoint-o';
            case '.xml':
                return 'fa-file-code-o';
        }
        if(strpos($content_type,'application')!==false)
        {
            switch($content_type)
            {
                case'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
                case 'application/msword':
                case 'application/vnd.oasis.opendocument.text':
                    return 'fa-file-word-o';
                case 'application/vnd.oasis.opendocument.presentation':
                case 'application/vnd.openxmlformats-officedocument.presentationml.presentation':
                case 'application/vnd.ms-powerpoint':
                    return 'fa-file-powerpoint-o';
                case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
                case 'application/vnd.ms-excel':
                case 'application/vnd.oasis.opendocument.spreadsheet':
                    return 'fa-file-excel-o';
                case 'application/pdf';
                    return 'fa-file-pdf-o';break;
                case 'application/ogg';
                    return 'fa-file-audio-o';break;
                case 'application/zip';
                    return 'fa-file-archive-o';break;
                default:
                    return 'fa-file-o';break;
            }
        }
        elseif(strpos($content_type,'audio')!==false)
        {
            return 'fa-file-audio-o';
        }
        elseif(strpos($content_type,'video')!==false)
        {
            return 'fa-file-video-o';
        }
        elseif(strpos($content_type,'image')!==false)
        {
            return 'fa-file-image-o';
        }
        elseif(strpos($content_type,'text')!==false)
        {
            return 'fa-file-text-o';
        }
        else
        {
            return 'fa-file-o';
        }
    }

    function get_file_size($path, $precision=2, $use_binary=true)
    {
        $size=filesize($path);
        $mult= $use_binary ? 1024 : 1000;
        $base = log($size) / log($mult);
        $suffixes = $use_binary ? array('  B', ' KiB', ' MiB', ' GiB', ' TiB') : array(' B', ' KB', ' MB', ' GB', ' TB');
        return round(pow($mult, $base - floor($base)), $precision) . $suffixes[floor($base)];
    }

}