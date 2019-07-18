<?php
namespace app\admin\controller;

class Trans extends BaseAdmin
{
    public function brief()
    {
        
        if(request()->isAjax()){

            $data=input("post.");

            $re=db("trans")->where("id",1)->find();
            
            if(request()->file("image")){
                 $data['image']=uploads("image");
            }else{
                $data['image']=$re['image'];
            }
            $res=db("trans")->where("id",1)->update($data);

            if($res){
                $this->success("修改成功");
            }else{
                $this->error("修改失败");
            }

        }else{
            $re=db("trans")->where("id",1)->find();

            $this->assign("re",$re);

            return $this->fetch();
        }

        
    }
    public function sever()
    {
        $list=db("trans")->where(["fid"=>2])->order(["sort asc","id desc"])->select();

        $this->assign("list",$list);

        
        
        return $this->fetch();
    }
   
    public function save_s(){
        $id=\input('id');
        $data=input("post.");
        if($id){
           $re=db('trans')->where("id=$id")->find();
           if(request()->file("image")){
               $data['image']=uploads("image");
              
           }else{
                $data['image']=$re['image'];
           }
           
           $res=db('trans')->where("id=$id")->update($data);
           if($res){
               $this->success("修改成功！");
           }else{
               $this->error("修改失败！");
           }
        }else{
            if(request()->file("image")){
                $data['image']=uploads("image");
            }
            
            $re=db('trans')->insert($data);
            if($re){
                $this->success("添加成功！");
            }else{
                $this->error("添加失败！");
            } 
        }
         
    }
    public function modifys_s(){
        $id=input("id");
        $re=db('trans')->where("id=$id")->find();
        echo json_encode($re);
    }
    public function delete_s(){
        $id=input('id');
        $re=db("trans")->where("id=$id")->find();
        if($re){
           $del=db("trans")->where("id=$id")->delete();
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
            db('trans')->where(array('id' => $id ))->setField('sort' , $sort);
        }
        $this->redirect('sever');
    }
    public function delete_all(){
        $id=input('id');
        $arr=explode(",", $id);
        foreach ($arr as $v){
            $re=db('trans')->where("id=$v")->find();
            if($re){
                $del=db('trans')->where("id=$v")->delete();
        }
        
       }
       $this->redirect('sever');
    }
    public function langs()
    {
        
        if(request()->isAjax()){

            $data=input("post.");

            $re=db("trans")->where("fid",3)->find();
            
            if(request()->file("image")){
                 $data['image']=uploads("image");
            }else{
                $data['image']=$re['image'];
            }
            $res=db("trans")->where("fid",3)->update($data);

            if($res){
                $this->success("修改成功");
            }else{
                $this->error("修改失败");
            }

        }else{
            $re=db("trans")->where("fid",3)->find();

            $this->assign("re",$re);

            return $this->fetch();
        }

        
    }
    //服务保障
    public function ensure()
    {
        $list=db("trans")->where(["fid"=>4])->order(["sort asc","id desc"])->select();

        $this->assign("list",$list);

        
        
        return $this->fetch();
    }
    public function save_e(){
        $id=\input('id');
        $data=input("post.");
        if($id){
           $re=db('trans')->where("id=$id")->find();
           if(request()->file("image")){
               $data['image']=uploads("image");
              
           }else{
                $data['image']=$re['image'];
           }
           
           $res=db('trans')->where("id=$id")->update($data);
           if($res){
               $this->success("修改成功！");
           }else{
               $this->error("修改失败！");
           }
        }else{
            if(request()->file("image")){
                $data['image']=uploads("image");
            }
            
            $re=db('trans')->insert($data);
            if($re){
                $this->success("添加成功！");
            }else{
                $this->error("添加失败！");
            } 
        }
         
    }
    public function modifys_e(){
        $id=input("id");
        $re=db('trans')->where("id=$id")->find();
        echo json_encode($re);
    }
    public function delete_e(){
        $id=input('id');
        $re=db("trans")->where("id=$id")->find();
        if($re){
           $del=db("trans")->where("id=$id")->delete();
           if($del){
               echo '1';
           }else{
               echo '2';
           }
        }else{
            echo '0';
        }
       
    }
    public function sorts_e(){
        $data=input('post.');
        foreach ($data as $id => $sort){
            db('trans')->where(array('id' => $id ))->setField('sort' , $sort);
        }
        $this->redirect('ensure');
    }
    //翻译流程
    public function proce()
    {
        
        if(request()->isAjax()){

            $data=input("post.");

            $re=db("trans")->where("fid",5)->find();
            
            if(request()->file("image")){
                 $data['image']=uploads("image");
            }else{
                $data['image']=$re['image'];
            }
            if(request()->file("images")){
                $data['images']=uploads("images");
           }else{
               $data['images']=$re['images'];
           }
            $res=db("trans")->where("fid",5)->update($data);

            if($res){
                $this->success("修改成功");
            }else{
                $this->error("修改失败");
            }

        }else{
            $re=db("trans")->where("fid",5)->find();

            $this->assign("re",$re);

            return $this->fetch();
        }

        
    }
    //简介
    public function offer()
    {
        
        if(request()->isAjax()){

            $data=input("post.");

            $re=db("about")->where("id",4)->find();
            
            if(request()->file("image")){
                 $data['image']=uploads("image");
            }else{
                $data['image']=$re['image'];
            }
            $res=db("about")->where("id",4)->update($data);

            if($res){
                $this->success("修改成功");
            }else{
                $this->error("修改失败");
            }

        }else{
            $re=db("about")->where("id",4)->find();

            $this->assign("re",$re);

            return $this->fetch();
        }

        
    }
    //列表
    public function lister()
    {
        $list=db("cases")->order(["sort asc","id desc"])->paginate(20);

        $this->assign("list",$list);

        
        
        return $this->fetch();
    }
    public function save(){
        $id=\input('id');
        $data=input("post.");
        if($id){
            $re=db('cases')->where("id=$id")->find();
            if(request()->file("image")){
                $data['image']=uploads("image");
           }else{
               $data['image']=$re['image'];
           }
           
           $res=db('cases')->where("id=$id")->update($data);
           if($res){
               $this->success("修改成功！");
           }else{
               $this->error("修改失败！");
           }
        }else{
            if(request()->file("image")){
                $data['image']=uploads("image");
           }
           $data['time']=time();
            
            $re=db('cases')->insert($data);
            if($re){
                $this->success("添加成功！");
            }else{
                $this->error("添加失败！");
            } 
        }
         
    }
    public function modifys(){
        $id=input("id");
        $re=db('cases')->where("id=$id")->find();
        echo json_encode($re);
    }
    public function delete(){
        $id=input('id');
        $re=db("cases")->where("id=$id")->find();
        if($re){
           $del=db("cases")->where("id=$id")->delete();
           if($del){
               echo '1';
           }else{
               echo '2';
           }
        }else{
            echo '0';
        }
       
    }
    public function sorts(){
        $data=input('post.');
        foreach ($data as $id => $sort){
            db('cases')->where(array('id' => $id ))->setField('sort' , $sort);
        }
        $this->redirect('lister');
    }
    public function tips()
    {
        
        if(request()->isAjax()){

            $data=input("post.");
            $re=db("about")->where("id",5)->find();
            if(request()->file("image")){
                $data['image']=uploads("image");
           }else{
               $data['image']=$re['image'];
           }
            $res=db("about")->where("id",5)->update($data);

            if($res){
                $this->success("修改成功");
            }else{
                $this->error("修改失败");
            }

        }else{
            $re=db("about")->where("id",5)->find();

            $this->assign("re",$re);

            return $this->fetch();
        }

        
    }

}