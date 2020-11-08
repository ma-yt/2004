<?php

namespace App\Http\Controllers\Weixin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class IndexController extends Controller
{

    public function index()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = env('WX_TOKEN');
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            echo $_GET['echostr'];
        }else{
            echo '123';
        }
    }


    public function event()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = env('WX_TOKEN');
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
           //1、接收数据
            $xml_data = file_get_contents("php://input");

            //记录日志
            file_put_contents('wx_event.log',$xml_data);
            echo "";
            die;
            //2、把xml文本转换成为php的对象或数组
            $data = simplexml_load_string($xml_data,'SimpleXMLElement');
            file_put_contents('a.txt',$data);die;
            $openid=$this->FromUserNam;
            if($data->MsgType=="event"){
                if($data->Event=="subscribe"){
                    $accesstoken = $this->gettokrn();
                    $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$accesstoken."&openid=".env('WX_APPID')."&lang=zh_CN";
                }
            }
//
//            $xml = "<xml>
//                  <ToUserName><![CDATA[toUser]]></ToUserName>
//                  <FromUserName><![CDATA[fromUser]]></FromUserName>
//                  <CreateTime>12345678</CreateTime>
//                  <MsgType><![CDATA[text]]></MsgType>
//                  <Content><![CDATA[你好]]></Content>
//                </xml>";
//            echo $xml;
        }else{
            echo "";
        }
    }

    public function gettoken(){

        $key = "AccessToken";

        $token = Redis::get($key);

        if(!$token){
            echo "没有缓存";
            $stream_opts = [
                "ssl" => [
                    "verify_peer"=>false,
                    "verify_peer_name"=>false,
                ]
            ];
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".env('WX_APPID')."&secret=".env('WX_APPSECRET');

            $token=file_get_contents($url,false,stream_context_create($stream_opts));
//            $token=file_get_contents($url);

            $tok = json_decode($token,true);
            $token = $tok['access_token'];
            Redis::set($key,$token);
            Redis::expire($key,3600);
        }
        echo $token;
    }

    //关注回复
    public function responseMsg($array,$Content){
                $ToUserName = $array->FromUserName;
                $FromUserName = $array->ToUserName;
                $CreateTime = time();
                $MsgType = "text";

                $text = "<xml>
                  <ToUserName><![CDATA[%s]]></ToUserName>
                  <FromUserName><![CDATA[%s]]></FromUserName>
                  <CreateTime>%s</CreateTime>
                  <MsgType><![CDATA[%s]]></MsgType>
                  <Content><![CDATA[%s]]></Content>
                </xml>";
                echo sprintf($text,$ToUserName,$FromUserName,$CreateTime,$MsgType,$Content);
            }
}
