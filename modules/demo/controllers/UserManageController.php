<?php
/**
 * Author: jiangm
 * Email: jmphper@foxmail.com
 * Date: 2018/2/27
 * Time: 11:23
 * Desc: 用户管理控制器
 */

namespace app\modules\demo\controllers;

use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

class UserManageController extends Controller
{

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::className(), // 访问控制更多内容在文档“授权”章节
                'only' => ['create', 'update'],
                'rules' => [
                    // 允许认证用户
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    // 默认禁止其他用户
                ],
            ],
        ]);
    }

    public function actionIndex(){
        return $this->render('index');
    }

    public function actionCreate(){
        return $this->render('create');
    }

    public function actionUpdate(){
        return $this->render('update');
    }

    public function actionDetail(){
        return $this->render('detail');
    }
}