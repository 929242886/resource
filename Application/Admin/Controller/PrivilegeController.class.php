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

class  PrivilegeController extends CommonController{

	//管理员添加
	public function add(){
		if($_POST)
		{   
            $privilege=D('Admin');
			
			//接收数据
			$res=$privilege->getadd();//var_dump($res);die;
			//入库操作
			if($privilege->add($res))
			{
				$this->redirect('Privilege/lists');
			}
			else
			{
				$this->redirect('Privilege/add');
			}
		}
		else
		{
            $data=$this->getList();
			//var_dump($data);die;
			$this->assign('data',$data);
			$this->display("Privilege/add");
		}
	}
	//管理员列表
    public function lists(){
		   
			$privilege=D('Admin');
		    //获取左侧
		    $this->data=$this->getList();
		  
  			$where = 'admin_id > 0';
	        $keyword = $_GET['keyword'];
			//echo $keyword;die;
	        if(!empty($keyword)) 
	        $where = " admin_name like '%$keyword%'"; 
	        $count = $privilege->where($where)->count();// 查询满足要求的总记录数
	        $Page  = new \Think\Page($count,4);// 实例化分页类 传入总记录数和每页显示的记录数
	        $Page->setConfig('first','第一页');
	        $Page->setConfig('prev','上一页');
	        $Page->setConfig('next','下一页');
	        $Page->setConfig('end','最后一页');
	        $show = $Page->show();// 分页显示输出
	        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
	        $list = $privilege->where($where)->order('admin_id desc ')->limit($Page->firstRow.','.$Page->listRows)->select();
	        //关键字标红
	        if(!empty($keyword)){
	            foreach($list as $k=>$v){
	               $list[$k]['admin_name'] =  str_replace($keyword,"<font color='red'>".$keyword."</font>",$v['admin_name']);
	            }
	        }
	        $this->assign('count',$count);
	        $this->assign('keyword',$keyword);
	        $this->assign('arr',$list);
	        $this->assign('page',$show);
            $this->display("Privilege/lists");
	}
    //删除管理员
	public function dele(){
	   $privilege=D('Admin');
	   $admin_id=$_GET['id'];
	   //echo $admin_id;die;
	   $row=$privilege->delete($admin_id);
	   if($row){
		   $this->redirect("Privilege/lists");
	   }else{
	       $this->redirect("Privilege/lists");
	   }
	}
	//编辑管理员
	public function edit()
	{
       $privilege=D('Admin');
	   if($_POST)
		{   
           
			$admin_id=$_POST['admin_id'];
			//接收数据
			$res=$privilege->getedit();//var_dump($res);die;
			//入库操作
			if($privilege->where("admin_id='$admin_id'")->save($res))
			{
				$this->redirect('Privilege/lists');
			}
			else
			{
				$this->redirect('Privilege/edit');
			}
		}
		else
		{
            $data=$this->getList();
			$admin_id=$_GET['id'];
			$row=$privilege->where("admin_id='$admin_id'")->find();//var_dump($row);die;
			$this->assign('data',$data);
            $this->assign('row',$row);
			$this->display("Privilege/update");
		}
	}
	//验证用户名唯一性
	public function checkname()
	{
	   $admin_name=$_GET['name'];
	   //echo $admin_name;
	   $privilege=D('Admin');
	   $row=$privilege->where("admin_name='$admin_name'")->find();
	   if($row)
	   {
		   echo 1;
	   }
	   else
	   {
		   echo -1;
	   }
	}
	//批量删除
	public function delAll()
	{
		
	   $privilege=D('Admin');
	   $admin_id=$_GET['idAll'];
	  //print_r($admin_id);die;
	   $row=$privilege->delete("$admin_id");
	   if($row){
		   $this->redirect("Privilege/lists");
	   }else{
	       $this->redirect("Privilege/lists");
	   }
	}
}
?>
	  
