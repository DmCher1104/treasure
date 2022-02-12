<?php

use yii\helpers\Url;
use yii\widgets\LinkPager;

/* @var $articles app\models\Article */
/* @var $popular_articles app\models\Article */
/* @var $last_articles app\models\Article */
/* @var $categories app\models\Category */
/* @var $sort yii\data\Sort */
?>

<!--main content start-->
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <?php // echo $sort->link('name') . ' | ' . $sort->link('viewed'). ' | ' . $sort->link('date'); ?>
                <?php if (Yii::$app->session->hasFlash('success')): ?>
                    <div class="alert alert-success alert-dismissible  show" role="alert">
                       <span><?php echo Yii::$app->session->getFlash('success'); ?></span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>
                <?php if (Yii::$app->session->hasFlash('error')): ?>
                    <div class="alert alert-danger alert-dismissible  show" role="alert">
                        <?php echo Yii::$app->session->getFlash('error'); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>
                <?php foreach ($articles as $article): ?>
                    <!--отображаем здесь $model-->
                    <article class="post">
                        <div class="post-thumb">
                            <a href="<?= Url::toRoute(['site/view', 'id' => $article->id]); ?>"><img
                                        src="<?= $article->getImage(); ?>" alt=""></a>

                            <a href="<?= Url::toRoute(['site/view', 'id' => $article->id]); ?>"
                               class="post-thumb-overlay text-center">
                                <div class="text-uppercase text-center">View Post</div>
                            </a>
                        </div>
                        <div class="post-content">
                            <header class="entry-header text-center text-uppercase">
                                <h6>
                                    <a href="<?= Url::toRoute(['site/category', 'id' => $article->category->id]); ?>"> <?= $article->category->title; ?></a>
                                </h6>

                                <h1 class="entry-title"><a
                                            href="<?= Url::toRoute(['site/view', 'id' => $article->id]); ?>"><?= $article->title ?></a>
                                </h1>


                            </header>
                            <div class="entry-content">
                                <p><?= $article->description ?></p>

                                <div class="btn-continue-reading text-center text-uppercase">
                                    <a href="<?= Url::toRoute(['site/view', 'id' => $article->id]); ?>"
                                       class="more-link">Continue Reading</a>
                                </div>
                            </div>
                            <div class="social-share">
                                <span class="social-share-title pull-left text-capitalize">By <a
                                            href="#"> <?= $article->author->name; ?></a> On <?= $article->getDate() ?> </span>
                                <ul class="text-center pull-right">
                                    <li><a class="s-facebook" href="#"><i class="fa fa-eye"></i></a></li>
                                    <?= (int)$article->viewed ?>
                                </ul>
                            </div>
                        </div>
                    </article>

                <?php endforeach; ?>
                <?php
                // отображаем ссылки на страницы
                echo LinkPager::widget([
                    'pagination' => $pages,
                ]);
                ?>
            </div>
            <?= $this->render('/parts/sidebar', [
                'popular_articles' => $popular_articles,
                'last_articles' => $last_articles,
                'categories' => $categories,
            ]) ?>
        </div>
    </div>
</div>
<!-- end main content-->