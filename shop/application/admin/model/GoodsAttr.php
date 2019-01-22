<?php 
namespace app\admin\model;
use think\Model;
/**
* 商品属性值表对应的模型
*/
class GoodsAttr extends Model
{
	// 实现属性值入库
	public function insertGoodsAttr($goods_id,$attr_ids,$attr_values)
	{
		$list = [];//保存最终需要的二维数组的格式
		$tmp = [];//保存使用attr_id 与attr_value组装的数组为一维数组 
		foreach ($attr_ids as $key => $value) {
			$attr_id_value = $value.'-'.$attr_values[$key];
			if(in_array($attr_id_value, $tmp)){
				// 要添加的内容在临时变量中存在说明重复
				continue;
			}
			$tmp[]=$attr_id_value;
			$list[]=[
				'goods_id'=>$goods_id,
				'attr_id'=>$value,
				'attr_values'=>$attr_values[$key]
			];
		}
		// 将数据批量写入
		if($list){
			db('goods_attr')->insertAll($list);
		}
	}
}

?>