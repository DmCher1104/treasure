<?php

use yii\helpers\Url;

/* @var $article app\models\Article */
/* @var $popular_articles app\models\Article */
/* @var $last_articles app\models\Article */
/* @var $categories app\models\Category */
/* @var $comment_form app\models\CommentForm */
/* @var $comments app\models\CommentForm */
?>

<!--main content start-->
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <article class="post">
                    <div class="post-thumb">
                        <a href="blog.html"><img src="<?= $article->getImage() ?>" alt=""></a>
                    </div>
                    <div class="post-content">
                        <header class="entry-header text-center text-uppercase">
                            <h6>
                                <a href="<?= Url::toRoute(['site/category', 'id' => $article->category->id]); ?>"> <?= $article->category->title ?></a>
                            </h6>

                            <h1 class="entry-title">
                                <a href="<?= Url::toRoute(['site/view', 'id' => $article->id]); ?>"> <?= $article->title ?></a>
                            </h1>


                        </header>
                        <div class="entry-content">
                            <p><?= $article->content ?>
                            </p>
                        </div>

                        <!--                        ВЫВОД ТЭГОВ сделать !!!!!!!!!!!-->
                        <div class="decoration">
                            <a href="#" class="btn btn-default">Decoration4444</a>
                        </div>

                        <div class="social-share">
							<span
                                    class="social-share-title pull-left text-capitalize">By <?=$article->author->name ?> on <?= $article->getDate() ?></span>
                            <ul class="text-center pull-right">
                                <li><a class="s-facebook" href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a class="s-twitter" href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a class="s-google-plus" href="#"><i class="fa fa-google-plus"></i></a></li>
                                <li><a class="s-linkedin" href="#"><i class="fa fa-linkedin"></i></a></li>
                                <li><a class="s-instagram" href="#"><i class="fa fa-instagram"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </article>

                <?= $this->render('/parts/commentField',[
                    'article'=>$article,
                    'comments'=>$comments,
                    'comment_form'=>$comment_form,
                ]) ?>
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