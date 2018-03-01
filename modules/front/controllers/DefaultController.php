<?php

namespace app\modules\front\controllers;

use yii\web\Controller;

/**
 * Default controller for the `front` module
 */
class DefaultController extends Controller
{
    public $layout = '/normal'; // 加上斜杠表示使用最外层views中的布局，默认使用模块中的布局
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }


    public function actionVue(){
        return $this->render('vue');
    }
}
