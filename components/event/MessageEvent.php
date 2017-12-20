<?php
/**
 * Author: jiangm
 * Email: jmphper@foxmail.com
 * Date: 2017/12/18
 * Time: 15:08
 * Desc:
 */

namespace app\components\event;

use yii\base\Event;

class MessageEvent extends Event
{
    public $message;

    /**
     * 消息发送事件处理器
     * @param $event
     */
    public function onMessageSend($event){
        echo '消息发送事件';
        echo '<br/>';
        echo strtoupper($event->message);
        echo '<br/>';
    }

    /**
     * 消息日志事件处理器
     * @param $event
     */
    public function onMessageLog($event){
        echo '消息日志事件';
        echo '<pre>';
        print_r($event->data);
        echo '</pre>';
        echo '<br/>';
        echo ucfirst($event->message);
        echo '<br/>';
    }

    /**
     * 消息用户信息处理器
     * @param $event
     */
    public function onDealUserInfo($event){
        echo '处理用户信息2';
        echo '<pre>';
        print_r($event->data);
        echo '</pre>';
        echo '<br/>';
    }
}