<?php

/*
 *   Copyright (c) 2012—2017 成都零点信息技术有限公司 All
 */

/**
 * 创建快跑者配送订单
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
    'note' => 'great',
    'order_content' => '1份烧白开(100x1),1份拉面(18x1)',
    'order_note' => '不要太辣了',
    'order_mark' => '12',
    'order_from' => '美团外卖',
    'order_send' => '下午六点钟之前送达',
    'order_no' => '12153155',
    'order_time' => '2016-12-31 23:59:59',
    'order_photo' => 'http://a4.att.hudong.com/38/47/19300001391844134804474917734_950.png',
    'order_price' => 99.99,

    'customer_name' => '郝美丽',
    'customer_tel' => '18288888888',
    'customer_address' => '成都市金牛区蓝海天地1栋421',
    'customer_tag' => '104.081909,30.779741',
    'customer_sex' => '男',

    'pay_status' => 1,
    'pay_type' => 2,
    'pay_fee' => 6.66,

    'team_token' => '1PD2QPBXY095TASL',
    'shop_id' => 24,
    'shop_name' => '廖记棒棒鸡',
    'shop_tel' => '18299999999',
    'shop_address' => '成都市金牛区金卉院',
    'shop_tag' => '104.181909,30.679741',
    'dev_key' => $devKey
);
// 创建 SDK 实例
$sdk = new KeloopCnSdk3($devKey, $devSecret);
// 调用 createOrder 方法
$result = $sdk->createOrder($para);
// 业务逻辑处理
if (is_null($result)) {
    exit('创建订单接口异常');
} else if (is_array($result)) {
    if ($result['code'] == 200) {
        $tradeNo = $result['data']['trade_no'];
        // TODO: => 将 $tradeNo 保存到数据库中，以待以后使用
        var_dump($tradeNo);
        exit('success');
    } else {
        exit('错误信息：' . $result['message']);
    }
} else {
    exit('接口调用异常');
}