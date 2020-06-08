<!DOCTYPE html>
<html lang="zh-CN">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>微信统计2.0</title>
  <?php require './utils/common.php' ?>
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
      <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  <script src="https://cdn.bootcdn.net/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script type="text/javascript" src="/js/getwx.js"></script>
  <style>
    .wxNumTextContainer {
      color: red;
      margin: 6px;
      font-size: 28px;
    }
  </style>
</head>

<body>
  <!--
    在你的html中自定义一个元素，class为wxNumTextContainer。
    调用getwx.js后，将会在指定容器内显示并统计该微信号码
    -->
  <p class="wxNumTextContainer"></p>
</body>

</html>