<?php

namespace app\modules\front\controllers;

use yii\web\Controller;
use yii\helpers\Url;
use app\modules\front\components\weixinjssdk\Jssdk;
/**
 * Default controller for the `front` module
 */
class DefaultController extends BaseController
{
    public $layout = 'main';
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * 欢迎界面
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        // 微信分享JSSDK
        $jssdk = new Jssdk('wx49580968627c700f', 'b2b04b9f618081e7ad0281d8f5709390');
        $signPackage = $jssdk->GetSignPackage();
        // 微信分享内容
        $wx_share_info = [
            'title' => '2018第五届海归人才招聘会（春季）',
            'desc' => '深圳站4月14-15日 上海站4月21日 北京站4月28日 www.jobshaigui.com',
            'link' => Url::toRoute('default/index', true),
            'imgUrl' => Url::to('@web/front/images/wx_20170408094200.jpg', true),
            'type' => '',
            'dataUrl' => '',
        ];


        return $this->render('index', [
            'candidate' => $this->candidate,
            'signPackage' => $signPackage,
            'wx_share_info' => $wx_share_info,
    ]);
    }


    /**
     * 欢迎界面
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex2()
    {
        // 微信分享JSSDK
        $jssdk = new Jssdk('wx49580968627c700f', 'b2b04b9f618081e7ad0281d8f5709390');
        $signPackage = $jssdk->GetSignPackage();
        // 微信分享内容
        $wx_share_info = [
            'title' => '2018第五届海归人才招聘会（春季）',
            'desc' => '深圳站4月14-15日 上海站4月21日 北京站4月28日 www.jobshaigui.com',
            'link' => Url::toRoute('default/index', true),
            'imgUrl' => Url::to('@web/front/images/wx_20170408094200.jpg', true),
            'type' => '',
            'dataUrl' => '',
        ];


        return $this->render('index2', [
            'candidate' => $this->candidate,
            'signPackage' => $signPackage,
            'wx_share_info' => $wx_share_info,
        ]);
    }




}
