<?php
/**
 * Author: jiangm
 * Email: jmphper@foxmail.com
 * Date: 2018/2/24
 * Time: 11:30
 * Desc: 测试组件
 */

namespace app\components;

use yii\base\Component;

class MyComponent extends Component
{
    public $prop1;
    public $prop2;

    public function __construct($param1, $param2, $config = [])
    {
        // ... initialization before configuration is applied

        parent::__construct($config);
    }

    public function init()
    {
        parent::init();

        // ... initialization after configuration is applied
    }
}