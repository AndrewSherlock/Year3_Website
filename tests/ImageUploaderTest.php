<?php

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageUploaderTest extends TestCase
{

    public function testCreateInstance()
    {

        $imageUploader = new \App\Utils\ImageUploader(new UploadedFile('C:\Users\andrew\Desktop\873625426_a7baa1334b_o.jpg', '873625426_a7baa1334b_o.jpg', 'image/jpeg', 85890));

        $this->assertNotNull($imageUploader);
    }

    public function testUpload()
    {
        $file = new UploadedFile('C:\Users\andrew\Desktop\873625426_a7baa1334b_o.jpg', '873625426_a7baa1334b_o.jpg', 'image/jpeg', 85890);
        $imageUploader = new \App\Utils\ImageUploader($file);

        $imageName = $imageUploader->beginUpload();

        $this->assertNotNull($imageName);
    }

    public function testCheckSize()
    {
        $file = new UploadedFile('C:\Users\andrew\Desktop\873625426_a7baa1334b_o.jpg', '873625426_a7baa1334b_o.jpg', 'image/jpeg', 85890);
        $imageUploader = new \App\Utils\ImageUploader($file);

        $this->assertTrue($imageUploader->checkSize($file->getClientSize(), 1000000));
    }

    public function testCheckSizeFail()
    {
        $file = new UploadedFile('C:\Users\andrew\Desktop\873625426_a7baa1334b_o.jpg', '873625426_a7baa1334b_o.jpg', 'image/jpeg', 85890);
        $imageUploader = new \App\Utils\ImageUploader($file);

        $this->assertFalse($imageUploader->checkSize($file->getClientSize(), 100));
    }

    public function testExtType()
    {

        $allowedFiles = ['jpeg', 'png', 'jpg'];

        $file = new UploadedFile('C:\Users\andrew\Desktop\873625426_a7baa1334b_o.jpg', '873625426_a7baa1334b_o.jpg', 'image/jpeg', 85890);
        $imageUploader = new \App\Utils\ImageUploader($file);

        $this->assertTrue($imageUploader->checkExtType($file->getClientOriginalExtension(), $allowedFiles));

    }

    public function testExtTypeFail()
    {

        $allowedFiles = ['png'];

        $file = new UploadedFile('C:\Users\andrew\Desktop\873625426_a7baa1334b_o.jpg', '873625426_a7baa1334b_o.jpg', 'image/jpeg', 85890);
        $imageUploader = new \App\Utils\ImageUploader($file);

        $this->assertFalse($imageUploader->checkExtType($file->getClientOriginalExtension(), $allowedFiles));

    }

    public function testNameGeneration()
    {
        $file = new \App\Utils\ImageUploader(new UploadedFile('C:\Users\andrew\Desktop\873625426_a7baa1334b_o.jpg', '873625426_a7baa1334b_o.jpg', 'image/jpeg', 85890));
        $imageUploader = new \App\Utils\ImageUploader($file);

        $this->assertNotNull($imageUploader->getNewFileName());
    }
}