<?php
namespace app\api\controller;

class Index  extends BaseApi
{
    public function index()
    {
        $url=parent::getUrl();
        //轮播图
        $banner=db("lb")->field("id,url,image")->where(["fid"=>1,"status"=>1])->order(["sort asc","id desc"])->select();

        foreach($banner as &$vb){
            $vb['image']=$url.$vb['image'];
        }

        //分类
        $type=db("dancer_type")->where(["type"=>3])->order("id asc")->select();

        foreach($type as &$vt){
            $vt['image']=$url.$vt['image'];
        }

        //优秀老师
        $teacher=db("teacher")->field("id,image")->where(["status"=>1,"recome"=>1])->order(["sort asc","id desc"])->limit(10)->select();

        foreach($teacher as &$vts){
            $vts['image']=$url.$vts['image'];
        }

        //新闻资讯
        $news=db("news")->field("id,title,image,marray,time")->where(["status"=>1,"groom"=>1])->order(["sort asc","id desc"])->limit(10)->select();

        foreach($news as &$vn){
            $vn['image']=$url.$vn['image'];
        }



        $arr=[
            'error_code'=>0,
            'msg'=>'获取成功',
            'data'=>[
                'banner'=>$banner,
                'type'=>$type,
                'teacher'=>$teacher,
                'news'=>$news
            ]
        ];

        return json($arr);
    }
    /**
    * 优秀老师
    *
    * @return void
    */
    public function teacher()
    {
        $url=parent::getUrl();
        
        //全部
        $res=db("teacher")->field("id,username,addr,age,tag,image")->where(["status"=>1])->order(["sort asc","id desc"])->select();

        foreach($res as  &$v){

            $v['image']=$url.$v['image'];
          
           $tag=explode(",",$v['tag']);
           $v['tag']=db("dancer_type")->field("name")->where("type",3)->where("id","in",$tag)->select();
        }
        //新入

        $news=db("teacher")->field("id,username,addr,age,tag,image")->where(["status"=>1,"news"=>1])->order(["sort asc","id desc"])->select();

        foreach($news as  &$n){

            $n['image']=$url.$n['image'];
          
           $tag=explode(",",$n['tag']);
           $n['tag']=db("dancer_type")->field("name")->where("type",3)->where("id","in",$tag)->select();
        }

        //最热
        $hot=db("teacher")->field("id,username,addr,age,tag,image")->where(["status"=>1,"hot"=>1])->order(["sort asc","id desc"])->select();

        foreach($hot as  &$h){

            $h['image']=$url.$h['image'];
          
           $tag=explode(",",$h['tag']);
           $h['tag']=db("dancer_type")->field("name")->where("type",3)->where("id","in",$tag)->select();
        }

        $arr=[
            'error_code'=>0,
            'msg'=>'获取成功',
            'data'=>[
                'all'=>$res,
                'news'=>$news,
                'hot'=>$hot,
              
            ]
        ];
        return json($arr);
    }
   
    /**
    * 新闻列表
    *
    * @return void
    */
    public function news()
    {
        
        $url=parent::getUrl();

        //新闻资讯
        $news=db("news")->field("id,title,image,marray,time")->where(["status"=>1])->order(["sort asc","id desc"])->limit(10)->select();

        foreach($news as &$vn){
            $vn['image']=$url.$vn['image'];
        }

        $arr=[
            'error_code'=>0,
            'msg'=>'获取成功',
            'data'=>$news
        ];
        return json($arr);
    }
   
    /**
    * 分类
    *
    * @return void
    */
    public function type()
    {
        $type=db("dancer_type")->field("id,name")->where("type",3)->order("id asc")->select();

        $edu=db("dancer_type")->field("id,name")->where("type",2)->order("id asc")->select();

        $major=db("dancer_type")->field("id,name")->where("type",1)->order("id asc")->select();

        $arr=[
            'error_code'=>0,
            'msg'=>'获取成功',
            'data'=>[
                'type'=>$type,
                'edu'=>$edu,
                'major'=>$major,
            ]
        ];
        return json($arr);
    }
    /**
    * 分类列表
    *
    * @return void
    */
    public function type_lister()
    {
        $tid=input("tid");

        $eid=input("eid");

        $mid=input("mid");

        $addr=input("addr");

        $keywords=input("keywords");

        $map=[];

        if($eid){
            $map['edu']=['eq',$eid];
        }
        if($mid){
            $map['major']=['eq',$mid];
        }
        if($addr){
            $map['addr']=['like',"%".$addr."%"];
        }
        if($keywords){
            $re=db("dancer_type")->where("type",3)->where("name","like","%".$keywords."%")->find();

            if($re){
                $tid=$re['id'];
            }
        }



        if($tid){

            $res=db("dancer")->field("id,uid,username,addr,age,tag,image")->where(["status"=>2])->where($map)->where("FIND_IN_SET($tid,tag)")->order(["sort asc","id desc"])->select();
        }else{
            $res=db("dancer")->field("id,uid,username,addr,age,tag,image")->where(["status"=>2])->where($map)->order(["sort asc","id desc"])->select();
        }

        $url=parent::getUrl();

        foreach($res as  &$v){

            if($v['uid'] == 0){

                $v['image']=$url.$v['image'];

            }else{
                $v['image']=db("user")->where("uid",$v['uid'])->find()['image'];
            }
 
           $tag=explode(",",$v['tag']);
           $v['tag']=db("dancer_type")->field("name")->where("type",3)->where("id","in",$tag)->select();
        }

        $arr=[
            'error_code'=>0,
            'msg'=>'获取成功',
            'data'=>$res
        ];
        return json($arr);

    }
    
    /**
    * 搜索推荐
    *
    * @return void
    */
    public function search()
    {
        $res=db("lb")->field("name")->where(["fid"=>2,"status"=>1])->order(["sort asc","id desc"])->select();

        $arr=[
            'error_code'=>0,
            'msg'=>'获取成功',
            'data'=>$res
        ];
        return json($arr);
    }
    /**
    * 上传图片
    *
    * @return void
    */
    public function add_img()
    {
        if(request()->file("image")){
            $image=uploads('image');

            if($image){
                $arr=[
                    'error_code'=>0,
                    'msg'=>"上传成功",
                    'data'=>$image
                ]; 
            }else{
                 $arr=[
                    'error_code'=>1,
                    'msg'=>"上传失败",
                    'data'=>''
                ]; 
            }
        }else{
             $arr=[
                'error_code'=>1,
                'msg'=>"上传失败",
                'data'=>''
            ]; 
        }
        
        return json($arr);
    }























}
