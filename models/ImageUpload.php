<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class ImageUpload extends Model
{
    public $image;

    public function rules(): array
    {
        return [
            [['image'], 'required'],
            [['image'], 'file', 'extensions' => 'jpeg, png,jpg']
        ];
    }

    public function uploadFile(UploadedFile $file, $current_image)
    {
        $this->image = $file;

        if ($this->validate()) {

            $this->deleteCurrentImage($current_image);

            return $this->saveImage();
        }
    }

    private function getFolder(): string
    {
        return Yii::getAlias('@web') . 'uploads/';
    }

    private function generateFileName(): string
    {
        return strtolower(md5(uniqid($this->image->baseName)) . '.' . $this->image->extension);
    }

    public function deleteCurrentImage($current_image)
    {
        if ($this->fileExists($current_image)) {

            unlink($this->getFolder() . $current_image);
        }
    }

    private function fileExists($current_image)
    {
        if (!empty($current_image )){
            return is_file($this->getFolder() . $current_image) && file_exists($this->getFolder() . $current_image);
        }
    }

    private function saveImage(): string
    {
        $file_name = $this->generateFileName();

        $this->image->saveAs($this->getFolder() . $file_name);

        return $file_name;
    }
}