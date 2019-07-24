<?php
namespace app\admin\controller;

use think\Db;

class Organ extends BaseAdmin
{
    public function type()
    {
        $type=input("type");

        if(empty($type)){
            $type=1;
        }

        $this->assign("type",$type);

        $list=db("organ_type")->where("type",$type)->select();

        $this->assign("list",$list);
        
        return $this->fetch();
    }
    public function save(){
        $id=\input('id');
        $data=input("post.");
        if($id){
            $re=db('organ_type')->where("id=$id")->find();
            if(request()->file("image")){
                $data['image']=uploads("image");
            }else{
                $data['image']=$re['image'];
            }
           $res=db('organ_type')->where("id=$id")->update($data);
           if($res){
               $this->success("修改成功！");
           }else{
               $this->error("修改失败！");
           }
        }else{
            if(request()->file("image")){
                $data['image']=uploads("image");
            }
            $re=db('organ_type')->insert($data);
            if($re){
                $this->success("添加成功！");
            }else{
                $this->error("添加失败！");
            } 
        }
         
    }
    public function modifys(){
        $id=input("id");
        $re=db('organ_type')->where("id=$id")->find();
        echo json_encode($re);
    }
    public function delete(){
        $id=input('id');
        $re=db("organ_type")->where("id=$id")->find();
        if($re){
           $del=db("organ_type")->where("id=$id")->delete();
           if($del){
               echo '1';
           }else{
               echo '2';
           }
        }else{
            echo '0';
        }     
    }
    public function lister()
    {
        $status=input("status");

        if(empty($status)){
            $status=2;
        }
        $this->assign("status",$status);

        $list=db("organ")->alias("a")->field("a.*,b.name as age,c.name as people")->where(["status"=>$status])->join("organ_type b","a.yid=b.id")->join("organ_type c","a.pid=c.id")->order(["sort asc","a.id asc"])->paginate("20");

        $this->assign("list",$list);

        $page=$list->render();

        $this->assign("page",$page);

        return $this->fetch();
    }
    public function looks()
    {
        $id=input("id");

        $re=db("organ")->where("id",$id)->find();

        

        $re['age']=db("organ_type")->where("id",$re['yid'])->find()['name'];

        $re['people']=db("organ_type")->where("id",$re['pid'])->find()['name'];

        $arr=explode(",",$re['image']);

        $this->assign("arr",$arr);

        

        $this->assign("re",$re);

        return $this->fetch();
    }
     /**
    * 驳回申请
    *
    * @return void
    */
    public function bo()
    {
        $id=input("id");

        $re=db("organ")->where("id",$id)->find();

        if($re){
            
            $res=db("organ")->where("id",$id)->setField("status",3);

            echo '0';

        }else{
            echo '1';
        }
    }
    public function deletes()
    {
        $id=\input('id');
        $re=db("organ")->where("id=$id")->find();
        if($re){
            $res=db("organ")->where("id=$id")->delete();
            if($res){
                echo '0';
            }else{
                echo '2';
            }
        }else{
            echo '1';
        }
    }
     /**
    * 通过申请
    *
    * @return void
    */
    public function tong()
    {
        $id=input("id");

        $re=db("organ")->where("id",$id)->find();
 
        if($re){

            // 启动事务
            Db::startTrans();
            try{
               if($re['uid'] != 0){
                   $data['addr']=$re['addr'];
                   $data['phone']=$re['phone'];
                   $data['company']=$re['name'];
                   $data['level']=2;

                   db("user")->where("uid",$re['uid'])->update($data);
               }

               db("organ")->where("id",$id)->setField("status",2);
                
                // 提交事务
               Db::commit();   
                echo '0'; 
            } catch (\Exception $e) {
                // 回滚事务
                Db::rollback();

                echo '1';
            }
            

        }else{
            echo '1';
        }

    }
    public function sort(){
        $data=input('post.');
   
        foreach ($data as $id => $sort){
            db("organ")->where(array('id' => $id ))->setField('sort' , $sort);
        }
        $this->redirect('lister');
    }
    public function add()
    {
        //办学年限
        $age=db("organ_type")->where("type",1)->select();

        $this->assign("age",$age);

        //人员规模
        $people=db("organ_type")->where("type",2)->select();

        $this->assign("people",$people);


        
        
        return $this->fetch();
    }
    public function saves()
    {
        $id=input("id");

        $data=input("post.");

        if($id){

            $re=db("organ")->where("id",$id)->find();

            if(request()->file("logo")){
                $data['logo']=uploads("logo");
            }else{
                $data['logo']=$re['logo'];
            }
      

            $res=db("organ")->where("id",$id)->update($data);

            if($res){
                $this->success("修改成功",url("lister"));
            }else{
                $this->error("修改失败");
            }

        }else{
            if(request()->file("logo")){
                $data['logo']=uploads("logo");
            }
           
            $data['time']=time();

            $data['status']=2;

            $re=db("organ")->insert($data);

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

        $re=db("organ")->where("id",$id)->find();

        $this->assign("re",$re);

        //办学年限
        $age=db("organ_type")->where("type",1)->select();

        $this->assign("age",$age);

        //人员规模
        $people=db("organ_type")->where("type",2)->select();

        $this->assign("people",$people);
        
        return $this->fetch();
    }
    public function changes()
    {
        $id=\input('id');
        $re=db("organ")->where("id=$id")->find();
        if($re){
            if($re['recome'] == 1){
                $res=db("organ")->where("id=$id")->setField("recome",0);
            }
           
            if($re['recome'] == 0){
                $res=db("organ")->where("id=$id")->setField("recome",1);
            }

            echo '0';
        }else{
            echo '1';
        }
    }
    public function changen()
    {
        $id=\input('id');
        $re=db("organ")->where("id=$id")->find();
        if($re){
            if($re['near'] == 1){
                $res=db("organ")->where("id=$id")->setField("near",0);
            }
           
            if($re['near'] == 0){
                $res=db("organ")->where("id=$id")->setField("near",1);
            }

            echo '0';
        }else{
            echo '1';
        }
    }
    public function changeh()
    {
        $id=\input('id');
        $re=db("organ")->where("id=$id")->find();
        if($re){
            if($re['goods'] == 1){
                $res=db("organ")->where("id=$id")->setField("goods",0);
            }
           
            if($re['goods'] == 0){
                $res=db("organ")->where("id=$id")->setField("goods",1);
            }

            echo '0';
        }else{
            echo '1';
        }
    }
    public function job()
    {
        
        $id=input("id");

        $this->assign("id",$id);

        $status=input("status");

        if(empty($status)){

            $status=2;

        }

       

        $this->assign("status",$status);

        $list=db("job")->where(["status"=>$status,"fid"=>$id])->select();

        $this->assign("list",$list);
        
        return $this->fetch();
    }
     /**
    * 驳回申请
    *
    * @return void
    */
    public function bo_job()
    {
        $id=input("id");

        $re=db("job")->where("id",$id)->find();

        if($re){
            
            $res=db("job")->where("id",$id)->setField("status",3);

            echo '0';

        }else{
            echo '1';
        }
    }
    public function deletes_job()
    {
        $id=\input('id');
        $re=db("job")->where("id=$id")->find();
        if($re){
            $res=db("job")->where("id=$id")->delete();
            if($res){
                echo '0';
            }else{
                echo '2';
            }
        }else{
            echo '1';
        }
    }
     /**
    * 通过申请
    *
    * @return void
    */
    public function tong_job()
    {
        $id=input("id");

        $re=db("job")->where("id",$id)->find();
 
        if($re){

            

               db("job")->where("id",$id)->setField("status",2);
                
             
               echo '0';

        }else{
            echo '1';
        }

    }
    public function modifys_job(){
        $id=input("id");
        $re=db('job')->where("id=$id")->find();
        echo json_encode($re);
    }
    public function save_job(){
        $id=\input('id');
        $data=input("post.");
        if($id){
            $re=db('job')->where("id=$id")->find();

            if($re['status'] == 3){
                $data['status']=1;
            }
           
           $res=db('job')->where("id=$id")->update($data);
           if($res){
               $this->success("修改成功！");
           }else{
               $this->error("修改失败！");
           }
        }else{
            $data['time']=time();
            $data['status']=2;
            $re=db('job')->insert($data);
            if($re){
                $this->success("添加成功！");
            }else{
                $this->error("添加失败！");
            } 
        }
         
    }



















}