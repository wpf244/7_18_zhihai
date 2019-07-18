<?php
namespace app\api\controller;

use think\Request;

class User extends BaseHome
{
    public function index()
    {
        $uid=Request::instance()->header("uid");

        $user=db("user")->where("uid",$uid)->find();

        $arr=[
            'error_code'=>0,
            'msg'=>'获取成功',
            'data'=>$user
        ];

        return json($arr);
    }
    public function dancer_type()
    {
        $arrs['major']=db("dancer_type")->field("id,name")->where("type",1)->order("id asc")->select();

        $arrs['edu']=db("dancer_type")->field("id,name")->where("type",2)->order("id asc")->select();

        $arrs['tag']=db("dancer_type")->field("id,name")->where("type",3)->order("id asc")->select();

        $arr=[
            'error_code'=>0,
            'msg'=>'获取成功',
            'data'=>$arrs
        ];

        return json($arr);
    }
    /**
    * 判断是否提交过了
    *
    * @return void
    */
    public function dancer()
    {
        $uid=Request::instance()->header("uid");

        $re=db("dancer")->where("uid",$uid)->find();

        if($re){

            $re['majors']=db("dancer_type")->where("id",$re['major'])->find()['name'];

            $re['edus']=db("dancer_type")->where("id",$re['edu'])->find()['name'];

            $re['tag']=explode(",",$re['tag']);

            $tags=db("dancer_type")->where("id","in",$re['tag'])->select();

            $name='';
            foreach($tags as $v){
                $name.=$v['name'].',';
            }
            $re['tags']=$name;

            $arr=[
                'error_code'=>1,
                'msg'=>'不是首次提交,修改信息',
                'data'=>$re
            ];

        }else{
            $arr=[
                'error_code'=>0,
                'msg'=>'首次提交',
                'data'=>[]
            ];
        }
        return json($arr);
    }

    /**
    * 提交修改信息
    *
    * @return void
    */
    public function dancer_save()
    {
        $uid=Request::instance()->header("uid");

        $data=input("post.");

        if(\is_array($data['tag'])){

            $data['tag']=\implode(",",$data['tag']);

        }
        
        $data['time']=\time();

        $data['uid']=$uid;

        $data['status']=1;

        $re=db("dancer")->where("uid",$uid)->find();

        if($re){
            $res=db("dancer")->where("uid",$uid)->update($data);

            if($res){
                $arr=[
                    'error_code'=>0,
                    'msg'=>'提交成功',
                    'data'=>[]
                ];
            }else{
                $arr=[
                    'error_code'=>1,
                    'msg'=>'提交失败',
                    'data'=>[]
                ];
            }
        }else{
            $res=db("dancer")->insert($data);
            if($res){
                $arr=[
                    'error_code'=>0,
                    'msg'=>'提交成功',
                    'data'=>[]
                ];
             }else{
                $arr=[
                    'error_code'=>1,
                    'msg'=>'提交失败',
                    'data'=>[]
                ];
            }

        }

        return json($arr);
    }
}