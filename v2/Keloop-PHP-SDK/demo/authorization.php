<?php

/*
 *   Copyright (c) 2012—2016 成都零点信息技术有限公司 All
 */

/**
 * 调用账号认证接口进行身份认证
 *
 * @author xuhaha
 */

header("Content-type: text/html; charset=utf-8");

// 引用keloopSDK文件
require '../KeloopSdk2.php';

// 快跑者商户的手机账号
$tel = '18280094727';
// 快跑者商户的密码
$password = '123456';
// 开发密钥
$devSecret = '9LIYXQ2PTKSZNGUJHHESXP7V1COHY2TW';
// 描述信息
$note = '三餐美食 - 兰州拉面店';
// 封装参数
$param = array(
    'tel' => $tel,
    'password' => $password,
    'dev_secret' => $devSecret,
    'note' => $note
);
// 调用 authorization 方法
$result = KeloopCnSdk2::authorization($param);
// 业务逻辑处理
if (is_null($result)) {
    exit('商户身份认证接口调用异常');
} else if (is_array($result)) {
    if ($result['code'] == 200) {
        $data = array(
            'access_key' => $result['data']['access_key'],
            'access_sec' => $result['data']['access_sec']
        );
        // TODO:: 将 $data 保存到数据库中！！！
        var_dump($data);
        exit('success');
    } else {
        exit('错误信息：' . $result['message']);
    }
} else {
    exit('接口调用异常');
}
