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
        'https://cdn.jsdelivr.net/npm/vue@2.5.13/dist/vue.js',
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

    /**
     * 定义按需加载JS方法，注意加载顺序在最后
     * @param $view object
     * @param $js_file string
     */
    public static function addScript($view, $js_file) {
        $view->registerJsFile($js_file, ['depends' => ['app\assets\CommonAsset'], 'position' => View::POS_HEAD]);
    }

    /**
     * 定义按需加载css方法，注意加载顺序在最后
     * @param $view object
     * @param $css_file string
     */
    public static function addCss($view, $css_file) {
        $view->registerCssFile($css_file, ['depends' => ['app\assets\CommonAsset'], 'position' => View::POS_HEAD]);
    }

}