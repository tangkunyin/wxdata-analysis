<?php

require 'config.php';

session_start();
if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {
    $type = $_POST['type'];
    $id = $_POST['id'];
    if($type == 0 && !empty($_POST['url'])){
      addWeixinData($id,$_POST['url']);
    }elseif ($type == 1) {
      changeWeixinState($id,$_POST['state']);
    }elseif ($type == 2) {
      deleteWeixin($id);
    }else {
      echo json_encode(array('code'=>-1,'msg'=>'操作失败，可能参数丢失'));
    }
} else {
    echo json_encode(array('code'=>403,'msg'=>'you need login'));
}

function addWeixinData($id,$url){
  $conn = get_db_con();
  $addQuery = mysqli_query($conn,"insert into wx_data_info (wxNum,wxQRCodeUrl) values ('".$id."','".$url."')");
  $addResult = mysqli_query($conn,$addQuery);

  if(empty($addResult)){
    echo json_encode(array('code'=>0,'msg'=>'添加成功'));
  }else{
    echo json_encode(array('code'=>-1,'msg'=>'添加失败'));
  }

}

function changeWeixinState($id,$state){
  $conn = get_db_con();
  $updateQuery = mysqli_query($conn,"update wx_data_info set state=".$state." where wxId=".$id);
  $updateResult = mysqli_query($conn,$updateQuery);

  if(empty($updateResult)){
    echo json_encode(array('code'=>0,'msg'=>'操作成功'));
  }else{
    echo json_encode(array('code'=>-1,'msg'=>'操作失败'));
  }
}

function deleteWeixin($id){
  $conn = get_db_con();
  $delQuery = mysqli_query($conn,"delete from wx_data_info where wxId=".$id);
  $delResult = mysqli_query($conn,$delQuery);

  if(empty($delResult)){
    echo json_encode(array('code'=>0,'msg'=>'删除成功'));
  }else{
    echo json_encode(array('code'=>-1,'msg'=>'删除失败'));
  }
}


?>
