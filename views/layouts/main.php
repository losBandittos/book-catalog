<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\models\Permissions;
use app\widgets\Alert;
use yii\bootstrap\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header id="header">
    <?php
    // NavBar::begin([
    //     'brandLabel' => Yii::$app->name,
    //     'brandUrl' => Yii::$app->homeUrl,
    //     'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top']
    // ]);
    $navItems = [];
    $navItems[] =  ['label' => 'Top Authors', 'url' => ['/author/top']];
    if (Yii::$app->user->can(Permissions::AUTHOR_VIEW)) {
        $navItems[] =  ['label' => 'Authors', 'url' => ['/author']];
    }
    if (Yii::$app->user->can(Permissions::BOOK_VIEW)) {
        $navItems[] =  ['label' => 'Books', 'url' => ['/book']];
    }
    if (Yii::$app->user->isGuest) {
        $navItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $navItems[] = '<li class="nav-item">'
        . Html::beginForm(['/site/logout'])
        . Html::submitButton(
            'Logout (' . Yii::$app->user->identity->username . ')',
            []//['class' => 'nav-link btn btn-link logout']
        )
        . Html::endForm()
        . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => $navItems
    ]);
    // NavBar::end();
    ?>
</header>

<main id="main" class="flex-shrink-0" role="main">
    <div class="container">
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>