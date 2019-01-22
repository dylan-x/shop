<?php
namespace app\index\model;
use think\Model;
use think\Db;

/**
 * 用户模型
 */
class User extends Model
{
	
	//注册数据入库
	public function regist($postData=[])
	{
		if (Db::name('user') -> where('username',$postData['username']) -> find()) {
			$this -> error = "用户名存在";
			return FALSE;
		}
		//计算出用户对应盐的内容
		$postData['salt'] = rand(100000,999999);
		//计算出加密后的密码
		$postData['password'] = md6($postData['password'],$postData['salt']);
		//写入数据库
		$result = model('user') -> isUpdate(false) -> allowField(true) -> save($postData);
		if (!$result) {
			$this -> error = '注册失败';
			return false;
		}
		return true;
	}

	//登入验证
	public function login($data=[])
	{
		//获取账户信息
		$user_info = Db::name('user') -> where('username',$data['username']) -> find();

		if (!$user_info) 
		{
			$this -> error = '用户名错误';
			return false;
		}
		//验证密码
		if ($user_info['password'] != md6($data['password'],$user_info['salt'])) 
		{
			$this -> error = '密码错误';
			return false;
		}
		
		//保存用户状态
		unset($user_info['password']);
		unset($user_info['salt']);

		session('user_info',$user_info);
		//将cookie中购物车的数据转移到数据库中
		model('Cart') -> cookieToDb();
		return true;
	}
}






?>