<?php
/**
 * User:  jiangm
 * Email: jmphper@foxmail.com
 * Date:  2018/04/05
 * Time:  22:13
 * Desc:  integer
 */

namespace app\controllers;

use Yii;
use yii\web\Controller;

class IntegerController extends Controller
{
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
    }

    /**
     * 整型是集合 ℤ = {..., -2, -1, 0, 1, 2, ...} 中的某个数
     * 
     * 1. 整型值可以使用十进制，十六进制，八进制或二进制表示(PHP 5.4.0 起可用)，前面可以加上可选的符号（- 或者 +）。
     * 2. 要使用八进制表达，数字前必须加上 0（零）。要使用十六进制表达，数字前必须加上 0x。要使用二进制表达，数字前必须加上 0b。
     * 3. 整型数的字长和平台有关，尽管通常最大值是大约二十亿（32 位有符号）。64 位平台下的最大值通常是大约 9E18。
     * 4. 整型大于最大值后溢出，整型溢出后就会自动转换类型为float浮点型。
     */
    public function actionIndex(){

        // 绝不要将未知的分数强制转换为 integer，这样有时会导致不可预料的结果
        echo (int) ( (0.1+0.7) * 10 ); // 显示 7!
    }

    
}