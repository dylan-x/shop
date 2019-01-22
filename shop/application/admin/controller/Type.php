<?php
namespace app\admin\controller;
use think\Db;
/**
 * 类型控制器
 */
class Type extends Common
{
	
	//添加
	public function add()
	{	
		//get请求,页面显示
		if (request()->isGet()) 
		{
			return $this -> fetch();
		}
		//post请求,添加入库
		$data = input();
		Db::name('type') -> insert($data);
		$this -> success('添加成功','index');
	}

	//列表显示
	public function index()
	{
		//查询类型数据
		$type = Db::name('type') -> select();
		//分配给模板
		$this -> assign('type',$type);
		return $this -> fetch();
	}

	//删除
	public function remove()
	{
		//接受类型的id
		$type_id = input('id/d');
		//删除对应的类型
		$result = Db::name('type') -> delete($type_id);
		if (!$result) {
			$this -> error('删除失败');
		}
		$this -> success('删除成功');
	}

	//修改
	public function edit()
	{
		
		//get请求,显示页面
		if (request()->isGet()) {
			//接受类型的id
			$type_id = input('id/d');
			$info = Db::name('type') -> find($type_id);
			$this -> assign('info',$info);
			return $this -> fetch();
		}
		//post请求,修改数据
		$data = input();
		//修改数据
		$result = Db::name('type') -> where('id',$data['id']) ->setField('type_name',$data['type_name']);
		if (!$result) {
			$this -> error('修改失败');
		}
		$this -> success('修改成功','index');
	}

}























