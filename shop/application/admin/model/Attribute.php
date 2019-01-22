<?php
namespace app\admin\model;
use think\Model;
use think\Db;

/**
 * 属性的模型类
 */
class Attribute extends Model
{
	//获取属性列表信息
	public function listData()
	{
		//连表查询
		return $data = Db::name('attribute') -> field('a.*,b.type_name') -> alias('a') -> join('shop_type b','a.type_id = b.id','left') -> select();
	}



	//属性的添加
	public function addAttribute($data=[])
	{
		//根据录入方式选择
		if ($data['attr_input_type']==1) {
			//手工录入,可以不写attr_values属性值
			unset($data['attr_values']);
		}else{
			//列表选择,必须填写
			if (!$data['attr_values']) {
				//属性值为空,报错
				$this -> error ='列表选择属性值不能为空';
				return false;
			}
		}
		//添加数据,入库,返回值
		return Db::name('attribute') -> insert($data);
	}
	
}





















?>