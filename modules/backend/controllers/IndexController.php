<?php
/**
 * Author: jiangm
 * Email: jmphper@foxmail.com
 * Date: 2018/5/3
 * Time: 11:42
 * Desc: 后台首页
 */


namespace app\modules\backend\controllers;

use Yii;
use app\modules\backend\models\Admin;
use app\modules\backend\components\AdminBaseController;

/**
 * Default controller for the `backend` module
 */
class IndexController extends AdminBaseController
{
    public $layout = '/normal';
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        echo '<pre>';
        print_r(Yii::$app->user->identity);
        echo '</pre>';
        return $this->render('index');
    }

}