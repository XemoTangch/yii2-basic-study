<?php
/**
 * User:  jiangm
 * Email: jmphper@foxmail.com
 * Date:  2019/01/12
 * Time:  18:07
 * Desc:  生成器
 */

namespace app\controllers;

use Yii;
use yii\web\Controller;

class YieldController  extends Controller
{
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
    }

    public function timeRange($number){
        $data = [];
        for($i=0;$i<$number;$i++){
            sleep(1);
            $data[] = time();
        }
        return $data;
    }

    public function YieldTimeRange($number){
        for($i=0;$i<$number;$i++){
            sleep(1);
            yield time();
        }
    }

    public function actionIndex(){
        $res = $this->timeRange(10);
        foreach($res as $key => $value){
            echo $value.'<br/>';
        }
    }
}
