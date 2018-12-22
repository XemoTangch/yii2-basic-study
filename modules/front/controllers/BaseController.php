<?php
/**
 * User: jiangm
 * Date: 2017/3/15
 * Time: 11:19
 * Desc: 前台基础控制器
 */
namespace app\modules\front\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use app\modules\front\components\MySendMail;

class BaseController extends Controller
{
    public $layout = 'main';
    public $enableCsrfValidation=false;
    public $candidate;

    /**
     * ---------------------------------------
     * 前台构造函数
     * ---------------------------------------
     */
    public function init(){
        //是否验证用户身份
        $this->candidate = ['mobile' => $_COOKIE['mobile'], 'email' => $_COOKIE['email'], 'mobile_prefix' => $_COOKIE['mobile_prefix']];
        
        if(!$this->candidate || !isset($this->candidate['mobile']) || !$this->candidate['mobile'])  $this->candidate = false;
    }

    /**
     * 验证器
     * @param $type mobile=手机验证 captcha=验证码验证
     * @param $content
     * @return boolean
     */
    protected function myValidate($type, $content){
        if(!$type || !$content) return false;
        switch($type){
            case 'mobile':
                return preg_match('/^(0|[0-9]{2}|17951)?(13[0-9]|15[012356789]|16[1-9]|17[0-9]|18[0-9]|14[57])[0-9]{8}$/', $content);
                break;
            case 'mobile2':
                return preg_match('/^1{10}$/', $content);
                break;
            case 'captcha':
                return preg_match('/^[0-9]{4}$/', $content);
                break;
            case 'mobile_prefix':
//                var_dump(preg_match('/^\d{1,6}$/', $content));exit;
                return preg_match('/^\d{1,6}$/', $content);
                break;
            default:
                return false;
                break;
        }
    }

    /**
     * 发送一条手机短信 互亿无线
     * @param  $mobile string 手机号
     * @param  $content string  内容
     * @return object
     * */
    public function mobileSMS($mobile, $content) {
        if(!$mobile || !$content) return false;

        $url = "http://106.ihuyi.cn/webservice/sms.php?method=Submit";
        $post_data = "account=cf_imhaigui&password=imhaigui123&mobile=" . $mobile . "&content=" . rawurlencode($content) . "&format=json";

        //初始化
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_NOBODY, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
        $output = curl_exec($curl);
        curl_close($curl);

        if ($output) {
            $output = json_decode($output, true);
            if ($output['code'] == 2) {
                return true;
            }
        }
        return false;
    }

    /*
    * ---------------------------------------
    * 发送一条手机短信 互亿无线 国际短信
    * @param  array $info  参数信息 array('mobile'=>'手机号','content'=>'内容')
    * @return obj
    * ---------------------------------------
    */
    public static function mobileSMS6($phone, $cont) {
        if(!$phone || !$cont) return false;

        $mobile = $phone;
        $content = $cont;

        $account = 'cf_imhaigui';
        $apikey = 'aa1ee8402a74a54113645787bab1c3b4';

        //$password = md5($account . $apikey . $mobile . $content . time());

        $password = $apikey;

        $url = "http://api.isms.ihuyi.cn/webservice/isms.php?method=Submit";
        $post_data = "account=" . $account . "&password=" . $password . "&mobile=" . $mobile . "&content=" . rawurlencode($content) . "&format=json";

        //初始化
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_NOBODY, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
        $output = curl_exec($curl);
        curl_close($curl);

        //var_export(json_decode($output,true));
        if ($output) {
            $output = json_decode($output, true);
            if ($output['code'] == 2) {
                return true;
            }
        }
        return false;
    }

    /**
     * ---------------------------------------
     * 发送手机短信 优讯通 短信验证码
     * @param  array $info 发送单条短信         ['mobile'=>'手机号','content'=>'内容']
     *                     发送多条内容相同短信 ['mobile'=>'手机号1,手机号2,手机号3','content'=>'内容']
     *                     发送多条内容不同短信 [['mobile'=>'手机号1','content'=>'内容1'],['mobile'=>'手机号2','content'=>'内容2']]
     * @return boolean
     * ---------------------------------------
     */
    public static function mobileSMS7($info) {
        if (empty($info) || !is_array($info)) {
            return false;
        }

        $data = [];
        /** 判断$info是一维数组还是二维数组 */
        if (count($info) == count($info, 1)) {
            /** 发送单条短信、发送多条内容相同短信 */
            if (!isset($info['mobile']) || !isset($info['content'])) {
                return false;
            }
            $data['phones']  = $info['mobile'];  // 接收手机号码，多个手机号码用英文逗号分隔，最多1000个，不能为空
            $data['content'] = $info['content']; // 短信内容，最多350汉字，不能为空
        } else {
            /** 发送多条内容不同短信 */
            foreach ($info as $v) {
                if (!isset($v['mobile']) || !isset($v['content'])) {
                    return false;
                }
                $data['list'][] = ['phone' => $v['mobile'], 'content' => $v['content']];
            }
        }

        $data['account']  = '20419';  // 用户账号
        $data['password'] = md5('6,AhK8tr'); // 账号密码，需采用MD5加密(小写)
        $data['sign']     = '【Jobs海归】';     // 短信签名，该签名有服务端告知客户端，不可修改。为空时使用默认值
        $data['subcode']  = '';                // 扩展子号码，内容可空，暂不支持
        $data['sendtime'] = '';                // 发送时间,格式yyyyMMddHHmm,可空

        // sid 安全机制验证， SHA1(token&message)加密，token用户可后台配置，没有配置代表不启用，不启用可为空，启用则必填。
        $message = json_encode($data);
        $sid     = sha1($message);

        $url       = 'http://new.yxuntong.com/emmpdata/sms/Submit?v=2.0&type=json&';
        $post_data = "sid=" . $sid . "&message=" . $message ;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_NOBODY, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
        $output = curl_exec($curl);
        curl_close($curl);

        //var_export(json_decode($output,true));
        if ($output) {
            $output = json_decode($output, true);
            if ($output['result'] == 0) {
                return true;
            }
        }
        return false;
    }

    /**
     * ajax返回
     * @param $data array
     * @return string
     */
    protected function ajaxReturn($data) {
        // 返回JSON数据格式到客户端 包含状态信息
        header('Content-Type:application/json; charset=utf-8');
        echo json_encode($data);
        exit;
    }

    /**
     * 获取表单验证错误信息第一条信息
     * @param $errors array 错误信息数组
     * @return string
     * */
    protected function getOneError($errors)
    {
        if(!$errors) return false;
        foreach($errors as $value){
            return $value[0];
        }
    }

    /**
     *
     * 调用phpmaler发送邮件
     * @param string $title 邮件的标题
     * @param string $body 邮件的内容
     * @param string $toemail 收件人地址，多个收件人用","分割
     *
     * @return true/false
     */
    public function mailto($title, $data, $toemail) {
        if (empty($toemail) || empty($data)) {
            return false;
        }
        $content = $this->render('/default/email.php', ['data' => $data]);
        $mail = new MySendMail();
        $mail->setServer("smtp.exmail.qq.com", "jobs@imhaigui.com", "Im123456");
        $mail->setFrom("jobs@imhaigui.com");
        $mail->setReceiver($toemail);
        $mail->setMail($title, $content);
        return $mail->sendMail();
    }

}