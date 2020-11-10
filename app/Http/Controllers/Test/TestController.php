<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use GuzzleHttp\Client;

class TestController extends Controller
{
    public function test(){
        $res = DB::table('ceshibiao')->get();
        dd($res);
    }

    public function info(){
        $key = '123';
        Redis::set($key,time());
        echo Redis::get($key);
    }

    public function abc(){
        echo '<pre>';print_r($_GET); echo '</pre>';
    }

    public function aaa(){
//        echo '<pre>';print_r($_POST); echo '</pre>';
        $xml_data = file_get_contents("php://input");
        $data = simplexml_load_string($xml_data,'SimpleXMLElement');
    }

    public function guzzle(){
//        echo __METHOD__;
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".env('WX_APPID')."&secret=".env('WX_APPSECRET');
        echo $url;die;

        //使用guzzle发送get请求
        $client = new Client();   //实例化客户端
        $response = $client->request('GET',$url,['verify'=>false]);    //发起请求并接受响应
        $json_str = $response->getBody();   //服务器的响应数据
        echo $json_str;
    }

    public function guzzle2(){
        $access_token ="";
        $type = "image";
        $url = "https://api.weixin.qq.com/cgi-bin/media/upload?access_token=".$access_token."&type=".$type;
        //使用guzzle发送get请求
        $client = new Client();   //实例化客户端
        $response = $client->request('POST',$url,[
            'verify' => false,
            'multipart' => [
                [
                    'name'     => 'media',   //上传文件的路径
                    'contents'     => fopen('iphone.jpg','r'),   //上传文件的路径
                ],
            ]
        ]);    //发起请求并接受响应
        $data = $response->getBody();
        echo $data;
    }
}
