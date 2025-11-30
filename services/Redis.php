<?php

namespace app\services;

use Yii;

class Redis {
    const AUTHOR_TOP_KEY_PREFIX = 'author_key_';

    static function saveAuthorTop(?int $year, string $value) {
        self::_put(self::AUTHOR_TOP_KEY_PREFIX . $year, $value);
    }

    static function getAuthorTop(?int $year): ?string {
        return self::_get(self::AUTHOR_TOP_KEY_PREFIX . $year);
    }

    static private function _put($key, $value) {
        Yii::$app->redis->set($key, $value);
    }

    static private function _get($key) {
        return Yii::$app->redis->get($key);
    }
}
