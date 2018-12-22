<?php
/**
 * User: jiang
 * Date: 2017/3/15
 * Time: 11:06
 * Desc: 招聘会控制器
 */
namespace app\modules\front\controllers;

use app\modules\cadmin\models\SendResume;
use Symfony\Component\HttpKernel\EventListener\ValidateRequestListener;
use Yii;
use app\models\CompanyModel;
use app\models\JobModel;
use app\modules\front\models\Job;
use app\models\ResumeModel;
use app\models\ApplyModel;
use app\modules\front\models\Resume;
use app\models\SendResumeModel;
use app\models\CaptchaModel;
use yii\helpers\Url;
use yii\web\UploadedFile;

class JobfairController extends BaseController
{

    private $title = '海归人才专场招聘会';



    /**
     * 招聘会会展首页
     * */
    public function actionIndex(){
        $event_id = Yii::$app->request->get('event_id')?Yii::$app->request->get('event_id'):1;

        $this->layout = false;

        switch($event_id){
            case 1:
                return $this->render('index_beijing');
                break;
            case 2:
                return $this->render('index_shanghai');
                break;
            case 3:
                return $this->render('index_shenzhen');
                break;
            default :

        }

    }

    /**
     * 内容处理
     */
    public function format_content($str){
        $str = nl2br(strip_tags($str));//转义html标签元素(必须因为可过滤或)   去除html标签元素  给换行出\n处插入<br />
        $str = str_replace(["\r\n", "\r", "\n"],'',$str);//去除所有 回车换行  回车  换行符
        $str = preg_replace('/(<br\s*\/?>+\s*)+/','<br>', $str);//把换行<br />  替换为<br>
        $str = str_replace('&nbsp;', '', $str);//去除html空格  &nbsp
        $str = trim($str, '<br>');
        return $str;
    }

    /**
     * 招聘会企业页面
     * */
    public function actionCompany($code = '',$id){
        if(!$code&&!$id) { return $this->redirect(Url::toRoute(['/front/jobfair']));}
        //获取企业信息
        if($code){
            $companyData = Yii::$app->jobsdb->createCommand("SELECT de.*,d.* from hg_document_exib de LEFT JOIN hg_document d ON de.id = d.id WHERE status = 1 AND de.exib_number ='".$code."'")->queryOne();
        }elseif($id){
            $companyData = Yii::$app->jobsdb->createCommand("SELECT de.*,d.* from hg_document_exib de LEFT JOIN hg_document d ON de.id = d.id WHERE status = 1 AND de.id ='".$id."'")->queryOne();
        }
        if(!$companyData ||$companyData['status'] !=1) return $this->redirect(Url::toRoute(['/front/jobfair']));

//        var_dump($companyData);exit;
        $jobList = Yii::$app->jobsdb->createCommand("SELECT dc.*,d.* from hg_document_company dc LEFT JOIN hg_document d ON dc.id = d.id WHERE d.status = 1 and dc.uid = '".$companyData['uid']."' and dc.event_id ='".$companyData['event_id']."'")->queryAll();

        $logo = Yii::$app->jobsdb->createCommand('SELECT path FROM hg_picture WHERE status = 1 AND id = '.$companyData['logo'])->queryOne();
        $companyData['image'] = 'http://www.jobshaigui.com/ot'.$logo['path'];
        $companyData['name_cn'] = $companyData['panelcn'];
        $companyData['id'] = $companyData['id'];
        $companyData['comdesccn'] = $this->format_content($companyData['comdesccn']);
//        var_dump($job);exit;

        foreach($jobList as $k => $v){
            $jobList[$k]['dcontent'] = $this->format_content($v['dcontent']);
            $jobList[$k]['is_send'] = false;
        }

        $companyData['jobname_string'] = '';
        //是否验证身份
        if($this->candidate){
            $resumeData = ResumeModel::findOne(['mobile'=>$this->candidate['mobile']]);
            $resumeid = $resumeData?$resumeData->resumeid:0;
            $this->candidate['resumeid'] = $resumeid;
            //当用户通过身份验证时 并且填写了简历时 给职位列表添加 是否给该职位发送过简历字段
            foreach ($jobList as $kk =>&$vv){
                $vv['is_send'] = $this->isSendResume($resumeid,$vv['id']);
            }
        }
        //增加所有职位字符串
        foreach ($jobList as $kk =>&$vv){
            $companyData['jobname_string'] .='、'.$vv['jobs'];
        }
        $companyData['jobname_string'] = trim($companyData['jobname_string'],'、');
        return $this->render('company', [
            'companyData' => $companyData,
            'jobList' => $jobList,
            'candidate' => $this->candidate,
        ]);
    }

    /**
     * 检测是否投递过该简历
     * @param $resumeid
     * @param $jobid
     * @return bool
     */
    public function isSendResume($resumeid,$jobid){
        if(!$resumeid || !$jobid) return false;
        $sendResume = SendResumeModel::findOne(['resumeid' => $resumeid,'jobid' => $jobid]);
        if($sendResume){
            return true;
        }else{
            return false;
        }
    }
    /**
     * 投递简历操作
     * 返回码
     * 1001 参数不完整
     * 1002 还未验证身份
     * 1003 还未填写简历
     * 1004 企业或岗位不存在
     * 1005 已投递过该岗位
     * 1006 简历投递失败
     * 200 简历投递成功
     * */
    public function actionSendResume(){
        //接收参数
        $jobid = Yii::$app->request->post('jobid');
        $jobs = Yii::$app->request->post('jobs');
        $companyid = Yii::$app->request->post('companyid');
        if(!$jobid || !$jobs || !$companyid) $this->ajaxReturn(array('code'=>1001, 'message'=>'抱歉，参数不完整，请稍后再试'));

        //是否验证用户身份
        if(!$this->candidate)  $this->ajaxReturn(array('code'=>1002, 'message'=>'您还未验证身份'));

        //是否已有简历
        $resumeData = ResumeModel::findOne(['mobile' => $this->candidate['mobile']]);
        if(!$resumeData) $this->ajaxReturn(array('code'=>1003, 'message'=>'您还未填写简历'));

        //企业和岗位是否存在
//        $query = new \yii\db\Query();
//        $jobData = $query->where('jobid=:jobid', [':jobid' => $jobid])->from(JobModel::tableName())->one();
        $jobData = Yii::$app->jobsdb->createCommand('SELECT * FROM hg_document_company WHERE id = '.$jobid)->queryOne();


        if(!$jobData) $this->ajaxReturn(array('code'=>1004, 'message'=>'岗位不存在'));

//        $companyData = $query->where('companyid='.$jobData['companyid'])->from(CompanyModel::tableName())->one();
        $companyData = Yii::$app->jobsdb->createCommand('SELECT de.*,d.* FROM hg_document_exib de LEFT JOIN hg_document d ON de.id=d.id WHERE de.id ='.$companyid.' AND d.`status`=1')->queryOne();

        if(!$companyData || $companyData['status'] !=1 ) $this->ajaxReturn(array('code'=>1004, 'message'=>'企业不存在'));

        //是否已经投递过该岗位
        if(SendResumeModel::findOne(['resumeid' => $resumeData['resumeid'], 'jobid' => $jobid])){
            $this->ajaxReturn(array('code'=>1005, 'message'=>'您已投递过该岗位'));
        }

        //投递简历操作
        $sendResume = new SendResumeModel();
        $sendResume->resumeid = $resumeData['resumeid'];
        $sendResume->jobs = $jobs;
        $sendResume->companyid = $companyid;
        $sendResume->jobid = $jobid;
        $sendResume->ctime = time();
        $sendResume->event_id = $jobData['event_id'];
        if($sendResume->save()){
            //发送邮件给企业 //邮件发送可能会导致ajax请求超时，用另外的ajax来发送邮件
//            if($companyData['email']){
//                $resumeData->work_time = $resumeData->work_time?json_decode($resumeData->work_time, true):'';
//                $emailData = array(
//                    'resumeData' => $resumeData,
//                    'jobData' => $jobData
//                );
//                $this->mailto('收到简历提醒-我是海归网', $emailData, $companyData['email']);
//            }
            $this->ajaxReturn(array('code'=>200, 'message'=>''));
        }else{
            $this->ajaxReturn(array('code'=>1006, 'message'=>'抱歉，简历投递失败，请稍后再试'));
        }

    }

    //用户招聘会 只剩一场深圳时
    public function actionHomepage(){
        if(!$this->candidate){
            $this->redirect(Url::toRoute('/index'));
        }

        if(!$this->CheckApply()){
            $this->redirect(Url::toRoute('/front/jobfair/applyinfo'));
        }

        //此处由于北京 上海结束 要求 去除 3入口页面 直接跳转 企业列表页 并在index方法写死 活动地区id 为1
        return $this->render('homepage', [
            'candidate' => $this->candidate,
        ]);

    }

    //用与招聘会 还有3站时
    public function actionHomepage2(){
        if(!$this->candidate){
            $this->redirect(Url::toRoute('/index'));
        }

        if(!$this->CheckApply()){
            $this->redirect(Url::toRoute('/front/jobfair/applyinfo2'));
        }
        $this->redirect(Url::toRoute('/front/jobfair/index'));

    }
    //检查用户是否已经报名
    public function CheckApply(){
        if(!$this->candidate) return false;
        $user_info = $this->candidate;
        if(!ApplyModel::findOne(['mobile' =>$user_info['mobile']])){
            return false;
        }else{
            return true;
        }
    }

    public function actionApply(){

        if(!$this->candidate)  $this->ajaxReturn(array('code'=>1002, 'message'=>'您还未验证身份'));
        if(!$this->CheckApply()){
            $this->ajaxReturn(array('code'=>1113, 'message'=>'您还没有报名'));
        }
        $this->ajaxReturn(array('code'=>200, 'message'=>'已报名'));
    }
   //报名页面  用户直接 去深圳企业列表
    public function actionApplyinfo(){

        if(!$this->candidate) $this->redirect(Url::toRoute('/front/jobfair/index'));
        $userinfo = $this->candidate;

        if(Yii::$app->request->isAjax){
            //接收参数
            $name = Yii::$app->request->post('name');
            $email = Yii::$app->request->post('email');
            $beijing = Yii::$app->request->post('beijing');
            $shanghai = Yii::$app->request->post('shanghai');
            $shenzhen = Yii::$app->request->post('shenzhen');

            $ApplyData = ApplyModel::findOne(['email'=>$email]);
            if($ApplyData){
                $this->ajaxReturn(array('code'=>1115, 'message'=>'您已经报过名请误重新报名'));
            }

            //报名
            $apply = new ApplyModel();
            $apply->name = $name;
            $apply->email = $email;
            $apply->mobile = $userinfo['mobile'];
            $apply->mobile_prefix = $userinfo['mobile_prefix'];
            $apply->Website = Yii::$app->request->hostInfo;
            $apply->ctime = time();
            $apply->beijing = $beijing;
            $apply->shanghai = $shanghai;
            $apply->shenzhen = $shenzhen;

            if($apply->save()){
                 $_COOKIE['email'] = $email;
                setcookie('email', $email, time()+(24*3600*30), '/');
                $this->ajaxReturn(array('code'=>200, 'message'=>'报名成功'));
            }else{
                $this->ajaxReturn(array('code'=>1114, 'message'=>'抱歉，报名失败，请重新报名'));
            }
        }

        return $this->render('applyinfo', [
            'candidate' => $this->candidate,
        ]);
    }
    //报名页面 用于报名后跳转三站入口页
    public function actionApplyinfo2(){

        if(!$this->candidate) $this->redirect(Url::toRoute('/front/jobfair/index'));
        $userinfo = $this->candidate;

        if(Yii::$app->request->isAjax){
            //接收参数
            $name = Yii::$app->request->post('name');
            $email = Yii::$app->request->post('email');
            $beijing = Yii::$app->request->post('beijing');
            $shanghai = Yii::$app->request->post('shanghai');
            $shenzhen = Yii::$app->request->post('shenzhen');


            //报名
            $apply = new ApplyModel();
            $apply->name = $name;
            $apply->email = $email;
            $apply->mobile = $userinfo['mobile'];
            $apply->mobile_prefix = $userinfo['mobile_prefix'];
            $apply->Website = Yii::$app->request->hostInfo;
            $apply->ctime = time();
            $apply->beijing = $beijing;
            $apply->shanghai = $shanghai;
            $apply->shenzhen = $shenzhen;

            if($apply->save()){
                $_COOKIE['email'] = $email;
                setcookie('email', $email, time()+(24*3600*30), '/');
                $this->ajaxReturn(array('code'=>200, 'message'=>'报名成功'));
            }else{
                $this->ajaxReturn(array('code'=>1114, 'message'=>'抱歉，报名失败，请重新报名'));
            }
        }

        return $this->render('applyinfo2', [
            'candidate' => $this->candidate,
        ]);
    }



    /**
     * 简历填写页面
     *
     * ajax 请求返回
     * 1001 还未验证身份
     * 1002 职位不存在
     * 1003 数据验证不通过
     * 1004 简历保存失败
     * 200 简历保存成功
     */
    public function actionResume($jobid = '',$companyid = ''){
        //ajax 提交简历数据
//        var_dump($_FILES);exit;

        if(Yii::$app->request->isPost){
            //接收数据
            $request = Yii::$app->request;
            $postData = $request->post();
            //是否验证身份
//            if(!$this->candidate) $this->ajaxReturn(array('code'=>1001, 'message'=>'您还未验证身份'));
            if(!$this->candidate) $this->redirect(Url::toRoute('/front/jobfair/company?id='.$postData['companyid']));
            //职位是否存在
            $jobData = Yii::$app->jobsdb->createCommand('SELECT * FROM hg_document_company WHERE id = '.$postData['jobid'])->queryOne();

//            $jobData = JobModel::findOne($postData['jobid']);
            if(!$jobData) $this->ajaxReturn(array('code'=>1002, 'message'=>'抱歉，职位不存在，请刷新页面后重试'));
            //企业是否存在
            $companyData = Yii::$app->jobsdb->createCommand('SELECT de.*,d.* FROM hg_document_exib de LEFT JOIN hg_document d ON de.id=d.id WHERE de.id ='.$postData['companyid'].' AND d.`status`=1')->queryOne();


//            $companyData = CompanyModel::findOne($jobData['companyid']);//待修改
            if(!$companyData || $companyData['status'] !=1 ) $this->ajaxReturn(array('code'=>1002, 'message'=>'抱歉，企业不存在，请刷新页面后重试'));
            //简历是否存在
            $resumeData = ResumeModel::findOne(['mobile'=>$this->candidate['mobile']]);
            if($resumeData){ //修改简历
                $ResumeModel = $resumeData;
            }else{ //新增简历
                $ResumeModel = new ResumeModel();
                $ResumeModel->ctime = time();
            }
            //整理简历数据
            $resumeForm = new Resume();
            //上传图片
            $resumeForm->load($postData);
            $resumeForm->validate();
            $resumeForm->getErrors();
            if($_FILES['Resume']['size']['file']){
                $resumeForm->file = UploadedFile::getInstance($resumeForm, 'file');
                $ResumeModel->file = $resumeForm->upload('file');
            }
            $ResumeModel->name = $request->post('name');
            $ResumeModel->mobile = $this->candidate['mobile'];
            $ResumeModel->email = $request->post('email');
            $ResumeModel->sex = $request->post('sex');
            $ResumeModel->college = $request->post('college');
            $ResumeModel->education = $request->post('education');
            $ResumeModel->current_company = $request->post('current_company');
            $ResumeModel->current_job = $request->post('current_job');
            $ResumeModel->professional = $request->post('professional');
            $ResumeModel->is_job = $request->post('is_job');
            $ResumeModel->interested_position = $request->post('interested_position');
            $ResumeModel->job_city = $request->post('job_city');

            if($request->post('work_time_start') && $request->post('work_time_end')){
                $ResumeModel->work_time = json_encode(['start_time'=>$request->post('work_time_start'), 'end_time'=>$request->post('work_time_end')]);
            }

            //开始事务
            $transaction = Yii::$app->db->beginTransaction();
            try{
                //保存简历
                $ResumeModel->save();
                //投递简历
                $SendResumeModel = new SendResumeModel();
                $SendResumeModel->resumeid = $ResumeModel->resumeid;
                $SendResumeModel->jobid = $postData['jobid'];
                $SendResumeModel->companyid = $postData['companyid'];
                $SendResumeModel->jobs = $postData['jobs'];
                $SendResumeModel->ctime = time();
                $SendResumeModel->event_id = $jobData['event_id'];
                $SendResumeModel->save();
                $transaction->commit();
            }catch(\Exception $e){
                $transaction->rollBack();
                $this->ajaxReturn(array('code'=>1004, 'message'=>'简历保存失败，请刷新页面后重试'));
            }

            return $this->redirect(Url::toRoute('/front/jobfair/company?id='.$postData['companyid']));exit;
        }

        //参数错误时的跳转页面
        if(Yii::$app->request->referrer){
            $redirectUrl = Yii::$app->request->referrer;
        }else{
            $redirectUrl = Url::toRoute('/front/jobfair');
        }
        //获取职位信息
        if(!$jobid){ return $this->redirect($redirectUrl); }
        $jobData = Yii::$app->jobsdb->createCommand('SELECT * FROM hg_document_company WHERE id = '.$jobid)->queryOne();

//        $jobData = JobModel::findOne($jobid);//待修改
        if(!$jobData){ return $this->redirect($redirectUrl); }
        //获取企业信息
        $companyData = Yii::$app->jobsdb->createCommand('SELECT de.*,d.* FROM hg_document_exib de LEFT JOIN hg_document d ON de.id=d.id WHERE de.id ='.$companyid.' AND d.`status`=1')->queryOne();

//        $companyData = CompanyModel::findOne($jobData->companyid);//待修改
        if(!$companyData || $companyData['status'] !=1 ){ return $this->redirect($redirectUrl); }
        //是否验证身份
        if(!$this->candidate){ return $this->redirect($redirectUrl); }

        //是否已填写简历
        $resumeData = ResumeModel::findOne(['mobile'=>$this->candidate['mobile']]);
        if($resumeData){
            $resumeData->work_time = $resumeData->work_time?json_decode($resumeData->work_time):'';
        }

        return $this->render('resume', [
            'companyData' => $companyData,
            'candidate' => $this->candidate,
            'jobData' => $jobData,
            'resumeData' => $resumeData,
        ]);
    }

    /**
     * 手机验证码操作
     * @param string $operate send=发送验证码 validate=验证手机验证码
     * @return string
     * 200 操作成功
     * 1001 参数丢失
     * 1002 未知操作
     * 1003 已验证身份
     * 1004 手机号格式有误
     * 1005 频繁发送
     * 1006 验证码保存失败
     * 1007 验证码发送失败
     *
     * 2001 参数丢失
     * 2002 手机号格式有误
     * 2003 验证码格式有误
     * 2004 验证不通过
     * 2005 验证码过期
     */
    public function actionCaptcha($operate = ''){
        if(!$operate) $this->ajaxReturn(array('code'=>1001, 'message'=>'抱歉，参数丢失，请稍后再试'));

        //是否验证用户身份
        if($this->candidate) $this->ajaxReturn(array('code'=>1003, 'message'=>'您已验证过身份'));

        switch($operate){
            case 'send':

                //验证手机号
                $mobile = Yii::$app->request->post('mobile');
                //国家区号
                $mobile_prefix = Yii::$app->request->post('mobile_prefix', 86);
                if($mobile_prefix ==86 && !$this->myValidate('mobile', $mobile)) $this->ajaxReturn(array('code'=>1004, 'message'=>'手机号格式有误，请重新输入'));
                if(!$this->myValidate('mobile_prefix', $mobile_prefix)) $this->ajaxReturn(array('code'=>2002, 'message'=>'国家区号有误，请重新输入'));
                //是否在1分钟内发送过手机号码
                $start_time = time()-60;
                $captchaData = CaptchaModel::find()
                    ->where('mobile=:mobile and ctime>:start_time and ctime<:end_time', [':mobile'=>$mobile, ':start_time'=>$start_time, ':end_time'=>time()])
                    ->one();
                if($captchaData) $this->ajaxReturn(array('code'=>1005, 'message'=>'请勿频繁操作'));
//$this->ajaxReturn(array('code'=>200, 'message'=>''));
                //发送验证码
                $captcha = mt_rand(1000, 9999);
                $captchaModel = new CaptchaModel();
                $captchaModel->mobile = $mobile;
                $captchaModel->captcha = (string)$captcha;
                $captchaModel->ip = Yii::$app->request->getUserIP();
                $captchaModel->ctime = time();
                if($captchaModel->save()){
                    //区分国外手机号
                    if($mobile_prefix == 86){
                        $issend = $this->mobileSMS($mobile, '您正在使用我是海归身份验证，验证码是：'.$captcha.'，仅用于身份验证，请于30分钟内正确输入。');
                    }else{
                        $mobile = $mobile_prefix.' '.$mobile;
                        $issend = $this->mobileSMS6($mobile, '您正在使用我是海归身份验证，验证码是：'.$captcha.'，仅用于身份验证，请于30分钟内正确输入。');
                    }

                    if($issend){
                        $this->ajaxReturn(array('code'=>200, 'message'=>''));
                    }else{
                        $this->ajaxReturn(array('code'=>1007, 'message'=>'验证码发送失败，请稍后再试'));
                    }
                }else{
                    $this->ajaxReturn(array('code'=>1006, 'message'=>'验证码发送失败，请稍后再试'));
                }

                break;
            case 'validate':
                $jobid = Yii::$app->request->post('jobid');
                $jobs = Yii::$app->request->post('jobs');
                $companyid = Yii::$app->request->post('companyid');
                if(!$jobid) $this->ajaxReturn(array('code'=>2001, 'message'=>'抱歉，参数丢失，请稍后再试'));
                //职位是否存在
                $jobData = Yii::$app->jobsdb->createCommand('SELECT * FROM hg_document_company WHERE id = '.$jobid)->queryOne();//待修改
                if(!$jobData) $this->ajaxReturn(array('code'=>2001, 'message'=>'抱歉，职位不存在，请刷新页面后重试'));
                //企业是否存在
//                $companyData = CompanyModel::findOne($jobData['companyid']);//待修改
                $companyData = Yii::$app->jobsdb->createCommand('SELECT de.*,d.* FROM hg_document_exib de LEFT JOIN hg_document d ON de.id=d.id WHERE de.id ='.$companyid.' AND d.`status`=1')->queryOne();

                if(!$companyData || $companyData['status'] !=1 ) $this->ajaxReturn(array('code'=>2001, 'message'=>'抱歉，企业不存在，请刷新页面后重试'));


                //验证格式
                $mobile_prefix = Yii::$app->request->post('mobile_prefix');
                $mobile = Yii::$app->request->post('mobile');
                $captcha = Yii::$app->request->post('captcha');
                if(!$mobile || !$captcha) $this->ajaxReturn(array('code'=>2001, 'message'=>'抱歉，参数丢失，请稍后再试'));
                if($mobile_prefix == 86 && !$this->myValidate('mobile', $mobile)) $this->ajaxReturn(array('code'=>2002, 'message'=>'手机号格式有误，请重新输入'));
                if(!$this->myValidate('captcha', $captcha)) $this->ajaxReturn(array('code'=>2003, 'message'=>'验证码格式有误，请重新输入'));
                if(!$this->myValidate('mobile_prefix', $mobile_prefix)) $this->ajaxReturn(array('code'=>2002, 'message'=>'国家区号有误，请重新输入'));
                //验证手机验证码
                $captchaData = CaptchaModel::find()
                    ->where('mobile=:mobile and captcha=:captcha', [':mobile'=>$mobile, ':captcha'=>$captcha])
                    ->one();
                if(!$captchaData) $this->ajaxReturn(array('code'=>2004, 'message'=>'验证码错误，请重新输入'));

                //验证码是否有效，有效期半小时
                $invalid_time = $captchaData->ctime + 1800;
                if(time() > $invalid_time) $this->ajaxReturn(array('code'=>2005, 'message'=>'验证码已过期，请重新获取验证码'));

                //验证成功
                $candidate = ['mobile'=>$mobile,'mobile_prefix'=>$mobile_prefix];
                $_COOKIE['mobile'] = $mobile;
                setcookie('mobile', $mobile, time()+(24*3600*30), '/');
                $_COOKIE['mobile_prefix'] = $mobile_prefix;
                setcookie('mobile_prefix', $mobile_prefix, time()+(24*3600*30), '/');
                //是否有填写简历
                $resumeData = ResumeModel::findOne(['mobile' => $mobile]);
                $record = SendResume::findOne(['jobid'=>$jobid,'resumeid'=>$resumeData->resumeid]);
                if($record) $this->ajaxReturn(array('code'=>2008, 'message'=>'您已经投递过该岗位'));
                if($resumeData){ //已有简历
                    //已有简历投递简历
                    $SendResumeModel = new SendResumeModel();
                    $SendResumeModel->resumeid = $resumeData->resumeid;
                    $SendResumeModel->jobid = $jobid;
                    $SendResumeModel->jobs = $jobs;
                    $SendResumeModel->companyid = $companyid;
                    $SendResumeModel->ctime = time();
                    $SendResumeModel->$jobData['event_id'];
                    if($SendResumeModel->save()){
                        $this->ajaxReturn(array('code'=>200, 'message'=>'身份验证成功，赶快去投简历吧 '));
                    }else{
                        $this->ajaxReturn(array('code'=>202, 'message'=>'身份验证成功，简历投递失败，请重新投递简历'));
                    }
                }else{
                    $this->ajaxReturn(array('code'=>201, 'message'=>'')); //提示验证成功并引导用户填写简历
                }

                break;
            case 'apply':
                //验证格式
                $mobile = Yii::$app->request->post('mobile');
                $captcha = Yii::$app->request->post('captcha');
                $mobile_prefix = Yii::$app->request->post('mobile_prefix');
                if(!$mobile || !$captcha) $this->ajaxReturn(array('code'=>2001, 'message'=>'抱歉，参数丢失，请稍后再试'));
                if($mobile_prefix == 86 && !$this->myValidate('mobile', $mobile)) $this->ajaxReturn(array('code'=>2002, 'message'=>'手机号格式有误，请重新输入'));
                if(!$this->myValidate('captcha', $captcha)) $this->ajaxReturn(array('code'=>2003, 'message'=>'验证码格式有误，请重新输入'));
                if(!$this->myValidate('mobile_prefix', $mobile_prefix)) $this->ajaxReturn(array('code'=>2002, 'message'=>'国家区号有误，请重新输入'));


                //验证手机验证码
                $captchaData = CaptchaModel::find()
                    ->where('mobile=:mobile and captcha=:captcha', [':mobile'=>$mobile, ':captcha'=>$captcha])
                    ->one();
                if(!$captchaData) $this->ajaxReturn(array('code'=>2004, 'message'=>'验证码错误，请重新输入'));

                //验证码是否有效，有效期半小时
                $invalid_time = $captchaData->ctime + 1800;
                if(time() > $invalid_time) $this->ajaxReturn(array('code'=>2005, 'message'=>'验证码已过期，请重新获取验证码'));

                //验证成功
                $candidate = ['mobile' => $mobile,'mobile_prefix' => $mobile_prefix];
                $_COOKIE['mobile'] = $mobile;
                setcookie('mobile', $mobile, time()+(24*3600*30), '/');
                $_COOKIE['mobile_prefix'] = $mobile_prefix;
                setcookie('mobile_prefix', $mobile_prefix, time()+(24*3600*30), '/');
                $res = ApplyModel::findOne(['mobile' =>$mobile]);
                if(!$res){
                    $this->ajaxReturn(array('code'=>1113, 'message'=>'您还没有报名'));
                }
                $_COOKIE['email'] = $res['email'];
                setcookie('email', $res['email'], time()+(24*3600*30), '/');
                $this->ajaxReturn(array('code'=>208, 'message'=>'您已经报过名，赶快去投简历吧 '));
                break;
            case 'apply2':
                //验证格式
                $mobile = Yii::$app->request->post('mobile');
                $captcha = Yii::$app->request->post('captcha');
                $mobile_prefix = Yii::$app->request->post('mobile_prefix');
                if(!$mobile || !$captcha) $this->ajaxReturn(array('code'=>2001, 'message'=>'抱歉，参数丢失，请稍后再试'));
                if($mobile_prefix == 86 && !$this->myValidate('mobile', $mobile)) $this->ajaxReturn(array('code'=>2002, 'message'=>'手机号格式有误，请重新输入'));
                if(!$this->myValidate('captcha', $captcha)) $this->ajaxReturn(array('code'=>2003, 'message'=>'验证码格式有误，请重新输入'));
                if(!$this->myValidate('mobile_prefix', $mobile_prefix)) $this->ajaxReturn(array('code'=>2002, 'message'=>'国家区号有误，请重新输入'));


                //验证手机验证码
                $captchaData = CaptchaModel::find()
                    ->where('mobile=:mobile and captcha=:captcha', [':mobile'=>$mobile, ':captcha'=>$captcha])
                    ->one();
                if(!$captchaData) $this->ajaxReturn(array('code'=>2004, 'message'=>'验证码错误，请重新输入'));

                //验证码是否有效，有效期半小时
                $invalid_time = $captchaData->ctime + 1800;
                if(time() > $invalid_time) $this->ajaxReturn(array('code'=>2005, 'message'=>'验证码已过期，请重新获取验证码'));

                //验证成功
                $candidate = ['mobile' => $mobile,'mobile_prefix' => $mobile_prefix];
                $_COOKIE['mobile'] = $mobile;
                setcookie('mobile', $mobile, time()+(24*3600*30), '/');
                $_COOKIE['mobile_prefix'] = $mobile_prefix;
                setcookie('mobile_prefix', $mobile_prefix, time()+(24*3600*30), '/');
                $res = ApplyModel::findOne(['mobile' =>$mobile]);
                if(!$res){
                    $this->ajaxReturn(array('code'=>1114, 'message'=>'您还没有报名'));
                }
                $_COOKIE['email'] = $res['email'];
                setcookie('email', $res['email'], time()+(24*3600*30), '/');
                $this->ajaxReturn(array('code'=>209, 'message'=>'您已经报过名，赶快去投简历吧 '));
                break;
            default:
                $this->ajaxReturn(array('code'=>1002, 'message'=>'抱歉，未知操作，请刷新页面后重试'));
                break;
        }
    }

    /**
     * ajax异步发送邮件
     * */
    public function actionSendMail(){
        $jobid = Yii::$app->request->post('jobid');
        $companyid = Yii::$app->request->post('companyid');
        if(!$jobid) $this->ajaxReturn(array('code'=>1001, 'message'=>'抱歉，参数不完整，请稍后再试'));

        //是否验证用户身份
        if(!$this->candidate)  $this->ajaxReturn(array('code'=>1002, 'message'=>'您还未验证身份'));

        //是否已有简历
        $resumeData = ResumeModel::findOne(['mobile' => $this->candidate['mobile']]);
        if(!$resumeData) $this->ajaxReturn(array('code'=>1003, 'message'=>'您还未填写简历'));

        //企业和岗位是否存在
//        $query = new \yii\db\Query();
//        $jobData = $query->where('jobid=:jobid', [':jobid' => $jobid])->from(JobModel::tableName())->one();//待修改
        $jobData = Yii::$app->jobsdb->createCommand('SELECT * FROM hg_document_company WHERE id = '.$jobid)->queryOne();

        if(!$jobData) $this->ajaxReturn(array('code'=>1004, 'message'=>'岗位不存在'));
//        $companyData = $query->where('companyid='.$jobData['companyid'])->from(CompanyModel::tableName())->one();//待修改
        $companyData = Yii::$app->jobsdb->createCommand('SELECT de.*,d.* FROM hg_document_exib de LEFT JOIN hg_document d ON de.id=d.id WHERE de.id ='.$companyid.' AND d.`status`=1')->queryOne();

        if(!$companyData || $companyData['status'] !=1 ) $this->ajaxReturn(array('code'=>1004, 'message'=>'企业不存在'));

        //发送邮件给企业
        if($companyData['email']){
            $resumeData->work_time = $resumeData->work_time?json_decode($resumeData->work_time, true):'';
            $emailData = array(
                'resumeData' => $resumeData,
                'jobData' => $jobData
            );
            if($this->mailto('收到简历提醒-我是海归网', $emailData, $companyData['email'])){
                $this->ajaxReturn(array('code'=>200, 'message'=>''));
            }else{
                $this->ajaxReturn(array('code'=>1007, 'message'=>'邮件发送失败'));
            }
        }else{
            $this->ajaxReturn(array('code'=>1006, 'message'=>'企业不存在'));
        }

    }


    /**
     * 简历信息导出
     * */
    public function actionExportimhg(){
        set_time_limit(0);
        /* 获取列表 */
        $result = new ApplyModel();
        $result = $result::find()->asArray()->all();

        /* 实例化excel类 */
        $resultPHPExcel = new \PHPExcel();

        /* excel文档基本设置 */
        $objProps = $resultPHPExcel->getProperties();
        $objActSheet = $resultPHPExcel->getActiveSheet();
        $objProps->setCreator('imhaigui');

        /* 表头设置 */
        $head = array(
            'A2' => 'ID',
            'B2' => '姓名',
            'C2' => '域名',
            'D2' => '手机号',
            'E2' => '邮箱',
            'F2' => '北京招聘会',
            'G2' => '上海招聘会',
            'H2' => '深圳招聘会',
        );
        foreach ($head as $key => $value) {
            $objActSheet->setCellValue($key, $value);
        }

        /* 设置宽度 */
        $objActSheet->getColumnDimension('B')->setWidth(15);
        $objActSheet->getColumnDimension('C')->setWidth(40);
        $objActSheet->getColumnDimension('D')->setWidth(15);
        $objActSheet->getColumnDimension('E')->setWidth(40);
        $objActSheet->getColumnDimension('F')->setWidth(10);
        $objActSheet->getColumnDimension('G')->setWidth(10);
        $objActSheet->getColumnDimension('H')->setWidth(10);

        /* 内容设置 */
        $i = 3; //开始行数
        foreach ($result as $vv) {
            $objActSheet->setCellValue('A' . $i, $vv['applyid']);
            $objActSheet->setCellValue('B' . $i, $vv['name']);
            $objActSheet->setCellValue('C' . $i, $vv['Website']);
            $objActSheet->setCellValue('D' . $i, $vv['mobile']);
            $objActSheet->setCellValue('E' . $i, $vv['email']);
            $objActSheet->setCellValue('F' . $i, $vv['beijing']);
            $objActSheet->setCellValue('G' . $i, $vv['shanghai']);
            $objActSheet->setCellValue('H' . $i, $vv['shenzhen']);
            $i++;
        }

        //设置导出文件名
        $outputFileName = '报名列表.xls';
        $xlsWriter = new \PHPExcel_Writer_Excel5($resultPHPExcel);
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Disposition:inline;filename="' . $outputFileName . '"');
        header("Content-Transfer-Encoding: binary");
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Pragma: no-cache");
        $xlsWriter->save("php://output");
    }
}