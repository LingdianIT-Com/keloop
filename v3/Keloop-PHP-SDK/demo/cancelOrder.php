<?php

/*
 *   Copyright (c) 2012—2017 成都零点信息技术有限公司 All
 */

/**
 * 撤销快跑者配送订单
 *
 * @author xuhaha sxuhaha@gmail.com
 */

header('Content-type: text/html; charset=utf-8');

// 引用 KeloopSDK 文件
require '../KeloopSdk3.php';

// 可在开发者中心（http://www.keloop.cn/home/open/admin）查看 dev_key 和 dev_secret 参数
$devKey = '9LIYXQ2PTKSZNGUJHHESXP7V1COHY2TW';
$devSecret = 'F0A7C215592E0BEBA900E7DE1BED833D';
// 封装参数
$para = array(
    'trade_no' => '17082810035800003'
);
// 创建 SDK 实例
$sdk = new KeloopCnSdk3($devKey, $devSecret);
// 调用 cancelOrder 方法
$result = $sdk->cancelOrder($para);
// 业务逻辑处理
if (is_null($result)) {
    exit('撤销快跑者配送订单接口异常');
} else if (is_array($result)) {
    if ($result['code'] == 200) {
        exit('success');
    } else {
        exit('错误信息：' . $result['message']);
    }
} else {
    exit('接口调用异常');
}