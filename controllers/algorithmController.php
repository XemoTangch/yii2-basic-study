<?php
/**
 * Author: jiangm
 * Email: jmphper@foxmail.com
 * Date: 2018/5/28
 * Time: 10:23
 * Desc: 算法
 */

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\components\AlgorithmComponent;

class AlgorithmController extends Controller
{
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        ini_set('display_errors','on');
        error_reporting(E_ALL);
    }

    public function actionIndex(){


    }

    public function actionGcd(){
        $q = Yii::$app->request->get('q', 0);
        $p = Yii::$app->request->get('p', 0);
        echo AlgorithmComponent::gcd($q, $p);
    }

    public function actionBinarySearch(){
        $key = Yii::$app->request->get('key', 0);
        $args = [1,3,4,5,6,7,8,9,12,34,55,77,89,123,1456];
        echo AlgorithmComponent::binarySearch($key, $args);
    }

    //------------------作业-----------------------
    public function actionExR1(){
        echo AlgorithmComponent::exR1(6);
    }
    public function actionMyStery(){
        echo '<br/>mystery(2,25) return:';
        echo AlgorithmComponent::mystery(2, 25);
        echo '<br/>mystery(3,11) return:';
        echo AlgorithmComponent::mystery(3, 11);
        echo '<br/>mystery1(2,25) return:';
        echo AlgorithmComponent::mystery1(2, 25);
        echo '<br/>mystery1(3,11) return:';
        echo AlgorithmComponent::mystery1(3, 11);
    }
}