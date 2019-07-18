<?php
namespace app\admin\controller;

class Dub extends BaseAdmin
{
    public function brief()
    {
        if(request()->isAjax()){

            $data=input("post.");

            $re=db("dub")->where("id",1)->find();
            
            if(request()->file("image")){
                 $data['image']=uploads("image");
            }else{
                $data['image']=$re['image'];
            }
            $res=db("dub")->where("id",1)->update($data);

            if($res){
                $this->success("修改成功");
            }else{
                $this->error("修改失败");
            }

        }else{
            $re=db("dub")->where("id",1)->find();

            $this->assign("re",$re);

            return $this->fetch();
        }
    }
    public function type()
    {
        $fids=input("fids");

        if(empty($fids))
        {
            $fids=1;
        }
        $map['fids']=['eq',$fids];

        $this->assign("fids",$fids);
        
        $list=db("dub_type")->where($map)->order(["tsort asc","tid desc"])->paginate(20);

        $this->assign("list",$list);

        $page=$list->render();

        $this->assign("page",$page);

        
        
        return $this->fetch();
    }
    public function save_s(){
        $id=\input('tid');
        $data=input("post.");
        if($id){
          
           $res=db('dub_type')->where("tid=$id")->update($data);
           if($res){
               $this->success("修改成功！");
           }else{
               $this->error("修改失败！");
           }
        }else{
            
            
            $re=db('dub_type')->insert($data);
            if($re){
                $this->success("添加成功！");
            }else{
                $this->error("添加失败！");
            } 
        }
         
    }
    public function modifys_s(){
        $id=input("id");
        $re=db('dub_type')->where("tid=$id")->find();
        echo json_encode($re);
    }
    public function delete_s(){
        $id=input('id');
        $re=db("dub_type")->where("tid=$id")->find();
        if($re){
           $del=db("dub_type")->where("tid=$id")->delete();
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
            db('dub_type')->where(array('tid' => $id ))->setField('tsort' , $sort);
        }
        $this->redirect('type');
    }
    public function lister()
    {
        $list=db("dub")->where("fid",2)->order(["sort asc","id desc"])->paginate(20);

        $this->assign("list",$list);

        $page=$list->render();

        $this->assign("page",$page);

        $langs=db("dub_type")->where("fids",1)->order(["tsort asc","tid desc"])->select();

        $this->assign("langs",$langs);

        $type=db("dub_type")->where("fids",2)->order(["tsort asc","tid desc"])->select();

        $this->assign("type",$type);

        $age=db("dub_type")->where("fids",3)->order(["tsort asc","tid desc"])->select();

        $this->assign("age",$age);

        $mood=db("dub_type")->where("fids",4)->order(["tsort asc","tid desc"])->select();

        $this->assign("mood",$mood);

        $money=db("dub_type")->where("fids",5)->order(["tsort asc","tid desc"])->select();

        $this->assign("money",$money);
        
        return $this->fetch();
    }
    public function save(){
        $id=\input('id');
        $data=input("post.");
        if($id){
           $re=db('dub')->where("id=$id")->find();

           $file=request()->file("image");
           if($file){
            $info = $file->validate(['size'=>50240000,'ext'=>['mp3']])->move(ROOT_PATH . 'public' . DS . 'uploads');

            if($info){
                $pa=$info->getSaveName();
                $path=str_replace("\\", "/", $pa);
                $paths='/uploads/'.$path;
                $data['image']=$paths;
            }else{
                $this->error("请上传10M以内的MP3格式的文件");
            }
              
           }else{
                $data['image']=$re['image'];
           }
           $files=request()->file("video");
           if($files){
            $infos = $files->validate(['size'=>50240000,'ext'=>['mp4']])->move(ROOT_PATH . 'public' . DS . 'uploads');

            if($infos){
                $pa=$infos->getSaveName();
                $path=str_replace("\\", "/", $pa);
                $paths='/uploads/'.$path;
                $data['video']=$paths;
            }else{
                $this->error("请上传10M以内的MP4格式的文件");
            }
              
           }else{
                $data['video']=$re['video'];
           }
           
           $res=db('dub')->where("id=$id")->update($data);
           if($res){
               $this->success("修改成功！");
           }else{
               $this->error("修改失败！");
           }
        }else{
            $file=request()->file("image");
           if($file){
            $info = $file->validate(['size'=>50240000,'ext'=>['mp3']])->move(ROOT_PATH . 'public' . DS . 'uploads');

            if($info){
                $pa=$info->getSaveName();
                $path=str_replace("\\", "/", $pa);
                $paths='/uploads/'.$path;
                $data['image']=$paths;
            }else{
                $this->error("请上传10M以内的MP3格式的文件");
            }
              
           }

           $files=request()->file("video");
           if($files){
            $infos = $files->validate(['size'=>50240000,'ext'=>['mp4']])->move(ROOT_PATH . 'public' . DS . 'uploads');

            if($infos){
                $pa=$infos->getSaveName();
                $path=str_replace("\\", "/", $pa);
                $paths='/uploads/'.$path;
                $data['video']=$paths;
            }else{
                $this->error("请上传10M以内的MP4格式的文件");
            }
              
           }
            
            $re=db('dub')->insert($data);
            if($re){
                $this->success("添加成功！");
            }else{
                $this->error("添加失败！");
            } 
        }
         
    }
    public function modifys(){
        $id=input("id");
        $re=db('dub')->where("id=$id")->find();
        echo json_encode($re);
    }
    public function delete(){
        $id=input('id');
        $re=db("dub")->where("id=$id")->find();
        if($re){
           $del=db("dub")->where("id=$id")->delete();
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
            db('dub')->where(array('id' => $id ))->setField('sort' , $sort);
        }
        $this->redirect('lister');
    }
    public function delete_all(){
        $id=input('id');
        $arr=explode(",", $id);
        foreach ($arr as $v){
            $re=db('dub')->where("id=$v")->find();
            if($re){
                $del=db('dub')->where("id=$v")->delete();
        }
        
       }
       $this->redirect('lister');
    }
    public function change(){
        $id=input('id');
        $re=db('dub')->where("id=$id")->find();
        if($re){
            if($re['te'] == 0){
                $res=db('dub')->where("id=$id")->setField("te",1);
            }
            if($re['te'] == 1){
                $res=db('dub')->where("id=$id")->setField("te",0);
                
            }
            echo '0';
        }else{
            echo '1';
        }
    }
    public function video()
    {
        $id=input("id");

        $list=db("dub_video")->where("did",$id)->order("id desc")->select();

        $this->assign("list",$list);

        $this->assign("id",$id);

        $type=db("dub_type")->where("fids",2)->order(["tsort asc","tid desc"])->select();

        $this->assign("type",$type);
        
        return $this->fetch();
    }
    public function save_v(){
        $id=\input('id');
        $data=input("post.");
        if($id){
           $re=db('dub_video')->where("id=$id")->find();

           $file=request()->file("image");
           if($file){
            $info = $file->validate(['size'=>50240000,'ext'=>['mp3']])->move(ROOT_PATH . 'public' . DS . 'uploads');

            if($info){
                $pa=$info->getSaveName();
                $path=str_replace("\\", "/", $pa);
                $paths='/uploads/'.$path;
                $data['image']=$paths;
            }else{
                $this->error("请上传10M以内的MP3格式的文件");
            }
              
           }else{
                $data['image']=$re['image'];
           }
           $files=request()->file("video");
           if($files){
            $infos = $files->validate(['size'=>50240000,'ext'=>['mp4']])->move(ROOT_PATH . 'public' . DS . 'uploads');

            if($infos){
                $pa=$infos->getSaveName();
                $path=str_replace("\\", "/", $pa);
                $paths='/uploads/'.$path;
                $data['video']=$paths;
            }else{
                $this->error("请上传10M以内的MP4格式的文件");
            }
              
           }else{
                $data['video']=$re['video'];
           }
           
           $res=db('dub_video')->where("id=$id")->update($data);
           if($res){
               $this->success("修改成功！");
           }else{
               $this->error("修改失败！");
           }
        }else{
            $file=request()->file("image");
           if($file){
            $info = $file->validate(['size'=>50240000,'ext'=>['mp3']])->move(ROOT_PATH . 'public' . DS . 'uploads');

            if($info){
                $pa=$info->getSaveName();
                $path=str_replace("\\", "/", $pa);
                $paths='/uploads/'.$path;
                $data['image']=$paths;
            }else{
                $this->error("请上传10M以内的MP3格式的文件");
            }
              
           }

           $files=request()->file("video");
           if($files){
            $infos = $files->validate(['size'=>50240000,'ext'=>['mp4']])->move(ROOT_PATH . 'public' . DS . 'uploads');

            if($infos){
                $pa=$infos->getSaveName();
                $path=str_replace("\\", "/", $pa);
                $paths='/uploads/'.$path;
                $data['video']=$paths;
            }else{
                $this->error("请上传10M以内的MP4格式的文件");
            }
              
           }
            
            $re=db('dub_video')->insert($data);
            if($re){
                $this->success("添加成功！");
            }else{
                $this->error("添加失败！");
            } 
        }
         
    }
    public function modifys_v(){
        $id=input("id");
        $re=db('dub_video')->where("id=$id")->find();
        echo json_encode($re);
    }
    public function delete_v(){
        $id=input('id');
        $re=db("dub_video")->where("id=$id")->find();
        if($re){
           $del=db("dub_video")->where("id=$id")->delete();
           if($del){
               echo '1';
           }else{
               echo '2';
           }
        }else{
            echo '0';
        }
       
    }
    public function sort_v(){
        $data=input('post.');
        foreach ($data as $id => $sort){
            db('dub_video')->where(array('id' => $id ))->setField('sort' , $sort);
        }
        $this->redirect('lister');
    }
    public function cases()
    {
        $list=db("dub_cases")->order(["sort asc","id desc"])->paginate(20);

        $this->assign("list",$list);

        $page=$list->render();

        $this->assign("page",$page);

       
        
        return $this->fetch();
    }
    public function save_c(){
        $id=\input('id');
        $data=input("post.");
        if($id){
           $re=db('dub_cases')->where("id=$id")->find();

           $file=request()->file("image");
           if($file){
            
            $data['image']=uploads('image');
           }else{
                $data['image']=$re['image'];
           }

           $files=request()->file("video");
           if($files){
            $info = $files->validate(['size'=>50240000,'ext'=>['mp4']])->move(ROOT_PATH . 'public' . DS . 'uploads');

            if($info){
                $pa=$info->getSaveName();
                $path=str_replace("\\", "/", $pa);
                $paths='/uploads/'.$path;
                $data['video']=$paths;
            }else{
                $this->error("请上传10M以内的MP4格式的文件");
            }
              
           }else{
                $data['video']=$re['video'];
           }
           
           $res=db('dub_cases')->where("id=$id")->update($data);
           if($res){
               $this->success("修改成功！");
           }else{
               $this->error("修改失败！");
           }
        }else{
            $file=request()->file("video");
           if($file){
            $info = $file->validate(['size'=>50240000,'ext'=>['mp4']])->move(ROOT_PATH . 'public' . DS . 'uploads');

            if($info){
                $pa=$info->getSaveName();
                $path=str_replace("\\", "/", $pa);
                $paths='/uploads/'.$path;
                $data['video']=$paths;
            }else{
                $this->error("请上传10M以内的MP4格式的文件");
            }
              
           }
           $files=request()->file("image");
           if($files){
            
            $data['image']=uploads('image');
           }
            $re=db('dub_cases')->insert($data);
            if($re){
                $this->success("添加成功！");
            }else{
                $this->error("添加失败！");
            } 
        }
         
    }
    public function modifys_c(){
        $id=input("id");
        $re=db('dub_cases')->where("id=$id")->find();
        echo json_encode($re);
    }
    public function delete_c(){
        $id=input('id');
        $re=db("dub_cases")->where("id=$id")->find();
        if($re){
           $del=db("dub_cases")->where("id=$id")->delete();
           if($del){
               echo '1';
           }else{
               echo '2';
           }
        }else{
            echo '0';
        }
       
    }
    public function sort_c(){
        $data=input('post.');
        foreach ($data as $id => $sort){
            db('dub_cases')->where(array('id' => $id ))->setField('sort' , $sort);
        }
        $this->redirect('cases');
    }
    public function delete_all_c(){
        $id=input('id');
        $arr=explode(",", $id);
        foreach ($arr as $v){
            $re=db('dub_cases')->where("id=$v")->find();
            if($re){
                $del=db('dub_cases')->where("id=$v")->delete();
        }
        
       }
       $this->redirect('cases');
    }
    public function change_c(){
        $id=input('id');
        $re=db('dub_cases')->where("id=$id")->find();
        if($re){
            if($re['recome'] == 0){
                $res=db('dub_cases')->where("id=$id")->setField("recome",1);
            }
            if($re['recome'] == 1){
                $res=db('dub_cases')->where("id=$id")->setField("recome",0);
                
            }
            echo '0';
        }else{
            echo '1';
        }
    }
    //简介
    public function offer()
    {
        
        if(request()->isAjax()){

            $data=input("post.");

            $re=db("Dub")->where("fid",3)->find();
            
            if(request()->file("image")){
                 $data['image']=uploads("image");
            }else{
                $data['image']=$re['image'];
            }
            $res=db("Dub")->where("fid",3)->update($data);

            if($res){
                $this->success("修改成功");
            }else{
                $this->error("修改失败");
            }

        }else{
            $re=db("Dub")->where("fid",3)->find();

            $this->assign("re",$re);

            return $this->fetch();
        }

        
    }
    //列表
    public function listers()
    {
        $list=db("dub")->where(["fid"=>4])->order(["sort asc","id desc"])->select();

        $this->assign("list",$list);

        
        
        return $this->fetch();
    }
    public function saves(){
        $id=\input('id');
        $data=input("post.");
        if($id){
          
           
           
           $res=db('dub')->where("id=$id")->update($data);
           if($res){
               $this->success("修改成功！");
           }else{
               $this->error("修改失败！");
           }
        }else{
           
            
            $re=db('dub')->insert($data);
            if($re){
                $this->success("添加成功！");
            }else{
                $this->error("添加失败！");
            } 
        }
         
    }
    public function modifyss(){
        $id=input("id");
        $re=db('dub')->where("id=$id")->find();
        echo json_encode($re);
    }
    public function deletes(){
        $id=input('id');
        $re=db("dub")->where("id=$id")->find();
        if($re){
           $del=db("dub")->where("id=$id")->delete();
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
            db('dub')->where(array('id' => $id ))->setField('sort' , $sort);
        }
        $this->redirect('listers');
    }
    public function tips()
    {
        
        if(request()->isAjax()){

            $data=input("post.");

           
            $res=db("dub")->where("fid",5)->update($data);

            if($res){
                $this->success("修改成功");
            }else{
                $this->error("修改失败");
            }

        }else{
            $re=db("dub")->where("fid",5)->find();

            $this->assign("re",$re);

            return $this->fetch();
        }

        
    }
}