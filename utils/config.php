<?php
error_reporting(0);

function get_db_con()
{

    $isDev = true;

    // MySql 数据库链接配置信息
    $serverName = "127.0.0.1";
    $port = 3306;

    // ==== 安装程序从这里改 ===
    $userName = ""; // 用户名
    $passWord = ""; // 密码
    $dbName = "";   // 数据库名

    if ($isDev) {
        // 这里头是开发环境的
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
