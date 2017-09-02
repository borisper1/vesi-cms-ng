<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class File_handler
{
    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
    }

    function get_fa_icon($path)
    {
        if(!file_exists($path))
        {
            return false;
        }
        $extension = '.'.pathinfo($path,PATHINFO_EXTENSION);
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

    function get_folder_size_raw($path)
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
        return $size===0 ? '0 B' : round(pow($mult, $base - floor($base)), $precision) . $suffixes[floor($base)];
    }

    function get_path_array($path)
    {
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

    function get_root_path_array()
    {
        $output = [];
        $full_path = FCPATH.'/files';
        $output[] = array(
            'icon' => 'fa-folder',
            'type' => 'folder',
            'name' => 'files',
            'size' => $this->get_folder_size($full_path),
            'edit_date' => date("d/m/Y",stat($full_path)['mtime']),
            'path' => 'files'
        );
        $full_path = FCPATH.'/img';
        $output[] = array(
            'icon' => 'fa-folder',
            'type' => 'folder',
            'name' => 'img',
            'size' => $this->get_folder_size($full_path),
            'edit_date' => date("d/m/Y",stat($full_path)['mtime']),
            'path' => 'img'
        );
        return $output;
    }

    function get_path_indicator_array($path)
    {
        $output = [];
        $path_items=explode('/',$path);
        $last_value = end($path_items);
        $previous_path = '';
        foreach($path_items as $item){
            $output[] = array('path' =>$previous_path.$item, 'name' => $item, 'active' => $item===$last_value);
            $previous_path.=$item.'/';
        }
        return $output;
    }

    function rename_path($path, $new_name)
    {
        $path_array = explode('/', $path);
        if(array_pop($path_array) !==  $new_name)
        {
            $base_path = implode(('/'), $path_array);
            return rename(FCPATH.$path, FCPATH.$base_path.'/'.$new_name);
        }
        else
        {
            return true;
        }
    }

    function delete_path($path)
    {
        if(is_dir(FCPATH.$path))
        {
            $this->CI->load->helper('file');
            delete_files(FCPATH.$path, TRUE);
            return rmdir(FCPATH.$path);
        }
        else
        {
            return unlink(FCPATH.$path);
        }
    }

    function pack_zip($paths, $base_path)
    {
        $output_id = uniqid();
        $output = APPPATH.'tmp/'.$output_id.'.zip';
        $zip = new ZipArchive();
        $zip->open($output, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        foreach($paths as $path)
        {
            $relative_path = substr($path, strlen($base_path) + 1);
            if(is_dir(FCPATH.$path))
            {
                //Code to compress a directory
                $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(FCPATH.$path), RecursiveIteratorIterator::LEAVES_ONLY);
                foreach ($files as $name => $file)
                {
                    if (!$file->isDir())
                    {
                        // Get real and relative path for current file
                        $filePath = $file->getRealPath();
                        $relativePath = substr($filePath, strlen(FCPATH.$base_path) + 1);
                        $zip->addFile($filePath, $relativePath);
                    }
                }
            }
            else
            {
                $zip->addFile(FCPATH.$path, $relative_path);
            }
        }
        $zip->close();
        $final_url = 'files/converted_files/'.$output_id.'.zip';
        if(!file_exists($output))
        {
            return false;
        }
        rename($output, FCPATH.$final_url);
        return base_url($final_url);
    }

    function move_path($path, $target)
    {
        $path_array = explode('/', $path);
        $file_name = end($path_array);
        return rename(FCPATH.$path, FCPATH.$target.'/'.$file_name);
    }

    function copy_path($path, $target)
    {
        $path_array = explode('/', $path);
        $file_name = end($path_array);
        if(is_dir(FCPATH.$path))
        {
            $this->recursive_copy(FCPATH.$path, FCPATH.$target.'/'.$file_name);
        }
        else
        {
            copy(FCPATH.$path, FCPATH.$target.'/'.$file_name);
        }
    }

    function new_folder($path)
    {
        return mkdir(FCPATH.$path);
    }

    protected function recursive_copy($src,$dst)
    {
        $dir = opendir($src);
        @mkdir($dst);
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . '/' . $file) ) {
                    $this->recursive_copy($src . '/' . $file,$dst . '/' . $file);
                }
                else {
                    copy($src . '/' . $file,$dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }

    function remove_empty_subfolders($path, $root = true)
    {
        $empty = true;
        foreach (glob($path . DIRECTORY_SEPARATOR . '*') as $file) {
            $empty &= is_dir($file) && $this->remove_empty_subfolders($file, false);
        }
        return $empty && (!$root) && rmdir($path);
    }

    function command_exists($command)
    {
        if(PHP_OS == 'WINNT')
        {
            return !empty(shell_exec('where '.escapeshellarg($command)));
        }
        else
        {
            //Standard POSIX
            return !empty(shell_exec('command -v '.escapeshellarg($command)));
        }
    }
}