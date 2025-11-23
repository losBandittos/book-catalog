<?php

/** 
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 */

use yii\grid\GridView;

?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4 mb-3">
                <?
                    echo GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            'id',
                            'fio'
                        ],
                    ]);
                ?>
            </div>
        </div>

    </div>
</div>