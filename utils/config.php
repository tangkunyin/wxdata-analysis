<?php

function get_db_con(){

    // MySql 数据库链接配置信息
    $serverName = "127.0.0.1";
    $userName = "weixinsql";
    $passWord = "dFNjn3JCDd~FNqjnq6v3qJCD";
    $port = 3306;
    $dbName = "weixinsql";



    $conn = mysqli_connect($serverName,$userName,$passWord,$dbName,$port);
    if($conn->connect_errno){
        die("数据库连接失败：".$conn->connect_errno);
        return null;
    }
    return $conn;

}
?>
