<?php
/**
 * User:  jiangm
 * Email: jmphper@foxmail.com
 * Date:  2018/12/23
 * Time:  15:37
 * Desc:
 */


namespace app\modules\api;

/**
 * front module definition class
 */
class ApiModule extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\api\controllers';

    public $layout = false;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
        \Yii::configure($this, require(__DIR__ . '/config/config.php'));
    }
}