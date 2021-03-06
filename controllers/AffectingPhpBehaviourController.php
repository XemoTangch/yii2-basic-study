<?php
/**
 * User:  jiangm
 * Email: jmphper@foxmail.com
 * Date:  2018/04/16
 * Time:  21:50
 * Desc:  影响php行为的扩展
 */

namespace app\controllers;

use Yii;
use yii\web\Controller;

class AffectingPhpBehaviourController extends Controller
{
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
    }

    /**
     * 该扩展已已经没有维护了，但是还是可以正常安装和使用
     * 1. Alternative PHP Cache (APC) 是一个开放自由的 PHP opcode 缓存。它的目标是提供一个自由、 开放，和健全的框架，用于缓存、优化 PHP 中间代码。
     * 2. 此扩展的代替者是： OPcache、 APCu、 Windows Cache for PHP 和 Session Upload Progress API。
     */
    public function actionApc(){
        echo 'Alternative PHP Cache (APC) 是一个开放自由的 PHP opcode 缓存。它的目标是提供一个自由、 开放，和健全的框架，用于缓存、优化 PHP 中间代码。';
    }

    /**
     * 支持php7，为APC适用的地方提供替代
     */
    public function actionApcu(){
        
    }


}