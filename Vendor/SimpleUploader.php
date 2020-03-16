<?php
namespace Vendor;

use Vendor\SimpleImage;
use Framework\Helpers\Random;
use Framework\Http\Uploader\File;
use Framework\FileSystem\FileManager;

class SimpleUploader
{

    protected $directory;

    public function __construct(string $directory)
    {
        $this->directory = $directory;

        FileManager::checkDIR($this->directory);
    }

    public function upload(File $file)
    {
        if ($file->isValid() === false) {
            return false;
        }

        $image = new SimpleImage($file->temp_path);

        $imagePath = FileManager::returnUniquePath($this->directory . DS . Random::str(8) . '.jpg');

//        $image->thumbnail(512, 512)->toFile($imagePath, null, 70);
        $image->resize(512)->toFile($imagePath, null, 70);

        return $imagePath;
    }
}
