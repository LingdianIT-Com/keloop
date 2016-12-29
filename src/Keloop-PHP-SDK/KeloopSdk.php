<?php

/*
 *   Copyright (c) 2012—2016 成都零点信息技术有限公司 All 
 */

/**
 * 2017 年新版快跑者 SDK
 *
 * @author xuhaha
 */
class KeloopCnSdk
{

    const BASE_URL = "http://www.keloop.cn/Api";

    private $accessKey = "";
    private $accessSec = "";

    /**
     * KeloopCnSdk constructor.
     * @param $key
     * @param $sec
     * @throws Exception
     */
    function __construct($key, $sec)
    {
        if (empty($key) || empty($sec)) {
            throw new Exception("身份认证标识(access_key)与身份认证密钥(access_sec)不能为空");
        }
        $this->accessKey = $key;
        $this->accessSec = $sec;
    }

    /**
     * @param $path
     * @param array $para
     * @return mixed|null
     */
    public function getUrl($path, $para = array())
    {
        $para['expire_time'] = time() + 120;
        $para['access_key'] = $this->accessKey;
        $sign = Md5Sign::getSign($para, $this->accessSec);
        $para['sign'] = $sign;
        $url = self::BASE_URL . $path;
        $data = HTTPRequest::getUrl($url, $para);
        if (!empty($data)) {
            return json_decode($data, true);
        } else {
            return null;
        }
    }

    /**
     * @param $path
     * @param array $para
     * @return mixed|null
     */
    public function postUrl($path, $para = array())
    {
        $para['expire_time'] = time() + 120;
        $para['access_key'] = $this->accessKey;
        $sign = Md5Sign::getSign($para, $this->accessSec);
        $para['sign'] = $sign;
        $url = self::BASE_URL . $path;
        $data = HTTPRequest::postUrl($url, $para);
        if (!empty($data)) {
            return json_decode($data, true);
        } else {
            return null;
        }
    }

    /**
     * 账号认证
     * @param $para
     * @return mixed|null
     */
    public function authorization($para)
    {
        $path = "/Tp/authorization";
        return $this->postUrl($path, $para);
    }

    /**
     * 向绑定的配送站发送订单
     * @param $para
     * @return mixed|null
     */
    public function createOrder($para)
    {
        $path = "/Tp/createOrder";
        return $this->postUrl($path, $para);
    }

    /**
     * 获取快跑者商户关联的配送团队及成员
     * @return boolean
     */
    public function getTeamMember()
    {
        $path = "/Tp/getTeamMember";
        return $this->getUrl($path);
    }

    /**
     * 取消订单
     * @param $para
     * @return mixed|null
     */
    public function cancelOrder($para)
    {
        $path = "/Tp/cancelOrder";
        return $this->postUrl($path, $para);
    }

}

class Md5Sign
{

    /**
     * 获取签名
     * @param array $para 密的参数数组
     * @param string $encKey 加密的key
     * @return bool|string 生产的签名
     */
    public static function getSign($para, $encKey)
    {
        if (empty($para) || empty($encKey)) {
            return false;
        }
        //除去待签名参数数组中的空值和签名参数
        $para = self::paraFilter($para);
        $para = self::argSort($para);
        $str = self::createLinkstring($para);
        $sign = self::md5Verify($str, $encKey);
        return $sign;
    }

    /**
     * 除去数组中的空值和签名参数
     * @param array $para 签名参数组
     * @return array 获取去掉空值与签名参数后的新签名参数组
     */
    private static function paraFilter($para)
    {
        $para_filter = array();
        while (list ($key, $val) = each($para)) {
            //去掉 "",null,保留数字0
            if ($key == "sign" || $key == "sign_type" || $key == "key" || (empty($val) && !is_numeric($val))) {
                continue;
            } else {
                $para_filter[$key] = $para[$key];
            }
        }
        return $para_filter;
    }

    /**
     * 对数组排序
     * @param array $para 排序前的数组
     * @return mixed 排序后的数组
     */
    private static function argSort($para)
    {
        ksort($para);
        reset($para);
        return $para;
    }

    /**
     * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
     * @param array $para 需要拼接的数组
     * @return string 拼接完成以后的字符串
     */
    private static function createLinkstring($para)
    {
        $arg = "";
        while (list ($key, $val) = each($para)) {
            $arg .= $key . "=" . $val . "&";
        }
        //去掉最后一个&字符
        $arg = trim($arg, '&');
        //如果存在转义字符，那么去掉转义
        if (get_magic_quotes_gpc()) {
            $arg = stripslashes($arg);
        }
        return $arg;
    }

    /**
     * 生成签名
     * @param string $prestr 需要签名的字符串
     * @param string $sec 身份认证密钥(access_sec)
     * @return string 签名结果
     */
    private static function md5Verify($prestr, $sec)
    {
        return md5($prestr . $sec);
    }

}

class HTTPRequest
{

    /**
     * Http post request
     * @param $url
     * @param array $params
     * @param int $timeout
     * @return bool|mixed
     */
    public static function postUrl($url, $params = array(), $timeout = 30)
    {
        //编码特殊字符
        $p = http_build_query($params);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        // 设置header
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $p);
        // 设置cURL 参数，要求结果保存到字符串中还是输出到屏幕上。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        // 运行cURL，请求网页
        $data = curl_exec($curl);
        if ($data === false) {
            return false;
        } else {
            return $data;
        }
    }

    /**
     * Http get request
     * @param $url
     * @param array $param
     * @return mixed
     */
    public static function getUrl($url, $param = array())
    {
        $url = self::buildUrl($url, $param);
        return self::get($url);
    }

    /**
     * Http get request
     * @param $url
     * @param int $timeout
     * @return mixed
     */
    public static function get($url, $timeout = 30)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $resposne = curl_exec($ch);
        return $resposne;
    }

    /**
     * Build request url
     * @param $url
     * @param $param
     * @return string
     */
    private static function buildUrl($url, $param)
    {
        $url = rtrim(trim($url), "?");
        $url = $url . "?";
        $query = "";
        if (!empty($param)) {
            $query = http_build_query($param);
        }
        return $url . $query;
    }

}