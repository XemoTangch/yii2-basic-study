<?php
/**
 * Author: jiangm
 * Email: jmphper@foxmail.com
 * Date: 2018/5/3
 * Time: 11:42
 * Desc: 后台首页
 */


namespace app\modules\backend\controllers;

use yii\web\Controller;
use app\modules\backend\models\Admin;

/**
 * Default controller for the `backend` module
 */
class IndexController extends Controller
{
    public $layout = '/normal';
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $admin = Admin::find()->where(['id'=>1])->one();
        echo '<pre>';
        print_r($admin);
        echo '</pre>';
        return $this->render('index');
    }

}