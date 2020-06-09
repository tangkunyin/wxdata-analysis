<?php

require 'config.php';

/*
 * 随机返回微信信息，同一Ip再次请求该信息不变
 */
function randomGet($gid)
{
    $refUrl = getReferUrl();
    $clientIp = get_client_ip();
    $conn = get_db_con();

    // 组条件
    $group = empty($gid) ? "" : " and groupId = " . $gid;

    //根据IP和refur联合查询
    $unioQuerySql = "SELECT wxId,wxNum FROM wx_data_info where state = 0 " . $group . " and wxId in (SELECT wxId FROM wx_analysis_info where clientIp='" . $clientIp . "' and refUrl='" . $refUrl . "') limit 0,1";
    
    $unioQuery = mysqli_query($conn, $unioQuerySql);
    $unioResult = mysqli_fetch_object($unioQuery);
    if (empty($unioResult)) {
        //根据ip返回
        $ipQuerySql = "SELECT wd.wxId,wd.wxNum,wd.state,wa.viewCount AS viewCount FROM wx_data_info wd INNER JOIN (SELECT wxId,viewCount FROM wx_analysis_info where clientIp='" . $clientIp . "') wa ON wd.wxId = wa.wxId and wd.state = 0 " . empty($gid) ? "" : " and wd.groupId = " . $gid . " order by viewCount desc limit 0,1";
        $ipQuery = mysqli_query($conn, $ipQuerySql);
        $ipQueryResult = mysqli_fetch_object($ipQuery);
        if (empty($ipQueryResult)) {
            //共查和ip都没有，随机返回
            $normalQuerySql = "SELECT wxId,wxNum FROM wx_data_info where state = 0 " . $group;
            $normalQuery = mysqli_query($conn, $normalQuerySql);
            $normalArr = array();
            while ($row = mysqli_fetch_object($normalQuery)) {
                array_push($normalArr, $row);
            }
            if (count($normalArr) > 0) {
                //随机返回一个
                $random_keys = array_rand($normalArr, 1);
                $wxInfo = $normalArr[$random_keys];
                return array('code' => 0, 'msg' => 'ok', 'data' => array('wxId' => $wxInfo->wxId, 'wxNum' => $wxInfo->wxNum));
            }
            return array('code' => 404, 'msg' => '当前组无有效数据', 'data' => null);
        }
        return array('code' => 0, 'msg' => 'ok', 'data' => array('wxId' => $ipQueryResult->wxId, 'wxNum' => $ipQueryResult->wxNum));
    }
    return array('code' => 0, 'msg' => 'ok', 'data' => array('wxId' => $unioResult->wxId, 'wxNum' => $unioResult->wxNum));
}


function getWeiXinInfo($wid, $clientIp, $referUrl)
{
    $conn = get_db_con();
    $wxInfo = queryWeixinInfo($wid);
    if (empty($wxInfo)) {
        return array('code' => 404, 'msg' => 'Can not find weixin info by wid ' . $wid, 'data' => null);
    } elseif ($wxInfo->state != 0) {
        return array('code' => 403, 'msg' => 'The state of this weixin is disabled.Please enable it before use', 'data' => null);
    } else {
        // 记录客户端IP，referer链接，访问时间
        $selectValues = "wxId='" . $wid . "' and clientIp='" . $clientIp . "' and refUrl='" . $referUrl . "'";
        $queryResult = mysqli_query($conn, 'select analyzeId,viewCount from wx_analysis_info where ' . $selectValues);
        $analyzeInfo = mysqli_fetch_object($queryResult);
        // 如果记录存在，则更改访问数和最后访问时间
        if (!empty($analyzeInfo)) {
            $count = $analyzeInfo->viewCount + 1;
            $upSql = "update wx_analysis_info set viewCount=$count,lastViewDate='" . getLastTime() . "' where " . $selectValues;
            mysqli_query($conn, $upSql);
        } else {
            addVisitRecord($wid, $clientIp, $referUrl);
        }
        return array('code' => 0, 'msg' => 'ok', 'data' => array('wxId' => $wxInfo->wxId, 'wxNum' => $wxInfo->wxNum));
    }
}


function queryWeixinInfo($wid)
{
    $conn = get_db_con();
    if (empty($wid)) {
        $wxinfoResult = mysqli_query($conn, 'select * from wx_data_info');
        $wxArr = array();
        while ($row = mysqli_fetch_object($wxinfoResult)) {
            array_push($wxArr, $row);
        }
        return $wxArr;
    } else {
        $wxinfoResult = mysqli_query($conn, 'select * from wx_data_info where wxId=' . $wid);
        return mysqli_fetch_object($wxinfoResult);
    }
}


function addVisitRecord($wid, $clientIp, $referUrl)
{
    $conn = get_db_con();
    $visiteDate = getLastTime();
    $addValues = "values ('" . $wid . "','" . $clientIp . "','" . $visiteDate . "','" . $referUrl . "')";
    $addSql = 'insert into wx_analysis_info (wxId,clientIp,lastViewDate,refUrl) ' . $addValues;
    $addResult = mysqli_query($conn, $addSql);
    return $addResult;
}



function getLastTime()
{
    date_default_timezone_set("Asia/Shanghai");
    $time = date("Y-m-d h:i:sa");
    return $time;
}

/*
 *
 * 获取ReferUrl
 *
 */
function getReferUrl()
{
    if (empty($_SERVER['HTTP_REFERER'])) {
        return $_SERVER['SERVER_NAME'] . ':' . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    }
    return $_SERVER['HTTP_REFERER'];
}


/**
 *@功能：获取客户端的真实IP地址,对代理IP无效
 *@参数：null
 *@返回：客户端的IP地址
 */
function get_client_ip()
{
    $ip = 'unknown';
    $pattern = '/((?:(?:25[0-5]|2[0-4]\d|[01]?\d?\d)\.){3}(?:25[0-5]|2[0-4]\d|[01]?\d?\d))/';
    if (isset($_SERVER['REMOTE_ADDR']) && preg_match($pattern, $_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
    } else if (isset($_SERVER['HTTP_X_REAL_FORWARDED_FOR']) && preg_match($pattern, $_SERVER['HTTP_X_REAL_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_REAL_FORWARDED_FOR'];
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && preg_match($pattern, $_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match($pattern, $_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    return $ip;
}
