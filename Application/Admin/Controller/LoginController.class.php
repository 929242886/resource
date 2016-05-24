<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller
{
	//显示登录表单的方法
	public function login()
	{
		$this->display('login');
	}
	
	//登录验证
	public function dologin(){
		
     	 $admin=D('Admin');
		 $row=$admin->login1();
		 if($row == 'kname'){
			 $this->error('用户名不能为空',U('Login/login'));
			die;
		 }
		 if($row == 'kpwd'){
			 $this->error('密码不能为空',U('Login/login'));
			die;
		 }
		 $name=$row['admin_name'];
		 if($row){

			 //开启session
			 session_start();
			 session('admin_name',$name);
			 session('admin_id',$row['admin_id']);

			 $this->success("欢迎登陆",U('Index/index'));
		 }else{
			  $this->error('用户名或密码错误',U('Login/login'));
		 }
     }  
	 /*//验证登录信息
	 public function checkall1()
	 {
        
		 echo 2;
	 }*/
	//退出成功
	public function logout()
	{
		unset($_SESSION['admin_name']);
        unset($_SESSION['admin_id']);
		$this->success('退出成功',U('Login/login'));
	}
	
		 
		
}



?>