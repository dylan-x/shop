<?php
namespace app\admin\controller;
use think\Request;
use think\Db;

/**
 * 分类的控制器
 */
class Category extends Common
{
	//显示分类添加模板
	public function add()
	{
		//get请求,显示分类添加模板
		if(request()->isGet()){
			//获取所有的分类信息，并格式化数据
			$category = model('category') -> getCateTree();
			//分配数据,渲染模板
			$this -> assign('category',$category);
			return $this -> fetch();
		}
		//post请求,提交数据
		//接受表单提交的数据,过滤函数设置
		$data = input();
		//判断分类名称是否为空
		if (empty($data['cate_name'])) {
			 $this ->error('数据不能为空');
		}
		//创建db类对象
		$obj = Db::name('category');
		//添加数据到数据库中
		$res = $obj -> insert($data);
		if (!$res) {
			//插入失败
			$this -> error('数据写入出错');
		}
		//成功
		$this -> success('数据成功','index');
	}
	//显示分类的列表页面
	public function index()
	{
		//获取所有的分类信息，并格式化数据
		$data = model('category') -> getCateTree();
			// //获取query对象
			// $db = Db::name('category');
			// //从数据库中查询数据
			// $data = $db -> select();
			// //格式化数据
			// $data = get_cate_tree($data);
		//将数据分配给模板
		$this -> assign('data',$data);
		//渲染模板
		return $this -> fetch();
	}
	//remove实现删除
	public function remove()
	{
		//获取传递过来的id
		$cate_id = input('id/d',0);
		//获取query对象
		$db = Db::name('category');
		//查询对应id的数据
		$data = $db -> where("parent_id",$cate_id) -> find();
		//判断有没有子类
		if($data){
			//有子分类
			$this -> error('存在子分类,不能删除');
		}
		//没有子分类
		$db -> where('id',$cate_id) -> delete();
		$this -> success('删除成功','index');
	}
	//edit实现修改
	public function edit()
	{
		//获取传递过来的id
		$cate_id = input('id/d',0);
		//获取要修改的类别信息
		$cate = db('category') -> find($cate_id);
		
		//获取query对象
		$db = Db::name('category');

		//get请求方式
		if (request()->isGet()) 
		{
			//获取要修改的数据的id
			$data = $db -> where('id',$cate_id) -> find();
			//获取所有的分类信息，并格式化数据
			$category = model('category') -> getCateTree();
				// //获取所有数据
				// $category = $db -> select();
				// //数据格式化
				// $category = get_cate_tree($category);
			//分配数据给模板
			$this -> assign('data',$data);
			$this -> assign('category',$category);
			//渲染页面
			return $this -> fetch();
		}

		//获取传递过来的id
		$cate = input();
		$model = model('Category');
		//post请求方式,更新数据
		//调用模型方法
		$result = $model -> editCategory($cate);

		//获取模型对象
		
		if($result === FALSE){
			//dump($model);die;
			$this -> error($model->getError());
		}
		 $this -> success('修改成功','index');
	}


}



?>