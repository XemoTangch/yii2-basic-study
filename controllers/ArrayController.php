<?php
/**
 * Author: jiangm
 * Email: jmphper@foxmail.com
 * Date: 2017/12/8
 * Time: 11:26
 * Desc:
 */

namespace app\controllers;

use Yii;
use yii\web\Controller;

class ArrayController extends Controller
{
    /**
     * 构造函数
     */
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        $this->layout = false;
    }

    public function actionTest(){
        if(array()){
            echo 'if(array()) is true';
        }else{
            echo 'if(array()) is false';
        }
        echo '<br/>';
    }
}