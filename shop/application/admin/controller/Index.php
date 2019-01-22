<?php 
namespace app\admin\controller;

/**
* 后台首页控制器
*/
class Index extends Common
{
	
	public function index()
	{
		return $this->fetch();
	}
	public function top()
	{
		return $this->fetch();
	}
	public function menu()
	{
		$this -> assign('menus',$this->_user['menus']);
		return $this->fetch();
	}
	public function main()
	{
		return $this->fetch();
	}
}
?>