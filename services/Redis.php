<?php

namespace app\services;

use Yii;

class Redis {
    const AUTHOR_TOP_KEY_PREFIX = 'author_key_';
    const AUTHOR_TOP_LIFE_TIME = 24 * 60 * 60;

    static function saveAuthorTop(?int $year, string $value) {
        self::_put(self::AUTHOR_TOP_KEY_PREFIX . $year, $value);
    }

    static function getAuthorTop(?int $year): ?string {
        return self::_get(self::AUTHOR_TOP_KEY_PREFIX . $year);
    }

    static function deleteAuthorTop(?int $year) {
        self::_delete(self::AUTHOR_TOP_KEY_PREFIX . $year);
    }

    static private function _put($key, $value) {
        Yii::$app->redis->set($key, $value);
        Yii::$app->redis->expire($key, self::AUTHOR_TOP_LIFE_TIME);
    }

    static private function _get($key) {
        return Yii::$app->redis->get($key);
    }

    static private function _delete($key) {
        Yii::$app->redis->del($key);
    }
}
