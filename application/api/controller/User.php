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

        $data['age']=$this->getAge(strtotime($data['birth']));



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
      /**
     * 准备工作完毕 开始计算年龄函数
     * @param  $birthday 出生时间 uninx时间戳
     * @param  $time 当前时间
     **/
    public function getAge($birthday){

        $byear=date('Y',$birthday);


        $bmonth=date('m',$birthday);


        $bday=date('d',$birthday);

        //格式化当前时间年月日

        $tyear=date('Y');

        $tmonth=date('m');

        $tday=date('d');
    

        //开始计算年龄

        $age=$tyear-$byear;

        if($bmonth>$tmonth || $bmonth==$tmonth && $bday>$tday){

            $age--;

        }
        return $age;
    }
    /**
    * 机构分类
    *
    * @return void
    */
    public function organ_type()
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
    * 提交修改信息
    *
    * @return void
    */
    public function organ_save()
    {
        $uid=Request::instance()->header("uid");

        $data=input("post.");

        if(\is_array($data['image'])){

            $data['image']=\implode(",",$data['image']);

        }
        
        $data['time']=\time();

        $data['uid']=$uid;

        $data['status']=1;

     
        $re=db("organ")->where("uid",$uid)->find();

        if($re){
            $res=db("organ")->where("uid",$uid)->update($data);

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
            $res=db("organ")->insert($data);
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
    /**
    * 判断是否提交过了
    *
    * @return void
    */
    public function organ()
    {
        $uid=Request::instance()->header("uid");

        $url=parent::getUrl();

        $re=db("organ")->where("uid",$uid)->find();

        if($re){

            $re['age']=db("organ_type")->where("id",$re['yid'])->find()['name'];

            $re['people']=db("organ_type")->where("id",$re['pid'])->find()['name'];

            $re['image']=explode(",",$re['image']);

            foreach($re['image'] as $v){
                $image[]=$url.$v;
            }
            $re['image']=$image;

            $re['logo']=$url.$re['logo'];

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
    * 提交招聘
    *
    * @return void
    */
    public function save_job()
    {
        $uid=Request::instance()->header("uid");

        $user=db("user")->where("uid",$uid)->find();

        if($user['level'] == 2){

            $organ=db("organ")->where("uid",$uid)->find();

            if($organ){

                $data=input("post.");

                $data['uid']=$uid;

                $data['fid']=$organ['id'];

                $data['time']=time();

                $re=db("job")->insert($data);

                if($re){
                    $arr=[
                        'error_code'=>0,
                        'msg'=>'提交成功',
                        'data'=>[]
                    ];
                }else {
                    $arr=[
                        'error_code'=>2,
                        'msg'=>'提交失败',
                        'data'=>[]
                    ];
                }

            }else{
                $arr=[
                    'error_code'=>1,
                    'msg'=>'认证机构才能发布招聘信息',
                    'data'=>[]
                ];
            }

        }else{
            $arr=[
                'error_code'=>1,
                'msg'=>'认证机构才能发布招聘信息',
                'data'=>[]
            ];
        }
        return json($arr);
    }
    /**
    * 我的发布
    *
    * @return void
    */
    public function my_release()
    {
        $uid=Request::instance()->header("uid");

        $status=input("status");

        $map=[];

        if($status){
             $map['status']=['eq',$status];
        }
        $res=db("job")->field("id,name,addr,age,edu,money")->where(["uid"=>$uid])->where($map)->select();

        $arr=[
            'error_code'=>0,
            'msg'=>'获取成功',
            'data'=>$res
        ];

        return json($arr);
    }
    /**
    * 删除我的发布
    *
    * @return void
    */
    public function delete()
    {
        $id=input("id");

        $re=db("job")->where("id",$id)->find();

        if($re){

            $del=db("job")->where("id",$id)->delete();

            if($del){
                $arr=[
                    'error_code'=>0,
                    'msg'=>'删除成功',
                    'data'=>[]
                ];
            }else{
                $arr=[
                    'error_code'=>2,
                    'msg'=>'删除失败',
                    'data'=>[]
                ];
            }

        }else{
            $arr=[
                'error_code'=>1,
                'msg'=>'参数错误',
                'data'=>[]
            ];
        }

        return json($arr);
    }
    /**
    * 合作渠道
    *
    * @return void
    */
    public function cooper()
    {
        $url=parent::getUrl();
        
        //合作机构
        $res=db("organ")->field("id,logo")->where(["status"=>2,"recome"=>1])->order(["sort asc","id desc"])->select();

        foreach($res as &$vc){
            $vc['logo']=$url.$vc['logo'];
        }
        $arr=[
            'error_code'=>0,
            'msg'=>'获取成功',
            'data'=>$res
        ];
        return json($arr);
    }
    /**
    * 老师详情
    *
    * @return void
    */
    public function teacher_detail()
    {
        $id=input("id");

        $re=db("teacher")->where("id",$id)->find();

       if($re){

            $url=parent::getUrl();

            $re['image']=$url.$re['image'];

            $re['major']=db("dancer_type")->where("id",$re['major'])->find()['name'];

            $re['edu']=db("dancer_type")->where("id",$re['edu'])->find()['name'];

            $re['tag']=explode(",",$re['tag']);

            $tags=db("dancer_type")->where("id","in",$re['tag'])->select();

            $name='';
            foreach($tags as $v){
                $name.=$v['name'].',';
            }
            $re['tag']=$name;

            $arr=[
                'error_code'=>0,
                'msg'=>'获取成功',
                'data'=>$re
            ];
       }else{
            $arr=[
                'error_code'=>1,
                'msg'=>'非法请求',
                'data'=>[
                    
                
                ]
            ];
       }
       return json($arr);
       
    }
    /**
    * 新闻详情
    *
    * @return void
    */
    public function news_detail()
    {
        $id=input("id");

        $re=db("news")->field("id,title,time,browse,content")->where(["id"=>$id,"status"=>1])->find();

        db("news")->where("id",$id)->setInc("browse",1);

        $arr=[
            'error_code'=>0,
            'msg'=>'获取成功',
            'data'=>$re
        ];
        return json($arr);
    }
    /**
    * 舞者详情
    *
    * @return void
    */
    public function detail()
    {
        $id=input("id");

        $re=db("dancer")->where("id",$id)->find();

       if($re){

            $url=parent::getUrl();

            if($re['uid'] == 0){

                $re['image']=$url.$re['image'];

            }else{
                $re['image']=db("user")->where("uid",$re['uid'])->find()['image'];
            }

            $re['major']=db("dancer_type")->where("id",$re['major'])->find()['name'];

            $re['edu']=db("dancer_type")->where("id",$re['edu'])->find()['name'];

            $re['tag']=explode(",",$re['tag']);

            $tags=db("dancer_type")->where("id","in",$re['tag'])->select();

            $name='';
            foreach($tags as $v){
                $name.=$v['name'].',';
            }
            $re['tag']=$name;

            $arr=[
                'error_code'=>0,
                'msg'=>'获取成功',
                'data'=>$re
            ];
       }else{
            $arr=[
                'error_code'=>1,
                'msg'=>'非法请求',
                'data'=>[
                    
                
                ]
            ];
       }
       return json($arr);
    }
     /**
    * 机构详情
    *
    * @return void
    */
    public function organ_detail()
    {
        $id=input("id");

        $re=db("organ")->where("id",$id)->find();

        $url=parent::getUrl();

        if($re['uid'] != 0){
            $image=explode(",",$re['image']);

            foreach($image as $v){
                $images[]=$url.$v;
            }
            $re['image']=$images;
        }

        $re['logo']=$url.$re['logo'];

        $re['age']=db("organ_type")->where(["id"=>$re['yid']])->find()['name'];

        $re['people']=db("organ_type")->where(["id"=>$re['pid']])->find()['name'];

        $re['job']=db("job")->field("id,name,addr,age,edu,money")->where(["fid"=>$id,"status"=>2])->select();



        $arr=[
            'error_code'=>0,
            'msg'=>'获取成功',
            'data'=>$re
        ];

        return json($arr);
    }
     
}