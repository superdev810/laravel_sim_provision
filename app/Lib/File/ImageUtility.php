<?php namespace App\Lib\File;

use Auth;
use Illuminate\Support\Facades\File;


/**
 * Image processing class
 *
 * @author Md.Atiqul Haque <md_atiqulhaque@yahoo.com>
 */
class ImageUtility
{

    public function deleteUserUploadFile($path)
    {
        if (!File::isDirectory($path)) {
            return array();
        }
        File::deleteDirectory($path);
    }

    public function getAllFiles($path)
    {
        if (!File::isDirectory($path)) {
            return array();
        }
        return File::allFiles($path);
    }


    public function getProfileTempFiles($id)
    {
        $path = base_path('/public/upload/temp/users/' . $id . '/profile');

        if (!File::isDirectory($path)) {
            return array();
        }
        return File::allFiles($path);
    }


    public function getFileDirectories($userId, $forUpload = false)
    {
        $paths = [
            'real' => 'upload/files/'. $userId,
            'realview' => '/upload/files/' . $userId
        ];

        if ($forUpload)
            return base_path('public/' . $paths['real']);
        else
            return asset($paths['real']);
    }

    public  function lineCount($file) {
        $linecount = 0;
        $handle = fopen($file, "r");
        while(!feof($handle)){
            if (fgets($handle) !== false) {
                $linecount++;
            }
        }
        fclose($handle);
        return  $linecount;
    }
}