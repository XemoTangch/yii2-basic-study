<?php
/**
 * Created by PhpStorm.
 * User: lzm
 * Date: 2017/3/22
 * Time: 13:53
 */

namespace app\modules\front\controllers;

use Yii;
use app\models\Join;
use app\models\CaptchaModel;

class JoinController extends BaseController {


    /**
     * ---------------------------------------
     * 提交数据
     * ---------------------------------------
     */
    public function actionJoin() {
        $json = ['code'=>'0', 'msg'=>'提交成功'];
        if (Yii::$app->request->isPost) {
            // 获取提交的数据
            $data['mobile']    = Yii::$app->request->post('mobilePhone', '');
            $data['name']      = Yii::$app->request->post('txtname', '');
            $data['sex']       = Yii::$app->request->post('hideSex', '');
            $data['country']   = Yii::$app->request->post('country', '');
            $data['school']    = Yii::$app->request->post('school', '');
            $data['education'] = Yii::$app->request->post('education', '');
            $data['major']     = Yii::$app->request->post('major', '');
            $data['email']     = Yii::$app->request->post('txtemail', '');
            $data['actids']    = Yii::$app->request->post('hideActID', '');
            $data['code']      = Yii::$app->request->post('mobileCode', '');
            $data['t']         = Yii::$app->request->post('t', '1');
            $data['ctime']     = time();
            // 数据必要性验证
            if (empty($data['mobile']) ||
                empty($data['name']) ||
                empty($data['sex']) ||
                empty($data['country']) ||
                empty($data['school']) ||
                empty($data['education']) ||
                empty($data['major']) ||
                empty($data['email']) ||
                empty($data['actids'])
            ) {
                $json['code'] = 2;
                $json['msg']  = '请填写完整资料';
                $this->ajaxReturn($json);
            }//var_dump($data);

            // 短信验证码验证
            $start_time = $data['code'] - 1800;
            $captchaData = CaptchaModel::find()
                ->where('mobile=:mobile and ctime>:start_time', [':mobile'=>$data['mobile'], ':start_time'=>$start_time])
                ->orderBy('id DESC')
                ->one();
            if (!$captchaData || $captchaData->captcha != $data['code']) {
                $json['code'] = 1;
                $json['msg']  = '验证码错误';
                $this->ajaxReturn($json);
            }

            // 写入数据库
            $ttt = 0;
            $model = Join::find()->where(['mobile'=>$data['mobile']])->one();
            if (!$model) {
                $model = new Join();
                $ttt = 1;
            }
            $model->setAttributes($data);
            //var_dump($model);exit;
            if ($model->save()) {
                // 发送短信
                $actids_arr = explode(',', $data['actids']);
                if (is_array($actids_arr)) {
                    foreach ($actids_arr as $value) {
                        switch ($value) {
                            case '1': 
                                $_tmp_str = '深圳';
                                $_tmp_str1 = '大中华国际交易广场';
                                break;
                            case '2': 
                                $_tmp_str = '北京';
                                $_tmp_str1 = '伯豪瑞廷酒店';
                                break;
                            case '3': 
                                $_tmp_str = '上海';
                                $_tmp_str1 = '雅居乐万豪酒店';
                                break;
                            default:continue;
                        }
                        $mess = [
                            'mobile'  => $data['mobile'],
                            'content' => '您已报名成功2018第六届海归人才秋季招聘会！'.$_tmp_str.'招聘会将于09:30-17:30在'.$_tmp_str1.'举行，届时14:00-17:30举办第四届海归人才职业规划与发展论坛。请提前登陆Jobs海归官网注册个人会员，并现场携带简历凭此短信入场。'
                        ];
                        if ($ttt) {
                            $this->mobileSMS7($mess);
                        }
                    }
                } 
                
                $json['code'] = 0; 
                $json['msg']  = '您已报名';
                if ($ttt) {
                    $json['msg']  = '提交成功，请等待短信通知';
                }
                $this->ajaxReturn($json);
            }
            $json['code'] = 3;
            $json['msg']  = '服务器错误，请联系管理员';
            $this->ajaxReturn($json);
        }

        return $this->render('join');
    }

    /**
     * ---------------------------------------
     * 报名人列表数据
     * ---------------------------------------
     */
    public function actionData($t){
        // 获取所有数据
        $data = Join::find()->where('t='.$t)->orderBy('sid DESC')->asArray()->all();
        // 表头数据
        $_mmm = new Join();
        $title_arr = $_mmm->attributeLabels();
        // 输出表格
        if (Yii::$app->request->get('output') == '1') { 
            $this->export_csv($data, $title_arr);
        }
        return $this->render('data', [
            'data' => $data,
            'title_arr' => $title_arr,
        ]);
    }

    /**
     * ---------------------------------------
     * 以CSV格式输出数据
     * @param $data
     * @param $title_arr
     * @param string $file_name
     * ---------------------------------------
     */
    public function export_csv($data,$title_arr,$file_name=''){
        ini_set("max_execution_time", "3600");

        $csv_data = '';

        /** 标题 */
        $nums = count($title_arr);

        for ($i = 0; $i < $nums - 1; ++$i) {
            //$csv_data .= '"' . $title_arr[$i] . '",';
            $csv_data .= $title_arr[$i] . ',';
        }
        if ($nums > 0) {
            $csv_data .= $title_arr[$nums - 1] . "\r\n";
        }

        foreach ($data as $k => $row) {
            $_tmp_csv_data = '';
            foreach ($row as $key => $r){
                $row[$key] = str_replace("\"", "\"\"", $r);

                if ( $_tmp_csv_data == '' ) {
                    $_tmp_csv_data = $row[$key];
                }
                else {
                    $_tmp_csv_data .= ','. $row[$key];
                }

            }

            $csv_data .= $_tmp_csv_data.$row[$nums - 1] . "\r\n";
            unset($data[$k]);
        }

        $csv_data = mb_convert_encoding($csv_data, "cp936", "UTF-8");
        $file_name = empty($file_name) ? date('Y-m-d-H-i-s', time()) : $file_name;
        // 解决IE浏览器输出中文名乱码的bug
        if(preg_match( '/MSIE/i', $_SERVER['HTTP_USER_AGENT'] )){
            $file_name = urlencode($file_name);
            $file_name = iconv('UTF-8', 'GBK//IGNORE', $file_name);
        }
        $file_name = $file_name . '.csv';
        header('Content-Type: application/download');
        header("Content-type:text/csv;");
        header("Content-Disposition:attachment;filename=" . $file_name);
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');
        echo $csv_data;
        exit();
    }

}