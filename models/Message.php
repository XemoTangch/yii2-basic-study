<?php

namespace app\models;

use app\controllers\EventController;
use Yii;
use yii\db\ActiveRecord;
use yii\base\Event;
use app\components\event\MessageEvent;
use app\components\helper\MessageHelper;

/**
 * This is the model class for table "message".
 *
 * @property int $message_id 消息id
 * @property int $uid 用户id
 * @property int $to_uid 接收消息用户
 * @property string $message 消息
 * @property int $ctime 发送时间
 */
class Message extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message_id'], 'required'],
            [['message_id', 'uid', 'to_uid', 'ctime'], 'integer'],
            [['message'], 'string', 'max' => 255],
            [['message_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'message_id' => 'Message ID',
            'uid' => 'Uid',
            'to_uid' => 'To Uid',
            'message' => 'Message',
            'ctime' => 'Ctime',
        ];
    }

    /**
     * 类级别事件绑定
     */
    public function messageEventOn1(){
        $message_event = new MessageEvent();
        // 附加类级别事件处理器（绑定类级别事件）
        Event::on(MessageHelper::className(), MessageHelper::EVENT_MESSAGE_SEND, [$message_event, 'onDealUserInfo'], ['message_event_on1'=>'message_event_on1']);
    }

    /**
     * 类级别事件触发
     * @param $message
     */
    public function messageEventTrigger1($message){
        // 触发类级别事件
        $event = new MessageEvent();
        $event->message = $message;
        Event::trigger(MessageHelper::className(), MessageHelper::EVENT_MESSAGE_SEND, $event);
    }

}
