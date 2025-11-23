<?php

namespace app\commands\cron;

use app\services\NotificationCenter;
use yii\console\Controller;

class WorkerController extends Controller {

    public function actionSendNewNotifications() {
        NotificationCenter::sendNewNotifications();
    }
}
