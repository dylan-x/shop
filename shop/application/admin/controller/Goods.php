<?php
namespace app\admin\controller;
use think\Request;
use think\Db;

/**
 * 商品的控制器
 */
class Goods extends Common
{
    //根据类型ID获取属性信息
    public function showAttr()
    {
        //获取type_id
        $type_id = input('type_id');
        if ($type_id <= 0) {
            return '参数错误';
        }
        //获取属性信息
        $result = Db::name('attribute') -> where('type_id',$type_id) -> select();
        foreach ($result as $key => $value) {
            if ($value['attr_input_type']==2) {
                //select选择,将attr_values值转成数组
                $result[$key]['attr_values'] = explode(',', $value['attr_values']);
            }
        }
        $this -> assign('result',$result);
        return $this -> fetch();
    }

    //伪删除
    public function remove()
    {
        //获取id
        $goods_id = input('id/d');
        //设置is_del字段,伪删除商品
        $result = Db::name('goods') -> where('id',$goods_id) -> setField('is_del',1);
        if (!$result) {
            $this -> error('删除失败');
        }
        $this -> success('删除成功','index');
    }
    
    //回收站列表显示
    public function recycle()
    {
        //获取所有分类信息
        $model = model('Goods');
        $category = model('Category') -> getCateTree();
        //分配给模板
        $this -> assign('category',$category);
        //获取is_del字段为1的商品信息
        $data = model('goods') -> listData(1);
        $this -> assign('data',$data);
        //渲染模板
        return $this -> fetch();
    }

    //商品还原
    public function rollback()
    {
        //获取id
        $goods_id = input('id/d');
        //将此商品is_del字段设置为0
        $result = Db::name('goods') -> where('id',$goods_id) -> setField('is_del',0);
        if (!$result) {
            $this -> error('还原失败');
        }
        $this -> success('还原成功','index');
    }

    //彻底删除
    public function del()
    {
        //获取id
        $goods_id = input('id/d');
        //删除商品
        $result = Db::name('goods') -> delete($goods_id);
        $this -> success('删除成功','index');
    }
    
    //编辑
    public function edit()
    {
        //get请求,显示页面
        $goods_id = input('id/d',0);
        $model = model('Goods');
        if (request()->isGet()) 
        {
            //获取需要编辑商品的信息
            $data = $model -> where('id',$goods_id) -> find();
            //分配给模板
            $this -> assign('data',$data);
            //获取所有分类信息
            $category = model('Category') -> getCateTree();
            //分配给模板
            $this -> assign('category',$category);
            //渲染页面
            return $this -> fetch();
        }
        //post请求,提交数据
        $data = input();
        //验证数据
        $result = $this -> validate($data,'Goods');
        if ($result !== TRUE) {
            $this -> error($result);
        }
        //货号检查,第二个参数 true为编辑操作
        if ($this -> checkGoodsSn($data,TRUE) === FALSE) {
            $this -> error('货号错误');
        }
        //数据入库
        $res = $model -> editGoods($data);
        if ($res === false) {
            $this -> error('修改失败');
        }
        $this -> success('修改成功','index');
    }


    //状态切换
    public function changeStatus()
    {
        $goods_id = input('goods_id');
        $field = input('field');
        //获取模型对象
        $model = model('Goods');
        $result = $model -> changeStatus($goods_id,$field);
        if ($result === FALSE) {
            //数据写入异常
            return json(['status'=>0,'msg'=>$model->getError()]);
        }
        return json(['status'=>1,'msg'=>'ok','code'=>$result]);

    }

    //列表显示
    public function index()
    {
        //获取商品信息
        //获取模型对象
        $model = model('Goods');
        //获取所有分类信息
        $category = model('Category') -> getCateTree();
        //分配数据
        $this ->assign('category',$category);
        //调用方法,获取商品信息
        $data = $model -> listData();
        //分配数据给模板
        $this -> assign('data',$data);
        return $this -> fetch();
    }
    // 添加
    public function add()
    {
        if(request()->isGet()){
            // 获取所有的类型
            $type = get_type_info();
            $this->assign('type',$type);
            // 获取到所有的分类数据
            $category = model('Category')->getCateTree();
            $this->assign('category',$category);
            return $this->fetch();
        }
        // 实现数据的入库
        $data = input();


        $goods_model = model('Goods');
        // 商品图片上传
        if($this->uploadGoodsImage($data) === FALSE){
            $this->error('文件上传错误');
        }
        // 校验数据 如果数据校验不通过 直接返回错误信息
        $result = $this->validate($data,'Goods');
        if($result !== TRUE){
            $this->error($result);
        }
        // 检查商品货号
        if(!$this->checkGoodsSn($data)){
            $this->error('货号错误');
        }
        // 调用模型下自定义的方法实现数据的入库
        $result = $goods_model->addGoods($data,input('attr_ids/a'),input('attr_values/a'));
        if($result === FALSE){
            $this->error($goods_model->getError());
        }
        $this->success('ok','index');
    }
    
    //商品图片上传      &$data引用传值
    private function uploadGoodsImage(&$data)
    {
        //获取file对象
        $file = request() -> file('goods_img');
        //实现图片上传 ext限制后缀 uploads保存的目录
        $info = $file -> validate(['ext'=>'jpeg,jpg,png']) -> move('uploads');
        //图片上传错误
        if(!$info){
            return FALSE;   
        }
        //获取上传后的地址
        $data['goods_img'] = str_replace('\\','/','uploads/'.$info -> getSaveName());

        //生成缩略图
        $img = \think\Image::open($data['goods_img']);
        //组装缩略图地址
        $data['goods_thumb'] = 'uploads/'.date('Ymd').'/thumb_'.$info -> getFileName();
        //将缩略图保存到对应的地址
        $img -> thumb(100,100) -> save($data['goods_thumb']);
        //将图片和缩略图转移到资源服务器上
        img_to_cdn($data['goods_img']);
        img_to_cdn($data['goods_thumb']);
    }

    //货号检查
    //$data  检查的数据
    //$is_edit  区别方式  false为商品添加  true为商品编辑
    private function checkGoodsSn(&$data,$is_edit = FALSE)
    {
        //有货号
        if ($data['goods_sn']) {
            //表单提交,需要检查唯一性
            $where = ['goods_sn' => $data['goods_sn']];
            //如果为编辑操作,则排除本身 本身已提交的ID进行判断
            if ($is_edit) {
                $where['id'] = ['neq',$data['id']];
            }
            if (model('Goods')->get($where)) {
                //存在商品货号goods_sn
                return FALSE;
            }
        }else{
            //没有货号,设置一个唯一值
            $data['goods_sn'] = 'SHOP'.strtoupper(uniqid());
        }
        return TRUE;
    }


}








?>
