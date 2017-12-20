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
use yii\base\Event;

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
        echo 'send " message '.$message.'" ok';
        echo '<br/>';

        // 触发事件
        $event = new MessageEvent();
        $event->message = $message;
        $this->trigger(self::EVENT_MESSAGE_SEND, $event);
    }

    /**
     * 更改消息内容
     * @param $message
     * @return mixed
     */
    public function changeMessage($message){
        // 修改消息
        echo 'change message "'.$message.'" ok';

        // 触发类级别事件
        $event = new MessageEvent();
        $event->message = $message;
        Event::trigger($this->className(), self::EVENT_MESSAGE_SEND, $event);
    }

}