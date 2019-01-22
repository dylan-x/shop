<?php
namespace app\index\controller;
use think\Controller;
/**
 * 公共控制器
 */
class Common extends Controller
{
	public function __construct()
	{
		parent::__construct();
		//获取分类信息
		$category = model('Category') -> getCate();
		$this -> assign('category',$category);
	}
	

}




?>