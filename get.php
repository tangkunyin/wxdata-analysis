<?php

require './utils/visite.php';

// 指定允许其他域名访问
header('Access-Control-Allow-Origin:*');
// 响应类型
header('Access-Control-Allow-Methods:GET,POST');
// 响应头设置
header('Access-Control-Allow-Headers:x-requested-with,content-type');

try {
    if (!empty($_GET['wid'])) {
        $wxId = $_GET['wid'];
        $weixinInfo = getWxId($wxId);
        echo json_encode($weixinInfo);
    } else {
        $randomInfo = randomGet($_GET['gid']);
        echo json_encode($randomInfo);
    }
} catch (Exception $e) {
    echo $e->getMessage();
}



/*
 * 根据传入的id返回该微信信息，并统计浏览数据
 */
function getWxId($wid)
{
    if (empty($wid)) {
        return 'wid must not be null';
    } else {
        $clientIp = get_client_ip();
        $referUrl = getReferUrl();
        $weixinInfo = getWeiXinInfo($wid, $clientIp, $referUrl);
        return $weixinInfo;
    }
}
