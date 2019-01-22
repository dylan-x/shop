<?php
namespace app\index\model;
use think\Db;
use think\Model;
/**
 * 
 */
class Category extends Model
{
	//获取分类信息
	public function getCate()
	{
		return Db::name('category') -> select();
	}


}

?>