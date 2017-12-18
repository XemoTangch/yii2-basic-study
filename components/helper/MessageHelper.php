<?php
/**
 * Author: jiangm
 * Email: jmphper@foxmail.com
 * Date: 2017/12/18
 * Time: 15:36
 * Desc:
 */
namespace app\components\helper;

use yii\base\Component;
use app\components\event\MessageEvent;

class MessageHelper extends Component
{
    const EVENT_MESSAGE_SEND = 'message-send'; // 消息发送事件

    /**
     * 发送消息
     * @param $message
     * @return mixed
     */
    public function send($message){
        // 发送消息逻辑
        echo 'send "'.$message.'" ok';
        echo '<br/>';

        // 触发事件
        $event = new MessageEvent();
        $event->message = $message;
        $this->trigger(self::EVENT_MESSAGE_SEND, $event);
    }

}