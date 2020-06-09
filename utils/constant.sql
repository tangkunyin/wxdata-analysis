# 查微信列表数据
SELECT wd.*, IFNULL(wa.viewCount,0) AS viewCount FROM wx_data_info wd LEFT JOIN (SELECT wxId, SUM(viewCount) viewCount FROM wx_analysis_info GROUP BY wxId) wa ON wd.wxId = wa.wxId where wd.groupId = 2 order by viewCount desc

# 查流量占比
## 总流量
select ifnull(sum(viewCount),0) as totalViewCount from wx_analysis_info where wxId in (select wxId from wx_data_info where groupId = 1);

# 随机返回信息
SELECT wxId,wxNum FROM wx_data_info where state = 0 and wxId in (SELECT wxId FROM wx_analysis_info where clientIp='127.0.0.1' and refUrl='https://www.baidu.com') limit 0,1

## 根据ip返回
SELECT wd.wxId,wd.wxNum,wd.state,wa.viewCount AS viewCount FROM wx_data_info wd LEFT JOIN (SELECT wxId,viewCount FROM wx_analysis_info where clientIp='127.0.0.1') wa ON wd.wxId = wa.wxId and wd.state = 0 order by viewCount desc limit 0,1

## 根据refUrl返回
SELECT wd.wxId,wd.wxNum,wd.state,wa.viewCount AS viewCount FROM wx_data_info wd LEFT JOIN (SELECT wxId,viewCount FROM wx_analysis_info where refUrl='https://www.baidu.com') wa ON wd.wxId = wa.wxId and wd.state = 0 order by viewCount desc limit 0,1

## ip和refUrl都没有，随机返回
SELECT wxId,wxNum FROM wx_data_info where state = 0