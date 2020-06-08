<?php

require './utils/config.php';

session_start();
if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {
  // 用户已登录，查询列表数据
  $totalViewCountQuerySql = 'select sum(viewCount) as totalViewCount from wx_analysis_info';
  $queryAllSql = 'SELECT wd.*, IFNULL(wa.viewCount,0) AS viewCount FROM wx_data_info wd LEFT JOIN (SELECT wxId, SUM(viewCount) viewCount FROM wx_analysis_info GROUP BY wxId) wa ON wd.wxId = wa.wxId order by viewCount desc';

  $conn = get_db_con();
  $totalCountResult = mysqli_query($conn, $totalViewCountQuerySql);
  $wxDataResult = mysqli_query($conn, $queryAllSql);

  //总浏览数
  $tCount = mysqli_fetch_object($totalCountResult);
  //各个微信号统计总数
  $wxDataList = array();
  while ($row = mysqli_fetch_object($wxDataResult)) {
    array_push($wxDataList, $row);
  }
} else {
  unset($_SESSION['admin']);
  echo "<script>window.location.href =\"/login.php\";</script>";
}
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>微信访问数据配置中心</title>
  <?php require './utils/common.php' ?>
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
      <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  <link href="/css/manage.css" rel="stylesheet">
  <script type="text/javascript" src="/js/manageWX.js"></script>
</head>

<body>
  <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="">微信统计中心 ( ＾∀＾）／欢迎＼( ＾∀＾）老板</a>
      </div>
      <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav navbar-right">
          <li><a href="javasript:" id="addWXBtn" style="color:lightgreen;font-weight:bolder">添加微信</a></li>
          <li><a href="javasript:" id="addOptBtn">添加分组</a></li>
          <li><a href="javascript" id="loginOutBtn">退出登陆</a></li>
        </ul>
        <form class="navbar-form navbar-right" action="" method="post">
          <input type="text" class="form-control" placeholder="按微信号查询" required="required">
        </form>
      </div>
    </div>
  </nav>

  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-3 col-md-2 sidebar">
        <ul class="nav nav-sidebar">
          <!--  TODO. 增加用户组  -->
          <li class="active"><a href="#">你自己<span class="sr-only">(current)</span></a></li>
          <li><a href="#">王尼玛</a></li>
          <li><a href="#">李尼玛</a></li>
          <li><a href="#">张尼玛</a></li>
        </ul>
      </div>
      <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <h1 class="page-header">流量占比</h1>
        <div class="row placeholders">
          <div class="col-xs-6 col-sm-3 placeholder">
            <div class="progress">
              <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $tCount->totalViewCount; ?>" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                <?php echo $tCount->totalViewCount; ?>
              </div>
            </div>
            <span class="text-muted">所有微信总访问量</span>
          </div>
          <?php
          if (count($wxDataList) == 1) {
            $percent = ($tCount->totalViewCount == 0) ? 0 : number_format($wxDataList[0]->viewCount / $tCount->totalViewCount, 2, '.', '');
            $num1 = array('percent' => $percent * 100, 'wxNum' => $wxDataList[0]->wxNum);
          ?>
            <div class="col-xs-6 col-sm-3 placeholder">
              <div class="progress">
                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="<?php echo $num1['percent']; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $num1['percent']; ?>%;">
                  <?php echo $num1['percent']; ?>%
                </div>
              </div>
              <span class="text-muted">冠军号: <?php echo $num1['wxNum']; ?></span>
            </div>
          <?php
          } elseif (count($wxDataList) == 2) {
            $percent1 = ($tCount->totalViewCount == 0) ? 0 : number_format($wxDataList[0]->viewCount / $tCount->totalViewCount, 2, '.', '');
            $percent2 = ($tCount->totalViewCount == 0) ? 0 : number_format($wxDataList[1]->viewCount / $tCount->totalViewCount, 2, '.', '');
            $num1 = array('percent' => $percent1 * 100, 'wxNum' => $wxDataList[0]->wxNum);
            $num2 = array('percent' => $percent2 * 100, 'wxNum' => $wxDataList[1]->wxNum);
          ?>
            <div class="col-xs-6 col-sm-3 placeholder">
              <div class="progress">
                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="<?php echo $num1['percent']; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $num1['percent']; ?>%;">
                  <?php echo $num1['percent']; ?>%
                </div>
              </div>
              <span class="text-muted">冠军号: <?php echo $num1['wxNum']; ?></span>
            </div>
            <div class="col-xs-6 col-sm-3 placeholder">
              <div class="progress">
                <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="<?php echo $num2['percent']; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $num2['percent']; ?>%;">
                  <?php echo $num2['percent']; ?>%
                </div>
              </div>
              <span class="text-muted">亚军号: <?php echo $num2['wxNum']; ?></span>
            </div>
          <?php
          } elseif (count($wxDataList) >= 3) {
            $percent1 = ($tCount->totalViewCount == 0) ? 0 : number_format($wxDataList[0]->viewCount / $tCount->totalViewCount, 2, '.', '');
            $percent2 = ($tCount->totalViewCount == 0) ? 0 : number_format($wxDataList[1]->viewCount / $tCount->totalViewCount, 2, '.', '');
            $percent3 = ($tCount->totalViewCount == 0) ? 0 : number_format($wxDataList[2]->viewCount / $tCount->totalViewCount, 2, '.', '');
            $num1 = array('percent' => $percent1 * 100, 'wxNum' => $wxDataList[0]->wxNum);
            $num2 = array('percent' => $percent2 * 100, 'wxNum' => $wxDataList[1]->wxNum);
            $num3 = array('percent' => $percent3 * 100, 'wxNum' => $wxDataList[2]->wxNum);
          ?>
            <div class="col-xs-6 col-sm-3 placeholder">
              <div class="progress">
                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="<?php echo $num1['percent']; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $num1['percent']; ?>%;">
                  <?php echo $num1['percent']; ?>%
                </div>
              </div>
              <span class="text-muted">冠军号: <?php echo $num1['wxNum']; ?></span>
            </div>
            <div class="col-xs-6 col-sm-3 placeholder">
              <div class="progress">
                <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="<?php echo $num2['percent']; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $num2['percent']; ?>%;">
                  <?php echo $num2['percent']; ?>%
                </div>
              </div>
              <span class="text-muted">亚军号: <?php echo $num2['wxNum']; ?></span>
            </div>
            <div class="col-xs-6 col-sm-3 placeholder">
              <div class="progress">
                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="<?php echo $num3['percent']; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $num3['percent']; ?>%;">
                  <?php echo $num3['percent']; ?>%
                </div>
              </div>
              <span class="text-muted">季军号: <?php echo $num3['wxNum']; ?></span>
            </div>
          <?php } ?>
        </div>
        <h2 class="sub-header">数据列表</h2>
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>编号</th>
                <th>微信号</th>
                <th>二维码地址</th>
                <th>总浏览数</th>
                <th>状态</th>
                <th>操作</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($wxDataList as $row) { ?>
                <tr>
                  <td><?php echo $row->wxId; ?></td>
                  <td><?php echo $row->wxNum; ?></td>
                  <td><?php echo $row->wxQRCodeUrl; ?></td>
                  <td><?php echo $row->viewCount; ?></td>
                  <td style="color:<?php echo $row->state == 0 ? 'green' : 'red'; ?>"><?php echo $row->state == 0 ? '已启用' : '已禁用'; ?></td>
                  <td>
                    <div class="btn-group btn-group-xs" role="group">
                      <button type="button" class="btn btn-warning" onclick="stateChange(<?php echo $row->wxId; ?>,<?php echo $row->state; ?>);">暂停</button>
                      <button type="button" class="btn btn-danger" onclick="deleteWX(<?php echo $row->wxId; ?>);">删除</button>
                    </div>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</body>

</html>