<?php

namespace app\modules\demo;

use yii\db\Query;

/**
 * demo module definition class
 */
class demoModule extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\demo\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

    /**
     * 模块行为
     */
    public function behaviors(){
        return [
            [
                'class' => 'app\components\filter\ActionTimeFilter',
//                'lastModified' => function ($action, $params) {
//                    echo '<pre>';
//                    print_r($action);
//                    print_r($params);
//                    echo '</pre>';
//                    $q = new Query();
//                    return $q->from('user')->max('updated_at');
//                },
            ],
        ];
    }

}
