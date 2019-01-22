<?php
namespace app\index\controller;

/**
 * 用户控制器
 */
class User extends Common
{
	
	//退出
	public function logout()
	{
		session('user_info',null);
		$this -> success('退出成功','user/login');
	}

	//注册
	public function regist()
	{
		if (request()->isGet()) {
			return $this-> fetch();
		}
		//接受数据
		$result = model('User') -> regist(input());
		if ($result === false) {
			$this -> error(model('User')->getError());
		}
		$this -> success('注册成功','login');
	}

	//登录
	public function login()
	{
		if (request()->isGet()) {
			return $this -> fetch();
		}
		//接受登录信息
		$result = model('User') -> login(input());
		if (!$result) {
			$this -> error(model('User')->getError());
		}
		
		$this -> success('登入成功','index/index');
	}
}






?>