<?php
/**
 * User: jiangm
 * Date: 2017/3/21
 * Time: 13:53
 * Desc: 岗位 模型
 */
namespace app\modules\front\models;

use Yii;
use app\models\SendResumeModel;
use app\models\JobModel;

class Job extends JobModel
{
    /**
     * 是否投递了该职位
     * @param $resumeid
     * @return bool
     */
    public function isSendResume($resumeid){
        if(!$resumeid) return false;
        return $this->hasOne(SendResumeModel::className(), ['jobid' => 'jobid'])
            ->where('resumeid = :resumeid', [':resumeid' => $resumeid])
            ->exists();
    }
}