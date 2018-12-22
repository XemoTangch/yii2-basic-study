<?php
/**
 * User: jiangm
 * Date: 2017/3/17
 * Time: 15:33
 * Desc: 简历模型
 */
namespace app\modules\front\models;

use Yii;
use app\models\ResumeModel;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%resume}}".
 *
 * @property string $resumeid
 * @property integer $uid
 * @property string $openid
 * @property string $name
 * @property integer $sex
 * @property string $mobile
 * @property string $email
 * @property string $college
 * @property string $education
 * @property string $current_company
 * @property string $current_job
 * @property string $work_time
 * @property string $previous
 * @property string $other
 * @property integer $ctime
 * @property integer $file
 */
class Resume extends ResumeModel
{


    const STATUS_DELETED = 0;
    const STATUS_ACTIVE  = 1;

    public $file; //文件上传

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'sex', 'email', 'college', 'education'], 'required', 'message' => '请将表单填写完整'],
            [['email'], 'email', 'message' => '邮箱格式有误，请重新输入'], // 邮箱
            [['uid', 'sex', 'ctime'], 'integer'],
            [['previous', 'other'], 'string'],
            [['file'], 'file', 'extensions' => 'png, jpg'], // 图片上传
            [['openid', 'email', 'college', 'work_time', 'file'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 10],
            [['mobile', 'education'], 'string', 'max' => 20],
            [['current_company', 'current_job'], 'string', 'max' => 50],
        ];
    }


    /**
     * 图片上传
     * @param string $name
     * @return bool
     * */
    public function upload($name)
    {
        if($this->$name){

            $imageName = $this->$name->baseName . time() . '.' . $this->$name->extension;
            $this->$name->saveAs('upload/' . $name .'/'. $imageName);
            return $imageName;
        }else{
            return false;
        }
    }



}