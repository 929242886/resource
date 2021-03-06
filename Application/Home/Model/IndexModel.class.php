<?php
namespace Home\Model;
use Think\Model;


class IndexModel extends Model{

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
		  echo "用户名不能为空";die;
	  }
	 
	  if(empty($password))
	  {
		   echo "密码不能为空";die;
	  }
		 
	 
	  $row=$this->table("admin")->where("admin_name='$name'")->find();
	 
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
	
}
?>