<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

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
}
