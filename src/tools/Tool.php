<?php
/**
 * Created by PHPStrom.
 * User: Wencai
 * Date: 2017/11/3
 * Time: 15:11
 */
namespace zunxiang\fenlei\tools;

use yii;

class Tool {

    public static function request($post_data,$cookie = '', $timeout = 10){


        // GBK站点需要从UTF8转换到GBK
        if (strtoupper(FORUM_CHARSET) == 'GBK') {
            $post_data = self::_convert($post_data);
        }

        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, FORUM_URL);

        //IP
        $requestIp = self::getRemoteAddress();

        //设置CURL头信息
        $header = [
            'CLIENT-IP:' . $requestIp,
            'X-FORWARDED-FOR:' . $requestIp,
            'REMOTE-ADDR:' . $requestIp,
            'REMOTE-PORT:' . (isset($_SERVER['REMOTE_PORT']) ? $_SERVER['REMOTE_PORT'] : 0),
            'Content-Type:multipart/form-data;charset=utf-8',
            "Expect:"
        ];

        curl_setopt( $curlHandle, CURLOPT_HEADER, 0 );
        curl_setopt( $curlHandle, CURLOPT_HTTPHEADER, $header );

        curl_setopt( $curlHandle, CURLOPT_FOLLOWLOCATION, 1 );
        curl_setopt( $curlHandle, CURLOPT_MAXREDIRS, 3 );

        if ($cookie != '') curl_setopt($curlHandle, CURLOPT_COOKIE, $cookie);
        if( isset($_POST['useragent']) )
        {
            curl_setopt( $curlHandle, CURLOPT_USERAGENT, $_POST['useragent'] );
        }
        else if( isset(Yii::$app->request->userAgent) )
        {
            curl_setopt( $curlHandle, CURLOPT_USERAGENT, Yii::$app->request->userAgent );
        }
        else
        {
            curl_setopt( $curlHandle, CURLOPT_USERAGENT, 'Qianfan Aliyun Server' );
        }
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlHandle, CURLOPT_CONNECTTIMEOUT, 0);

        if(!empty($post_data)){
            //增加REMOTE PORT
            $post_data['remote_port'] = isset($_SERVER['REMOTE_PORT']) ? $_SERVER['REMOTE_PORT'] : 0;

            if( !isset($post_data['nonce']))
            {
                //增加校验参数
                //$post_data['nonce'] = self::nonce(32);
                //$post_data['codeSign'] = self::sign( $post_data, FORUM_SECRET_KEY );

            }

            curl_setopt($curlHandle, CURLOPT_POST, count($post_data));
            curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $post_data);
            curl_setopt($curlHandle, CURLOPT_TIMEOUT, $timeout);
        }

        if (substr(FORUM_URL, 0, 8) == "https://") {
            curl_setopt( $curlHandle , CURLOPT_SSL_VERIFYHOST, false );
            curl_setopt( $curlHandle , CURLOPT_SSL_VERIFYPEER, false );
        }

        $data = curl_exec($curlHandle);
        $status = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);
        curl_close($curlHandle);
        if ($status != 200){
            return '';
        }

        if (substr($data, 0, 3) == "\xEF\xBB\xBF") {
            $data = substr($data, 3);
        }

        return $data;
    }

    public static function nonce($length = 32){
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }


    public static function sign($params,$secret){
        ksort($params);
        $sparams = array();
        foreach ($params as $k => $v) {
            if ("@" != substr($v, 0, 1)) {
                $sparams[] = "$k=$v";
            }
        }
        $sparams[] = "secret=" . $secret;
        return strtoupper(md5(implode("&", $sparams)));
    }

    /**
     * 将参数转码 GBK 2 UTF-8
     * @param $post_data
     * @return array|string
     */
    public static function _convert($post_data)
    {
        if (is_array($post_data)) {
            return array_map(function ($post_data) {
                return self::_convert($post_data);
            }, $post_data);
        } else {
            if (is_string($post_data)) {
                return mb_convert_encoding($post_data, 'GBK', 'UTF-8');
            } else {
                return $post_data;
            }
        }
    }
    /**
     * 获取请求的IP地址
     * @return mixed
     */
    public static function getRemoteAddress() {
        $ip = '';

        if( isset($_SERVER['REMOTE_ADDR']) )
        {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        else if (isset($_SERVER['HTTP_CDN_REAL_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CDN_REAL_IP']))
        {
            $ip = $_SERVER['HTTP_CDN_REAL_IP'];
        }
        else if (isset($_SERVER['HTTP_CDN_SRC_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CDN_SRC_IP']))
        {
            $ip = $_SERVER['HTTP_CDN_SRC_IP'];
        }
        elseif (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP']))
        {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        else if (isset($_SERVER['HTTP_X_REAL_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_X_REAL_IP']))
        {
            $ip = $_SERVER['HTTP_X_REAL_IP'];
        }
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) AND preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches))
        {
            foreach ($matches[0] AS $xip)
            {
                if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip))
                {
                    $ip = $xip;
                    break;
                }
            }
        }

        return $ip;
    }
}

