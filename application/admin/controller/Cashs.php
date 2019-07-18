<?php
namespace app\admin\controller;

class Cashs extends BaseAdmin
{
    public function index()
    {
        $re=db("cash_s")->where("id",1)->find();

        $this->assign("re",$re);
        
        return $this->fetch();
    }
    public function savet()
    {
        $data=input("post.");
        $res=db("cash_s")->where("id",1)->update($data);
        if($res){
            $this->success("修改成功");
        }else{
            $this->error("修改失败");
        }
    }
    public function lister()
    {
       
        $status=input("status");

        if($status){
            $map['status']=['eq',$status];
        }else{
            $status=0;
            $map['status']=['eq',0];
        }
        $this->assign("status",$status);

        $list=db("money_log")->alias("a")->where($map)->field("a.*,b.username")->join("user b","a.uid=b.uid")->order("mid desc")->paginate(20);
        $this->assign("list",$list);
        $page=$list->render();
        $this->assign("page",$page);
        return $this->fetch();
    }
    public function change()
    {
        $id=input("id");
        $re=db("money_log")->where("mid",$id)->find();
        if($re){
            db("money_log")->where("mid",$id)->setField("status",1);
        }
        $this->redirect("lister");
    }
    public function changet()
    {
        $id=input("id");
        $re=db("money_log")->where("mid",$id)->find();
        if($re){
            db("money_log")->where("mid",$id)->setField("status",2);
            $uid=$re['uid'];
            $money=$re['moneys'];
            $shop=db("user")->where("uid",$uid)->find();
            if($shop){
                db("user")->where("uid",$uid)->setInc("integ",$money);
            }
        }
        $this->redirect("lister");
    }
}