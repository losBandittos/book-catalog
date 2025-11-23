<?php

/** 
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var boolean $canAddNew
 */

use yii\bootstrap\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'Authors';
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4 mb-3">
                <?
                    if ($canAddNew) {
                        echo Html::a('Add new Author', ['/author/add'], ['class' => 'btn']);
                    }
                ?>
                <br>
                <br>
                <br>
                <?
                    echo GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'attribute' => 'fio',
                                'content' => function ($author) {
                                    return Html::a($author->fio, Url::to(['author/view/' . $author->id]));
                                }
                            ],
                        ],
                    ]);
                ?>
            </div>
        </div>

    </div>
</div>