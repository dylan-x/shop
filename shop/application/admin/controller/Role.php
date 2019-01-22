<?php
namespace app\admin\controller;
use think\controller;
use think\Db;

/**
 * 角色控制器
 */
class Role extends Common
{
	//分配权限
	public function disfetch()
	{
		//需要修改权限的角色id
		$role_id = input('id/d');
		//get请求,显示权限分配页面
		if (request()->isGet()) {
			//获取当前角色已有的权限
			$info = Db::name('role') -> find($role_id);
			$this -> assign('info',$info);
			//获取所有权限信息
			$data = Db::name('rule') -> select();
			// dump($data);die;
			$this -> assign('data',$data);
			return $this -> fetch();
		}
		//post表单提交,数据入库
		$rule = input('rule/a');
		//将数组转化为字符串
		$rule = implode(',', $rule);
		//数据入库
		Db::name('role') -> where('id',$role_id) -> setField('rule_ids',$rule);
		$this -> success('ok','index');
	}
	//添加
	public function add()
	{
		//get请求,显示添加角色页面
		if (request()->isGet()) {
			return $this -> fetch();
		}
		//post请求,提交数据入库
		Db::name('role') -> insert(input());
		$this -> success('添加成功','index');
	}

	//列表显示
	public function index()
	{
		//获取角色表数据
		$data = Db::name('role') ->select();
		$this -> assign('data',$data);
		return $this -> fetch();
	}

	//修改
	public function edit()
	{
		//get请求,显示修改页面
		if (request()->isGet()) {
			$info = Db::name('role') -> find(input('id/d'));
			$this -> assign('info',$info);
			return $this -> fetch();
		}
		//post请求,提交修改,数据入库
		$data = input();
		$res = Db::name('role') -> update($data);
		if (!$res) {
			$this -> error('修改失败');
		}
		$this -> success('修改成功','index');

	}

	//删除
	public function remove()
	{
		$id = input('id/d');
		if ($id <= 1){
			$this -> error('参数错误');
		}
		$res = Db::name('role') -> delete($id);
		if (!$res) {
			$this -> error('删除失败');
		}
		$this -> success('删除成功','index');
	}


}



?>