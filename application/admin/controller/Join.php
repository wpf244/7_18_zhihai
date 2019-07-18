<?php
namespace app\admin\controller;

class Join extends BaseAdmin
{
    public function lister()
    {
        $list=db("join")->order(["sort asc","id desc"])->paginate(20);

        $this->assign("list",$list);

        
        return $this->fetch();
    }
    public function save(){
        $id=\input('id');
        $data=input("post.");
        if($id){
           
           
           $res=db('join')->where("id=$id")->update($data);
           if($res){
               $this->success("修改成功！");
           }else{
               $this->error("修改失败！");
           }
        }else{
            $data['time']=date("Y-m-d");
            $re=db('join')->insert($data);
            if($re){
                $this->success("添加成功！");
            }else{
                $this->error("添加失败！");
            } 
        }
         
    }
    public function modifys(){
        $id=input("id");
        $re=db('join')->where("id=$id")->find();
        echo json_encode($re);
    }
    public function delete(){
        $id=input('id');
        $re=db("join")->where("id=$id")->find();
        if($re){
           $del=db("join")->where("id=$id")->delete();
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
            db('join')->where(array('id' => $id ))->setField('sort' , $sort);
        }
        $this->redirect('lister');
    }
    public function delete_all(){
        $id=input('id');
        $arr=explode(",", $id);
        foreach ($arr as $v){
            $re=db('join')->where("id=$v")->find();
            if($re){
                $del=db('join')->where("id=$v")->delete();
        }
        
       }
       $this->redirect('lister');
    }
    public function index()
    {
        $status=input("status");

        if($status){
            $map['status']=['eq',$status];
        }else{
            $status=0;
            $map['status']=['eq',0];
        }
        $this->assign("status",$status);
        
        $list=db("resume")->alias("a")->field("a.*,b.name")->where($map)->join("join b","a.jid=b.id")->order("a.id asc")->paginate(20,false,['query'=>request()->param()]);;

        $this->assign("list",$list);

        $page=$list->render();

        $this->assign("page",$page);
        
        return $this->fetch();
        
       
    }
    public function changes(){
        $id=input('id');
        $re=db('resume')->where("id=$id")->find();
        if($re){
            if($re['status'] == 0){
                $res=db('resume')->where("id=$id")->setField("status",1);
            }
            if($re['status'] == 1){
                $res=db('resume')->where("id=$id")->setField("status",0);
                
            }
            echo '0';
        }else{
            echo '1';
        }
    }
    public function deletes(){
        $id=input('id');
        $re=db("resume")->where("id=$id")->find();
        if($re){
           $del=db("resume")->where("id=$id")->delete();
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