<?php

namespace app\modules\front;

/**
 * front module definition class
 */
class FrontModule extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\front\controllers';

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
