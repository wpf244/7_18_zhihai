<?php
namespace app\admin\controller;

use think\Db;

class Dancer extends BaseAdmin
{
    public function type()
    {
        $type=input("type");

        if(empty($type)){
            $type=1;
        }

        $this->assign("type",$type);

        $list=db("dancer_type")->where("type",$type)->select();

        $this->assign("list",$list);
        
        return $this->fetch();
    }
    public function save(){
        $id=\input('id');
        $data=input("post.");
        if($id){
            $re=db('dancer_type')->where("id=$id")->find();
            if(request()->file("image")){
                $data['image']=uploads("image");
            }else{
                $data['image']=$re['image'];
            }
           $res=db('dancer_type')->where("id=$id")->update($data);
           if($res){
               $this->success("修改成功！");
           }else{
               $this->error("修改失败！");
           }
        }else{
            if(request()->file("image")){
                $data['image']=uploads("image");
            }
            $re=db('dancer_type')->insert($data);
            if($re){
                $this->success("添加成功！");
            }else{
                $this->error("添加失败！");
            } 
        }
         
    }
    public function modifys(){
        $id=input("id");
        $re=db('dancer_type')->where("id=$id")->find();
        echo json_encode($re);
    }
    public function delete(){
        $id=input('id');
        $re=db("dancer_type")->where("id=$id")->find();
        if($re){
           $del=db("dancer_type")->where("id=$id")->delete();
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

        $list=db("dancer")->where(["status"=>$status])->order(["sort asc","id asc"])->paginate("20");

        $this->assign("list",$list);

        $page=$list->render();

        $this->assign("page",$page);

        return $this->fetch();
    } 
    public function looks()
    {
        $id=input("id");

        $re=db("dancer")->where("id",$id)->find();

        $this->assign("re",$re);

        $re['major']=db("dancer_type")->where("id",$re['major'])->find()['name'];

        $re['edu']=db("dancer_type")->where("id",$re['edu'])->find()['name'];

        $re['tag']=explode(",",$re['tag']);

        $tags=db("dancer_type")->where("id","in",$re['tag'])->select();

        $name='';
        foreach($tags as $v){
            $name.=$v['name'].',';
        }
        $re['tag']=$name;

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

        $re=db("dancer")->where("id",$id)->find();

        if($re){
            
            $res=db("dancer")->where("id",$id)->setField("status",3);

            echo '0';

        }else{
            echo '1';
        }
    }
    public function deletes()
    {
        $id=\input('id');
        $re=db("dancer")->where("id=$id")->find();
        if($re){
            $res=db("dancer")->where("id=$id")->delete();
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

        $re=db("dancer")->where("id",$id)->find();
 
        if($re){

            // 启动事务
            Db::startTrans();
            try{
               if($re['uid'] != 0){
                   $data['birth']=$re['birth'];
                   $data['phone']=$re['phone'];

                   db("user")->where("uid",$re['uid'])->update($data);
               }

               db("dancer")->where("id",$id)->setField("status",2);
                
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
            db("dancer")->where(array('id' => $id ))->setField('sort' , $sort);
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

            $re=db("dancer")->where("id",$id)->find();

            if(request()->file("image")){
                $data['image']=uploads("image");
            }else{
                $data['image']=$re['image'];
            }
            $data['tag']=\implode(",",$data['tag']);

            $res=db("dancer")->where("id",$id)->update($data);

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

            $data['status']=2;

            $re=db("dancer")->insert($data);

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

        $re=db("dancer")->where("id",$id)->find();

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
}