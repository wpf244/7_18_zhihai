<?php
namespace app\admin\controller;

class First extends BaseAdmin
{
    public function gl()
    {
        if(request()->isAjax()){

            $data=input("post.");

            $re=db("first")->where("fid",1)->find();
            
            
            $res=db("first")->where("fid",1)->update($data);

            if($res){
                $this->success("修改成功");
            }else{
                $this->error("修改失败");
            }

        }else{
            $re=db("first")->where("fid",1)->find();

            $this->assign("re",$re);

            return $this->fetch();
        }
    }
    public function lister()
    {
        $list=db("first")->where(["fid"=>2])->order(["sort asc","id desc"])->select();

        $this->assign("list",$list);

        
        
        return $this->fetch();
    }
   
    public function save_s(){
        $id=\input('id');
        $data=input("post.");
        if($id){
           $re=db('first')->where("id=$id")->find();
           if(request()->file("image")){
               $data['image']=uploads("image");
              
           }else{
                $data['image']=$re['image'];
           }
           
           $res=db('first')->where("id=$id")->update($data);
           if($res){
               $this->success("修改成功！");
           }else{
               $this->error("修改失败！");
           }
        }else{
            if(request()->file("image")){
                $data['image']=uploads("image");
            }
            
            $re=db('first')->insert($data);
            if($re){
                $this->success("添加成功！");
            }else{
                $this->error("添加失败！");
            } 
        }
         
    }
    public function modifys_s(){
        $id=input("id");
        $re=db('first')->where("id=$id")->find();
        echo json_encode($re);
    }
    public function delete_s(){
        $id=input('id');
        $re=db("first")->where("id=$id")->find();
        if($re){
           $del=db("first")->where("id=$id")->delete();
           if($del){
               echo '1';
           }else{
               echo '2';
           }
        }else{
            echo '0';
        }
       
    }
    public function sorts_s(){
        $data=input('post.');
        foreach ($data as $id => $sort){
            db('first')->where(array('id' => $id ))->setField('sort' , $sort);
        }
        $this->redirect('lister');
    }
    public function money()
    {
        if(request()->isAjax()){

            $data=input("post.");

            $re=db("first")->where("fid",3)->find();
            
            
            $res=db("first")->where("fid",3)->update($data);

            if($res){
                $this->success("修改成功");
            }else{
                $this->error("修改失败");
            }

        }else{
            $re=db("first")->where("fid",3)->find();

            $this->assign("re",$re);

            return $this->fetch();
        }
    }
    public function papers()
    {
        if(request()->isAjax()){

            $data=input("post.");

            $re=db("first")->where("fid",4)->find();
            if(request()->file("image")){
                $data['image']=uploads("image");
               
            }else{
                 $data['image']=$re['image'];
            }
            
            $res=db("first")->where("fid",4)->update($data);

            if($res){
                $this->success("修改成功");
            }else{
                $this->error("修改失败");
            }

        }else{
            $re=db("first")->where("fid",4)->find();

            $this->assign("re",$re);

            return $this->fetch();
        }
    }
    public function help()
    {
        if(request()->isAjax()){

            $data=input("post.");

            $re=db("first")->where("fid",5)->find();
            if(request()->file("image")){
                $data['image']=uploads("image");
               
            }else{
                 $data['image']=$re['image'];
            }
            
            $res=db("first")->where("fid",5)->update($data);

            if($res){
                $this->success("修改成功");
            }else{
                $this->error("修改失败");
            }

        }else{
            $re=db("first")->where("fid",5)->find();

            $this->assign("re",$re);

            return $this->fetch();
        }
    }
}