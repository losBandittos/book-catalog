<?php

/** 
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var boolean $canAddNew
 */

use yii\bootstrap\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'Books';
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4 mb-3">
                <?
                    if ($canAddNew) {
                        echo Html::a('Add new Book', ['/book/add'], ['class' => 'btn']);
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
                            'year',
                            [
                                'attribute' => 'title',
                                'content' => function ($book) {
                                    return Html::a($book->title, Url::to(['book/view/' . $book->id]));
                                },
                            ],
                            [
                                'attribute' => 'authors',
                                'content' => function ($book) {
                                    return $book->authorFios;
                                },
                            ],
                            'isbn',
                            'cover_link'
                        ],
                    ]);
                ?>
            </div>
        </div>

    </div>
</div>