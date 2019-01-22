<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:83:"/Users/dylan/PHP/Project/shop/public/../application/admin/view/attribute/index.html";i:1547213745;}*/ ?>
<!-- $Id: category_list.htm 17019 2010-01-29 10:10:34Z liuhui $ -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 商品分类 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="__ADMIN__/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="__ADMIN__/Styles/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    <span class="action-span"><a href="__GROUP__/Category/categoryAdd">添加分类</a></span>
    <span class="action-span1"><a href="__GROUP__">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 商品分类 </span>
    <div style="clear:both"></div>
</h1>
<form method="post" action="" name="listForm">
    <div class="list-div" id="listDiv">
        <table width="100%" cellspacing="1" cellpadding="2" id="list-table">
            <tr>
                <th>属性名称</th>
                <th>所属类型</th>
                <th>本身类型</th>
                <th>属性值录入方式</th>
                <th>默认值</th>
                <th>操作</th>
            </tr>  
            <?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <tr align="center" class="0">
                <td class="first-cell" ><?php echo $vo['attr_name']; ?></td>
                <td class="first-cell" ><?php echo $vo['type_name']; ?></td>
                <td class="first-cell" ><?php if($vo['attr_type'] == '1'): ?>唯一属性<?php else: ?>单选属性<?php endif; ?></td>
                <td class="first-cell" ><?php if($vo['attr_input_type'] == '1'): ?>手工输入<?php else: ?>列表输入<?php endif; ?></td>
                <td  class="first-cell" ><?php echo $vo['attr_values']; ?></td>
                <td width="30%" align="center">
                <a href="<?php echo url('edit','id='.$vo['id']); ?>">编辑</a> |
                <a href="<?php echo url('remove','id='.$vo['id']); ?>" title="移除" onclick="">移除</a>
                </td>
            </tr>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            
        </table>
    </div>
</form>
<div id="footer">
共执行 1 个查询，用时 0.055904 秒，Gzip 已禁用，内存占用 2.202 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>