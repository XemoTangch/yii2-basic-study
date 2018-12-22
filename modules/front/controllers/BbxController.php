<?php
/**
 * User:  jiangm
 * Email: jmphper@foxmail.com
 * Date:  2018/11/04
 * Time:  15:14
 * Desc:
 */

namespace app\modules\front\controllers;

use Yii;
use app\models\Bbx2018Apply;

class BbxController extends BaseController
{
    public function init()
    {
        $this->layout = false;
    }

    public function actionApply(){
        $param = Yii::$app->request->post('param');
        // 验证数据是否正确
        foreach($param as $key => $value){
            if($key === 'project') continue;
            if(!$value) die($key.'不能为空，请填写');
        }
        // todo 手机号和邮箱验证

        $model = new Bbx2018Apply();
        // 是否已提交过数据
        if($model->findOne(['mobile'=>$param['mobile']])) die('您已经提交过信息了，请您耐心等待');
        // 保存数据
        $param['ctime'] = time();
        $model->setAttributes($param);
        if($model->save()){
            die('success');
        }else{
            die('信息保存失败，请稍后再试');
        }
    }

    public function actionData(){
        $t = Yii::$app->request->get('t', 1);
        // 获取所有数据
        $data = Bbx2018Apply::find()->where('t='.$t)->orderBy('id DESC')->asArray()->all();
        foreach($data as &$row){
            // 处理字段
            $row['sex'] = $row['sex'] == 1?'男':'女';
            $row['t'] = $this->getTName((int)$row['t']);
            $row['ctime'] = date('Y-m-d H:i', $row['ctime']);
        }
        // 表头数据
        $_mmm = new Bbx2018Apply();
        $title_arr = $_mmm->attributeLabels();
        // 输出表格
        if (Yii::$app->request->get('output', '')) {
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
        $title_arr = array_values($title_arr);
        $nums = count($title_arr);

        for ($i = 0; $i < $nums - 1; ++$i) {
            //$csv_data .= '"' . $title_arr[$i] . '",';
            $csv_data .= $title_arr[$i] . ',';
        }
        if ($nums > 0) {
            $csv_data .= $title_arr[$nums - 1] . "\r\n";
        }

        foreach ($data as $k => $row) {
            $row = array_values($row);
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

    public function getTName($t){
        switch ($t){
            case 1:
                $name = '招商报名';
                break;
            case 2:
                $name = '成果展示报名';
                break;
            case 3:
                $name = '参会报名';
                break;
            default:
                $name = '未知报名渠道';
                break;
        }
        return $name;
    }

}