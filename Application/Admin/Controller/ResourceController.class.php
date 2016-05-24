<?php

namespace Admin\Controller;
use Think\Controller;

	/****
	**	资源管理
	** 	name:zhangcheng
	** 	tel:57689
	** 	time:16/05/21
	****
	*/

class  ResourceController extends CommonController{

	public function add(){
		

		if($_POST){
	// 添加资源	
			$upload = new \Think\Upload();// 实例化上传类 
			$upload->autoSub   = false;    
			$upload->maxSize   =     0 ;// 设置附件上传大小    
			$upload->exts      =     array(
				'jpg', 'gif', 'png', 'jpeg','octet-stream','exe','zip','rar','7z',
				'wmv',
				'txt','doc','docx','wps','pdf','xls',
			);// 设置附件上传类型    
			$upload->savePath  =      './'; // 设置附件上传目录   
			 // 上传文件 
			$size = $_FILES['url']['size']; 
			$resource= substr($_FILES['url']['name'],0,(strpos($_FILES['url']['name'],'.')));
		 
			$info   =   $upload->upload(); 
		
			$url = $_FILES['url']['savepath'];
			$name=$info['url']['savename'];
			if(!$info) {
				// 上传错误提示错误信息        
				$this->error($upload->getError());
		    }
			

			//复制文件到新目录
		    // $newFile="D:/WWW/Public/uploads/".$name;
		    // echo copy($name,$newFile);

		    $re= D('Resource');
		    $model=D("Type");
		    $time=date('Y-m-d H:i:s',time());
		    $f_id=intval($_POST['t_id'])?intval($_POST['t_id']):0;

		    $typeone=$model->selectTypeone($f_id);

		    $ip=gethostbyname($_ENV['COMPUTERNAME']); //获取内网ip
            
            if($f_id==0){
                $url="$ip/resource/Public/uploads/".$name;
                $t_id=0;
            }elseif($f_id>0){
            	$model=D("Type");
                $d_type=$model->select();
                $arr = $this->noLimit($d_type,$f_id,$level);
                $fid=1;
				if($typeone['f_id']!=0&&$typeone['f_id']!=""){
					for($i=0;$i<$fid;$i++){
						$typeone=$model->selectTypeone($typeone['f_id']);
						$urllist[]=$typeone['type'];//获取上级分类的名称
						$fid=$typeone['f_id'];
					}
				}
		
				krsort($urllist);
				$url="$ip/resource/Public/upload".implode("/",$urllist)."/".$name;
 			
 				$t_id=$arr[0]['t_id'];
            }
       
            $size = $_FILES['url']['size'];
            $data=array(
                'resource'=>$resource,
                'url'=>$url,
                'bei_url'=>$_POST['bei_url'],
                'size'=>$size,
                't_id'=>$t_id,
                'add_time'=>$time,
            );
		    $add=$re->add($data);
		    if($add){

		//添加日志
		    		$log = M('Log');
					$u_id=session('admin_id');
					$time=date('Y-m-d H:i:s',time());
					$arr=array(
							're_id'=>$add,
							'admin_id'=>$u_id,
							'add_time'=>$time,
						);
					$log=$log->add($arr);
					$this->redirect('Resource/lists');
		    }	
		}else{
			$data=$this->getList(); //左侧列表

			$this->assign('data',$data);
			$this->display();
		}		
	}

	public function noLimit($d_type,$f_id,$level){
		static $lists=array();
		foreach($d_type as $key=>$v){
			if($v['t_id']==$f_id){
				$v['level']=$level;
				$lists[]=$v;
				$this->noLimit($d_type,$v['f_id'],$level+1);
			}
		}
		return $lists;
	}



	//资源列表
	public function lists(){
		$model=D("Resource");

		$this->data=$this->getList(); //左侧列表

		$where = 're_id > 0';
		$keyword = $_GET['keyword'];
        if(!empty($keyword)) 
        $where = " resource like '%$keyword%'"; 
        $count = $model->where($where)->count();// 查询满足要求的总记录数
        //var_dump($count);die;
        $Page  = new \Think\Page($count,4);// 实例化分页类 传入总记录数和每页显示的记录数
        $Page->setConfig('first','第一页');
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->setConfig('end','最后一页');
        $show = $Page->show();// 分页显示输出
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $list = $model->where($where)->order('add_time desc ')->limit($Page->firstRow.','.$Page->listRows)->select();
        //关键字标红
        if(!empty($keyword)){
            foreach($list as $k=>$v){
               $list[$k]['resource'] =  str_replace($keyword,"<font color='red'>".$keyword."</font>",$v['resource']);
            }
        }	
		$this->assign('count',$count);
        $this->assign('keyword',$keyword);
        $this->assign('arr',$list);
        $this->assign('page',$show);
		$this->display();
	}

	//资源批量删除
	public function delAll(){
		$ids =$_GET['idAll'];
		$model = D("Resource");
		$model->delete("$ids");
		$this->redirect('Resource/lists');
	}

	//资源详情
	public function details(){
		if($_POST){
			$id=$_POST['re_id'];
			//var_dump($id);die;
			$model= D("Resource");
			$data=array(
					'resource'=>$_POST['resource'],
					'url'=>$_POST['url'],
					'bei_url'=>$_POST['bei_url'],
					'jieshao'=>$_POST['jieshao'],
					'content'=>$_POST['content'],
				);
			$model->where("re_id=$id")->save($data);
			$this->redirect('Resource/lists');
		}else{
			$id=$_GET['id'];
			$model = D("Resource");
			//查询出单条数据
			$this->row = $model ->join("resource join type on type.t_id=resource.t_id")-> where("re_id=$id") -> find();
			
			//左侧权限列表
			$this->data=$this->getList();
			$this->display();
		}
		
	}


	/*
     * 资源上传页面
     * @type 文件夹
     * @dir 文件
     * */
    public function upload(){
    
    	if($_GET){

    		$id=$_GET['id'];

			$type=D("Resource");
			//根据id查询一条
			$resourcelist=$type->Resourcetid($id);
			//var_dump($resourcelist);die;
			//查询父类
			$typeid=$type->typeId($id);
			
			$t_id=$typeid['t_id'];
			//var_dump($t_id);die;
			foreach ($resourcelist as $k => $v) {
	        	$name = $v['resource'];
	        	$format[] =  substr($name,strpos($name,'.')+1);
	        }
	       // var_dump($resourcelist);die;
			$typeone=$type->selectTypeone($id);
			$info=$typeone;
			
			//定义一个空数组
			$urllist=array($info['type']);
			//面包屑url
			$url="";
			$fid=1;
			if($info['f_id']!=0&&$info['f_id']!=""){
				for($i=0;$i<$fid;$i++){
					$info=$type->selectTypeone($info['f_id']);
					$urllist[]="<a href='".__CONTROLLER__."/upload/id/".$info['t_id']."'>".$info['type']."</a>";//获取上级分类的名称
					$fid=$info['f_id'];
				}
			}
			krsort($urllist);
			$url="<a href='".__CONTROLLER__."/upload'>".全部文件."</a>".'>'.implode(">",$urllist);
			//print_r($url);	
			$wenjianjia=$type->selectType($id);
			$resourcenum=count($wenjianjia);
			$this->data=$this->getList();
			$resource = M('Resource');
            $dir=$resource->where('t_id = '.$id)->select();

            $this->assign('dir',$dir);
			$this->assign('resourcelist',$resourcelist);
			$this->assign('resourcenum',$resourcenum);
			$this->assign('url',$url);
			$this->assign("format",$format);
			$this->assign("t_id",$t_id);
			$this->assign('wenjianjia',$wenjianjia);
			$this->display('level');
    	}else{
    		$type = M('Type');
	        $data=$type->where('f_id = 0')->order("t_id desc")->select();
	        //var_dump($data);die;
	  		$this->data=$this->getList();
	        $arr=array();
	        foreach($data as $k=>$v){
	            $arr[]=$v['type'];
	        }
	        
	        $resource = M('Resource');
	        $dir=$resource->where('t_id = 0')->select();
	       // var_dump($dir);die;
	        $this->assign('type',$data);
	        $this->assign('dir',$dir);
	        $this->assign('arr',implode(',',$arr));
	        $this->assign('fid',0);
	        $this->display();
    	}
        
    }
    /*
     * 添加文件夹
     * */
    public function adddir(){
        $type = M('Type');
        $data['f_id']=intval($_GET['fid']);
        $data['type']=strval($_GET['text']);
        //判断type f_id
        if($data['f_id']==0){
            $str="./Public/upload";
        }else{
            $str=$type->where("t_id=".$data['f_id']);
            $str=$str['t_url'];
        }
        $file_path=$str."/".$data['type'];
        if(!file_exists($data['type'])){
            mkdir(iconv('utf-8','gbk',$file_path));
        }
        $data['t_url']=$file_path;
        //文件添加
        $query=$type->add($data);
        if($query){
            echo 1;
        }else{
            rmdir($file_path);
            echo "新建失败！";
        }
    }

     /*
     * 删除文件夹
     * */
    public function del_dir(){
        $t_id=intval($_GET['t_id']);
        $type = M('Type');
        //查询记录
        $data=$type->where("t_id=".$t_id)->find();
        //删除该条记录
        $query=$type->where("t_id=".$t_id)->delete();
        if($query){
            rmdir($data['t_url']);
            echo 1;
        }else{
            echo "删除失败";
        }
    }
    /*
     * 修改文件夹名称
     * */
    public function updatedir(){
        $data=$_GET;
        //dump($data);
        if(strval($data['type']=="dir")){
            $type=M("Type");
            $where="t_id=".intval($data['fid']);
            $datas['type']=strval($data['text']);
        }elseif($data['type']=="link"){
            $type=M("Resource");
            $where="re_id=".intval($data['fid']);
            $datas['resource']=strval($data['text']);
        }
        //echo $where;die;
        $query=$type->where($where)->save($datas);
        if($query){
            echo 1;
        }else{
            echo "重命名失败";
        }
    }
    /*
     * 删除资源
     * */
    public function del_resource(){
        $t_id=intval($_GET['t_id']);
        $type = M('Resource');
        $data=$type->where("re_id=".$t_id)->find();
        //删除该条记录
        $query=$type->where("re_id=".$t_id)->delete();
        if($query){
            unlink($data['url']);
            echo 1;
        }else{
            echo "删除失败";
        }
    }

    
}

	  
