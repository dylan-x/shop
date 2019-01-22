<?php
namespace app\index\controller;
use think\Db;

/**
 * 购物车控制器
 */
class Cart extends Common
{

	//更改购物车商品数量
	public function changeCartGoodsNumber()
	{
		$goods_id = input('goods_id');
		$goods_count = input('goods_count');
		$goods_attr_ids = input('goods_attr_ids');
		//使用模型方法
		$model = model('Cart');
		$result = $model -> changeCartGoodsNumber($goods_id,$goods_count,$goods_attr_ids);
		
	}

	//删除购物车商品
	public function delCartGoods()
	{
		$goods_id = input('goods_id/d');
		$goods_attr_ids = input('goods_attr_ids');
		$model = model('Cart');
		$result = $model -> delCartGoods($goods_id,$goods_attr_ids);
		if ($result === false) {
			$this -> error($model -> getError());
		}
		$this -> success('删除成功','index');
	}

	//显示购物车
	public function index()
	{	
		
		//获取购物车信息,属性信息
		$data = model('Cart') -> listData();
		$this -> assign('data',$data);
		return $this -> fetch();
	}

	//商品加入购物车
	public function addCart()
	{
		//接收表单数据
		$goods_id = input('goods_id/d');
		$goods_count = input('goods_count/d');
		$goods_attr_ids = input('goods_attr_id/a',[]);	
		//将属性值的ID转化为字符串
		$goods_attr_ids = implode(',', $goods_attr_ids);
		$model = model('Cart');
		//调用模型方法写入数据库
		$result = $model -> addCart($goods_id,$goods_count,$goods_attr_ids);
		if ($result === false) {
			$this -> error($model -> getError());
		}
		$this -> success('添加成功','index');
	}
	
}






?>