<?php

namespace app\models;

use Yii;
use yii\data\Pagination;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
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
            [['date'], 'default', 'value' => date('Y-m-d h-m')], //дефолт знач для даты (тек дата)
            [['title'], 'string', 'min' => 3, 'max' => 255],
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

    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function getTags()
    {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])
            ->viaTable('article_tag', ['article_id' => 'id']);
    }

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function getSelectedTags()
    {
        $selectedInd = $this->getTags()->select('id')->asArray()->all();

        return ArrayHelper::getColumn($selectedInd, 'id');
    }

    public function saveCategory($category_id)
    {
        $category = Category::findOne($category_id);

        if ($category !== null) {
            $this->link('category', $category);
            return true;
        }
    }

    public function saveTags($tags)
    {
        $this->clearCurrentTags();

        if (is_array($tags)) {
            foreach ($tags as $tag_id) {
                $tag = Tag::findOne($tag_id);
                $this->link('tags', $tag);
            }
        }
    }

    public function saveImage($file_name): bool
    {
        $this->image = $file_name;
        return $this->save(false);
    }

    public function getImage()
    {
        return ($this->image) ? '/uploads/' . $this->image : '/uploads/no-image.png';
    }

    public function deleteImage()
    {
        $image_upload_model = new ImageUpload();

        $image_upload_model->deleteCurrentImage($this->image);
    }

    public function beforeDelete()
    {
        $this->deleteImage();
        return parent::beforeDelete();
    }

    public function clearCurrentTags()
    {
        ArticleTag::deleteAll(['article_id' => $this->id]);
    }

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function getDate()
    {
        return Yii::$app->formatter->asDate($this->date);
    }

    public static function getAll($pageSize = 3)
    {
        $query = Article::find();

        $countQuery = clone $query;
        $pagination = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => $pageSize]);

        $articles = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return ['articles' => $articles, 'pagination' => $pagination];
    }

    public static function getPopular()
    {
        return Article::find()->orderBy('viewed desc')->limit(3)->all();
    }

    public static function getLast()
    {
        return Article::find()->orderBy('viewed desc')->limit(3)->all();
    }

}
