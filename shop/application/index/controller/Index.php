<?php
namespace app\index\controller;
use think\Db;

/**
 * 首页控制器
 */
class Index extends Common
{
	//显示首页
	public function index()
	{
		//分配一个表示为首页
		$this -> assign('is_index',1);
		//首页热卖显示
		$hot = model('Goods') -> getRecGoods('is_hot');
		$this -> assign('hot',$hot);
		return $this -> fetch();
	}
}
