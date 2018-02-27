<?php
/**
 * Author: jiangm
 * Email: jmphper@foxmail.com
 * Date: 2018/2/27
 * Time: 14:47
 * Desc: 可在begin和end调用中使用的小部件
 */
namespace app\components\widget;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;

class Hello2Widget extends Widget
{
    public $message;

    public function init()
    {
        parent::init();
        ob_start();
    }

    public function run()
    {
        $content = ob_get_clean();
        return Html::encode($content);
    }
}