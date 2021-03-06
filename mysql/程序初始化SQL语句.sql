# create database weixin;
# use weixin;

create table wx_user (
    uid int auto_increment,
    uname varchar(100) unique not null comment 'login user name',
    passd varchar(100) not null default '123456' comment 'login user password.Default password is 123456',
    role int default 0 comment 'user role: 0=master,1=admin,2=guester,4=forbidden',
    phone varchar(20) comment 'user contact phone',
    remark varchar(200) default 'master user' comment'remark infomations',
    primary key(uid,uname)
);
create table wx_group (
    id int auto_increment,
    uid int not null comment 'login user name',
    name varchar(200) unique not null comment 'wx group name',
    status int default 0 comment 'group status: 0=normal,1=forbidden|deleted',
    primary key(id)
);
create table wx_data_info (
    wxId int auto_increment,
    groupId int not null,
    wxNum varchar(60) unique comment 'weixin number',
    wxQRCodeUrl varchar(200) comment 'weixin qrcode image url',
    state int default 0 comment '0:enable,1:disable',
    primary key(wxId,wxNum)
);
create table wx_analysis_info (
    analyzeId int auto_increment,
    wxId int comment 'the wxId',
    clientIp varchar(60) not null default '0.0.0.0' comment 'the remote client ip address',
    viewCount int default 1 comment 'weixin view count number',
    lastViewDate varchar(30) comment 'the last viewed time',
    refUrl varchar(200) comment 'visite url',
    primary key(analyzeId,wxId,clientIp)
);

# 注意帐号密码从这里改，没有加密！
insert into wx_user (uname,passd,phone,remark) values ('admin','123456',13012345678, 'just a test data');
insert into wx_group (uid,name) values (1, '你自己');

insert into wx_data_info (groupId,wxNum,wxQRCodeUrl) values (1,'test1','http://www.demo.com/weixin-qrcode.jpg');
insert into wx_data_info (groupId,wxNum,wxQRCodeUrl) values (1,'test2','http://www.demo.com/weixin-qrcode.jpg');
insert into wx_data_info (groupId,wxNum,wxQRCodeUrl) values (1,'test3','http://www.demo.com/weixin-qrcode.jpg');
insert into wx_data_info (groupId,wxNum,wxQRCodeUrl) values (1,'test4','http://www.demo.com/weixin-qrcode.jpg');
insert into wx_data_info (groupId,wxNum,wxQRCodeUrl) values (1,'test5','http://www.demo.com/weixin-qrcode.jpg');

insert into wx_analysis_info (wxId) values (1);
