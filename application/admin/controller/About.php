<?php
namespace app\admin\controller;

class About extends BaseAdmin
{
    public function company()
    {
        if(request()->isAjax()){
            $data=input("post.");
            $re=db("about")->where("id",1)->find();
            if(\request()->file('image')){
                $data['image']=uploads("image");
            }else{
                $data['image']=$re['image'];
            }
            $res=db("about")->where("id",1)->update($data);

            if($res){
                $this->success("修改成功");
            }else{
                $this->error("修改失败");
            }
        }else{
            $re=db("about")->where("id",1)->find();

            $this->assign("re",$re);
            
            return $this->fetch();
        }
        
      
    }
    public function curture()
    {
        if(request()->isAjax()){
            $data=input("post.");
            $re=db("about")->where("id",2)->find();
            if(\request()->file('image')){
                $data['image']=uploads("image");
            }else{
                $data['image']=$re['image'];
            }
            $res=db("about")->where("id",2)->update($data);

            if($res){
                $this->success("修改成功");
            }else{
                $this->error("修改失败");
            }
        }else{
            $re=db("about")->where("id",2)->find();

            $this->assign("re",$re);
            
            return $this->fetch();
        }
        
      
    }
    public function photos()
    {
        if(request()->isAjax()){
            $data=input("post.");
            $re=db("about")->where("id",3)->find();
            if(\request()->file('image')){
                $data['image']=uploads("image");
            }else{
                $data['image']=$re['image'];
            }
            if(\request()->file('images')){
                $data['images']=uploads("images");
            }else{
                $data['images']=$re['images'];
            }
            $res=db("about")->where("id",3)->update($data);

            if($res){
                $this->success("修改成功");
            }else{
                $this->error("修改失败");
            }
        }else{
            $re=db("about")->where("id",3)->find();

            $this->assign("re",$re);
            
            return $this->fetch();
        }
        
      
    }
  
    /**
    * 资质荣誉
    *
    * @return void
    */
    public function honor()
    {
        $list=db("honor")->where(["type"=>1])->order(["sort asc","id desc"])->paginate(20);

        $this->assign("list",$list);

        $page=$list->render();

        $this->assign("page",$page);
        
        return $this->fetch();
    }
    public function save_cs(){
        $id=\input('id');
        $data=input("post.");
        if($id){
           $re=db('honor')->where("id=$id")->find();
           if(request()->file("image")){
               $data['image']=uploads("image");
              
           }else{
                $data['image']=$re['image'];
           }
           
           $res=db('honor')->where("id=$id")->update($data);
           if($res){
               $this->success("修改成功！");
           }else{
               $this->error("修改失败！");
           }
        }else{
            if(request()->file("image")){
                $data['image']=uploads("image");
            }
            
            $re=db('honor')->insert($data);
            if($re){
                $this->success("添加成功！");
            }else{
                $this->error("添加失败！");
            } 
        }
         
    }
    public function modifys_s(){
        $id=input("id");
        $re=db('honor')->where("id=$id")->find();
        echo json_encode($re);
    }
    public function delete_cs(){
        $id=input('id');
        $re=db("honor")->where("id=$id")->find();
        if($re){
           $del=db("honor")->where("id=$id")->delete();
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
            db('honor')->where(array('id' => $id ))->setField('sort' , $sort);
        }
        $this->redirect('honor');
    }
    public function delete_all(){
        $id=input('id');
        $arr=explode(",", $id);
        foreach ($arr as $v){
            $re=db('honor')->where("id=$v")->find();
            if($re){
                $del=db('honor')->where("id=$v")->delete();
        }
        
       }
       $this->redirect('honor');
    }
    public function change(){
        $id=input('id');
        $re=db('honor')->where("id=$id")->find();
        if($re){
            if($re['status'] == 0){
                $res=db('honor')->where("id=$id")->setField("status",1);
            }
            if($re['status'] == 1){
                $res=db('honor')->where("id=$id")->setField("status",0);
    
            }
            echo '0';
        }else{
            echo '1';
        }
    }
    /**
    * 公司图片
    *
    * @return void
    */
    public function photo()
    {
        $list=db("honor")->where(["type"=>2])->order(["sort asc","id desc"])->paginate(20);

        $this->assign("list",$list);

        $page=$list->render();

        $this->assign("page",$page);
        
        return $this->fetch();
    }
    public function sorts_p(){
        $data=input('post.');
        foreach ($data as $id => $sort){
            db('honor')->where(array('id' => $id ))->setField('sort' , $sort);
        }
        $this->redirect('photo');
    }
    public function delete_alls(){
        $id=input('id');
        $arr=explode(",", $id);
        foreach ($arr as $v){
            $re=db('honor')->where("id=$v")->find();
            if($re){
                $del=db('honor')->where("id=$v")->delete();
        }
        
       }
       $this->redirect('photo');
    }
    /**
    * 案例分类
    *
    * @return void
    */
    public function type()
    {
        $list=db("cases_type")->order(["sort asc","id desc"])->select();

        $this->assign("list",$list);
        
        return $this->fetch();
    }
    public function save_t(){
        $id=\input('id');
        $data=input("post.");
        if($id){
           $re=db('cases_type')->where("id=$id")->find();
          
           
           $res=db('cases_type')->where("id=$id")->update($data);
           if($res){
               $this->success("修改成功！");
           }else{
               $this->error("修改失败！");
           }
        }else{
           
            
            $re=db('cases_type')->insert($data);
            if($re){
                $this->success("添加成功！");
            }else{
                $this->error("添加失败！");
            } 
        }
         
    }
    public function modifys_t(){
        $id=input("id");
        $re=db('cases_type')->where("id=$id")->find();
        echo json_encode($re);
    }
    public function delete_t(){
        $id=input('id');
        $re=db("cases_type")->where("id=$id")->find();
        if($re){
           $del=db("cases_type")->where("id=$id")->delete();
           if($del){
               echo '1';
           }else{
               echo '2';
           }
        }else{
            echo '0';
        }
       
    }
    public function sorts_t(){
        $data=input('post.');
        foreach ($data as $id => $sort){
            db('cases_type')->where(array('id' => $id ))->setField('sort' , $sort);
        }
        $this->redirect('type');
    }
    /**
    * 案例列表
    *
    * @return void
    */
    public function cases()
    {
        $list=db("cases")->alias("a")->field("a.*,b.name as tname")->join("cases_type b","a.tid=b.id")->order(["a.sort asc","a.id desc"])->paginate(20);

        $this->assign("list",$list);

        $page=$list->render();

        $this->assign("page",$page);

        $res=db("cases_type")->select();

        $this->assign("res",$res);
        
        return $this->fetch();
    }
    public function save_c(){
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
               
            }else{
                 $data['image']=$re['image'];
            }
            
            $re=db('cases')->insert($data);
            if($re){
                $this->success("添加成功！");
            }else{
                $this->error("添加失败！");
            } 
        }
         
    }
    public function modifys_c(){
        $id=input("id");
        $re=db('cases')->where("id=$id")->find();
        echo json_encode($re);
    }
    public function delete_allc(){
        $id=input('id');
        $arr=explode(",", $id);
        foreach ($arr as $v){
            $re=db('cases')->where("id=$v")->find();
            if($re){
                $del=db('cases')->where("id=$v")->delete();
        }
        
       }
       $this->redirect('cases');
    }
    public function delete_c(){
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
    public function sorts_c(){
        $data=input('post.');
        foreach ($data as $id => $sort){
            db('cases')->where(array('id' => $id ))->setField('sort' , $sort);
        }
        $this->redirect('cases');
    }
    public function changec(){
        $id=input('id');
        $re=db('cases')->where("id=$id")->find();
        if($re){
            if($re['status'] == 0){
                $res=db('cases')->where("id=$id")->setField("status",1);
            }
            if($re['status'] == 1){
                $res=db('cases')->where("id=$id")->setField("status",0);
    
            }
            echo '0';
        }else{
            echo '1';
        }
    }
    public function changecs(){
        $id=input('id');
        $re=db('cases')->where("id=$id")->find();
        if($re){
            if($re['recome'] == 0){
                $res=db('cases')->where("id=$id")->setField("recome",1);
            }
            if($re['recome'] == 1){
                $res=db('cases')->where("id=$id")->setField("recome",0);
    
            }
            echo '0';
        }else{
            echo '1';
        }
    }
}