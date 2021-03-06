<?php
/**
 * User:  jiangm
 * Email: jmphper@foxmail.com
 * Date:  2018/12/19
 * Time:  21:31
 * Desc:  物流信息爬取
 */

namespace app\controllers;

use Yii;
use yii\web\Controller;
use QL\QueryList;

class TrackGetController extends Controller
{
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
    }


    public function actionTest(){
        return $this->render('test');
    }

    public function actionTest2(){
        $ql = new QueryList();
        $ql->post('https://t.17track.net/restapi/track',[
            'guid' => '',
            'data' => [
                [ 'num' => 'LZ869364109CN' ],
                [ 'num' => 'LZ869364245CN' ],
                [ 'num' => 'LZ869364510CN' ],
                [ 'num' => 'LZ869364951CN' ],
                [ 'num' => 'LZ869365206CN' ],
            ],
        ],[
            'headers' => [
                ':authority' => 't.17track.net',
                ':method' => 'POST',
                ':path' => '/restapi/track',
                ':scheme' => 'https',
                'accept' => 'application/json, text/javascript, */*; q=0.01',
                'accept-encoding' => 'gzip, deflate, br',
                'accept-language' => 'zh-CN,zh;q=0.9',
                'accept-control' => 'no-cache',
                'origin' => 'https://t.17track.net',
                'pragma' => 'no-cache',
                'referer' => 'https://t.17track.net/zh-cn',
                'content-type' => 'application/x-www-form-urlencoded; charset=UTF-8',
                'Accept' => 'application/json',
                'Cookie' => 'v5_TranslateLang=zh-CHS; _yq_bid=G-2F0B6606A734D68B; _ga=GA1.2.1428749566.1545143334; _gid=GA1.2.1498633866.1545450039; Last-Event-ID=657572742f3462332f64396331373034643736312f657461636e7572742d74786574206c69616d652d726573752d7179d111cb4c0750dd7a7d5'
            ]
        ]);
        echo $ql->getHtml();
    }

    public function actionTest1() {
        $url = 'https://t.17track.net/restapi/track';
        $cookie = 'v5_TranslateLang=zh-CHS; _yq_bid=G-2F0B6606A734D68B; _ga=GA1.2.1428749566.1545143334; _gid=GA1.2.1236896295.1545143334; Last-Event-ID=657572742f3462332f31656132323037633736312f6461672d6c656e61702d717918211c02f3be035de9e2';
//        // {"guid":"","data":[{"num":"LZ869364109CN"},{"num":"LZ869364245CN"},{"num":"LZ869364510CN"},{"num":"LZ869364951CN"},{"num":"LZ869365206CN"},{"num":"LZ869365285CN"}
        $param = [
            'guid' => '',
            'data' => [
                [ 'num' => 'LZ869364109CN' ],
                [ 'num' => 'LZ869364245CN' ],
                [ 'num' => 'LZ869364510CN' ],
                [ 'num' => 'LZ869364951CN' ],
                [ 'num' => 'LZ869365206CN' ],
            ],
        ];
        $data = $this->curl_request($url, $param, $cookie, 0, false);
//        $data = $this->http_post_data($url, json_encode($param));
//        $data = htmlentities($data);
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }

    //参数1：访问的URL，参数2：post数据(不填则为GET)，参数3：提交的$cookies,参数4：是否返回$cookies
    /**
     * @param $url
     * @param string $post
     * @param string $cookie
     * @param int $returnCookie
     * @param bool $json
     * @return mixed|string
     */
    public function curl_request($url,$post='',$cookie='', $returnCookie=0, $json = false){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/6.0)');
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        curl_setopt($curl, CURLOPT_REFERER, "https://t.17track.net/zh-cn");
        if($post) {
            curl_setopt($curl, CURLOPT_POST, 1);
            if($json){
                $post = json_encode($post);
                curl_setopt($curl, CURLOPT_HTTPHEADER,[
                    'Content-Type: application/json; charset=utf-8',
                    'Content-Length:' . strlen($post)
                ]);
            }else{
                $post = http_build_query($post);
            }
            curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        }
        if($cookie) {
            curl_setopt($curl, CURLOPT_COOKIE, $cookie);
        }
        curl_setopt($curl, CURLOPT_HEADER, $returnCookie);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);
        if (curl_errno($curl)) {
            return curl_error($curl);
        }
        curl_close($curl);
        if($returnCookie){
            list($header, $body) = explode("\r\n\r\n", $data, 2);
            preg_match_all("/Set\-Cookie:([^;]*);/", $header, $matches);
            $info['cookie']  = substr($matches[1][0], 1);
            $info['content'] = $body;
            return $info;
        }else{
            return $data;
        }
    }


    function http_post_data($url, $data_string) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Content-Type: application/json; charset=utf-8",
                "Content-Length: " . strlen($data_string))
        );
        ob_start();
        curl_exec($ch);
        $return_content = ob_get_contents();
        ob_end_clean();
        $return_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//        return array($return_code, $return_content);
        return $return_content;
    }
}