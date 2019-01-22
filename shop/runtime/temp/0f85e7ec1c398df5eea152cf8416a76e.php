<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:81:"/Users/dylan/PHP/Project/shop/public/../application/admin/view/role/disfetch.html";i:1547886097;}*/ ?>
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
<div class="list-div" id="listDiv">
    <form action="" method="POST" enctype="multipart/form-data">
        <table width="100%" cellspacing="1" cellpadding="2" id="list-table">
            <thead>
                <tr>
                    <th width="40"><input type="checkbox" id="selectAll" />全选</th>
                    <th>顶级权限</th>
                    <th>子权限</th>
                </tr>
            </thead>
            <tbody>
                <?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;if($vo['parent_id'] == '0'): ?>
                <tr>
                    <td>
                        <input type="checkbox" class="top" name="rule[]" value="<?php echo $vo['id']; ?>" <?php if(in_array(($vo['id']), is_array($info['rule_ids'])?$info['rule_ids']:explode(',',$info['rule_ids']))): ?>checked="checked"<?php endif; ?>>
                    </td>
                    <td><?php echo $vo['rule_name']; ?></td>
                    <td>
                        <?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;if($v['parent_id'] == $vo['id']): ?>
                        <input type="checkbox" class="child" name="rule[]" value="<?php echo $v['id']; ?>" <?php if(in_array(($v['id']), is_array($info['rule_ids'])?$info['rule_ids']:explode(',',$info['rule_ids']))): ?>checked="checked"<?php endif; ?>/>
                        <?php echo $v['rule_name']; endif; endforeach; endif; else: echo "" ;endif; ?>
                    </td>
                </tr>
                <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                <tr>
                    <td colspan="3">
                        <button type="submit" class="btn btn-default">表单提交</button>
                    </td>
                </tr>

            </tbody>
        </table>
    </form>
</div>
<div id="footer">
共执行 1 个查询，用时 0.055904 秒，Gzip 已禁用，内存占用 2.202 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>