<?php
/**
 * Author: jiangm
 * Email: jmphper@foxmail.com
 * Date: 2018/5/28
 * Time: 10:31
 * Desc: 算法组件
 */

namespace app\components;

use yii\base\Component;

class AlgorithmComponent extends Component
{
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
    }

    /**
     * 欧几里得算法
     * 计算两个非负整数p和q的最大公约数
     * @param $p
     * @param $q
     */
    static public function gcd($p, $q){
        if ($q == 0) return $p;
        $r = $p % $q;
        return static::gcd($q, $r);
    }

    /**
     * binary search 对分查找，二分查找
     * @param $key int 必须存在$a数组中
     * @param $array array 必须是有序的整数数组
     * @return int
     */
    static public function binarySearch($key, $array){
        sort($array);
        $lo = 0;
        $hi = count($array) - 1;
        while ($lo <= $hi) {
            $mid = $lo + ($hi - $lo)/2;
            if ($key < $array[$mid]) {
                $hi = $mid - 1;
            } else if ($key > $array[$mid]) {
                $lo = $mid + 1;
            } else {
                return $mid;
            }
        }
        return -1;
    }


    //----------------作业-------------------
    static public function exR1($n){
        if($n <= 0) return 0;
        return static::exR1($n-3) + $n + static::exR1($n-2) + $n;
    }
    static public function mystery($a, $b){
        if($b == 0) return 0;
        if($b % 2 == 0) return static::mystery($a+$a, (int)($b/2));
        return static::mystery($a+$a, (int)($b/2)) + $a;
    }
    static public function mystery1($a, $b){
        if($b == 0) return 1;
        if($b % 2 == 0) return static::mystery($a*$a, (int)($b/2));
        return static::mystery($a*$a, (int)($b/2)) + $a;
    }
}