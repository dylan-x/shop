<?php
namespace app\admin\controller;
use think\Db;

/**
 * 后台管理员用户控制器
 */
class Admin extends Common
{
	//用户信息的编辑
	public function edit()
	{
		$id = input('id/d');
		if ($id <= 1) {
			$this -> error('参数错误');
		}
		//get请求,显示页面
		$obj = Db::name('admin');
		if (request()->isGet()) {
			//获取用户信息
			$info = $obj -> find($id);
			$this -> assign('info',$info);
			//获取角色信息
			$role = Db::name('role') -> select();
			$this -> assign('role',$role);
			return $this -> fetch();
		}
		//post请求,数据入库
		$data = input();
		if ($data['password']) {
			//用户提交密码,需要修改
			$data['password'] = md5($data['password']);
		}else{
			//没有填写密码,则不修改
			unset($data['password']);
		}
		//检查账号
		$where=[
			'username'=>$data['username'],
			'id'=>['neq',$data['id']]//排除自己本身
		];
		if ($obj -> where($where) -> find()) {
			$this -> error('用户名错误');
		}
		//修改账号信息
		$obj -> update($data);
		$this -> success('修改成功','index');
	}
	
	
	//删除
	public function remove()
	{
		$id = input('id/d');
		if ($id <= 1) {
			$this -> error('参数错误');
		}
		$result = Db::name('admin') -> delete($id);
		$this -> success('删除成功','index');
	}
	
	//添加
	public function add()
	{
		//get请求,显示添加页面
		if (request()->isGet()) {
			//获取所有角色信息
			$role = Db::name('role') -> select();
			$this -> assign('role',$role);
			return $this -> fetch();
		}
		//post请求 表单提交 数据入库
		$data = input();
		$result = model('Admin') -> addUser($data); 
		if (!$result) {
			//添加失败
			$this -> error('添加失败');
		}
		$this -> success('添加成功','index');
	}

	//列表显示
	public function index()
	{
		//获取用户信息 连表查询 获取角色名称
		$info = Db::name('admin') -> alias('a') -> field('a.*,b.role_name') -> join('shop_role b','a.role_id=b.id','left') ->select();
		$this -> assign('info',$info);
		//显示用户列表页面
		return $this -> fetch();
	}
}



?>