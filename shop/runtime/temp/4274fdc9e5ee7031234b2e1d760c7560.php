<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:81:"/Users/dylan/PHP/Project/shop/public/../application/admin/view/goods/recycle.html";i:1547961350;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 商品列表 </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="__ADMIN__/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="__ADMIN__/Styles/main.css" rel="stylesheet" type="text/css" />
<style>
    .pagination li{
        display: block;
        float: left;
        text-decoration: none;
        margin: 0 20px;
        width: 30px;
        height: 30px;
        line-height: 30px;
        font-size: 18px;
    }
</style>
</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo url('add'); ?>">添加新商品</a></span>
    <span class="action-span1"><a href="<?php echo url('admin/index/index'); ?>">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 商品列表 </span>
    <div style="clear:both"></div>
</h1>
<div class="form-div">
    <form action="" name="searchForm">
        <img src="__ADMIN__/Images/icon_search.gif" width="26" height="22" border="0" alt="search" />
        <!-- 分类 -->
        <select name="cat_id">
            
            <option value="0">所有分类</option>
            <?php if(is_array($category) || $category instanceof \think\Collection || $category instanceof \think\Paginator): $i = 0; $__LIST__ = $category;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <option value="<?php echo $vo['id']; ?>"><?php echo str_repeat('&nbsp;&nbsp;',$vo['lev']); ?><?php echo $vo['cate_name']; ?></option>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            
        </select>

        <!-- 推荐 -->
        <select name="intro_type">
            <option value="0">全部</option>
            <option value="is_rec">推荐</option>
            <option value="is_new">新品</option>
            <option value="is_hot">热销</option>
        </select>
        <!-- 关键字 -->
        关键字 <input type="text" name="keyword" size="15" />
        <input type="submit" value=" 搜索 " class="button" />
    </form>
</div>

<!-- 商品列表 -->

    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr>
                <th>编号</th>
                <th>商品名称</th>
                <th>货号</th>
                <th>价格</th>
                <th>推荐</th>
                <th>新品</th>
                <th>热销</th>
                <th>操作</th>
            </tr>
            <?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <tr>
                <td align="center"><?php echo $vo['id']; ?></td>
                <td align="center" class="first-cell"><span><?php echo $vo['goods_name']; ?></span></td>
                <td align="center"><span onclick=""><?php echo $vo['goods_sn']; ?></span></td>
                <td align="center"><span><?php echo $vo['shop_price']; ?></span></td>
                <td align="center"><img onclick="changeStatus(this,<?php echo $vo['id']; ?>,'is_rec')" src="__ADMIN__/Images/<?php if($vo['is_rec'] == '1'): ?>yes<?php else: ?>no<?php endif; ?>.gif "/></td>
                <td align="center"><img onclick="changeStatus(this,<?php echo $vo['id']; ?>,'is_new')" src="__ADMIN__/Images/<?php if($vo['is_new'] == '1'): ?>yes<?php else: ?>no<?php endif; ?>.gif "/></td>
                <td align="center"><img onclick="changeStatus(this,<?php echo $vo['id']; ?>,'is_hot')" src="__ADMIN__/Images/<?php if($vo['is_hot'] == '1'): ?>yes<?php else: ?>no<?php endif; ?>.gif "/></td>
                <td align="center">
                <a href="<?php echo url('rollback','id='.$vo['id']); ?>" title="还原"><img src="__ADMIN__/Images/icon_edit.gif" width="16" height="16" border="0" /></a>
                <a href="<?php echo url('del','id='.$vo['id']); ?>" onclick="" title="彻底删除"><img src="__ADMIN__/Images/icon_trash.gif" width="16" height="16" border="0" /></a></td>
            </tr>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </table>

        <!-- 分页开始 -->
        <table id="page-table" cellspacing="0">
            <tr>
                <td width="30%">&nbsp;</td>
                <td align="center" nowrap="true">
                    <?php echo $data->render(); ?>
                </td>
            </tr>
        </table>
    <!-- 分页结束 -->
    </div>

<div id="footer">
共执行 7 个查询，用时 0.028849 秒，Gzip 已禁用，内存占用 3.219 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>

<script type="text/javascript" src="__ADMIN__/Js/jquery-1.8.3.min.js"></script>
<script type="text/javascript">
    function changeStatus(obj,goods_id,field){
        $.ajax({
            url: "<?php echo url('changeStatus'); ?>",
            type: 'post',
            data: {'goods_id': goods_id,'field':field},
            success:function(response)
            {
                if (response.status == 1) 
                {
                    //数据修改正常
                    if (response.code == 1) 
                    {
                        $(obj).attr('src','__ADMIN__/Images/yes.gif');
                    }else{
                        $(obj).attr('src','__ADMIN__/Images/no.gif');
                    }
                }
            }
        })
    }
    
    

</script>











