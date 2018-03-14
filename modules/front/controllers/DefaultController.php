<?php

namespace app\modules\front\controllers;

use yii\web\Controller;

/**
 * Default controller for the `front` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $html = '<div class="alert alert-info" role="alert">页面加载中，请稍后。。。</div>';
    }
}
