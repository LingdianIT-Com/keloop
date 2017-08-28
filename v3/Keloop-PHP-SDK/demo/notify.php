<?php

/*
 *   Copyright (c) 2012—2017 成都零点信息技术有限公司 All
 */

/**
 * 快跑者配送订单状态变更时，回调第三方系统
 *
 * @author xuhaha sxuhaha@gmail.com
 */

header('Content-type: text/html; charset=utf-8');

// 引用 KeloopSDK 文件
require '../KeloopSdk3.php';

// 可在开发者中心（http://www.keloop.cn/home/open/admin）查看 dev_key 和 dev_secret 参数
$devKey = '9LIYXQ2PTKSZNGUJHHESXP7V1COHY2TW';
$devSecret = 'F0A7C215592E0BEBA900E7DE1BED833D';
// 获取 post 数据
$para = $_POST;
if ($para['expire_time'] < time()) {
    exit('消息已过期');
}
// 创建 SDK 实例
$sdk = new KeloopCnSdk3($devKey, $devSecret);
// 调用 checkSign 方法
if ($sdk->checkSign($para)) {
    exit('验签失败');
}
// TODO:: 进行业务操作
var_dump($para);
exit('success');
