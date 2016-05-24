<?php
namespace Admin\Model;
use Think\Model;


class AdminModel extends Model{

  //验证登陆
  public function login1(){
	  $post=$this->post_check($_POST);

	  $name =trim($post['admin_name']);
	  $password=trim($post['password']);
	  $admin_name=$this->actionClean($name);
      $pwd= $this->actionClean(MD5($password));
	  //echo $pwd;die;
	  if(empty($name))
	  {
		  return 'kname';die;
	  }
	 
	  if(empty($password))
	  {
		   return 'kpwd';die;
	  }
		 
	 
	  $row=$this->table("admin")->where("admin_name='$name' and password='$pwd'")->find();
	 
	  return $row;
  }

  //接收数据
  public function getadd(){
	  $post=$this->post_check($_POST);
	  $admin_name=trim($post['admin_name']);
	  $role_id=trim($post['role_id']);
	  $password=md5(trim($post['password']));
	  $add_time=date('Y-m-d H:i:s',time());
	  $row=array('admin_name'=>$admin_name,'role_id'=>$role_id,'password'=>$password,'add_time'=>$add_time);
	  return $row;
  }
  //修改后的数据
  public function getedit(){
      $post=$this->post_check($_POST);
	  $admin_name=trim($post['admin_name']);
	  $role_id=trim($post['role_id']);
	  $password=md5(trim($post['password']));
	  $add_time=date('Y-m-d H:i:s',time());
	  $row=array('admin_name'=>$admin_name,'role_id'=>$role_id,'password'=>$password,'add_time'=>$add_time);
	  return $row;
  }

   
    //批量删除
	public function dele($r_id){

		$e_id = '';
		foreach ($r_id as $key => $value) {
			$e_id .= $value.',';
		}
		$e_id = trim($e_id,',');
		$row = $this->table("qipin_resume")->where("r_id in($e_id)")->delete();
		return $row;

	}

    //防止sql注入,xss攻击
    public function post_check($post) {
      if(!get_magic_quotes_gpc()) {
          foreach($post as $key=>$val){
             $post[$key]  = addslashes($val);
          }
        }
      foreach($post as $key=>$val){
        //把"_"过滤掉
        $post[$key] = str_replace("_", "\_", $val);
        //把"%"过滤掉
        $post[$key] = str_replace("%", "\%", $val); //sql注入
        $post[$key] = nl2br($val);
        //转换html
        $post[$key] = htmlspecialchars($val); //xss攻击
      }
      return $post;
  }
   /*  防sql注入,xss攻击  (1)*/
    function actionClean($str)
    {
        $str=trim($str);
        $str=strip_tags($str);
        $str=stripslashes($str);
        $str=addslashes($str);
        $str=rawurldecode($str);
        $str=quotemeta($str);
        $str=htmlspecialchars($str);
        //去除特殊字符
        $str=preg_replace("/\/|\~|\!|\@|\#|\\$|\%|\^|\&|\*|\(|\)|\_|\+|\{|\}|\:|\<|\>|\?|\[|\]|\,|\.|\/|\;|\'|\`|\-|\=|\\\|\|/", "" , $str);
        $str=preg_replace("/\s/", "", $str);//去除空格、换行符、制表符
        return $str;
    }
	
	/****
	**  name:zhangcheng
	**  tel:57689
	**  time:08:58:20
	****
	*/	

    //左侧菜单列表
    
    public function getList(){
        $u_id=session('admin_id');
        //var_dump($u_id);die;
        $data=$this->join("admin join rp on rp.role_id=admin.role_id join privilege on privilege.privilege_id=rp.privilege_id")->where("admin.admin_id=$u_id and privilege.pid=0")->select();
        foreach($data as $k=>$v){
          $arr=$this->join("admin join rp on rp.role_id=admin.role_id join privilege on privilege.privilege_id=rp.privilege_id")->where("admin.admin_id=$u_id and privilege.pid=".$v['privilege_id'])->select();
          $data[$k]['son']=$arr;
        }
        return $data;
    }
}
?>