<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $description
 * @property string|null $content
 * @property string|null $date
 * @property string|null $image
 * @property int|null $viewed
 * @property int|null $user_id
 * @property int|null $status
 * @property int|null $category_id
 *
 * @property ArticleTag[] $articleTags
 * @property Comment[] $comments
 */
class Article extends ActiveRecord
{

    public static function tableName(): string
    {
        return 'article';
    }

    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title', 'description', 'content'], 'string'],
//            [['date'], 'date', 'format' => 'php:Y-m-d'],  // м.б стоит убрать присвоение даты
            [['date'], 'default', 'value' => date('Y-m-d')], //дефолт знач для даты (тек дата)
            [['title'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'content' => 'Content',
            'date' => 'Date',
            'image' => 'Image',
            'viewed' => 'Viewed',
            'user_id' => 'User ID',
            'status' => 'Status',
            'category_id' => 'Category ID',
        ];
    }

    public function saveImage($file_name): bool
    {
        $this->image = $file_name;
        return $this->save(false);
    }

    public function getImage(){
        return($this->image) ? '/uploads/'.$this->image : '/uploads/no-image.png'  ;
    }

    public function deleteImage(){
        $imageUploadModel = new ImageUpload();

        $imageUploadModel->deleteCurrentImage($this->image);
    }

    public function beforeDelete()
    {
        $this->deleteImage();
        return parent::beforeDelete();
    }


}
