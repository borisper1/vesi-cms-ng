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

    function preview_mode($path){
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type=finfo_file($finfo, $path);
        if(strpos($mime_type,"audio")!==false){
            return "audio";
        }elseif(strpos($mime_type,"video")!==false){
            return "video";
        }elseif(strpos($mime_type,"image")!==false){
            return "image";
        }elseif($mime_type=="application/pdf"){
            return "pdf";
        }else{
            return false;
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

    private function get_folder_size_raw($path)
    {
        $count_size = 0;
        $count = 0;
        $dir_array = scandir($path);
        foreach($dir_array as $key=>$filename){
            if($filename!=".." && $filename!="."){
                if(is_dir($path."/".$filename)){
                    $new_foldersize = $this->get_folder_size_raw($path."/".$filename);
                    $count_size = $count_size+ $new_foldersize;
                }else if(is_file($path."/".$filename)){
                    $count_size = $count_size + filesize($path."/".$filename);
                    $count++;
                }
            }
        }
        return $count_size;
    }

    function get_folder_size($path, $precision=2, $use_binary=true)
    {
        $size=$this->get_folder_size_raw($path);
        $mult= $use_binary ? 1024 : 1000;
        $base = log($size) / log($mult);
        $suffixes = $use_binary ? array('  B', ' KiB', ' MiB', ' GiB', ' TiB') : array(' B', ' KB', ' MB', ' GB', ' TB');
        return round(pow($mult, $base - floor($base)), $precision) . $suffixes[floor($base)];
    }

    function get_path_array($path)
    {
        //TODO: Move protection to controller
        if(!in_array(explode('/', $path)[0], array('files', 'img'))){
            return false;
        }
        $output = [];
        $base_path = FCPATH.$path;
        $fs_array=array_diff(scandir($base_path),array('..', '.', '.DS_Store'));
        foreach($fs_array as $fs)
        {
            $full_path = $base_path.'/'.$fs;
            if(is_dir($full_path))
            {
                $directory = array(
                    'icon' => 'fa-folder',
                    'type' => 'folder',
                    'name' => $fs,
                    'size' => $this->get_folder_size($full_path),
                    'edit_date' => date("d/m/Y",stat($full_path)['mtime']),
                    'path' => $path.'/'.$fs
                );
                $output[]=$directory;
            }
            else
            {
                $previewable = $this->preview_mode($full_path);
                $file = array(
                    'icon' => $this->get_fa_icon($full_path),
                    'type' => $previewable ? 'file-previewable' : 'file',
                    'name' => $fs,
                    'size' => $this->get_file_size($full_path),
                    'edit_date' => date("d/m/Y",filemtime($full_path)),
                    'path' => $path.'/'.$fs
                );
                if($previewable)
                {
                    $file['preview_mode'] = $previewable;
                }
                $output[]=$file;
            }
        }
        return $output;
    }

}