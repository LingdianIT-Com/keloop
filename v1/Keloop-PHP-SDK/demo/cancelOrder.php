<?php

/*
 *   Copyright (c) 2012—2016 成都零点信息技术有限公司 All 
 */

/**
 * 撤销订单
 *
 * @author xuhaha
 */

// 引用keloopSDK文件
require '../KeloopSdk.php';

// TODO:: 从数据库中获取 access_key 和 access_sec，下面直接定义两个变量
$accessKey = '600FKO6O';
$accessSec = '1PXUKW65';

// TODO:: 获取需要撤销的订单的 trade_no
$tradeNo = '17011810460100001';
// 封装参数
$para = array(
    'trade_no' => $tradeNo
);
// 创建 SDK 实例
$sdk = new KeloopCnSdk($accessKey, $accessSec);
// 调用 cancelOrder 方法
$result = $sdk->cancelOrder($para);
// 业务逻辑处理
if (is_null($result)) {
    exit('撤销订单接口异常');
} else if (is_array($result)) {
    if ($result['code'] == 200) {
        exit('Success');
    } else {
        exit($result['message']);
    }
} else {
    exit('接口调用异常');
}
