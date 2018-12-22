<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%bbx2018_apply}}".
 *
 * @property int $id
 * @property string $name
 * @property string $organization
 * @property int $sex
 * @property string $mobile
 * @property string $telephone
 * @property string $email
 * @property string $education
 * @property string $country
 * @property string $university
 * @property string $major
 * @property string $study_field
 * @property string $project
 * @property string $t
 * @property int $ctime
 */
class Bbx2018Apply extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%bbx2018_apply}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sex', 'ctime'], 'integer'],
            [['name', 'organization', 'education', 'country', 'university', 'major', 'study_field', 'project', 't'], 'string', 'max' => 100],
            [['mobile', 'telephone'], 'string', 'max' => 20],
            [['email'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'organization' => 'Organization',
            'sex' => 'Sex',
            'mobile' => 'Mobile',
            'telephone' => 'Telephone',
            'email' => 'Email',
            'education' => 'Education',
            'country' => 'Country',
            'university' => 'University',
            'major' => 'Major',
            'study_field' => 'Study Field',
            'project' => 'Project',
            't' => 'T',
            'ctime' => 'Ctime',
        ];
    }
}
