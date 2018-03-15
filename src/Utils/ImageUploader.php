<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 15/03/2018
 * Time: 19:27
 */

namespace App\Utils;


class ImageUploader
{

    private $files;
    private $allowedFiles;
    /**
     * ImageUploader constructor.
     */
    public function __construct($files)
    {
        $this->files = $files;
        $this->allowedFiles = ['jpeg', 'png', 'jpg'];
    }

    public function beginUpload()
    {
        $fileNames = [];
        $fileArray = $this->files;

        foreach ($fileArray as $file)
        {
            if(!in_array($file->getClientOriginalExtension(), $this->allowedFiles))
            {
                return null;
            }

            if($file->getClientSize() > 100000)
            {
                return null;
            }
        }

        foreach ($fileArray as $file)
        {
            $name = $this->getNewFileName().'.'.$file->guessExtension();
            $fileName = '/images/foods/'.$name;
            array_push($fileNames, $fileName);
            echo $_SERVER['DOCUMENT_ROOT'].$fileName;
            $file->move($_SERVER['DOCUMENT_ROOT'].'/images/foods/', $name);
        }

        return $fileNames;

    }

    private function getNewFileName()
    {
        return md5(uniqid());
    }
}