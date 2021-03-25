<?php


namespace app\index\model;


use think\Model;

class User extends Model
{
    public function getUserInfo(){
        $info = User::get('11');
//        return ['data'=>$info];
        print_r($info);
    }

}