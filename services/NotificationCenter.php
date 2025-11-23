<?php

namespace app\services;

use app\models\Book;
use app\models\Notification;
use yii\helpers\Url;

class NotificationCenter {

    static function addNotifications(Book $book) {
        foreach ($book->authors as $author) {
            foreach($author->subscribers as $subscriber) {
                $existNotification = Notification::findOne([
                    'user_id' => $subscriber->id,
                    'book_id' => $book->id,
                ]);
                if ($existNotification === null) {
                    $subscriber->link('bookNotifications', $book, ['was_sent' => false]);
                }
            }
        }
    }

    static function sendNewNotifications() {
        foreach(Notification::findAll(['was_sent' => 0]) as $notification) {
            self::_sendNotification($notification);
        }
    }

    static private function _sendNotification(Notification $notification) {
        $phone = $notification->user->phone;
        $text = 'New book added. ' . Url::to(['book/view/' . $notification->book->id]);
        if (Smspilot::sendSms($phone, $text)) {
            $notification->was_sent = true;
            $notification->save();
        }
    }
}
