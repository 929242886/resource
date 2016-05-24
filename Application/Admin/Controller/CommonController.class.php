<?php

namespace Admin\Controller;
use Think\Controller;

	/****
	** 	name:zhangcheng
	** 	tel:57689
	** 	time:16/05/21
	****
	*/
class CommonController extends Controller{

	//登录验证
	public function _initialize(){
		$u_id=session('admin_id');
		if(!session('admin_id')){
			$this->error("请先登录",U("Login/login"),2);
		}
			// $admin=D('Admin');
	  // $data=$admin->field("concat(privilege.controller,'-',privilege.action) url")->join("admin join rp on rp.role_id=rp.role_id join privilege on privilege.privilege_id=rp.privilege_id")->where("admin.admin_id=$u_id")->group("privilege.privilege_id")->select();
			// // print_r($data);die; 
			//  $str=CONTROLLER_NAME.'-'.ACTION_NAME;
			//  //var_dump($str);die;

			// if(in_array($str,$data)){
			// 	return true;
			// }else if($str=="Index/index"){
			// 	return true;
			// }else{
			// 	$this->error('您没有权限',U('Index/index'),2);
			// }	
	}

	public function getList(){
		$privilege=D('Admin');
		$data=$privilege->getlist();		
		return $data;
	}
	
}