<?php
/**
 * User:  jiangm
 * Email: jmphper@foxmail.com
 * Date:  2017/11/28
 * Time:  22:46
 * Desc:  我是海归 - 数据统计
 */

namespace app\controllers;

use Yii;
use yii\web\controller;

class ImhgDataController extends Controller
{

    public $layout = false;
    public $start_time;
    public $end_time;
    public function init(){
        parent::init();
        // 默认时间
        $this->start_time = date('Ymd', time()-(14*24*3600));
        $this->end_time = date('Ymd', time());
        $this->layout = 'normal';
    }

    public function actionIndex(){
        return $this->render('index');
    }

    public function actionBraTest(){
        die('{"text":"\u603b\u91cf\u7edf\u8ba1","subtext":"","legend_data":["\u603b\u6570\u91cf"],"xAxis_data":["\u7528\u6237","\u6d3b\u52a8","\u6d77\u5f52\u5708","\u6d77\u8c08","\u521b\u4e1a\u9879\u76ee","\u7fa4\u7ec4"],"series":[{"name":"\u603b\u6570\u91cf","type":"bar","data":["352","27","850","37","4","0"]}]}');
    }

    /*
      * ---------------------------------------
      * 用户数据统计
      * ---------------------------------------
      */
    public function actionAjaxAllNumber() {
        if(!Yii::app()->session['is_admin']) exit; // 没有权限

        $start_time = Yii::app()->request->getParam('start_time', $this->start_time);
        $end_time = Yii::app()->request->getParam('end_time', $this->end_time);
        // 返回数据
        $return['text'] = '总量统计';
        $return['subtext'] = '';
        $return['legend_data'] = ['总数量'];
        $return['xAxis_data'] = ['用户', '活动', '海归圈', '海谈', '创业项目', '群组'];

        // 时间段
        $where = '';
        if($start_time){
            $start_time = strtotime($start_time);
            $where .= ' ctime>='.$start_time.' AND';
        }
        if($end_time){
            $end_time = strtotime($end_time)+24*3600;
            $where .= ' ctime<='.$end_time.' AND';
        }

        // 获取用户总数据
        $userWhere = rtrim($where, 'AND');
        $userCount = User::model()->count($userWhere);

        // 获取活动数据
        $eventWhere = $where.' status=1';
        $eventCount = Event::model()->count($eventWhere);

        // 获取海归圈
        $circleWhere = $where.' status=1';
        $circleCount = Circle::model()->count($circleWhere);

        // 获取海谈数量
        $threadWhere = $where.' status=1';
        $threadCount = Thread::model()->count($threadWhere);

        // 创业项目
        $projectWhere = $where.' status=1';
        $projectCount = Project::model()->count($projectWhere);

        // 群组
        $groupWhere = $where.' status=1';
        $groupCount = Group::model()->count($groupWhere);

        $return['series'] = [
            array(
                'name' => '总数量',
                'type' => 'bar',
                'data' => [$userCount, $eventCount, $circleCount, $threadCount, $projectCount, $groupCount]
            ),
        ];

        Yii::app()->utils->ajaxReturn($return);
    }

    /*
     * ---------------------------------------
     * 用户性别数据统计
     * ---------------------------------------
     */
    public function actionAjaxSexPie() {
        if(!Yii::app()->session['is_admin']) exit; // 没有权限

        //by lzm 增加认证用户筛选条件
        $userType = Yii::app()->request->getParam('type',0);
        //by lzm 增加认证用户筛选条件
        $connection = Yii::app()->db->createCommand();
        $connection->select('count(*) as total,sex');
        $connection->from(User::model()->tableName());
        $connection->where("uid>0");
        //by lzm 增加认证用户筛选条件
        if($userType){
            $connection->andwhere(" status >=2 ");
        }
        //by lzm 增加认证用户筛选条件
//        $connection = $this->dealTime($connection);
        $connection->group("sex");
        $connection->order("total desc");
        $result = $connection->queryAll();
        $return = array();
        $return['text'] = "用户性别分布总览"; //标题
        $return['subtext'] = ""; //副标题
        $return['series_name'] = '性别';
        $region = new Region();
        foreach ($result as $k => $v) {

            if ($v['sex'] == 2) {

                $return['legend'][] = '女';
                $return['series'][] = array('value' => $v['total'], 'name' => '女');
            } elseif ($v['sex'] == 1) {

                $return['legend'][] = '男';
                $return['series'][] = array('value' => $v['total'], 'name' => '男');
            } else {

                $return['legend'][] = '未选择';
                $return['series'][] = array('value' => $v['total'], 'name' => '未选择或未填写');
            }
        }
        //var_export($return);
        //exit;
        Yii::app()->utils->ajaxReturn($return);
    }

    /*
     * ---------------------------------------
     * 用户留学国家统计
     * ---------------------------------------
     */
    public function actionAjaxCountryPie() {
        if(!Yii::app()->session['is_admin']) exit; // 没有权限
        //by lzm 增加认证用户筛选条件
        $userType = Yii::app()->request->getParam('type',0);
        //by lzm 增加认证用户筛选条件
        // 查询用户数据
        $connection = Yii::app()->db->createCommand();
        $connection->select('count(*) as total,country_id');
        $connection->from(User::model()->tableName());
        $connection->where("uid>0");
        //by lzm 增加认证用户筛选条件
        if($userType){
            $connection->andwhere(" status >=2 ");
        }
        //by lzm 增加认证用户筛选条件
        // 时间段条件
//        $connection = $this->dealTime($connection);
        $connection->group("country_id");
        $connection->order("total desc");
        $result = $connection->queryAll();
        $line = $result?$result[0]['total']/80:0; // 显示过滤
        // 整理返回数据
        $return = array();
        $return['text'] = "用户留学国家分布总览"; //标题
        $return['subtext'] = ""; //副标题
        $return['series_name'] = "国家";
        $model = new Country();
        $otherTotal = 0;
        $noCountrTotal = 0;
        foreach ($result as $k => $v) {
            if ($v['country_id']) {

                if ($v['total'] > $line) {
                    $one = $model->findByPk($v['country_id']);
                    if (!$one) {
                        continue;
                    }
                    $return['legend'][] = $one->name;
                    $return['series'][] = array('value' => $v['total'], 'name' => $one->name);
                } else {

                    $otherTotal += $v['total'];
                }

            } else {

                $noCountrTotal += $v['total'];
            }
        }
        if ($otherTotal > 0) {
            $return['legend'][] = '其他';
            $return['series'][] = array('value' => $otherTotal, 'name' => '其他');
        }
        if ($noCountrTotal > 0){
            $return['legend'][] = '未选择或未填写';
            $return['series'][] = array('value' => $noCountrTotal, 'name' => '未选择或未填写');
        }
        Yii::app()->utils->ajaxReturn($return);
    }

    /**
     * 新增用户年龄柱状分布
     */
    public function actionAjaxUserAgeBar(){
        if(!Yii::app()->session['is_admin']) exit;//没有权限
        //by lzm 增加认证用户筛选条件
        $userType = Yii::app()->request->getParam('type',0);
        //by lzm 增加认证用户筛选条件
        // 生成 时间段 5 年一个跨度
        $yearTime = 157680000; //5年的时间戳
        $birthdayCount = floor( (date('Y', time()) - 1960 )/5 );
        $birthday = array();
        for($i=0;$i<$birthdayCount;$i++){
            $nowYear = 60 + $i*5;
            $birthday[$i]['name'] = $nowYear. '后';
            if($nowYear == 60) {
                $birthday[$i]['min'] = -$yearTime * 2;
                $birthday[$i]['max'] = -$yearTime * 1;
            }elseif($nowYear == 65){
                $birthday[$i]['min'] = -$yearTime * 2;
                $birthday[$i]['max'] = -$yearTime * 1;
            }else{
                if($nowYear >= 100){
                    $birthday[$i]['name'] = substr((string)$nowYear, 1, 2). '后';
                }
                $birthday[$i]['min'] = $yearTime*($i-2);
                $birthday[$i]['max'] = $yearTime*($i-1);
            }
        }

        foreach ($birthday as $k => $v) {
            $connection = Yii::app()->db->createCommand();
            $connection->select('count(*) as total');
            $connection->from(User::model()->tableName());
            $connection->where("uid>0");
            //by lzm 增加认证用户筛选条件
            if($userType){
                $connection->andwhere(" status >=2 ");
            }
            //by lzm 增加认证用户筛选条件
//            $connection = $this->dealTime($connection);
            $connection->andWhere("birthday>=" . $v['min'] . " AND birthday<=" . $v['max']); //年代
            $result = $connection->queryRow();
            $birthday[$k]['total'] = $result['total'];
        }

        //整理返回数组
        $return = [];
        $return['text'] = '年龄分布柱状图';
        $return['subtext'] = '';
        $return['legend_data'] = ['年龄'];

        $return['series'] =array(
            'name' => '人数',
            'type' => 'bar',
            'data' => []
        );
        if(!$birthday){
            $return = [['title'=>'未查找到相应数据', 'num1'=>0]];
        }

        foreach ($birthday as $key =>$value){
            $return['xAxis_data'][]= $value['name'];
            $return['series']['data'][] = $value['total'];
        }


        Yii::app()->utils->ajaxReturn($return);


    }
    /**
     * 用户年龄分布
     * */
    public function actionAjaxUserAgePie(){
        if(!Yii::app()->session['is_admin']) exit; // 没有权限
        //by lzm 增加认证用户筛选条件
        $userType = Yii::app()->request->getParam('type',0);
        //by lzm 增加认证用户筛选条件
        // 生成 时间段 5 年一个跨度
        $yearTime = 157680000; //5年的时间戳
        $birthdayCount = floor( (date('Y', time()) - 1960 )/5 );
        $birthday = array();
        for($i=0;$i<$birthdayCount;$i++){
            $nowYear = 60 + $i*5;
            $birthday[$i]['name'] = $nowYear. '后';
            if($nowYear == 60) {
                $birthday[$i]['min'] = -$yearTime * 2;
                $birthday[$i]['max'] = -$yearTime * 1;
            }elseif($nowYear == 65){
                $birthday[$i]['min'] = -$yearTime * 2;
                $birthday[$i]['max'] = -$yearTime * 1;
            }else{
                if($nowYear >= 100){
                    $birthday[$i]['name'] = substr((string)$nowYear, 1, 2). '后';
                }
                $birthday[$i]['min'] = $yearTime*($i-2);
                $birthday[$i]['max'] = $yearTime*($i-1);
            }
        }

        foreach ($birthday as $k => $v) {
            $connection = Yii::app()->db->createCommand();
            $connection->select('count(*) as total');
            $connection->from(User::model()->tableName());
            $connection->where("uid>0");
            //by lzm 增加认证用户筛选条件
            if($userType){
                $connection->andwhere(" status >=2 ");
            }
            //by lzm 增加认证用户筛选条件
//            $connection = $this->dealTime($connection);
            $connection->andWhere("birthday>=" . $v['min'] . " AND birthday<=" . $v['max']); //年代
            $result = $connection->queryRow();
            $birthday[$k]['total'] = $result['total'];
        }

        $return = array();
        $return['text'] = "用户年龄分布总览"; //标题
        $return['subtext'] = ""; //副标题
        $return['series_name'] = '年龄'; //副标题
        foreach ($birthday as $k => $v) {

            $return['legend'][] = $v['name'];
            $return['series'][] = array('value' => $v['total'], 'name' => $v['name']);
        }

        Yii::app()->utils->ajaxReturn($return);
    }

    /**
     * 用户漏斗图数据
     * */
    public function actionAjaxUserFunnel(){
        if(!Yii::app()->session['is_admin']) exit; // 没有权限

        $start_time = Yii::app()->request->getParam('start_time', $this->start_time);
        $end_time = Yii::app()->request->getParam('end_time', $this->end_time);
        //转换为 开始时间戳  和结束当天 凌晨时间戳
        $start_time = $start_time?strtotime($start_time):0;
        $end_time = $end_time?strtotime($end_time)+24*3600:time();

        $return['text'] = "用户漏斗图"; //标题
        $return['subtext'] = ""; //副标题
        $return['legend_data'] = ['数量'];

        // 注册用户，基数
        $userRegister = 0;
        $command = Yii::app()->db->createCommand();
        $command->select('uid');
        $command->from(User::model()->tableName());
        $command->where("uid>0");
        $command = $this->dealTime($command);
        $userData = $command->queryAll();
        $userRegister = count($userData);
        // 该时间段内所有注册用户uid用逗号分隔
        $userRegisterUid = implode(',', array_column( $userData ,  'uid' ));

        // 认证用户和加v用户
        $userCert = 0;
        $userVip = 0;
        $command->reset();
        $command->select('count(*) as total,type');
        $command->from(UserCert::model()->tableName());
        $command->where('uid in ('.$userRegisterUid.') and status=1');
        $command = $this->dealTime($command);
        $command->group("type");
        $command->order("type asc");
        $userCertData = $command->queryAll();
        foreach($userCertData as $value){
            $userCert += $value['total'];
            if($value['type'] == 4 || $value['type'] == 5){ // 加v
                $userVip += $value['total'];
            }
        }

        // 付费用户
        $userFf = $userVip; // 加v用户
        $eventOrderDB = Yii::app()->db->createCommand();
        $eventOrderDB->select('eo.uid');
        $eventOrderDB->from(EventOrder::model()->tableName(). ' as eo');
        $eventOrderDB->leftJoin(User::model()->tableName() . ' as u', 'eo.uid = u.uid');
        $eventOrderDB->where('eo.status=2 and u.status in (0,1,2) and eo.uid in ('.$userRegisterUid.')');// 已付款的非加v用户
        $eventOrderDB->andWhere('eo.ctime>='.$start_time.' and eo.ctime<='.$end_time);
        $eventOrderDB->group("uid");
        $eventOrderNumber = $eventOrderDB->queryAll();
        $userFf += count($eventOrderNumber);

        // 整理返回数据
        $return['series_data_sj'] = [
            array('value' => $userRegister, 'name'=> '注册'),
            array('value' => $userCert, 'name'=> '认证'),
            array('value' => $userVip, 'name'=> '加v'),
            array('value' => $userFf, 'name'=> '付费用户'),
        ];
        Yii::app()->utils->ajaxReturn($return);

    }

    /**
     * 活跃用户漏斗图
     * */
    public function actionAjaxUserFunnelLively(){
        if(!Yii::app()->session['is_admin']) exit; // 没有权限

        $start_time = Yii::app()->request->getParam('start_time', $this->start_time);
        $end_time = Yii::app()->request->getParam('end_time', $this->end_time);
        //转换为 开始时间戳  和结束当天 凌晨时间戳
        $start_time = $start_time?strtotime($start_time):0;
        $end_time = $end_time?strtotime($end_time)+24*3600:time();

        $return['text'] = "活跃用户漏斗图"; //标题
        $return['subtext'] = ""; //副标题
        $return['legend_data'] = ['数量'];

        // 注册用户，基数
        $userRegister = 0;
        $command = Yii::app()->db->createCommand();
        $command->select('uid');
        $command->from(User::model()->tableName());
        $command->where("uid>0");
        $command = $this->dealTime($command);
        $userData = $command->queryAll();
        $userRegister = count($userData);
        // 该时间段内所有注册用户uid用逗号分隔
        $userRegisterUid = implode(',', array_column( $userData ,  'uid' ));

        // 活跃用户获取
        $logUserCountDB = Yii::app()->db->createCommand();
        $logUserCountDB->select('count(*) as total, uid');
        $logUserCountDB->from(LogLogin::model()->tableName());
        $logUserCountDB->where('status=1 AND uid in ('.$userRegisterUid.')');
        $logUserCountDB = $this->dealTime($logUserCountDB);
        $logUserCountDB->group("uid");
        $logUserCountDB->order("total desc");
        $DauCountAll = $logUserCountDB->queryAll();
        $userDau = 0;
        $lively_scale = 3/7; // 比例，一周内登录三次为活跃
        $lively_login_num = floor(floor(($end_time-$start_time)/(24*3600))*$lively_scale); // 该段时间内达到登录次数，为活跃用户
        // 计算活跃用户
        for($i=0;$i<count($DauCountAll);$i++){
            if($DauCountAll[$i]['total'] >= $lively_login_num) $userDau++;
        }

        // 整理返回数据
        $return['series_data_sj'] = [
            array('value' => $userRegister, 'name'=> '注册'),
            array('value' => $userDau, 'name'=> '活跃'),
        ];
        Yii::app()->utils->ajaxReturn($return);

    }

    /**
     * 用户所在城市分布热点图
     * */
    public function actionAjaxUserCity(){
        if(!Yii::app()->session['is_admin']) exit; // 没有权限

        //by lzm 增加认证用户筛选条件
        $userType = Yii::app()->request->getParam('type',0);
        //by lzm 增加认证用户筛选条件

        // 查询用户信息
        $connection = Yii::app()->db->createCommand();
        $connection->select('count(*) as total,city_id');
        $connection->from(User::model()->tableName());
        $connection->where("uid>0");
        //by lzm 增加认证用户筛选条件
        if($userType){
            $connection->andwhere(" status >=2 ");
        }
        //by lzm 增加认证用户筛选条件
        // 时间段条件
        $connection = $this->dealTime($connection);
        $connection->group("city_id");
        $connection->order("total desc");
        $result = $connection->queryAll();
        // 整理返回数据
        $return = array();
        $return['text'] = "用户所在城市分布热点图"; //标题
        $return['subtext'] = ""; //副标题
        $return['legend_data'] = ['城市'];
        $region = new Region();
        foreach ($result as $k => $v) {
            // 获取城市
            if ($v['city_id']) {
                $city = $region->findByPk($v['city_id']);
                $return['legend'][] = $city->region_name;
                $return['data'][] = array('value' => $v['total'], 'name' => $city->region_name);

            }
        }

        Yii::app()->utils->ajaxReturn($return);
    }

    /*
   * ---------------------------------------
   * 用户兴趣饼图   无时间条件
   * ---------------------------------------
   */
    public function actionAjaxInterestPie() {
        if(!Yii::app()->session['is_admin']) exit; // 没有权限
        //by lzm 增加认证用户筛选条件
        $userType = Yii::app()->request->getParam('type',0);
        //by lzm 增加认证用户筛选条件

        $all = UserInterest::model()->findAll();
        foreach ($all as $k => $v) {
            $connection = Yii::app()->db->createCommand();
            $connection->select('count(*) as total');
            $connection->from(User::model()->tableName());
            $connection->where("uid>0");
            //by lzm 增加认证用户筛选条件
            if($userType){
                $connection->andwhere(" status >=2 ");
            }
            //by lzm 增加认证用户筛选条件
            $connection->andWhere("interest like '%" . $v->interest_id . "%'"); //兴趣
            $result = $connection->queryRow();

            $interest[$k]['total'] = $result['total'];
            $interest[$k]['name'] = $v->name;
        }

        $return = array();
        $return['text'] = "用户兴趣分布总览"; //标题
        $return['subtext'] = ""; //副标题
        $return['series_name'] = "兴趣";
        foreach ($interest as $k => $v) {

            $return['legend'][] = $v['name'];
            $return['series'][] = array('value' => $v['total'], 'name' => $v['name']);
        }

        // 未选择或未填写兴趣的用户
        $return['legend'][] = '未选择或未填写';
        $return['series'][] = array('value' => User::model()->count('uid>0 AND interest="" '), 'name' => '未选择或未填写');
        Yii::app()->utils->ajaxReturn($return);
    }

    /*
    * ---------------------------------------
    * 小喇叭 饼图 无时间条件
    * ---------------------------------------
    */
    public function actionAjaxHornPie() {
        if(!Yii::app()->session['is_admin']) exit; // 没有权限

        //by lzm 增加认证用户筛选条件
        $userType = Yii::app()->request->getParam('type',0);
        //by lzm 增加认证用户筛选条件

        $connection = Yii::app()->db->createCommand();
        $connection->select('count(*) as total,horn_id');
        $connection->from(User::model()->tableName());
        $connection->where("uid>0");
        //by lzm 增加认证用户筛选条件
        if($userType){
            $connection->andwhere(" status >=2 ");
        }
        //by lzm 增加认证用户筛选条件
        $connection->group("horn_id");
        $connection->order("total desc");
        $result = $connection->queryAll();
        $return = array();
        $return['text'] = "用户小喇叭分布总览"; //标题
        $return['subtext'] = ""; //副标题
        $return['series_name'] = "小喇叭";
        $model = new UserHorn();
        $noHornTotal = 0;
        foreach ($result as $k => $v) {

            if ($v['horn_id']) {

                $one = $model->findByPk($v['horn_id']);
                if (!$one) {
                    continue;
                }
                $return['legend'][] = $one->horn_name;
                $return['series'][] = array('value' => $v['total'], 'name' => $one->horn_name);
            } else {
                $noHornTotal += $v['total'];
            }
        }
        if($noHornTotal > 0 ){
            $return['legend'][] = '未选择或未填写';
            $return['series'][] = array('value' => $noHornTotal, 'name' => '未选择或未填写');
        }
        Yii::app()->utils->ajaxReturn($return);
    }

    /**
     * 活动类型的分布
     * */
    public function actionAjaxActivityType(){
        if(!Yii::app()->session['is_admin']) exit; // 没有权限
        //获取开始结束时间  须转化为时间戳  对应数据库
        $start_time = Yii::app()->request->getParam('start_time', $this->start_time);
        $end_time = Yii::app()->request->getParam('end_time', $this->end_time);

        //转换为 开始时间戳  和结束当天 凌晨时间戳
        $start_time = $start_time?strtotime($start_time):0;
        $end_time = $end_time?strtotime($end_time)+24*3600:time();

        //查询hot字段排名前10的 活动主题
        $connection = Yii::app()->db->createCommand();
        $result = $connection
            ->select('SUM(eu.num) num1,e.type ')
            ->from(EventOrder::model()->tableName().' as eu')
            ->leftJoin(Event::model()->tableName().' as e', 'eu.event_id = e.event_id')
            ->where('e.status=1 AND eu.ctime >'.$start_time.' AND eu.ctime <'.$end_time)
            ->group('e.type')
            ->order('num1 desc')
            ->queryAll();

        //整理返回数据
        $return = [];
        //设置标题
        $return['text'] = "活动分类参加人数总览"; //标题
        $return['subtext'] = ""; //副标题
        $return['series_name'] = "活动";
        $return['legend'] = ['展会活动参加人数', '体育活动参加人数', '沙龙活动参加人数', '户外活动参加人数', 'Party活动参加人数', '演出活动参加人数', '论坛活动参加人数', '其他活动参加人数'];
        if(!$result){
            $result = [
                ['type'=>1, 'num1'=>0],
                ['type'=>2, 'num1'=>0],
                ['type'=>3, 'num1'=>0],
                ['type'=>4, 'num1'=>0],
                ['type'=>5, 'num1'=>0],
                ['type'=>6, 'num1'=>0],
                ['type'=>7, 'num1'=>0],
                ['type'=>8, 'num1'=>0],
            ];
        }

        foreach ($result as $k=>$v){
            switch ($v['type']){
                case 1:
                    $return['series'][] = array('value' => $v['num1'], 'name' => '展会活动参加人数');
                    break;
                case 2:
                    $return['series'][] = array('value' => $v['num1'], 'name' => '体育活动参加人数');
                    break;
                case 3:
                    $return['series'][] = array('value' => $v['num1'], 'name' => '沙龙活动参加人数');
                    break;
                case 4:
                    $return['series'][] = array('value' => $v['num1'], 'name' => '户外活动参加人数');
                    break;
                case 5:
                    $return['series'][] = array('value' => $v['num1'], 'name' => 'Party活动参加人数');
                    break;
                case 6:
                    $return['series'][] = array('value' => $v['num1'], 'name' => '演出活动参加人数');
                    break;
                case 7:
                    $return['series'][] = array('value' => $v['num1'], 'name' => '论坛活动参加人数');
                    break;
                case 8:
                    $return['series'][] = array('value' => $v['num1'], 'name' => '其他活动参加人数');
                    break;

            }
        }
        Yii::app()->utils->ajaxReturn($return);
    }

    /**
     * 活动前10排行柱状图
     */
    public function actionAjaxRankList(){
        if(!Yii::app()->session['is_admin']) exit; // 没有权限

        //获取开始结束时间  须转化为时间戳  对应数据库
        $start_time = Yii::app()->request->getParam('start_time', $this->start_time);
        $end_time = Yii::app()->request->getParam('end_time', $this->end_time);

        //转换为 开始时间戳  和结束当天 凌晨时间戳
        $start_time = $start_time?strtotime($start_time):0;
        $end_time = $end_time?strtotime($end_time)+24*3600:time();

        //查询hot字段排名前10的 活动主题
        $connection = Yii::app()->db->createCommand();
        $result = $connection
            ->select('e.title,sum(eu.num) as num1')
            ->from(EventOrder::model()->tableName().' as eu')
            ->leftJoin(Event::model()->tableName().' as e', 'e.event_id = eu.event_id')
            ->where('eu.ctime >'.$start_time.' AND eu.ctime <'.$end_time)
            ->limit(10)
            ->group('e.event_id')
            ->order('num1 desc')
            ->queryAll();

        //整理返回数组
        $return = [];
        $return['text'] = '活动排名';
        $return['subtext'] = '';
        $return['legend_data'] = ['活动排名'];

        $return['series'] =array(
            'name' => '参加人数',
            'type' => 'bar',
            'data' => []
        );
        if(!$result){
            $result = [['title'=>'未查找到相应数据', 'num1'=>0]];
        }

        foreach ($result as $key =>$value){
            $return['xAxis_data'][]= $value['title'];
            $return['series']['data'][] = $value['num1'];
        }

//      var_dump($return);exit;
        Yii::app()->utils->ajaxReturn($return);
    }

    /**
     * 板块参加人数饼图
     */
    public function actionAjaxModuleHot(){
        if(!Yii::app()->session['is_admin']) exit; // 没有权限

        //获取开始结束时间  须转化为年月生日数字  对应数据库数据
        $start_time = Yii::app()->request->getParam('start_time', $this->start_time);
        $end_time = Yii::app()->request->getParam('end_time', $this->end_time);

        //转换为 开始时间戳  和结束当天 凌晨时间戳
        $start_time = $start_time?$start_time:0;
        $end_time = $end_time?date('Ymd',strtotime($end_time)+(24*3600)):date('Ymd',time());

        //sql语句查询重定义 uri字段 模糊字段
        $sql = "SELECT SUM(times) total,CASE
 when uri LIKE '/api/list%' THEN 'list'
 when uri LIKE '/api/login%' THEN 'login'
 when uri LIKE '/api/event%' THEN 'event'
 when uri LIKE '/api/circle%' THEN 'circle'
 when uri LIKE '/api/thread%' THEN 'thread'
  when uri LIKE '/api/group%' THEN 'group'
 when uri LIKE '/api/project%' THEN 'project'
 when uri LIKE '/api/user%' THEN 'user'
ELSE 'else'
 END

 FROM  imhg_api_count WHERE `day` BETWEEN ".$start_time." AND ".$end_time."  GROUP BY uri";
        $connection = Yii::app()->db->createCommand($sql);
        $result = $connection->queryAll();
//var_dump($result);exit;
        $data = [];
        $k = 'CASE
 when uri LIKE \'/api/list%\' THEN \'list\'
 when uri LIKE \'/api/login%\' THEN \'login\'
 when uri LIKE \'/api/event%\' THEN \'event\'
 when uri LIKE \'/api/circle%\' THEN \'circle\'
 when uri LIKE \'/api/thread%\' THEN \'thread\'
  when uri LIKE \'/api/group%\' TH';

        //整理查询结果 为key模块名 value时间段内 总点击数量 数组
        foreach($result as $key =>$value){
            $data[$value[$k]] = 0;
        }
        foreach($result as $key =>$value){
            $data[$value[$k]] +=$value['total'];
        }

        //整理返回数据
        $return = [];
        //设置标题
        $return['text'] = "板块热度总览"; //标题
        $return['subtext'] = ""; //副标题
        $return['series_name'] = "板块";
        if(!$data){
            $data = [ 'list'=>0, 'login'=>0, 'event'=>0, 'circle'=>0, 'thread'=>0, 'fuli'=>0, 'group'=>0, 'project'=>0 ];
        }

        foreach ($data as $k=>$v){
            switch ($k){
                case 'list':
                    $return['legend'][] = '附近的人和推荐板块';
                    $return['series'][] = array('value' => $v, 'name' => '附近的人和推荐板块');
                    break;
//                case 'login':
//                    $return['legend'][] = '登录板块';
//                    $return['series'][] = array('value' => $v, 'name' => '登录板块');
//                    break;
                case 'event':
                    $return['legend'][] = '活动板块';
                    $return['series'][] = array('value' => $v, 'name' => '活动板块');
                    break;
                case 'circle':
                    $return['legend'][] = '海归圈板块';
                    $return['series'][] = array('value' => $v, 'name' => '海归圈板块');
                    break;
                case 'thread':
                    $return['legend'][] = '海谈板块';
                    $return['series'][] = array('value' => $v, 'name' => '海谈板块');
                    break;
                case 'fuli':
                    $return['legend'][] = '福利板块';
                    $return['series'][] = array('value' => $v, 'name' => '福利板块');
                    break;
                case 'group':
                    $return['legend'][] = '群组板块';
                    $return['series'][] = array('value' => $v, 'name' => '群组板块');
                    break;
                case 'project':
                    $return['legend'][] = '创业板块';
                    $return['series'][] = array('value' => $v, 'name' => '创业板块');
                    break;
//                case 'user':
//                    $return['legend'][] = '用户板块';
//                    $return['series'][] = array('value' => $v, 'name' => '用户板块');
//                    break;
            }
        }

        Yii::app()->utils->ajaxReturn($return);
    }


    /**
     * 处理获取时间段数据
     * @param $connection
     * @return mixed
     */
    private function dealTime($connection){
        if(!Yii::app()->session['is_admin']) exit; // 没有权限

        $start_time = Yii::app()->request->getParam('start_time', $this->start_time);
        $end_time = Yii::app()->request->getParam('end_time', $this->end_time);

        if($start_time){
            $start_time = strtotime($start_time);
            $connection->andWhere("ctime >= :start_time", [':start_time'=>$start_time]);
        }
        if($end_time){
            // 计算到当天24点
            $end_time = strtotime($end_time)+24*3600;
            $connection->andWhere("ctime <= :end_time", [':end_time'=>$end_time]);
        }
        return $connection;
    }


    /**
     * app定位热点图
     * */
    public function actionAjaxLocation(){
        if(!Yii::app()->session['is_admin']) exit; // 没有权限

        //by lzm 增加认证用户筛选条件
        $userType = Yii::app()->request->getParam('type',0);
        //by lzm 增加认证用户筛选条件

        // 查询出所有定位热点
        $connection = Yii::app()->db->createCommand();
        $connection->select('l.longitude,l.latitude')->from(Location::model()->tableName().' as l');
        $connection->leftJoin(User::model()->tableName().' as u', 'l.uid=u.uid');
        //by lzm 增加认证用户筛选条件
        if($userType){
            $connection->where(" u.status >=2 ");
        }
        //by lzm 增加认证用户筛选条件
        $locationData = $connection->queryAll();

        // 整理返回数据
        foreach($locationData as &$value){
            $value[0] = $value['longitude'];
            $value[1] = $value['latitude'];
            unset($value['longitude']);
            unset($value['latitude']);
        }

        Yii::app()->utils->ajaxReturn($locationData);
    }

    /**
     * app定位热力图
     * */
    public function actionAjaxLocationWarm(){
        if(!Yii::app()->session['is_admin']) exit; // 没有权限
        //获取开始结束时间  须转化为年月生日数字  对应数据库数据
        $start_time = Yii::app()->request->getParam('start_time', $this->start_time);
        $end_time = Yii::app()->request->getParam('end_time', $this->end_time);

        //转换为 开始时间戳  和结束当天 凌晨时间戳
        $start_time = $start_time?$start_time:0;
        $end_time = $end_time?date('Ymd',strtotime($end_time)+(24*3600)):date('Ymd',time());

        //by lzm 增加认证用户筛选条件
        $userType = Yii::app()->request->getParam('type',0);
        //by lzm 增加认证用户筛选条件

        // 查询出所有定位热点
        $connection = Yii::app()->db->createCommand();
        $connection->select('l.longitude,l.latitude')->from(Location::model()->tableName().' as l');
        $connection->leftJoin(User::model()->tableName().' as u', 'l.uid=u.uid');
        $connection->where('u.last_login > '.strtotime($start_time).' and u.last_login <'.strtotime($end_time));
        //by lzm 增加认证用户筛选条件
        if($userType){
            $connection->andWhere(" u.status >=2 ");
        }
        //by lzm 增加认证用户筛选条件
        $locationData = $connection->queryAll();
        // 整理数据
        $return = $this->dealCoordForWarm($locationData);
        if(!$return){
            $return = array();
        }
        Yii::app()->utils->ajaxReturn($return);
    }
    /**
     * 格式化坐标数据
     * @param $locationData
     * @return array|bool
     */
    protected function dealCoordForWarm($locationData){
        if(!$locationData) return false;
        // 整理数据
        $coordinate_area = array();
        foreach ($locationData as $key => $row)
        {
            // 将高德地图坐标转换为百度地图坐
            $row = $this->bd_encrypt($row['longitude'], $row['latitude']);

            // 写入数组
            $this_coordinate_area_key = substr($row['longitude'], 0, strpos($row['longitude'], '.')+3).','. substr($row['latitude'], 0, strpos($row['latitude'], '.')+3);
            $this_coordinate_area_value = ['coord'=> [$row['longitude'],$row['latitude']], 'elevation'=>1];
            $coordinate_area[$this_coordinate_area_key][] = $this_coordinate_area_value;
        }

        $return = array_values($coordinate_area);
        return $return;
    }
    /**
     * 高德地图坐标转换为百度地图坐标
     * @param $gg_lon
     * @param $gg_lat
     * @return mixed
     */
    protected function bd_encrypt($gg_lon,$gg_lat)
    {
        $x_pi = 3.14159265358979324 * 3000.0 / 180.0;
        $x = $gg_lon;
        $y = $gg_lat;
        $z = sqrt($x * $x + $y * $y) - 0.00002 * sin($y * $x_pi);
        $theta = atan2($y, $x) - 0.000003 * cos($x * $x_pi);
        $data['longitude'] = $z * cos($theta) + 0.0065;
        $data['latitude'] = $z * sin($theta) + 0.006;
        return $data;
    }


}