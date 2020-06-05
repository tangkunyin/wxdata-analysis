<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IndexNum</title>
    <?php require './utils/common.php' ?>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript" src="/js/getwx.js"></script>
  </head>
  <body>
    <!--
    在你的html中自定义一个元素，class为wxNumTextContainer。
    调用getwx.js后，将会在指定容器内显示并统计该微信号码
    -->
    <h1 class="color:red" class="wxNumTextContainer"></h1>
  </body>
</html>
