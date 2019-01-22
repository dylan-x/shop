<?php
namespace app\admin\controller;
use think\Controller;
use think\captcha\Captcha;
/**
 * 登录的控制器
 */
class Login extends Controller
{
	//退出登录
	public function logout()
	{
		//清除cookie中的user_info用户登录信息
		cookie('user_info',null);
		$this -> success('退出成功','index');
	}


	//用户登录
	public function index()
	{
		//get请求,显示登录页面
		if (request()->isGet()) 
		{
			return $this -> fetch();
		}
		//post请求,实现用户登录
		$data = input();
		$model = model('Admin');
		$result = $model -> login($data);
		if ($result === false) {
			//验证失败
			$this -> error($model -> getError());
		}
		$this -> success('登入成功','index/index');

	}

	//生成验证码图片(未做gd库有问题)
	public function makeCaptcha()
	{
		$obj = new Captcha();
		return  $obj -> entry();
	}

}








?>