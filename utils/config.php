<?php

function get_db_con()
{

    $isDev = true;

    // MySql 数据库链接配置信息
    $serverName = "127.0.0.1";
    $port = 3306;

    // 以下分别是数据库用户名、密码、数据库名
    $userName = "";
    $passWord = "";
    $dbName = "";

    if ($isDev) {
        $userName = "root";
        $passWord = "root";
        $dbName = "weixin";
    }

    $conn = mysqli_connect($serverName, $userName, $passWord, $dbName, $port);
    if ($conn->connect_errno) {
        die("数据库连接失败：" . $conn->connect_errno);
        return null;
    }
    return $conn;
}
