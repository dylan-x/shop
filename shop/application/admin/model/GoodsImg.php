<?php 

namespace app\admin\model;
use think\Model;
/**
* 
*/
class GoodsImg extends Model
{
	// 相册图片上传以及录入 $field为表单中上传文本框的名称
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
}
?>