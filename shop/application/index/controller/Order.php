<?php
namespace app\index\controller;
use think\Db;

/**
 * 结算控制器
 */
class Order extends Common
{
	
	//结算页面显示
	public function check()
	{
		//判断用户是否登录
		$user_id = get_user_id();
		if ($user_id === FALSE) {
			//没有登录 请登录
			$this -> error('请先登录','user/login');
		}
		//已经登录
		//获取购物车信息
		$data = model('Cart') -> listData();
		$this -> assign('data',$data);
		return $this -> fetch();
	}




}
?>