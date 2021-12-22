<?php

namespace app\models;

use yii\data\Pagination;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string|null $title
 */
class Category extends ActiveRecord
{

    public static function tableName()
    {
        return 'category';
    }

    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
        ];
    }

    public function getArticles()
    {
        return $this->hasMany(Article::class, ['category_id' => 'id']);
    }

    public function getArticlesCount()
    {
        return $this->getArticles()->count();
    }

    public static function getAll()
    {
        return Category::find()->all();
    }

    public static function getArticlesByCategory($id)
    {

        $query = Article::find()->where(['category_id' => $id]);

        $countQuery = clone $query;
        $pagination = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 4]);

        $articles = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return ['articles' => $articles, 'pagination' => $pagination];
    }
}
