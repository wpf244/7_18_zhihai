<?php
namespace app\admin\controller;

class Teacher extends BaseAdmin
{
    public function lister()
    {
        $list=db("teacher")->order(["sort asc","id asc"])->paginate("20");

        $this->assign("list",$list);

        $page=$list->render();

        $this->assign("page",$page);
        
        return $this->fetch();
    }
    public function looks()
    {
        $id=input("id");

        $re=db("teacher")->where("id",$id)->find();

       

        $re['major']=db("dancer_type")->where("id",$re['major'])->find()['name'];

        $re['edu']=db("dancer_type")->where("id",$re['edu'])->find()['name'];

        $re['tag']=explode(",",$re['tag']);

        $tags=db("dancer_type")->where("id","in",$re['tag'])->select();

        $name='';
        foreach($tags as $v){
            $name.=$v['name'].',';
        }
        $re['tag']=$name;

      //  $re['age']=$this->getAge(strtotime($re['birth']));

        $this->assign("re",$re);

        return $this->fetch();
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

    public function sort(){
        $data=input('post.');
   
        foreach ($data as $id => $sort){
            db("teacher")->where(array('id' => $id ))->setField('sort' , $sort);
        }
        $this->redirect('lister');
    }
    public function add()
    {
        //专业
        $major=db("dancer_type")->where("type",1)->select();

        $this->assign("major",$major);

        //学历
        $edu=db("dancer_type")->where("type",2)->select();

        $this->assign("edu",$edu);

        //职业标签
        $tag=db("dancer_type")->where("type",3)->select();

        $this->assign("tag",$tag);

        
        
        return $this->fetch();
    }
    public function saves()
    {
        $id=input("id");

        $data=input("post.");

        if($id){

            $re=db("teacher")->where("id",$id)->find();

            if(request()->file("image")){
                $data['image']=uploads("image");
            }else{
                $data['image']=$re['image'];
            }
            $data['tag']=\implode(",",$data['tag']);

            $res=db("teacher")->where("id",$id)->update($data);

            if($res){
                $this->success("修改成功",url("lister"));
            }else{
                $this->error("修改失败");
            }

        }else{
            if(request()->file("image")){
                $data['image']=uploads("image");
            }
            $data['tag']=\implode(",",$data['tag']);

            $data['time']=time();

         

            $re=db("teacher")->insert($data);

            if($re){
                $this->success("保存成功",url("lister"));
            }else{
                $this->error("保存失败");
            }
        }
    }
    public function modify()
    {
        $id=input("id");

        $re=db("teacher")->where("id",$id)->find();

        $this->assign("re",$re);

        //专业
        $major=db("dancer_type")->where("type",1)->select();

        $this->assign("major",$major);

        //学历
        $edu=db("dancer_type")->where("type",2)->select();

        $this->assign("edu",$edu);

        //职业标签
        $tag=db("dancer_type")->where("type",3)->select();

        $this->assign("tag",$tag);

        $tags=\explode(",",$re['tag']);

        $this->assign("tags",$tags);
        
        return $this->fetch();
    }
    public function deletes()
    {
        $id=\input('id');
        $re=db("teacher")->where("id=$id")->find();
        if($re){
            $res=db("teacher")->where("id=$id")->delete();
            if($res){
                echo '0';
            }else{
                echo '2';
            }
        }else{
            echo '1';
        }
    }
    public function change()
    {
        $id=\input('id');
        $re=db("teacher")->where("id=$id")->find();
        if($re){
            if($re['status'] == 1){
                $res=db("teacher")->where("id=$id")->setField("status",0);
            }
           
            if($re['status'] == 0){
                $res=db("teacher")->where("id=$id")->setField("status",1);
            }

            echo '0';
        }else{
            echo '1';
        }
    }
    public function changes()
    {
        $id=\input('id');
        $re=db("teacher")->where("id=$id")->find();
        if($re){
            if($re['recome'] == 1){
                $res=db("teacher")->where("id=$id")->setField("recome",0);
            }
           
            if($re['recome'] == 0){
                $res=db("teacher")->where("id=$id")->setField("recome",1);
            }

            echo '0';
        }else{
            echo '1';
        }
    }
    public function changen()
    {
        $id=\input('id');
        $re=db("teacher")->where("id=$id")->find();
        if($re){
            if($re['news'] == 1){
                $res=db("teacher")->where("id=$id")->setField("news",0);
            }
           
            if($re['news'] == 0){
                $res=db("teacher")->where("id=$id")->setField("news",1);
            }

            echo '0';
        }else{
            echo '1';
        }
    }
    public function changeh()
    {
        $id=\input('id');
        $re=db("teacher")->where("id=$id")->find();
        if($re){
            if($re['hot'] == 1){
                $res=db("teacher")->where("id=$id")->setField("hot",0);
            }
           
            if($re['hot'] == 0){
                $res=db("teacher")->where("id=$id")->setField("hot",1);
            }

            echo '0';
        }else{
            echo '1';
        }
    }



















}