<?php
/**
 * Created by PhpStorm.
 * User: lzm
 * Date: 2017/3/22
 * Time: 13:53
 */

namespace app\modules\front\controllers;

use Yii;
use app\models\CompanyModel;
use app\models\UserCompanyModel;
use app\modules\front\models\Company;
use app\modules\front\models\UserCompany;

class VotesysController extends BaseController
{

    //被投票企业id
    public $vote_company_id;


    /**
     * 投票系统首页界面
     * */
    public function actionIndex(){
        $this->layout = false;var_dump($_REQUEST);
//          //测试投票入口
//        $this->actionVote();

    }


    /**
     * 分类投票页
     * @param $type
     */
    public function actionClassvote(){
        $class = '';
        $type = YII::$app->request->get('type');
        switch ($type){
            case 'bank':
                $class = '银行专场';
                break;
            case 'car':
                $class = '汽车专场';
                break;
            case 'city':
                $class = '城市专场';
                break;
            default :
                $class = '';
                break;
        }
        $reslist = Yii::$app->db->createCommand("SELECT *,votenum+votenumadd AS `click` FROM ".Company::tableName()." WHERE status = 1 AND class ='" .$class."'  order by `click` DESC LIMIT 21")->queryAll();
        return $this->render('vote'.$type,['reslist'=>$reslist]);

    }
    /**
     * 投票列表
     */
    public function actionGetCompany(){

        $company = new Company();
        //获取所有职位
        $reslist = Yii::$app->db->createCommand("SELECT *,votenum+votenumadd AS `click` FROM ".Company::tableName()."WHERE status = 1  order by `click` DESC")->queryAll();
//        $reslist = $company::find()->select('*,votenum+votenumadd as click')
//            ->where('status = 1')->asArray()->all();


        //按分类整理职位数据
        $company = [];
        foreach($reslist as $value){
            switch ($value['class']){
                case '银行专场':
                    $company['banklist'][] = $value;
                    break;
                case '汽车专场':
                    $company['carlist'][] = $value;
                    break;
                case '城市专场':
                    $company['citylist'][] = $value;
                    break;
            }
        }

        //限制每个楼层显示最多6个企业
        $companylist = [];
                $companylist['banklist'] = array_slice($company['banklist'],0,6);
                $companylist['carlist'] =  array_slice($company['carlist'],0,6);
                $companylist['citylist'] = array_slice($company['citylist'],0,6);

        return $this->render('vote',['companylist'=>$companylist]);

    }



    /**
     * 三种用户通用投票入口
     * 错误代码
     * 200  投票成功
     * 1001 未知用户类型
     * 1002 用户信息不全
     * 1003 没有选中投票的企业
     * 1004 投票记录保存失败
     * 1005 企业投票失败
     * 1006 您今天已经投了n次
     * 1007 您今天已经投了该公司,请明天在投
     * 1008 投票失败
     * 1009 用户类型不合法
     * 1010 app用户id类型错误  必须是整形
     * 1011 父类中ip地址未获取到
     */
    public function actionVote(){
        //从基类获取用户类型
        $type = $this->type;
        //从基类用户信息
        $userData = $this->userData;
        //获取被投票企业id
        $company_id = YII::$app->request->post('vote_company_id');

        //测试 模拟用户和投票数据
//        $type = $this->type ='ip';
//        $userData['userid'] = $this->userData['userid'] = '192.168.0.1';
//        $company_id = $this->vote_company_id = 3;



        //判断是否获取到企业id  获取到 把企业id赋值给  自身属性 vote_company_id
        if(!$company_id){
            $this->ajaxReturn(array('code'=>1003,'message'=>'没有选中要投票的企业'));
        }else{
            $this->vote_company_id = $company_id;
        }


        //判断用户类型是否存在
        if(!$type){
            $this->ajaxReturn(array('code'=>1001,'message'=>'未知用户类型'));
        }
        //判断用户信息是否存在
        if(!$userData){
            $this->ajaxReturn(array('code'=>1002,'message'=>'用户信息不全'));
        }

        //根据类型选择 执行投票方法
        $this->SelectVote($type);

    }


    /**
     * 根据类型参数 执行投票方法
     * @param $type 用户类型
     */
    protected function SelectVote($type){
        switch ($type){
            case 'app':
                $this->appVote($this->userData);
                break;
            case 'wx':
                $this->wxVote($this->userData);
                break;
            case 'sina':
                $this->sinaVote($this->userData);
                break;
            case 'ip':
                $this->ipVote($this->userData);
                break;
            default :
                $this->ajaxReturn(array('code'=>1009, 'message'=>'用户类型不合法'));
                break;

        }

    }

    /**
     * 海龟app用户投票
     * @param $userdata 海龟app用户信息
     */
    protected function ipVote($userdata){

        //验证当天投票次数
        $this->checkVoteTimes('ip',$userdata);
        //验证当天该企业是否被该用户投过
        $this->checkVoteRepeat('ip',$userdata);

        //这里需要开启事物处理
        /* 使用事务 */
        $transaction = Yii::$app->db->beginTransaction();
        try {
            //插入投票记录
            //获得企业信息模型
            $CompanyModel = new CompanyModel();
            //获得投票记录表模型
            $UserCompanyModel = new UserCompanyModel();
            $UserCompanyModel->ipaddress = $userdata['userid'];
            $UserCompanyModel->vote_company_id = $this->vote_company_id;
            $UserCompanyModel->ctime = time();

            //保存投票记录
            if($UserCompanyModel->save()){
                //更新企业表中真实投票数 字段votenum数据
                $company = $CompanyModel::findOne($this->vote_company_id);
//            $company = $CompanyModel->find()->where(['vote_company_id'=> $this->vote_company_id])->one();
                $res['click'] = $company->votenum += 1;
                $res['click'] +=$company->votenumadd;
                //增加 企业真实投票数量
                if($company->save()){
                    $transaction->commit();
                    $this->ajaxReturn(array('code'=>200,'res' =>$res));

                }else{
                    $this->ajaxReturn(array('code'=>1005, 'message'=>'企业投票失败'));
                }

            }else{
                $this->ajaxReturn(array('code'=>1004, 'message'=>'投票记录保存失败'));
            }

        }catch (Exception $e) {
            $transaction->rollBack();
            $this->ajaxReturn(array('code'=>1008, 'message'=>$e->getMessage()));
        }
    }


    /**
     * 海龟app用户投票
     * @param $userdata 海龟app用户信息
     */
    protected function appVote($userdata){
        //验证app用户的id是否为真 整型
        if(!$userdata['userid']||!is_int($userdata['userid'])){

            $this->ajaxReturn(array('code'=>1010, 'message'=>'app用户id类型错误'));
        }
        //验证当天投票次数
        $this->checkVoteTimes('app',$userdata);
        //验证当天该企业是否被该用户投过
        $this->checkVoteRepeat('app',$userdata);

        //这里需要开启事物处理
        /* 使用事务 */
        $transaction = Yii::$app->db->beginTransaction();
        try {
        //插入投票记录
        //获得企业信息模型
        $CompanyModel = new CompanyModel();
        //获得投票记录表模型
        $UserCompanyModel = new UserCompanyModel();
        $UserCompanyModel->voteuid = $userdata['userid'];
        $UserCompanyModel->vote_company_id = $this->vote_company_id;
        $UserCompanyModel->ctime = time();

        //保存投票记录
        if($UserCompanyModel->save()){
            //更新企业表中真实投票数 字段votenum数据
            $company = $CompanyModel::findOne($this->vote_company_id);
//            $company = $CompanyModel->find()->where(['vote_company_id'=> $this->vote_company_id])->one();
            $company->votenum += 1;
            //增加 企业真实投票数量
            if($company->save()){
                $transaction->commit();
                $this->ajaxReturn(array('code'=>200));
            }else{
                $this->ajaxReturn(array('code'=>1005, 'message'=>'企业投票失败'));
            }

        }else{
            $this->ajaxReturn(array('code'=>1004, 'message'=>'投票记录保存失败'));
        }

        }catch (Exception $e) {
            $transaction->rollBack();
            $this->ajaxReturn(array('code'=>1008, 'message'=>$e->getMessage()));
        }
    }

    /**
     * 微信用户投票
     * @param $userdata 微信用户数据
     */
    protected function wxVote($userdata){
        //验证当天投票次数
        $this->checkVoteTimes('wx',$userdata);
        //验证当天该企业是否被该用户投过
        $this->checkVoteRepeat('wx',$userdata);

        //这里需要开启事物处理

        /* 使用事务 */
        $transaction = Yii::$app->db->beginTransaction();
        try {


        //插入投票记录
        //获得企业信息模型
        $CompanyModel = new CompanyModel();
        //获得投票记录表模型
        $UserCompanyModel = new UserCompanyModel();
        $UserCompanyModel->oppenid = $userdata['userid'];
        $UserCompanyModel->vote_company_id = $this->vote_company_id;
        $UserCompanyModel->ctime = time();

        //保存投票记录
        if($UserCompanyModel->save()){
            //更新企业表中真实投票数 字段votenum数据
            $company = $CompanyModel::findOne($this->vote_company_id);
            $company->votenum += 1;
            //增加 企业真实投票数量
            if($company->save()){
                $transaction->commit();
                $this->ajaxReturn(array('code'=>200));
            }else{
                $this->ajaxReturn(array('code'=>1005, 'message'=>'企业投票失败'));
            }

        }else{
            $this->ajaxReturn(array('code'=>1004, 'message'=>'投票记录保存失败'));
        }

        }catch (Exception $e) {
            $transaction->rollBack();
            $this->ajaxReturn(array('code'=>1008, 'message'=>$e->getMessage()));
        }

    }

    /**
     * sinna用户投票
     * @param $userdata 用户数据
     */
    protected function sinaVote($userdata){
        //验证当天投票次数
        $this->checkVoteTimes('sina',$userdata);
        //验证当天该企业是否被该用户投过
        $this->checkVoteRepeat('sina',$userdata);

        //这里需要开启事物处理

        /* 使用事务 */
        $transaction = Yii::$app->db->beginTransaction();
        try {
        //插入投票记录
        //获得企业信息模型
        $CompanyModel = new CompanyModel();
        //获得投票记录表模型
        $UserCompanyModel = new UserCompanyModel();
        $UserCompanyModel->sinnaid = $userdata['userid'];
        $UserCompanyModel->vote_company_id = $this->vote_company_id;
        $UserCompanyModel->ctime = time();

        //保存投票记录
        if($UserCompanyModel->save()){
            //更新企业表中真实投票数 字段votenum数据
            $company = $CompanyModel->findOne($this->vote_company_id);
            $company->votenum += 1;
            //增加 企业真实投票数量
            if($company->save()){
                $transaction->commit();
                $this->ajaxReturn(array('code'=>200));
            }else{
                $this->ajaxReturn(array('code'=>1005, 'message'=>'企业投票失败'));
            }

        }else{
            $this->ajaxReturn(array('code'=>1004, 'message'=>'投票记录保存失败'));
        }

        }catch (Exception $e) {
            $transaction->rollBack();
            $this->ajaxReturn(array('code'=>1008, 'message'=>$e->getMessage()));
        }


    }


    /**
     * 验证当天投票次数是否大于3默认次数
     * @param $type 用户类型
     * @param $userdata 用户信息
     * @param $times 当天投票次数 默认3
     */
    protected function checkVoteTimes($type,$userdata,$times = 3){

        switch ($type){
            case 'app':
                //获得投票记录表模型
                $UserCompanyModel = new UserCompanyModel();

                //当天开始时间戳 与当天结束时间戳
                $starttime = strtotime(date('Ymd'));
                $endtime   = $starttime +86400;

                //查询当天投票次数
                $count = $UserCompanyModel->find()
                    ->where(['between', 'ctime',$starttime,$endtime])
                    ->andWhere(['voteuid' => $userdata['userid']])
                    ->count('vote_company_id');

                if($count>=$times){
                    $this->ajaxReturn(array('code'=>1006, 'message'=>'您今天已经投了'.$times.'次'));
                }
                break;
            case 'wx':
                //获得投票记录表模型
                $UserCompanyModel = new UserCompanyModel();

                //当天开始时间戳 与当天结束时间戳
                $starttime = strtotime(date('Ymd'));
                $endtime   = $starttime +86400;

                //查询当天投票次数
                $count = $UserCompanyModel->find()
                    ->where(['between', 'ctime',$starttime,$endtime])
                    ->andWhere(['oppenid' => $userdata['userid']])
                    ->count('vote_company_id');

                if($count>=$times){
                    $this->ajaxReturn(array('code'=>1006, 'message'=>'您今天已经投了'.$times.'次'));
                }
                break;
            case 'sina':
                //获得投票记录表模型
                $UserCompanyModel = new UserCompanyModel();
                //当天开始时间戳 与当天结束时间戳

                $starttime = strtotime(date('Ymd'));
                $endtime   = $starttime +86400;

                //查询当天投票次数
                $count = $UserCompanyModel->find()
                    ->where(['between', 'ctime',$starttime,$endtime])
                    ->andWhere(['sinnaid' => $userdata['userid']])
                    ->count('vote_company_id');
                if($count>=$times){
                    $this->ajaxReturn(array('code'=>1006, 'message'=>'您今天已经投了'.$times.'次'));
                }
                break;
            case 'ip':
                //获得投票记录表模型
                $UserCompanyModel = new UserCompanyModel();
                //当天开始时间戳 与当天结束时间戳

                $starttime = strtotime(date('Ymd'));
                $endtime   = $starttime +86400;

                //查询当天投票次数
                $count = $UserCompanyModel->find()
                    ->where(['between', 'ctime',$starttime,$endtime])
                    ->andWhere(['ipaddress' => $userdata['userid']])
                    ->count('vote_company_id');
                if($count>=$times){
                    $this->ajaxReturn(array('code'=>1006, 'message'=>'您今天已经投了'.$times.'次'));
                }
                break;
            default :
                $this->ajaxReturn(array('code'=>1009, 'message'=>'用户类型不合法'));
                break;
        }

    }

    /**
     * 验证当天该企业是否被该用户投过
     * @param $type 用户类型
     * @param $userdata 用户信息
     */
    protected function checkVoteRepeat($type,$userdata){

        switch ($type){
            case 'app':
                //获得投票记录表模型
                $UserCompanyModel = new UserCompanyModel();

                //当天开始时间戳 与当天结束时间戳
                $starttime = strtotime(date('Ymd'));
                $endtime   = $starttime +86400;

                //查询当天是否投过该企业
                $count = $UserCompanyModel->find()
                    ->where(['between', 'ctime',$starttime,$endtime])
                    ->andWhere(['voteuid' => $userdata['userid'],'vote_company_id' => $this->vote_company_id])
                    ->count('vote_company_id');
                if($count){
                    $this->ajaxReturn(array('code'=>1007, 'message'=>'您今天已经投了该公司,请明天在投'));
                }

                break;
            case 'wx':
                //获得投票记录表模型
                $UserCompanyModel = new UserCompanyModel();

                //当天开始时间戳 与当天结束时间戳
                $starttime = strtotime(date('Ymd'));
                $endtime   = $starttime +86400;

                //查询当天是否投过该企业
                $count = $UserCompanyModel->find()
                    ->where(['between', 'ctime',$starttime,$endtime])
                    ->andWhere(['oppenid' => $userdata['userid'],'vote_company_id' => $this->vote_company_id])
                    ->count('vote_company_id');
                if($count){
                    $this->ajaxReturn(array('code'=>1007, 'message'=>'您今天已经投了该公司,请明天在投'));
                }
                break;
            case 'sina':
                //获得投票记录表模型
                $UserCompanyModel = new UserCompanyModel();

                //当天开始时间戳 与当天结束时间戳
                $starttime = strtotime(date('Ymd'));
                $endtime   = $starttime +86400;

                //查询当天是否投过该企业
                $count = $UserCompanyModel->find()
                    ->where(['between', 'ctime',$starttime,$endtime])
                    ->andWhere(['sinnaid' => $userdata['userid'],'vote_company_id' => $this->vote_company_id])
                    ->count('vote_company_id');
                if($count){
                    $this->ajaxReturn(array('code'=>1007, 'message'=>'您今天已经投了该公司,请明天在投'));
                }
                break;
            case 'ip':
                //获得投票记录表模型
                $UserCompanyModel = new UserCompanyModel();

                //当天开始时间戳 与当天结束时间戳
                $starttime = strtotime(date('Ymd'));
                $endtime   = $starttime +86400;

                //查询当天是否投过该企业
                $count = $UserCompanyModel->find()
                    ->where(['between', 'ctime',$starttime,$endtime])
                    ->andWhere(['ipaddress' => $userdata['userid'],'vote_company_id' => $this->vote_company_id])
                    ->count('vote_company_id');
                if($count){
                    $this->ajaxReturn(array('code'=>1007, 'message'=>'您今天已经投了该公司,请明天在投'));
                }
                break;
            default :
                $this->ajaxReturn(array('code'=>1009, 'message'=>'用户类型不合法'));
                break;
        }

    }






}