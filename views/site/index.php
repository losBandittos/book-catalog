<?php

/** 
 * @var yii\web\View $this
 * @var app\models\User $currentUser
 */

use yii\bootstrap\Html;

$this->title = 'Test Application';
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4 mb-3">
                <?
                    if ($currentUser->isGuest()) {
                        echo Html::a('Upgrade to USER', ['/site/upgrade-guest-to-user'], ['class' => 'btn']);
                    }
                    if ($currentUser->isUser()) {
                        echo Html::a('Downgrade to GUEST', ['/site/downgrade-user-to-guest'], ['class' => 'btn']);
                    }
                ?>
            </div>
        </div>

    </div>
</div>