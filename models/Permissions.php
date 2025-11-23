<?php
namespace app\models;

class Permissions {
    const AUTHOR_ADD_EDIT_DELETE = 'author_add_edit_delete';
    const AUTHOR_VIEW = 'author_view';
    const AUTHOR_SUBSCRIBE = 'author_subscribe';

    const BOOK_ADD_EDIT_DELETE = 'book_add_edit_delete';
    const BOOK_VIEW = 'book_view';

    static function getAllPermissions() : array {
        $reflectionClass = new \ReflectionClass(static::class);
        return $reflectionClass->getConstants();
    }
}
