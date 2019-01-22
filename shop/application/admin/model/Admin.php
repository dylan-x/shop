<?php
namespace app\admin\model;
use think\Model;

/**
 * 
 */
class Admin extends Model
{
	//添加管理员用户
	public function addUser($data)
	{
		//验证账号名的唯一性
		if ($this -> get(['username'=>$data['username']])) {
			//存在相同的账号名
			$this ->error='用户名存在';
			return false;
		}
		//密码加密
		$data['password'] = md5($data['password']);
		//数据入库
		return $this -> isUpdate(false) -> allowField(true) ->save($data);
	}

	//管理员登录
	public function login($data)
	{
		//验证用户名和密码
		$map = [
			'username' => $data['username'],
			'password' => md5($data['password'])
		];
		$user_info = $this -> get($map);
		if (!$user_info) {
			//验证失败
			$this -> error ='账号信息错误';
			return false;
		}
		//验证成功后,保存信息到cookie中
		//设置cookie有效时间 默认0,浏览器关闭销除cookie信息
		$expire = 0;
		//开启cookie
		cookie('a');
		//判断是否存在remember值
		if (isset($data['remember']))
		{
			//设置cookie有效时间为1天
			$expire = 3600*24;
		}
		//保存用户信息到cookie中,将$user_info对象转化为数组
		cookie('user_info',$user_info -> toArray(),$expire);
	}


	
}

?>