<?php
namespace app\admin\model;
use think\Model;
use think\Db;

/**
 * 分类的模型
 * 
 */

class Category extends Model
{
    //获取所有的分类信息，并格式化数据
    public function getCateTree($id=0,$is_clear = FALSE)
    {
        //获取query对象
        $db = Db::name('category');
        //查询所有分类
        $category = $db -> select();
        //使用公共函数,格式化数据
        return get_cate_tree($category,$id,0,$is_clear);
    }

    //实现分类的编辑
    public function editCategory($postData=[])
    {
        
        //验证数据
        //1.父类不能为自己
        if($postData['id']==$postData['parent_id'])
        {
            //父类和自己相同,设置自定义错误属性error
            $this -> error ='类别不能为自己';
           
            return FALSE;
        }
        
        //2.父类不能为子类
        //获取子分类的信息
        $son = $this -> getCateTree($postData['id']);
        //使得到的子分类的id与要修改的分类数据的上级分类parent_id比较
        foreach ($son as $key => $value) {
            if($value['id']==$postData['parent_id'])
            {
                //相等,则报错
                $this -> error ='类别不能为子分类';
                //dump($this->error);die;
                return FALSE;
            }
        }
        Category::isUpdate(true) -> save($postData);
    }

}


?>