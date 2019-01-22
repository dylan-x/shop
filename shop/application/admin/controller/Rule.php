<?php
namespace app\admin\controller;
use think\Db;
/**
 * 权限控制器
 */
class Rule extends Common
{
	//添加
	public function add()
	{
		//get请求,显示页面
		if (request()->isGet()) {
			//获取权限分类信息
			$rule = model('Rule') -> getRuleTree();
			$this -> assign('rule',$rule);
			return $this -> fetch();
		}
		//post请求,数据入库
		Db::name('rule') -> insert(input());
		$this -> success('ok','index');
	}

	//列表的显示
	public function index()
	{
		$data = model('Rule') -> getRuleTree();
		$this -> assign('data',$data);
		return $this -> fetch();
	}

	//删除
	public function del()
	{
		//获取id
		$id = input('id/d');
		$model = model('Rule');
		//调用模型方法
		$result = $model -> delRule($id);
		if ($result === false) {
			$this -> error($model->getError());
		}
		$this -> success('删除成功','index');
	}

	//修改
	public function edit()
	{
		//获取id
		$id = input('id/d');
		//get请求,显示编辑页面
		if (request()->isGet()) {
			//获取数据
			$data = Db::name('rule') -> find($id);
			$this -> assign('data',$data);
			//获取权限分类信息
			$tree = model('Rule') -> getRuleTree();
			$this -> assign('tree',$tree);
			//渲染模板
			return $this -> fetch();
		}
		//post请求,数据入库
		$rule_info = input();
		//更新数据
		$result = model('Rule') -> isUpdate(true) -> save($rule_info);
		if (!$result) {
			$this -> error('修改失败');
		}
		$this -> success('修改成功','index');
		
	}
}




?>