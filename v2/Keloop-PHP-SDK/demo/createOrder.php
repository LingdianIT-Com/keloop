<?php

/*
 *   Copyright (c) 2012—2016 成都零点信息技术有限公司 All
 */

/**
 * 创建快跑者订单
 *
 * @author xuhaha
 */

header("Content-type: text/html; charset=utf-8");

// 引用keloopSDK文件
require '../KeloopSdk.php';

// TODO:: 从数据库中获取 access_key 和 access_sec，下面直接定义两个变量
$accessKey = '600FKO6O';
$accessSec = '1PXUKW65';
// 封装参数
$para = array(
    'order_content' => '1份烧白开(100x1),1份拉面(18x1)',
    'order_note' => '不要太辣了',
    'order_mark' => '外卖订单',
    'order_from' => '三餐美食 - 兰州拉面',
    'order_send' => '下午六点钟之前送达',
    'order_no' => '12153546',
    'order_time' => '2016-12-31 23:59:59',
    'order_photo' => 'http://a4.att.hudong.com/38/47/19300001391844134804474917734_950.png',
    'order_price' => 99.99,

    'customer_name' => '郝美丽',
    'customer_tel' => '18288888888',
    'customer_address' => '成都市金牛区蓝海天地1栋421',
    'customer_tag' => '104.081909,30.779741',
    'customer_sex' => '男',

    'pay_status' => 1,
    'pay_type' => 1,
    'pay_fee' => 6.66,

    'team_id' => 4,
    'group_id' => 185
);
// 如果之前使用了 v1 版本的开放接口，生成的 access_key 和开发密钥(dev_secret)未绑定，则进行兼容绑定
$para['dev_secret'] = 'BSLFRYSD';
// 创建 SDK 实例
$sdk = new KeloopCnSdk($accessKey, $accessSec);
// 调用 createOrder 方法
$result = $sdk->createOrder($para);
// 业务逻辑处理
if (is_null($result)) {
    exit('创建订单接口异常');
} else if (is_array($result)) {
    if ($result['code'] == 200) {
        $tradeNo = $result['data']['trade_no'];
        // TODO:: 将 $tradeNo 保存到数据库中，以待以后使用
        var_dump($tradeNo);
        exit('Success');
    } else {
        exit('错误信息：' . $result['message']);
    }
} else {
    exit('接口调用异常');
}
