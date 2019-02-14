<?php
/**
 * Author: jiangm
 * Email: jmphper@foxmail.com
 * Date: 2019/2/14
 * Time: 14:16
 * Desc: 上传
 */

namespace app\controllers;

use Yii;
use yii\web\Controller;


class UploadController extends Controller
{
    public function actionIndex(){
        return $this->render('index');
    }
}