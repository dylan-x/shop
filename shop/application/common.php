<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

//获取用户id
if (!function_exists('get_user_id')) {
    
    function get_user_id()
    {
        //从session中获取用户信息
        $user_info = session('user_info');
        if (!$user_info) {
            //没有登录,没有用户信息
            return false;
        }
        return $user_info['id'];
    }
}

//md6加密  
if (!function_exists('md6')) {
    //md5双重加密
    function md6($password,$salt)
    {
        return md5(md5($password).$salt);
    }
    
}

//获取所有类型
if (!function_exists('get_type_info')) 
{
    //
    function get_type_info()
    {
        $type = db('type') -> select(); 
        $typeinfo = [];
        foreach ($type as $key => $value)
        {
            $typeinfo[$value['id']] =$value;
        }
        return $typeinfo;
    }
}




//无限极分类
//判断函数是否存在,不存在则创建
if(!function_exists('get_cate_tree'))
{
    //数据格式化函数
    function get_cate_tree($data,$id=0,$lev=0,$is_clear=FALSE)
    {
        //设置一个空数组
        static $list = [];
        //
        if ($is_clear) {
            $list = [];
        }
        //遍历数据
        foreach ($data as $value) 
        {   //得到一级分类,看当前记录的父级是否是对应的id
            if ($value['parent_id'] == $id) {
                //添加一个等级字段,一级分类为0
                $value['lev'] = $lev;
                //将新数据放入数组中
                $list[] = $value;
                //递归得出无限极分类
                get_cate_tree($data,$value['id'],$lev+1);
            }    
        }
        return $list;
    }
}


//图片转移
if(!function_exists('img_to_cdn'))
{
    /**
     * 方法: 图片转移
     * @param [type] $local_path 本地地址
     * @param [type] $server_path 上传地址
     *
     * @return 
     */
    function img_to_cdn($local_path,$server_path='')
    {
        $ftpObj = new \ftp('192.168.128.135','21','ftpuser','xu6218653');
        $server_path = $server_path?$server_path:$local_path;
        return $ftpObj -> up_file($local_path,$server_path);
    }
}





