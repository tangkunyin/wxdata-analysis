<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>登陆先</title>
    <?php require './utils/common.php' ?>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript" src="/js/login.js"></script>
    <link href="/css/login.css" rel="stylesheet">
  </head>
  <body>
    <div class="container">
      <form class="form-signin" id="loginForm" action="" method="POST">
        <h2 class="form-signin-heading">请先登录</h2>
        <label for="inputEmail" class="sr-only">账号</label>
        <input id="inputEmail" class="form-control" name="uname" placeholder="账号" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" name="passd" class="form-control" placeholder="密码" required>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me">记住我
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">登录</button>
      </form>
    </div>
  </body>
</html>
