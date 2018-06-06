<?php
/**
 * Author: jiangm
 * Email: jmphper@foxmail.com
 * Date: 2018/5/3
 * Time: 15:39
 * Desc:
 */
namespace app\assets;

use yii\web\AssetBundle;
use yii\web\View;

class AdminAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'adminAssets/css/vendors.bundle.css',
        'adminAssets/css/style.bundle.css',
    ];
    public $js = [
        'adminAssets/js/vendors.bundle.js',
        'adminAssets/js/scripts.bundle.js',
    ];// js 一般在尾部加载，好处有：html是从上到下加载，js放在最后加载可以加快页面展示速度；再就是防止DOM未加载完成造成js执行错误。
    public $depends = [
        'yii\web\JqueryAsset',
    ];

    /**
     * 定义按需加载JS方法，注意加载顺序在最后
     * @param $view object
     * @param $js_file string
     */
    public static function addScript($view, $js_file) {
        $view->registerJsFile($js_file, ['depends' => ['app\assets\AdminAsset'], 'position' => View::POS_END]);
    }

    /**
     * 定义按需加载css方法，注意加载顺序在最后
     * @param $view object
     * @param $css_file string
     */
    public static function addCss($view, $css_file) {
        $view->registerCssFile($css_file, ['depends' => ['app\assets\AdminAsset'], 'position' => View::POS_HEAD]);
    }

}