## 操作手册

项目地址：https://gitee.com/tangkunyin/wxdata-analysis.git

可以安装Git工具更新，https://git-scm.com/downloads

### 安装

1. 使用前先确认MySQL正常使用，手动执行/mysql/sqls.sql文件中的语句。
2. 数据库完成安装后，直接将代码放到网站根目录下
3. 更改数据库密码，/utils/config.php中，14行开始，换上自己的数据库信息。

### 首页

访问`index.php`可以**演示**数据库中第一组第一个可用微信号的浏览量。

### 登录

系统默认用户名密码是：admin,123456

这个可以在初始化的SQL中改，/mysql/sqls.sql文件第41行。目前不支持用户注册修改之类的操作！

或者直接复制以下语句修改，切莫动其他语句！！！

```sql
insert into wx_user (uname,passd,phone,remark) values ('登录名','密码',13012345678, 'just a test data');
```

### 库使用

1. 页面引用两个库：

```
<script src="https://cdn.bootcdn.net/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script type="text/javascript" src="(代码运行的域名)/js/getwx.js"></script>
```

2. 你的html中自定义一个元素，id为wxNumTextContainer。调用getwx.js后，将会在指定容器内显示并统计该微信号码
