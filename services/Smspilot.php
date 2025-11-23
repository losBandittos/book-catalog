<?php

namespace app\services;

use Yii;

class Smspilot {
    const BASE_URL = 'https://smspilot.ru/api.php';
    const SUCCESS_STATUS = '0';

    static function sendSms($phone, $text) {
        $params = [
            'format' => 'json',
            'apikey' => Yii::$app->params['smspilot_apikey'],
            'to' => self::_formatPhone($phone),
            'send' => $text
        ];
        $queryString = http_build_query($params);
        $url = self::BASE_URL . '?' . $queryString;
        $response = json_decode(file_get_contents($url));

        return $response->send[0]->status === self::SUCCESS_STATUS;
    }

    static private function _formatPhone($phone) {
        return preg_replace('/[^0-9]+/', '', $phone);
    }
}
