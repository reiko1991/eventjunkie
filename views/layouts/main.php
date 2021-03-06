<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>


<link rel="icon" href="<?php  echo \Yii::$app->request->getBaseUrl() .'/favicon.png' ?>" type="image/x-icon">


    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body onload="init()">

<?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => 'EventJunkie',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-left'],
            'items' => [
                ['label' => 'Info', 'url' => ['/site/about']],
                ['label' => 'Contact', 'url' => ['/site/contact']],
            ], 
        ]);

        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                /*                    ['label' => 'Home', 'url' => ['/site/index']],
                                    ['label' => 'About', 'url' => ['/site/about']],
                                    ['label' => 'Contact', 'url' => ['/site/contact']],*/
                //['label' => 'Create event',  'url' =>  Yii::$app->user->isGuest ?  Yii::$app->request->BaseUrl.'/index.php?r=user/login' :  \Yii::$app->request->BaseUrl.'/index.php?r=event/create' ],
                // not logged in
                ['label' => 'Register', 'url' => ['/user/register'], 'visible'=>  Yii::$app->user->isGuest],
                ['label' => 'Login', 'url' => ['/user/login'], 'visible' => Yii::$app->user->isGuest],
                // admin
                ['label' => 'Manage users', 'url' => ['/user/admin'], 'visible' => !Yii::$app->user->isGuest && Yii::$app->user->can('admin')],
                ['label' => 'Manage events', 'url' => ['/event/admin'], 'visible' => !Yii::$app->user->isGuest && Yii::$app->user->can('admin')],
                // user
                ['label' => 'My events', 'url' => ['/event/list'], 'visible' => !Yii::$app->user->isGuest && !Yii::$app->user->can('admin')],
                ['label' => 'Create event',  'url' => ['/event/create'], 'visible' => !Yii::$app->user->isGuest && !Yii::$app->user->can('admin')],
                // logged in
                ['label' => Yii::$app->user->displayName, 'url' => ['/user/account'], 'visible'=>  !Yii::$app->user->isGuest],
                ['label' => 'Logout (' . Yii::$app->user->displayName . ')',
                    'url' => ['/user/logout'],
                    'linkOptions' => ['data-method' => 'post'],
                    'visible' => !Yii::$app->user->isGuest],
 /*               Yii::$app->user->isGuest ?
                    ['label' => 'Login', 'url' => ['/user/login']] :
                    ['label' => 'Logout (' . Yii::$app->user->displayName . ')',
                        'url' => ['/user/logout'],
                        'linkOptions' => ['data-method' => 'post']],*/
            ],
        ]);
        NavBar::end();
        ?>

        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; EventJunkie <?= date('Y') ?></p>
            <!-- <p class="pull-right"><?= Yii::powered() ?></p> -->
        </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
