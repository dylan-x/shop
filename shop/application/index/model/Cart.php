<?php
namespace app\index\model;
use think\Model;
use think\Db;

/**
 * 购物车模型
 */
class Cart extends Model
{
	//登录后,将cookie中的数据转移到数据库中
	public function cookieToDb()
	{
		
		$user_id = get_user_id();
		if ($user_id === FALSE) {
			return FALSE;
		}
		//获取cookie购物车数据
		$list = cookie('cartlist')?cookie('cartlist'):[];
		foreach ($list as $key => $value) {
			$tmp = explode('-',$key);
			$map = [
				'user_id' => $user_id,
				'goods_id' => $tmp[0],
				'goods_attr_ids' => $tmp[1]
			];

			if (Db::name('cart') -> where($map) -> find()) {
				//如果购物车表,有此商品,则修改数量
				Db::name('cart') -> where($map) -> serField('goods_count',$value);
			}else{
				//没有此商品,则添加
				$map['goods_count'] = $value;
				Db::name('cart') -> insert($map);
			}
		}
		//清空cookie中的cartlist数据
		cookie('cartlist',null);
	}

	//更改购物车商品数量
	public function changeCartGoodsNumber($goods_id,$goods_count,$goods_attr_ids)
	{
		$user_id = get_user_id();
		if ($user_id === FALSE) {
			//没有登录 修改cookie中商品数量
			$list = cookie('cartlist')?cookie('cartlist'):[];
			$key = $goods_id.'-'.$goods_attr_ids;
			$list[$key] = $goods_count;
			cookie('cartlist',$list[$key]);
		}else{
			//已经登录 修改数据库中的商品数量
			$map = [
				'goods_id'=>$goods_id,
				'goods_attr_ids'=>$goods_attr_ids,
				'user_id'=>$user_id
			];
			//修改购物车表中商品数量
			Db::name('cart') -> where($map) -> setField('goods_count',$goods_count);
			
		}

	}

	//删除购物车商品
	public function delCartGoods($goods_id,$goods_attr_ids)
	{
		$user_id = get_user_id();
		if ($user_id === FALSE) {
			//没有登录,删除cookie中购物车商品
			$list = cookie('cartlist')?cookie('cartlist'):[];
			$key = $goods_id.'-'.$goods_attr_ids;
			unset($list[$key]);
			cookie('cartlist',$list);
		}else{
			//已经登录,删除数据库中购物车商品
			$map = [
				'user_id' => $user_id,
				'goods_id' => $goods_id,
				'goods_attr_ids' => $goods_attr_ids
			];
			$result = Db::name('Cart') -> where($map) -> delete();
			
		}
	}

	//获取购物车信息
	public function listData()
	{
		
		$user_id = get_user_id();
		if ($user_id === FALSE) {
			//没有登录
			$list = cookie('cartlist')?cookie('cartlist'):[];
			$cart =[];
			//将cookie中的数据转化为与登录后的数据相同的格式
			foreach ($list as $key => $value) {
				$tmp = explode('-', $key);
				$cart[] = [
					'goods_id' => $tmp[0],
					'goods_count' => $value,
					'goods_attr_ids' => $tmp[1]
				];
			}
		}else{
			//已经登录
			$cart = Db::name('Cart') -> where('user_id',$user_id) -> select();	
		}
		//保存商品总金额和商品数量
		$total = ['money'=>0,'number'=>0];
		foreach ($cart as $key => $value) {
			//获取商品信息
			$cart[$key]['goods_info'] = Db::name('goods') ->find($value['goods_id']);
			//获取属性名,属性值
			$cart[$key]['attrs'] = Db::name('goods_attr') ->alias('a') -> field('b.attr_name,a.attr_values') -> join('shop_attribute b','b.id=a.attr_id','left') -> where('a.id','in',$value['goods_attr_ids']) ->select();
			$total['number'] += $value['goods_count'];
			$total['money'] += $cart[$key]['goods_info']['shop_price']*$value['goods_count'];
		}
		return ['list'=>$cart,'total'=>$total];
	}

	//添加商品到购物车
	public function addCart($goods_id,$goods_count,$goods_attr_ids)
	{
		//获取用户id
		$user_id = get_user_id();
		//没有登入
		if ($user_id === FALSE) {
			//没有登入
			//先从cookie中获取购物车的信息
			$cart = cookie('cartlist')?cookie('cartlist'):[];
			//组装下标
			$key = $goods_id.'-'.$goods_attr_ids;
			if (array_key_exists($key, $cart)) {
				//下标在数组里面,数量进行累加
				$cart[$key] += $goods_count; 
			}else{
				$cart[$key] = $goods_count;
			}
			//将数据保存到cookie中
			cookie('cartlist',$cart);
		}else{
			//已经登入
			//组装商品条件
			$map=[
				'user_id' => $user_id,
				'goods_id' => $goods_id,
				'goods_attr_ids' => $goods_attr_ids
			];
			//查找数据库,是否存在同样的商品
			if (Cart::get($map)) {
				//存在
				Db::name('Cart') -> where($map) -> setInc('goods_count',$goods_count);
			}else{
				//不存在
				$map['goods_count'] = $goods_count;
				Db::name('Cart') -> insert($map);
			}
		}
	}


}



?>