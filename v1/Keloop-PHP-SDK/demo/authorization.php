<?php

/*
 *   Copyright (c) 2012—2016 成都零点信息技术有限公司 All 
 */

/**
 * 调用账号认证接口进行身份认证
 *
 * @author xuhaha
 */

// 引用keloopSDK文件
require '../KeloopSdk.php';

// 快跑者商户的手机账号
$tel = '18280094727';
// 快跑者商户的密码
$password = '123456';
// 描述信息
$note = '三餐美食 - 兰州拉面';
// 封装参数
$para = array(
    'tel' => $tel,
    'password' => $password,
    'note' => $note
);
// 创建 SDK 实例（注意：这儿传入的 $tel 和 $password 参数仅是避免实例化对象时报错，没任何实际意义，也可使用任意字符串代替）
$sdk = new KeloopCnSdk($tel, $password);
// 调用 authorization 方法
$result = $sdk->authorization($para);
// 业务逻辑处理
if (is_null($result)) {
    exit('身份认证接口异常');
} else if (is_array($result)) {
    if ($result['code'] == 200) {
        $data = array(
            'access_key' => $result['data']['access_key'],
            'access_sec' => $result['data']['access_sec']
        );
        // TODO:: 将 $data 保存到数据库中！！！
        var_dump($data);
        exit('Success');
    } else {
        exit($result['message']);
    }
} else {
    exit('接口调用异常');
}
