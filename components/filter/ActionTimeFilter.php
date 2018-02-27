<?php
/**
 * Author: jiangm
 * Email: jmphper@foxmail.com
 * Date: 2018/2/27
 * Time: 10:17
 * Desc: 过滤器 是特殊的行为，除了控制器外，可在 模块或应用主体 中申明过滤器
 */

namespace app\components\filter;

use Yii;
use yii\base\ActionFilter;

class ActionTimeFilter extends ActionFilter
{
    private $_startTime;

    public function beforeAction($action)
    {
        $this->_startTime = microtime(true);
        return parent::beforeAction($action);
    }

    public function afterAction($action, $result)
    {
        $time = microtime(true) - $this->_startTime;
        Yii::trace("'{$action->uniqueId}' 页面执行耗时 $time 秒.");
        return parent::afterAction($action, $result);
    }
}