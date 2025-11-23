<?php

namespace app\models;

use yii\base\Model;

class TopForm extends Model {
    public $year;

    public function rules() {
        return [
            ['year', 'required'],
            ['year', 'integer', 'min' => Book::APOSTOL_YEAR, 'max' => date('Y')],
        ];
    }
}