<?php

require 'config.php';

$userName = $_POST["uname"];
$passWord = $_POST["passd"];

$loginResult =  checkUser($userName, $passWord);

echo json_encode($loginResult);

function checkUser($userName, $passWord)
{

    if (empty($userName) || empty($passWord)) {
        return json_encode(array('code' => -1, 'msg' => '用户名或密码不能为空'));
    }

    $conn = get_db_con();
    $userQuery = mysqli_query($conn, "select * from wx_user where uname='" . $userName . "' and passd='" . $passWord . "'");
    $user = mysqli_fetch_object($userQuery);

    mysqli_close($conn);

    if (empty($user)) {
        return json_encode(array('code' => -1, 'msg' => '用户名或密码错误'));
    } elseif ($user->role == 4) {
        return json_encode(array('code' => 4, 'msg' => '用户禁止登陆'));
    } else {
        session_start();
        $_SESSION['admin'] = true;
        $_SESSION['adminId'] = $user->uid;
        return json_encode(array('code' => 0, 'msg' => '登陆成功'));
    }
}
