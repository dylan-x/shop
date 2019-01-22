<?php
namespace app\index\controller;
use think\Db;

/**
 * 商品控制器
 */
class Goods extends Common
{
	
	//商品详情页展示
	public function index()
	{
		//获取商品的id
		$goods_id = input('id/d');
		//获取商品信息
		$goods_info = model('Goods') -> getGoodsInfo($goods_id);
		$this -> assign('goods_info',$goods_info);
		return $this -> fetch();
	}

	


}
?>