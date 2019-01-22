<?php
namespace app\admin\controller;
use think\Db;
/**
 * 属性的控制器
 */
class Attribute extends Common
{
	//修改(未完)
	public function edit()
	{
		//get请求,显示页面
		if (request()->isGet()) {
			//获取id对应的属性信息
			$info = Db::name('Attribute')-> find(input('id/d'));
			//分配给模板
			$this -> assign('info',$info);
			//获取类别信息
			$type = Db::name('type') -> select();
			$this -> assign('type',$type);
			return $this -> fetch();
		}
		//post请求,修改数据,入库
		
	}

	//删除
	public function remove()
	{
		//接受id
		$attr_id = input('id/d');
		//删除属性
		$result = Db::name('attribute') -> where('id',$attr_id) -> delete();
		if ($result !== 1) {
			//数据删除失败
			$this -> error('删除失败');
		}
		//添加成功
		$this -> success('删除成功','index');
	}

	//添加
	public function add()
	{
		//获取类型信息
		$type = Db::name('type') -> select();
		//get请求,显示添加页面
		if (request()->isGet()) 
		{
			$this -> assign('type',$type);
			return $this -> fetch();
		}
		//post请求,添加数据入库
		$attrs = input();
		//数据入库,调用模型方法
		$model = model('Attribute');
		$result = $model -> addAttribute($attrs);
		if ($result === false) {
			//数据添加失败
			$this -> error($model ->getError());
		}
		//添加成功
		$this -> success('添加成功');
	}

	//列表显示
	public function index()
	{
		//获取属性信息
		$model = model('Attribute');
		$data = $model -> listData();
		//分配给模板
		$this -> assign('data',$data);
		return $this -> fetch();
	}
	
}






















?>