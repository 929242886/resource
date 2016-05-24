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
class ResourceModel extends Model{

	//资源列表
	public function reList(){
		$arr=$this->order("add_time desc")->select();
		return $arr;
	}

	public function typeId($id){
		return $this->Table("type")->where("t_id=$id")->find();
	}
	/*
		*王一尘
		*@方法名resourcelist
		*/
		function resourcelist($sou){
			return $this->Table("resource")->where("resource like '%$sou%'")->select();
		}
		/*
		*王一尘
		*@方法名Resourcetid
		*/
		function Resourcetid($id){
			return $this->Table("resource")->where("t_id=$id")->select();
		}
		/*
		*王一尘
		*@方法名selectSearchtype
		*/
		function selectSearchtype($sou){
			return $this->Table("type")->where("type like '%$sou%'")->select();
		}
		/*
		*王一尘
		*@方法名selectResource
		*/
		function selectResource(){
			return $this->Table("resource")->where("re_id>0")->select();
		}
		/*
		*王一尘
		*@方法名selectClick
		*/
		function selectClick($t_id){
			return $this->Table("type")->where("f_id=$t_id")->select();
		}
		/*
		*王一尘
		*@方法名selectWenjianjia
		*/
		function selectWenjianjia(){
			return $this->Table("type")->where("f_id=0")->select();
		}
		/*
		*王一尘
		*@方法名selectType
		*/
		function selectType($id){
			return $this->Table("type")->where("f_id=$id")->select();
		}
		/*
		*王一尘
		*方法名selectTypeone
		*/
		function selectTypeone($id){
			return $this->Table("type")->where("t_id=$id")->find();
		}
		/*
		*王一尘
		*方法名resourceOne
		*/
		function resourceOne($re_id){
			return $this->Table('resource')->where("re_id=$re_id")->find();
		}
}