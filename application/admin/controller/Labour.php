<?php
namespace app\admin\controller;

class Labour extends BaseAdmin
{
    public function index()
    {
        if(request()->isAjax()){

            $data=input("post.");

            $re=db("labour")->where("fid",1)->find();
            
            if(request()->file("image")){
                 $data['image']=uploads("image");
            }else{
                $data['image']=$re['image'];
            }
            $res=db("labour")->where("fid",1)->update($data);

            if($res){
                $this->success("修改成功");
            }else{
                $this->error("修改失败");
            }

        }else{
            $re=db("labour")->where("fid",1)->find();

            $this->assign("re",$re);

            return $this->fetch();
        }
        
        return $this->fetch();
    }
    public function type()
    {
        $list=db("labour_type")->order(["tsort asc","tid desc"])->paginate(20);

        $this->assign("list",$list);

        $page=$list->render();

        $this->assign("page",$page);

        
        
        return $this->fetch();
    }
    public function save_s(){
        $id=\input('tid');
        $data=input("post.");
        if($id){
          
           $res=db('labour_type')->where("tid=$id")->update($data);
           if($res){
               $this->success("修改成功！");
           }else{
               $this->error("修改失败！");
           }
        }else{
            
            
            $re=db('labour_type')->insert($data);
            if($re){
                $this->success("添加成功！");
            }else{
                $this->error("添加失败！");
            } 
        }
         
    }
    public function modifys_s(){
        $id=input("id");
        $re=db('labour_type')->where("tid=$id")->find();
        echo json_encode($re);
    }
    public function delete_s(){
        $id=input('id');
        $re=db("labour_type")->where("tid=$id")->find();
        if($re){
           $del=db("labour_type")->where("tid=$id")->delete();
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
            db('labour_type')->where(array('tid' => $id ))->setField('tsort' , $sort);
        }
        $this->redirect('type');
    }
    public function money()
    {
        $list=db("labour_money")->order(["tsort asc","tid desc"])->paginate(20);

        $this->assign("list",$list);

        $page=$list->render();

        $this->assign("page",$page);

        
        
        return $this->fetch();
    }
    public function save_money(){
        $id=\input('tid');
        $data=input("post.");
        if($id){
          
           $res=db('labour_money')->where("tid=$id")->update($data);
           if($res){
               $this->success("修改成功！");
           }else{
               $this->error("修改失败！");
           }
        }else{
            
            
            $re=db('labour_money')->insert($data);
            if($re){
                $this->success("添加成功！");
            }else{
                $this->error("添加失败！");
            } 
        }
         
    }
    public function modifys_money(){
        $id=input("id");
        $re=db('labour_money')->where("tid=$id")->find();
        echo json_encode($re);
    }
    public function delete_money(){
        $id=input('id');
        $re=db("labour_money")->where("tid=$id")->find();
        if($re){
           $del=db("labour_money")->where("tid=$id")->delete();
           if($del){
               echo '1';
           }else{
               echo '2';
           }
        }else{
            echo '0';
        }
       
    }
    public function sorts_money(){
        $data=input('post.');
        foreach ($data as $id => $sort){
            db('labour_money')->where(array('tid' => $id ))->setField('tsort' , $sort);
        }
        $this->redirect('money');
    }
    public function lister()
    {
        $list=db("labour")->where("fid",2)->alias("a")->field("a.*,b.tname,c.tname as tmoney")->join("labour_type b","a.pid=b.tid","left")->join("labour_money c","a.mid=c.tid","left")->order(["sort asc","id desc"])->paginate(20);

        $this->assign("list",$list);

        $page=$list->render();

        $this->assign("page",$page);

        $res=db("labour_type")->order(["tsort asc","tid desc"])->select();

        $this->assign("res",$res);

        $money=db("labour_money")->order(["tsort asc","tid desc"])->select();

        $this->assign("money",$money);
        
        return $this->fetch();
    }
    public function save(){
        $id=\input('id');
        $data=input("post.");
        if($id){
           $re=db('labour')->where("id=$id")->find();
           if(request()->file("image")){
               $data['image']=uploads("image");
              
           }else{
                $data['image']=$re['image'];
           }
           
           $res=db('labour')->where("id=$id")->update($data);
           if($res){
               $this->success("修改成功！");
           }else{
               $this->error("修改失败！");
           }
        }else{
            if(request()->file("image")){
                $data['image']=uploads("image");
            }
            
            $re=db('labour')->insert($data);
            if($re){
                $this->success("添加成功！");
            }else{
                $this->error("添加失败！");
            } 
        }
         
    }
    public function modifys(){
        $id=input("id");
        $re=db('labour')->where("id=$id")->find();
        echo json_encode($re);
    }
    public function delete(){
        $id=input('id');
        $re=db("labour")->where("id=$id")->find();
        if($re){
           $del=db("labour")->where("id=$id")->delete();
           if($del){
               echo '1';
           }else{
               echo '2';
           }
        }else{
            echo '0';
        }
       
    }
    public function sort(){
        $data=input('post.');
        foreach ($data as $id => $sort){
            db('labour')->where(array('id' => $id ))->setField('sort' , $sort);
        }
        $this->redirect('lister');
    }
    public function delete_all(){
        $id=input('id');
        $arr=explode(",", $id);
        foreach ($arr as $v){
            $re=db('labour')->where("id=$v")->find();
            if($re){
                $del=db('labour')->where("id=$v")->delete();
        }
        
       }
       $this->redirect('lister');
    }
    public function change(){
        $id=input('id');
        $re=db('labour')->where("id=$id")->find();
        if($re){
            if($re['recome'] == 0){
                $res=db('labour')->where("id=$id")->setField("recome",1);
            }
            if($re['recome'] == 1){
                $res=db('labour')->where("id=$id")->setField("recome",0);
                
            }
            echo '0';
        }else{
            echo '1';
        }
    }
    //聘用列表
    public function demand()
    {
        $status=input("status");

        if($status){
            $map['status']=['eq',$status];
        }else{
            $status=0;
            $map['status']=['eq',0];
        }
        $this->assign("status",$status);
        
        $list=db("demand")->alias("a")->field("a.*,b.name")->where($map)->join("labour b","a.lid=b.id",'left')->order("a.id desc")->paginate(20,false,['query'=>request()->param()]);

        $this->assign("list",$list);

        $page=$list->render();

        $this->assign("page",$page);
        
        return $this->fetch();
    }
    public function changes(){
        $id=input('id');
        $re=db('demand')->where("id=$id")->find();
        if($re){
            if($re['status'] == 0){
                $res=db('demand')->where("id=$id")->setField("status",1);
            }
            if($re['status'] == 1){
                $res=db('demand')->where("id=$id")->setField("status",0);
                
            }
            echo '0';
        }else{
            echo '1';
        }
    }
    public function deletes(){
        $id=input('id');
        $re=db("demand")->where("id=$id")->find();
        if($re){
           $del=db("demand")->where("id=$id")->delete();
           if($del){
               echo '0';
           }else{
               echo '2';
           }
        }else{
            echo '1';
        }
       
    }













}