<?php
namespace app\index\model;
use think\Db;
use think\Model;
/**
 * 
 */
class Goods extends Model
{

	//获取商品信息
	public function getGoodsInfo($goods_id)
	{
		$goods_info = Db::name('goods') -> find($goods_id);
		//获取商品相册
		$goods_info['image'] = Db::name('goods_img') -> where('goods_id',$goods_id) -> select();
		//获取属性信息 连表查询
		$attribute = Db::name('goods_attr') -> alias('a') -> field('a.*,b.attr_name,b.attr_type') -> join('shop_attribute b','a.attr_id=b.id','left') -> where('goods_id',$goods_id) -> select();
		//唯一属性
		$goods_info['unique'] = [];
		//单选属性
		$goods_info['radio'] = [];
		foreach ($attribute as $key => $value) {
			if ($value['attr_type'] == 1) {
				//唯一属性
				$goods_info['unique'][] = $value;
			}else{
				//单选属性
				$goods_info['radio'][$value['attr_id']][] = $value; 
			}
		}
		return $goods_info;
	}

	//获取分类信息
	public function getCate()
	{
		return Db::name('category') -> select();
	}

	//获取推荐状态的商品  is_hot  is_rec  is_new
	public function getRecGoods($field='is_hot')
	{
		return Db::name('goods') -> limit(5) -> where($field,1) -> order("id desc") ->select();
	}



}

?>