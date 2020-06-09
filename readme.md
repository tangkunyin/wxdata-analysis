## 操作手册

项目地址：https://gitee.com/tangkunyin/wxdata-analysis.git

可以安装Git工具更新，https://git-scm.com/downloads

### 安装

1. 使用前先确认MySQL正常使用，用记事本或notepad++等文本工具打开：/mysql/sqls.sql文件，复制所有文字到phpmyadmin中粘贴执行。参考「数据库导入教程」图片所示。
2. 数据库完成安装后，直接将代码放到网站根目录下
3. 更改数据库密码，/utils/config.php中，14行开始，换上自己的数据库信息。

### 首页

访问`index.php`可以**演示**数据库中第一组第一个可用微信号的浏览量。

### 登录

系统默认用户名密码是：admin,123456

这个可以在初始化的SQL中改，/mysql/sqls.sql文件第38行。目前不支持用户注册修改之类的操作！

或者直接复制以下语句修改，切莫动其他语句！！！

```sql
insert into wx_user (uname,passd,phone,remark) values ('登录名','密码',13012345678, 'just a test data');
```

### 库使用

1. 页面引用两个库：

```
<script src="https://cdn.bootcdn.net/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script type="text/javascript" src="/getwx.js" id="getwxJS" wid="5" gid="2"></script>
```

- wid即系统内的微信号，如果指定则统计指定的微信号。若不指定则取第一组第一个有效的微信号
- gid即系统内的分组号，如果仅指定分组号，则统计改组第一个有效的微信号。

**wid和gid都有则只取wid，两个都没有取第一组第一个有效微信号**


2. 你的html中自定义一个元素，id为wxNumTextContainer。调用getwx.js后，将会在指定容器内显示并统计该微信号码
