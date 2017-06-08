<?php

/*
 *   Copyright (c) 2012—2016 成都零点信息技术有限公司 All
 */

/**
 * Description of ...
 *
 * @author xuhaha
 */

header("Content-type: text/html; charset=utf-8");

// 引用keloopSDK文件
require '../KeloopSdk2.php';

// 获取 post 数据
$para = $_POST;
if ($para['expire_time'] < time()) {
    exit('消息已过期');
}
if (!$accessKey = $para['access_key']) {
    exit('access_key 不存在');
}
// TODO::根据 $accessKey 获取保存在你的数据库中对应的 access_sec，下面直接定义 $accessSec 变量
$accessSec = 'Z0AX4ZHH';

// 创建 SDK 实例
$sdk = new KeloopCnSdk2($accessKey, $accessSec);
// 调用 cancelOrder 方法
if ($sdk->checkSign($para)) {
    exit('验签失败');
}
// TODO:: 进行业务操作
var_dump($para);
exit('success');
