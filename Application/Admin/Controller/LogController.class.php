<?php
namespace Admin\Controller;
use Think\Controller;

/****
**	权限管理
** 	name:邵会霞
** 	tel:57689
** 	time:16/05/21
****
*/
class LogController extends CommonController{
	//日志展示
	public function lists(){
		//左侧
		$this->data=$this->getList();
		//print_r($data);die;
		//日志
		$log=D('Log');
		$res=$log->join('l left join admin a on l.admin_id=a.admin_id join resource on l.re_id=resource.re_id')->order("l.add_time desc")->limit(4)->select();
		//var_dump($res);exit;
		$this->assign('res',$res);
		$this->display('lists');
	}
	 //删除管理员
	public function dele(){
	   $privilege=D('Log');
	   $log_id=$_GET['id'];
	   //echo $log_id;fie;
	   $row=$privilege->delete($log_id);
	   if($row){
		   $this->redirect("Log/lists");
	   }else{
	       $this->redirect("Log/lists");
	   }
	}
	//批量删除
	public function delAll()
	{
	   $privilege=D('Log');
	   $log_id=$_GET['idAll'];
	  //print_r($log_id);die;
	   $row=$privilege->delete("$log_id");
	   if($row){
		   $this->redirect("Log/lists");
	   }else{
	       $this->redirect("Log/lists");
	   }
	}
}?>