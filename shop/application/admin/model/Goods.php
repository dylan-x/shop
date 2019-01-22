<?php
namespace app\admin\model;
use think\Model;
use think\Db;

/**
 * 商品的模型
 * 
 */

class Goods extends Model
{

    //相册图片上传以及录入 $field为表单中上传文本框的名称
    public function insertImg($goods_id,$field)
    {
        $list = [];//保存最终要写入数据的变量
        // 获取上传的对象的数组
        $files = request()->file($field);
        foreach ($files as  $file) {
            $info = $file->validate(['ext'=>'jpeg,jpg,png'])->move('uploads');
            if(!$info){
                // 上传图片异常 忽略问题文件
                continue;
            }
            // 组装出本地的地址
            $goods_img = str_replace('\\', '/', 'uploads/'.$info -> getSaveName());
            // 生成缩略图
            $img = \think\Image::open($goods_img);
            // 计算出缩略图保存地址。与原图存储同一目录下并且文件名称在原图的基础上增加thumb_
            $goods_thumb = 'uploads/'.date('Ymd').'/thumb_'.$info->getFileName();
            // 生成缩略图
            $img->thumb(150,150)->save($goods_thumb);
            // 将商品的原图与缩略图转移到资源服务器下
            img_to_cdn($goods_img);
            img_to_cdn($goods_thumb);
            $list[]= [
                'goods_id'=>$goods_id,
                'goods_img'=>$goods_img,
                'goods_thumb'=>$goods_thumb
            ];
        }
        if($list){
            db('goods_img')->insertAll($list);
        }
    }

    //商品属性上传
    public function insertGoodsAttr($goods_id,$attr_ids,$attr_values)
    {
        $list = [];
        $tmp = [];//保存使用attr_id与attr_value组装的数组为一维数组
        foreach ($attr_ids as $key => $value) {
            $attr_id_value = $value.'-'.$attr_values[$key];
            if (in_array($attr_id_value, $tmp)) {
                //要添加的内容在临时变量中存在说明重复
                continue;
            }
            $tmp[]=$attr_id_value;
            $list = [
                'goods_id' => $goods_id,
                'attr_id' => $value,
                'attr_values' => $attr_values[$key]
            ];
        }

        //将数据批量写入
        if ($list) {
            db('goods_attr')->insertAll($list);
        }
    }

    //修改商品
    public function editGoods($data=[])
    {
        //处理推荐状态 如果没有勾选的话,数据中没有这些字段,就不会更改
        $data['is_rec'] = isset($data['is_rec'])?1:0;
        $data['is_hot'] = isset($data['is_hot'])?1:0;
        $data['is_new'] = isset($data['is_new'])?1:0;
        return $this -> isUpdate(true) -> save($data);
    }

    //实现修改状态切换
    public function changeStatus($goods_id,$field)
    {
        //查询当前字段对应的数据信息
        $goods_info = Db::name('Goods') ->find($goods_id);
        $status = $goods_info[$field]?0:1;
        //修改对应数据推荐状态值
        Db::name('Goods') -> where('id',$goods_id) -> setField($field,$status);
        //返回改变后的推荐字段状态值
        return $status;
    }

    // 商品添加
    public function addGoods($postData=[],$attr_ids=[],$attr_values=[])
    {
        // 增加商品的添加时间
        $postData['addtime']=time();
        // 开启事物
        $this->startTrans();
        try {
            // 商品信息入库
            $this->isUpdate(false)->allowField(true)->save($postData);
            // 实现商品属性值录入
            // 获取商品ID
            $goods_id = $this->getLastInsId(); //获取写入数据的主键标识
            // 商品属性值入库
            model('GoodsAttr')->insertGoodsAttr($goods_id,$attr_ids,$attr_values);
            // 实现相册的入库
            model('GoodsImg')->insertImg($goods_id,'pic');
            $this->commit();//提交事物
        } catch (\Exception $e) {
            $this->error = '数据写入错误';
            $this->rollback();
            return FALSE;
        }
    }

    //获取商品信息
    public function listData($is_del=0)
    {   
        $where = ['is_del'=>$is_del];//保存搜索条件
    	//获取query对象
    	$queryObj = Db::name('goods');
        //使用关键词搜索
        $keyword = input('keyword');
        if ($keyword) {
            //关键字存在
            $where['goods_name'] = ['like','%'.$keyword.'%']; 
        }
        //使用推荐查询
        $intro_type = input('intro_type');
        if ($intro_type) {
            //推荐存在值
            $where[$intro_type] = 1;
        }
        //使用分类查询
        $cate_id = input('cat_id');
        if ($cate_id) {
            //获取所有子分类
            $tree = model('Category') -> getCateTree($cate_id,TRUE);
            //将本身添加到数组中
            $cate_ids = [$cate_id];
            foreach ($tree as $key => $value) {
                $cate_ids[] = $value['id']; 
            }
            $where['cate_id'] = ['in',$cate_ids];
        }
        
        $list = $queryObj -> where($where) -> paginate(3,FALSE,['query'=>input()]);
    	//获取所有商品信息数据
    	return $list;
    }


}