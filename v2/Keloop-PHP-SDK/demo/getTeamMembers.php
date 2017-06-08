<?php

/*
 *   Copyright (c) 2012—2016 成都零点信息技术有限公司 All
 */

/**
 * 获取快跑者商户关联的合作配送团体及配送团体下的配送群和配送员信息
 *
 * @author xuhaha
 */

header("Content-type: text/html; charset=utf-8");

// 引用keloopSDK文件
require '../KeloopSdk2.php';

// TODO:: 从数据库中获取 access_key 和 access_sec，下面直接定义两个变量
$accessKey = 'K6GQF8N8';
$accessSec = 'Z0AX4ZHH';
// 创建 SDK 实例
$sdk = new KeloopCnSdk2($accessKey, $accessSec);
// 参数
$param = array();
// 如果之前使用了 v1 版本的开放接口，生成的 access_key 和开发密钥(dev_secret)未绑定，则进行兼容绑定
$param['dev_secret'] = '9LIYXQ2PTKSZNGUJHHESXP7V1COHY2TW';
// 调用 getTeamMember 方法
$result = $sdk->getTeamMembers($param);
// 业务逻辑处理
if (is_null($result)) {
    exit('获取配送团队成员信息接口异常');
} else if (is_array($result)) {
    if ($result['code'] == 200) {
        $data = $result['data'];
        // 打印获取到的配送团队成员信息
        var_dump($data);
        // TODO:: 进行业务处理
        exit('success');
    } else {
        exit('错误信息：' . $result['message']);
    }
} else {
    exit('接口调用异常');
}
