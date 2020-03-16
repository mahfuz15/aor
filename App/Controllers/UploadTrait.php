<?php

namespace App\Controllers;

use Framework\FileSystem\FileManager;
use Framework\Http\Uploader\File;
use Vendor\SimpleImage;

trait UploadTrait
{

    public function uploadFile($file,$path)
    {

        if (!empty($file) && empty($file->error)) {
            $tempPath = $file->tmp_name;
            $filename = $this->sanitizeFileName($file->name);
            $dir = $this->fileDir($path);

            $destination = FileManager::returnUniquePath($dir . DS . $filename);

            move_uploaded_file($tempPath, $destination);

            if (file_exists($destination)) {

                return $path.$filename;
            }
        }

        return false;
    }

    public function sanitizeFileName($filename)
    {
        $pathinfo = pathinfo($filename);

        $filename = strtolower(preg_replace('/[^a-zA-Z0-9\-_]/', '-', $pathinfo['filename']));
        if (strlen($filename) > 25) {
            $filename = substr($filename, 0, 25);
        }

        return $filename . '.' . $pathinfo['extension'];
    }

    public function createDir($dir)
    {
        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }

        return file_exists($dir);
    }

    public function fileDir($path, $ext = false)
    {
        $dir = ROOT . DS . 'Public' . DS . 'files/product/downloads/' . $path;
        if (!empty($ext)) {
            $dir .= DS . $ext;
        }
        $this->createDir($dir);

        return $dir;
    }

    protected function uploadImage(File $file, $folder)
    {
        $dir = FileManager::checkDIR(ROOT . DS . PUBLIC_DIR . DS . 'images' . DS . $folder);

        $image = new SimpleImage($file->temp_path);
        $imageName = \Framework\Helpers\Random::str(8) . '.' . $file->extension;
        $imagePath = FileManager::returnUniquePath($dir . DS . $imageName);
        $image->toFile($imagePath, null, 100);
        if (file_exists($imagePath)) {
            return $imageName;
        } else
            return false;
    }

    protected function unlinkImage($file)
    {
        $file_with_path = ROOT . DS . PUBLIC_DIR . DS . $file;
        if (file_exists($file_with_path)) {
            FileManager::unlink(ROOT . DS . PUBLIC_DIR . DS . $file);
        }
    }

}
 