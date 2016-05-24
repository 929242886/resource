<?php
namespace Home\Model;
use Think\Model;


class TypeModel extends Model{

  //查询文件夹
  public function c_folder(){
    $arr = $this->where("f_id = 0")->select();
    return $arr;
  }

}