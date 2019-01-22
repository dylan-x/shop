<?php
namespace app\admin\model;
use think\Model;
use think\Db;
/**
 * 权限模型
 */
class Rule extends Model
{
	//获取所有权限分类
	public function getRuleTree($id=0,$is_clear=false)
	{
		//获取所有分类信息
		$category = Db::name('rule') -> select();
		return get_cate_tree($category,$id,0,$is_clear);
	}

	//删除权限
	public function delRule($id)
	{
		//判断是不是顶级权限 有子权限不能删除
		if (Db::name('rule')->where('parent_id',$id)->find()) {
			$this -> error = '存在子权限';
			return false;
		}
		//没有子权限
		$result = Db::name('rule') -> where('id',$id) -> delete();
		if (!$result) {
			$this -> error = '删除失败';
			return false;
		}
		
	}


}

?>