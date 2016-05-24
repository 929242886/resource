<?php

namespace Admin\model;
use Think\Model;

	/****
	**	资源管理
	** 	name:zhangcheng
	** 	tel:57689
	** 	time:16/05/21
	****
	*/
class TypeModel extends Model{

		/*
		*王一尘
		*方法名selectTypeone
		*/
		function selectTypeone($id){
			//var_dump($id);die;
			return $this->Table("type")->where("t_id=$id")->find();
		}
		
}