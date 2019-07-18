<?php
namespace app\admin\controller;

class Dd extends BaseAdmin
{
    public function lister()
    {
        $status=input("status");

        if(empty($status)){
            $status=1;
        }
        $map['status']=['eq',$status];

        $list=db("car_dd")->where($map)->order("id asc")->paginate(20);

        $this->assign("list",$list);

        $page=$list->render();

        $this->assign("page",$page);

        $this->assign("status",$status);
        
        return $this->fetch();
    }
    public function modifys()
    {
        $id=input("id");

        $re=db("car_dd")->field("id,money,money_ding,money_zhong,money_wan")->where("id",$id)->find();

        return json($re);
    }
    public function save()
    {
        $id=input("id");

        $re=db("car_dd")->where("id",$id)->find();

        if($re){
            $data=input("post.");
            $data['status']=2;

            $res=db("car_dd")->where("id",$id)->update($data);

            if($res){

                $log['uid']=$re['uid'];
                $log['content']="您好，你的订单已经更新了哦，已经完成报价，请及时付款。";
                $log['time']=time();

                db("dope")->insert($log);

                $this->success("报价成功");
            }else{
                $this->error("报价失败");
            }

        }else{
            $this->error("参数错误");
        }
    }
    public function delete(){
        $id=input('id');
        $re=db("car_dd")->where("id=$id")->find();
        if($re){
           $del=db("car_dd")->where("id=$id")->delete();
           if($del){
               echo '1';
           }else{
               echo '2';
           }
        }else{
            echo '0';
        }
       
    }
    public function looks()
    {
        $id=input("id");

        $re=db("car_dd")->where("id",$id)->find();

        $this->assign("re",$re);
        
        return $this->fetch();
    }
    public function change(){
        $id=input('id');
        $re=db("car_dd")->where("id=$id")->find();
        if($re){
           $del=db("car_dd")->where("id=$id")->update(["status"=>3]);
           if($del){
               echo '1';
           }else{
               echo '2';
           }
        }else{
            echo '0';
        }
       
    }
    public function usave()
    {
        $id=input("id");

        $re=db("car_dd")->where("id",$id)->find();

        if($re){

            $file=request()->file("image");

        if($file){
            $info = $file->validate(['size'=>50240000,'ext'=>['zip','rar','doc','docx','xls','xlsx']])->move(ROOT_PATH . 'public' . DS . 'uploads');

            if($info){
                $pa=$info->getSaveName();
                $path=str_replace("\\", "/", $pa);
                $paths='/uploads/'.$path;
    
    
                $data['files']=$paths;
                $data['status']=4;

                $res=db("car_dd")->where("id",$id)->update($data);

               

                if($res){
                    $log['uid']=$re['uid'];
                    $log['content']="您好，你的订单已经更新了哦，已经翻译完成了，请及时下载查看。";
                    $log['time']=time();

                    db("dope")->insert($log);

                    return  ['code'=>1,'msg'=>'上传成功'];
                }else{
                    return  ['code'=>0,'msg'=>'系统繁忙稍后再试'];
                }
            }else{
                return  ['code'=>0,'msg'=>'请上传正确的zip,rar,doc,docx,xls,xlsx附件类型,文件大小10M'];
            }
           
        }else{
            return  ['code'=>0,'msg'=>'请上传文件'];
        }

        }else{
            return  ['code'=>0,'msg'=>'参数错误'];
        }
        
        
    }
}