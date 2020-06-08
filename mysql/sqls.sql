# create database weixin

create database weixin;

use weixin;

# create data tables

## user table
create table wx_user (
    uid int auto_increment,
    uname varchar(100) unique not null comment 'login user name',
    passd varchar(100) not null default '123456' comment 'login user password.Default password is 123456',
    role int default 0 comment 'user role: 0=master,1=admin,2=guester,4=forbidden',
    phone varchar(20) comment 'user contact phone',
    remark varchar(200) default 'master user' comment'remark infomations',
    primary key(uid,uname)
);

## group table
create table wx_group (
    id int auto_increment,
    uid int not null comment 'login user name',
    name varchar(300) unique not null comment 'wx group name',
    status int default 0 comment 'group status: 0=normal,1=forbidden|deleted',
    primary key(id)
);

insert into wx_user (uname,phone,remark) values ('admin',13012345678, 'just a test data');
insert into wx_group (uid,name) values (1, '你自己');


## weixin visite infomations table
create table wx_data_info (
    wxId int auto_increment,
    groupId int not null,
    wxNum varchar(60) unique comment 'weixin number',
    wxQRCodeUrl varchar(200) comment 'weixin qrcode image url',
    state int default 0 comment '0:enable,1:disable',
    primary key(wxId,wxNum)
);

insert into wx_data_info (groupId,wxNum,wxQRCodeUrl) values (1,'test1','http://www.faxingw.cn/upload/image/20160314/1457948139747182.jpg');
insert into wx_data_info (groupId,wxNum,wxQRCodeUrl) values (1,'test2','http://www.faxingw.cn/upload/image/20160314/1457948139747182.jpg');
insert into wx_data_info (groupId,wxNum,wxQRCodeUrl) values (1,'test3','http://www.faxingw.cn/upload/image/20160314/1457948139747182.jpg');
insert into wx_data_info (groupId,wxNum,wxQRCodeUrl) values (1,'test4','http://www.faxingw.cn/upload/image/20160314/1457948139747182.jpg');
insert into wx_data_info (groupId,wxNum,wxQRCodeUrl) values (1,'test5','http://www.faxingw.cn/upload/image/20160314/1457948139747182.jpg');

## weixin analysis infomations table
create table wx_analysis_info (
    analyzeId int auto_increment,
    wxId int comment 'the wxId in wx_data_info table',
    clientIp varchar(60) not null default '0.0.0.0' comment 'the remote client ip address',
    viewCount int default 1 comment 'weixin view count number',
    lastViewDate varchar(30) comment 'the last viewed time',
    refUrl varchar(200) comment 'the referer of visite url',
    primary key(analyzeId,wxId,clientIp)
);

insert into wx_analysis_info (wxId) values (1);

# ==========

# 查微信列表数据
SELECT wd.*, IFNULL(wa.viewCount,0) AS viewCount FROM wx_data_info wd LEFT JOIN (SELECT wxId, SUM(viewCount) viewCount FROM wx_analysis_info GROUP BY wxId) wa ON wd.wxId = wa.wxId order by viewCount desc

# 查流量占比
## 总流量
select sum(viewCount) as totalViewCount from wx_analysis_info;

#  随机返回信息

SELECT wxId,wxNum FROM wx_data_info where state = 0 and wxId in (SELECT wxId FROM wx_analysis_info where clientIp='127.0.0.1' and refUrl='https://www.baidu.com') limit 0,1

## 根据ip返回
SELECT wd.wxId,wd.wxNum,wd.state,wa.viewCount AS viewCount FROM wx_data_info wd LEFT JOIN (SELECT wxId,viewCount FROM wx_analysis_info where clientIp='127.0.0.1') wa ON wd.wxId = wa.wxId and wd.state = 0 order by viewCount desc limit 0,1

## 根据refUrl返回
SELECT wd.wxId,wd.wxNum,wd.state,wa.viewCount AS viewCount FROM wx_data_info wd LEFT JOIN (SELECT wxId,viewCount FROM wx_analysis_info where refUrl='https://www.baidu.com') wa ON wd.wxId = wa.wxId and wd.state = 0 order by viewCount desc limit 0,1

## ip和refUrl都没有，随机返回
SELECT wxId,wxNum FROM wx_data_info where state = 0
