<?php
/**
 * Author: jiangm
 * Email: jmphper@foxmail.com
 * Date: 2018/8/1
 * Time: 14:36
 * Desc: 字符串工具类
 */

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;

class StringToolsController extends Controller
{
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
    }

    /**
     * 工具首页
     * @return string
     */
    public function actionIndex(){
        $ref = new \ReflectionClass($this);
        $methods = $ref->getMethods(\ReflectionMethod::IS_PUBLIC);
        $list = array_filter($methods, function(&$one){
            if($one->class == self::class
                && strpos($one->name, 'action') !== false
                && $one->name != 'init'){
                $uri = $this->uncamelize(str_replace('action', '', $one->name), '-');
                $one->url = Url::to([$uri]);
                return true;
            }
            return false;
        });
        return $this->render('index', [
            'tool_list' => $list,
        ]);
    }

    /**
     * 串行化工具
     * @return string
     */
    public function actionSerialize(){
        $content = '';
        if(Yii::$app->request->isPost)
            $content = Yii::$app->request->post('content', '');

        return $this->render('serialize', [
            'content' => $content,
            'un_serialize' => unserialize($content),
        ]);
    }

    /**
     * 时间戳工具
     * @return string
     */
    public function actionTime(){
        $param = '';
        $time = time();
        $date = date('Y-m-d H:i:s', time());
        if(Yii::$app->request->isPost){
            $param = trim(Yii::$app->request->post('param', ''));
            if($param){
                $time = strtotime($param);
                // 参数为日期
                if(!preg_match('/^[0-9]{10,}$/', $param)){
                    $date = $param;
                }else{ // 参数为时间戳
                    $date = date('Y-m-d H:i:s', $param);
                    $time = $param;
                }
            }
        }
        return $this->render('time', [
            'time' => $time,
            'date' => $date,
            'param' => $param,
        ]);
    }

    public function actionTestOne(){
        $res = 'aaa';
        var_dump((integer)$res);
    }


    /** *******************************工具方法********************************* */

    /**
     * 驼峰命名转下划线命名
     * @param $str
     * @return string
     */
    function toUnderScore($str)
    {
        $dstr = preg_replace_callback('/([A-Z]+)/',function($matchs)
        {
            return '_'.strtolower($matchs[0]);
        },$str);
        return trim(preg_replace('/_{2,}/','_',$dstr),'_');
    }

    /**
     * 驼峰命名转下划线命名
     * @param $str
     * @return string
     */
    function toCamelCase($str)
    {
        $array = explode('_', $str);
        $result = $array[0];
        $len=count($array);
        if($len>1)
        {
            for($i=1;$i<$len;$i++)
            {
                $result.= ucfirst($array[$i]);
            }
        }
        return $result;
    }

    /**
     * 下划线转驼峰
     * 思路:
     * step1.原字符串转小写,原字符串中的分隔符用空格替换,在字符串开头加上分隔符
     * step2.将字符串中每个单词的首字母转换为大写,再去空格,去字符串首部附加的分隔符.
     *
     * @param $uncamelized_words
     * @param string $separator
     * @return string
     */
    function camelize($uncamelized_words,$separator='_')
    {
        $uncamelized_words = $separator. str_replace($separator, " ", strtolower($uncamelized_words));
        return ltrim(str_replace(" ", "", ucwords($uncamelized_words)), $separator );
    }

    /**
     * 驼峰命名转下划线命名
     * 思路:
     * 小写和大写紧挨一起的地方,加上分隔符,然后全部转小写
     * @param $camelCaps
     * @param string $separator
     * @return string
     */
    function uncamelize($camelCaps,$separator='_')
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', "$1" . $separator . "$2", $camelCaps));
    }

}