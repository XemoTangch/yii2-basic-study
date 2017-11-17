<?php
/**
 * Author: jiangm
 * Email: jmphper@foxmail.com
 * Date: 2017/10/21
 * Time: 10:14
 * Desc: 公共资源加载
 */

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\View;

class CommonAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
    ];
    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset', // bootstrap
    ];

    /**
     * @inheritdoc
     */
    public $jsOptions = [
        'position' => View::POS_HEAD,
    ];  // 这是设置所有js放置的位置
}