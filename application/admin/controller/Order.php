<?php
namespace app\admin\controller;

class Order extends BaseAdmin
{
    public function lister()
    {
        $fid=input("fid");

        if(empty($fid)){
            $fid=1;
        }
        $map['fid']=['eq',$fid];

        $this->assign("fid",$fid);
        
        $list=db("langs")->where($map)->order(["sort asc","id desc"])->paginate(20);

        $this->assign("list",$list);

        $page=$list->render();

        $this->assign("page",$page);
        
        return $this->fetch();
    }
    public function save(){
        $id=\input('id');
        $data=input("post.");
        if($id){
          
           
           
           $res=db('langs')->where("id=$id")->update($data);
           if($res){
               $this->success("修改成功！");
           }else{
               $this->error("修改失败！");
           }
        }else{
           
            
            $re=db('langs')->insert($data);
            if($re){
                $this->success("添加成功！");
            }else{
                $this->error("添加失败！");
            } 
        }
         
    }
    public function modifys(){
        $id=input("id");
        $re=db('langs')->where("id=$id")->find();
        echo json_encode($re);
    }
    public function delete(){
        $id=input('id');
        $re=db("langs")->where("id=$id")->find();
        if($re){
           $del=db("langs")->where("id=$id")->delete();
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
            db('langs')->where(array('id' => $id ))->setField('sort' , $sort);
        }
      echo '<script>
      window.history.back(-1);
      </script>';exit;
    }
}