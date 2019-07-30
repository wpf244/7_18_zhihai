<?php
namespace app\api\controller;

use think\Request;

class Organ extends BaseApi
{
    public function index()
    {
        $url=parent::getUrl();

        //banner图
        $banner=db("lb")->field("url,image")->where(["fid"=>3,"status"=>1])->find();

        $banner['image']=$url.$banner['image'];

        //合作机构
        $cooper=db("organ")->field("id,logo")->where(["status"=>2,"recome"=>1])->order(["sort asc","id desc"])->select();

        foreach($cooper as &$vc){
            $vc['logo']=$url.$vc['logo'];
        }

        //综合
        $comper=db("organ")->field("id,logo")->where(["status"=>2])->order(["sort asc","id desc"])->select();

        foreach($comper as &$vcs){
            $vcs['logo']=$url.$vcs['logo'];
        }

        //附近
        $near=db("organ")->field("id,logo")->where(["status"=>2,"near"=>1])->order(["sort asc","id desc"])->select();

        foreach($near as &$vn){
            $vn['logo']=$url.$vn['logo'];
        }

        //优秀
        $goods=db("organ")->field("id,logo")->where(["status"=>2,"goods"=>1])->order(["sort asc","id desc"])->select();

        foreach($goods as &$vg){
            $vg['logo']=$url.$vg['logo'];
        }

        $arr=[
            'error_code'=>0,
            'msg'=>'获取成功',
            'data'=>[
                'banner'=>$banner,
                'cooper'=>$cooper,
                'comper'=>$comper,
                'near'=>$near,
                'goods'=>$goods,
            ]
        ];
    
        return json($arr);

    }
    /**
    * 搜索条件
    *
    * @return void
    */
    public function search()
    {
        $arrs['age']=db("organ_type")->field("id,name")->where("type",1)->order("id asc")->select();

        $arrs['people']=db("organ_type")->field("id,name")->where("type",2)->order("id asc")->select();

        $arr=[
            'error_code'=>0,
            'msg'=>'获取成功',
            'data'=>$arrs
        ];

        return json($arr);
    }
    /**
    * 搜索结果列表
    *
    * @return void
    */
    public function lister()
    {
        $url=parent::getUrl();

        $aid=input("aid");

        $pid=input("pid");

        $addr=input("addr");

        $map=[];

        if($aid){
            $map['yid']=['eq',$aid];
        }
        if($pid){
            $map['pid']=['eq',$pid];
        }
        if($addr){
            $map['addr']=['like',"%".$addr."%"];
        }
        

        $res=db("organ")->field("id,logo,name,addr,marray")->where(["status"=>2])->where($map)->order(["sort asc","id desc"])->select();

        foreach($res as  &$v){
            $v['logo']=$url.$v['logo'];
        }


         $arr=[
            'error_code'=>0,
            'msg'=>'获取成功',
            'data'=>$res
        ];

        return json($arr);

    }
   
    /**
    * 职位详情
    *
    * @return void
    */
    public function detail_job()
    {
        
        $url=parent::getUrl();

        $id=input("id");

        $re=db("job")->where("id",$id)->find();

        $re['company']=db("organ")->field("id,name,logo,pid")->where(["id"=>$re['fid']])->find();

        $re['company']['logo']=$url.$re['company']['logo'];

        $re['company']['people']=db("organ_type")->where("id",$re['company']['pid'])->find()['name'];

        $re['job']=db("job")->field("id,name,addr,age,edu,money")->where(["fid"=>$re['fid'],"status"=>2,"id"=>['neq',$id]])->select();

        $arr=[
            'error_code'=>0,
            'msg'=>'获取成功',
            'data'=>$re
        ];

        return json($arr);

    }
    
   

}