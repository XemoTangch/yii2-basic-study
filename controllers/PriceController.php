<?php
/**
 * Author: jiangm
 * Email: jmphper@foxmail.com
 * Date: 2017/10/30
 * Time: 11:17
 * Desc: 价格处理
 */

namespace app\controllers;

use Yii;
use yii\web\Controller;

class PriceController extends Controller
{
    /**
     * 格式化金额
     *
     * @get int $money
     * @get int $len
     * @get int $comma 0,1
     * @return string
     */
    public function actionFormatMoney() {
        $money = Yii::$app->request->get('money', 0);
        $len = Yii::$app->request->get('len', 2);
        $comma = Yii::$app->request->get('comma', 0);

        $negative = $money > 0 ? '' : '-';
        $int_money = intval(abs($money));
        $len = intval(abs($len));
        $decimal = ''; //小数
        if ($len > 0) {
            $decimal = '.' . substr(sprintf('%01.' . $len . 'f', $money), -$len);
        }
        $tmp_money = strrev($int_money);
        $strlen = strlen($tmp_money);
        $format_money = '';
        for ($i = 3; $i < $strlen; $i += 3) {
            if ($comma) {
                $format_money .= substr($tmp_money, 0, 3) . ',';
            } else {
                $format_money .= substr($tmp_money, 0, 3);
            }

            $tmp_money = substr($tmp_money, 3);
        }
        $format_money .= $tmp_money;
        $format_money = strrev($format_money);
        return $negative . $format_money . $decimal;
    }

}