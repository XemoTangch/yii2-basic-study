<?php
/**
 * User:  jiangm
 * Email: jmphper@foxmail.com
 * Date:  2017/11/1
 * Time:  19:23
 * Desc:  free code camp 作业
 */

namespace app\controllers;

use Yii;
use yii\web\Controller;

class FreeCodeCampController extends Controller
{
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        $this->layout = 'normal';
    }

    public function actionLinkinPark(){
        return $this->render('LinkinPark');
    }
}