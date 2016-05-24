<?php
  namespace Admin\Controller;
  use Think\Controller;
  class IndexController extends CommonController{
		 public function index()
		{
			$data=$this->getList();
			$this->assign('data',$data);
			$this->display('index');
		}

}
?>