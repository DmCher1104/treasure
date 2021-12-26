<?php

namespace app\controllers;

use app\models\Article;
use app\models\Category;
use app\models\CommentForm;
use app\models\ContactForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class SiteController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $data = Article::getAll(2);

        $popular_articles = Article::getPopular();
        $last_articles = Article::getLast();
        $categories = Category::getAll();

        return $this->render('index', [
            'articles' => $data['articles'],
            'pages' => $data['pagination'],
            'popular_articles' => $popular_articles,
            'last_articles' => $last_articles,
            'categories' => $categories,
        ]);
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionView($id)
    {
        $article = Article::find()->where(['id' => $id])->one();

        $popular_articles = Article::getPopular();
        $last_articles = Article::getLast();
        $categories = Category::getAll();

        $comments = $article->getArticleComments();
        $comment_form = new CommentForm();


        return $this->render('single-post', [
            'article' => $article,
            'popular_articles' => $popular_articles,
            'last_articles' => $last_articles,
            'categories' => $categories,
            'comments' => $comments,
            'comment_form' => $comment_form,
        ]);
    }

    public function actionCategory($id)
    {

        $data = Category::getArticlesByCategory($id);

        $popular_articles = Article::getPopular();
        $last_articles = Article::getLast();
        $categories = Category::getAll();

        return $this->render('category', [
            'articles' => $data['articles'],
            'pages' => $data['pagination'],
            'popular_articles' => $popular_articles,
            'last_articles' => $last_articles,
            'categories' => $categories,

        ]);
    }

    public function actionComment($id){
        $model = new CommentForm();

        if (Yii::$app->request->isPost){
            $model->load(Yii::$app->request->post());
            if ($model->saveComment($id)){

                Yii::$app->getSession()->setFlash('comment', 'Your comment will confirmed soon :)');
                return $this->redirect(['site/view', 'id'=>$id]);
            }
        }
    }
}
