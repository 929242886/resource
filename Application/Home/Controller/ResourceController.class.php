<?php
namespace Home\Controller;
use Think\Controller;
class ResourceController extends Controller {
	/*
	*王一尘
	*@方法名：resourcelist
	*/
	function resourcelist(){
		$resource=D('Resource');
		$resourcelist=$resource->selectResource();

		foreach ($resourcelist as $k => &$v) {
        	$name = $v['resource'];
        	$v['vo']  =  substr($name,strpos($name,'.')+1);
        }
        //print_r($resourcelist);die;
		$wenjianjia=$resource->selectWenjianjia();
		$resourcenum=count($wenjianjia)+count($resourcelist);
		$click=$resource->selectWenjianjia();
		$ming="全部文件";
		$this->assign("ming",$ming);
		$this->assign('click',$click);
		$this->assign("resourcelist",$resourcelist);
		$this->assign('wenjianjia',$wenjianjia);
		$this->assign('resourcenum',$resourcenum);
		$this->display();
	}
	/*
	*王一尘
	*@方法名：search
	*/
	function search(){
		$sou=I('get.sou');
		$type=D("Resource");
		$resourcelist=$type->resourcelist($sou);
		//print_r($resourcelist);die;
		$wenjianjia=$type->selectSearchtype($sou);
		foreach ($resourcelist as $k => &$v) {
        	$name = $v['resource'];
        	$v['vo']  =  substr($name,strpos($name,'.')+1);
        }
		$resourcenum=count($wenjianjia);
		$ming="全部文件";
		$this->assign("ming",$ming);
		$this->assign("resourcelist",$resourcelist);
		$this->assign('wenjianjia',$wenjianjia);
		$this->assign('resourcenum',$resourcenum);
		$this->display('level');
	}
	/*
	*王一尘
	*@方法名：click
	*/
	function click(){
		$t_id=I('get.t_id');
		$resource=D('Resource');
		$typeone=$resource->selectTypeone($t_id);
		$resourcelist=$resource->Resourcetid($t_id);
		foreach ($resourcelist as $k => &$v) {
        	$name = $v['resource'];
        	$v['vo']  =  substr($name,strpos($name,'.')+1);
        }
		$click=$resource->selectWenjianjia();
		$ming="<a href='".__CONTROLLER__."/resourcelist'>".全部文件."</a>".'>'.$typeone['type'];
		$resourcenum=count($resourcelist);
		$this->assign("ming",$ming);	
		$this->assign('resourcelist',$resourcelist);	
		$this->assign('click',$click);
		$this->assign("id",$t_id);
		$this->assign('resourcenum',$resourcenum);
		$this->display('click');
	}
	/*
	*王一尘
	*@方法名:level
	*/
	function level(){
		if(I('post.id')){
			$tid=I('post.id');
		}else{
			$tid=I('get.id');
		}
		$type=D("Resource");
		//根据id查询一条
		$resourcelist=$type->Resourcetid($tid);
		foreach ($resourcelist as $k => &$v) {
        	$name = $v['resource'];
        	$v['vo']  =  substr($name,strpos($name,'.')+1);
        }
		$typeone=$type->selectTypeone($tid);
		$info=$typeone;
		//定义一个空数组
		$urllist=array($info['type']);
		//面包屑url
		$url="";
		$fid=1;
		if($info['f_id']!=0&&$info['f_id']!=""){
			for($i=0;$i<$fid;){
				$info=$type->selectTypeone($info['f_id']);
				$urllist[]="<a href='javascript:void(0)' onclick='level(".$info['t_id'].")'>".$info['type']."</a>";//获取上级分类的名称
				$fid=$info['f_id'];
			}
		}
		krsort($urllist);
		if($typeone['f_id']==0){
			$url="<a href='".__CONTROLLER__."/resourcelist'>".全部文件."</a>".'>'."<a href='javascript:void(0)' onclick='level(".$typeone['t_id'].")'>".$typeone['type']."</a>";
		}else{
			$url="<a href='javascript:void(0)' onclick='level(".$typeone['f_id'].")'>".返回上一级."</a>".'|'."<a href='".__CONTROLLER__."/resourcelist'>".全部文件."</a>".'>'.implode(">",$urllist);
		}

		//print_r($url);
		$wenjianjia=$type->selectType($tid);
		$resourcenum=count($wenjianjia)+count($resourcelist);
		$this->assign('resourcelist',$resourcelist);
		$this->assign('resourcenum',$resourcenum);
		$this->assign('url',$url);
		$this->assign('wenjianjia',$wenjianjia);
		$this->display('level');
	}
	/*
	*王一尘
	*@方法名about
	*/
	function about(){
		$re_id=I('get.id');
		$type=D('Resource');
		$resourceOne=$type->resourceOne($re_id);
		$ip=gethostbyname($_ENV['COMPUTERNAME']);
		//echo $iipp;die;
		$re=substr($ip,0,3);
		if($re==192){
			$display=1;
		}else{
			$display=0;
		}
		$resourcelist=$type->Resourcetid($resourceOne['t_id']);
		foreach ($resourcelist as $k => &$v) {
        	$name = $v['resource'];
        	$v['vo']  =  substr($name,strpos($name,'.')+1);
        }
		$typeone=$type->selectTypeone($resourceOne['t_id']);
		$info=$typeone;
		//定义一个空数组
		$urllist=array("<a href='javascript:void(0)' onclick='level(".$info['t_id'].")'>".$info['type']."</a>");		//面包屑url
		$url="";
		$fid=1;
		if($info['f_id']!=0&&$info['f_id']!=""){
			for($i=0;$i<$fid;){
				$info=$type->selectTypeone($info['f_id']);
				$urllist[]="<a href='javascript:void(0)' onclick='level(".$info['t_id'].")'>".$info['type']."</a>";//获取上级分类的名称
				$fid=$info['f_id'];
			}
		}
		krsort($urllist);
		if($typeone['f_id']==0){
			$url="<a href='".__CONTROLLER__."/resourcelist'>".全部文件."</a>".'>'."<a href='javascript:void(0)' onclick='level(".$typeone['t_id'].")'>".$typeone['type']."</a>".'>'.$resourceOne['resource'];
		}else{
			$url="<a href='javascript:void(0)' onclick='level(".$typeone['f_id'].")'>".返回上一级."</a>".'|'."<a href='".__CONTROLLER__."/resourcelist'>".全部文件."</a>".'>'.implode(">",$urllist).'>'.$resourceOne['resource'];
		}
		$load_num=$resourceOne['load_num']+1;
		$type->updateResource($load_num,$re_id);
		$this->assign('url',$url);
		$this->assign('display',$display);
		$this->assign('resource',$resourceOne);
		$this->display();
	}

	function downun(){
		// $file_name="cookie.jpg"; 
		$re_id=I('get.re_id');
		$display=I("get.display");
		$resource=D('Resource');
		$resourceOne=$resource->resourceOne($re_id);
		$file_name=$resourceOne['resource'];
		//用以解决中文不能显示出来的问题 
		$file_name=iconv("utf-8","gbk",$file_name);
		if($display==1){
			$file_sub_path=$resourceOne['url']; 
		}else{
			$file_sub_path=$resourceOne['bei_url']; 
		}
		$file_path=$file_sub_path;
		//首先要判断给定的文件存在与否 
		if(!file_exists($file_path)){ 
		echo "没有该文件文件"; 
		return false; 
		} 
		$fp=fopen($file_path,"r");
		$file_size=filesize($file_path); 
		//echo $file_size;die;
		//下载文件需要用到的头 
		Header("Content-type:application/octet-stream");    
    	Header("Accept-Ranges:bytes");    
    	Header("Accept-Length:".$file_size);    
    	Header("Content-Disposition:attachment;filename=".$file_name);    
		readfile($file_path); 
	}



	//严昊所做首页竖排
	public function upright(){
   	    $resource=D('Resource');
		$resourcelist=$resource->selectResource();
		//print_r($resourcelist);die;
		foreach ($resourcelist as $k => &$v) {
        	$name = $v['resource'];
        	$v['vo']  =  substr($name,strpos($name,'.')+1);
        }
       //print_r($format);
		$wenjianjia=$resource->selectWenjianjia();
		//print_r($wenjianjia);die;

		$resourcenum=count($wenjianjia)+count($resourcelist);
		$click=$resource->selectWenjianjia();
		//print_r($click);die;
	
		$this->assign('click',$click);
		$this->assign("format",$format);
		$this->assign("resourcelist",$resourcelist);
		$this->assign('wenjianjia',$wenjianjia);
		$this->assign('resourcenum',$resourcenum);
		$this->display("side");
   }
   //严昊左侧竖排
   public function uprightfile(){
   	$id = $_POST['id'];
   	$resource=D('Resource');
    $resourcelist=$resource->query("SELECT * from  type INNER JOIN resource on type.t_id = resource.t_id WHERE type.t_id = '$id'");
    //print_r($resourcelist);die;

    foreach ($resourcelist as $k => $v) {
     $resource = $v['resource'];
       
        $format =  substr($resource,strpos($resource,'.')+1);
        //echo $format;

    }
    //print_r($format);
    $this->assign("format",$format);
    $this->assign("resourcelist",$resourcelist);
    $this->display("uprightfile");
   }


}
?>