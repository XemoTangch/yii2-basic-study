<?php
/**
 * Author: jiangm
 * Email: jmphper@foxmail.com
 * Date: 2017/10/23
 * Time: 15:30
 * Desc: 依赖注入
 */

// 数据库类
class Database
{
    protected $adapter;

    // 高耦合，不能更换适配器
    /*public function __construct()
    {
        $this->adapter = new MySqlAdapter;
    }*/

    public function __construct(MysqlAdapter $adapter)
    {
        $this->adapter = $adapter; // 适配器类作为参数，解耦
    }
}
// 数据库适配器
class MysqlAdapter {}