<?php
namespace App\Lib\Uploader;

use File;

/**
 * File Upload Library
 *
 * @package App\lib
 * @author  Md.AtiqulHaque <md_atiqulhaque@yahoo.com>
 * @author  Syed Abidur Rahman <aabid048@gmail.com>
 */
class FileUpload
{
    private $uploader;

    public function __construct()
    {
        $this->uploader = new UploadHandler();
    }

    public function doUpload(array $options)
    {
        if (isset($_GET['done'])) {
            $result = $this->uploader->combineChunks('files');
        } else {
            $destination =  $options['path'];
            File::isDirectory($destination) || File::makeDirectory($destination, 0755, true, true);
            $result = $this->uploader->handleUpload($options['path'],$options['fileName']);
            $result['uploadName'] = $this->uploader->getUploadName();
        }

        return $result;
    }

    public function getFileName()
    {
       return $this->uploader->getName();
    }
}
