<?php
/**
 * User: jiangm
 * Date: 2017/3/15
 * Time: 11:22
 * Desc: 手机验证码模型
 */
namespace app\modules\front\models;

use Yii;
use app\models\CaptchaModel;


/**
 * This is the model class for table "{{%captcha}}".
 *
 * @property string $id
 * @property string $ip
 * @property string $mobile
 * @property string $captcha
 * @property integer $ctime
 */
class Captcha extends CaptchaModel
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ctime'], 'integer'],
            [['ip'], 'string', 'max' => 15],
            [['mobile'], 'string', 'max' => 18],
            [['captcha'], 'string', 'max' => 4],
        ];
    }

}