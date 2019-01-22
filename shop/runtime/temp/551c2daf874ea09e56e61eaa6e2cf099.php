<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:82:"/Users/dylan/PHP/Project/shop/public/../application/admin/view/attribute/edit.html";i:1547215411;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 添加分类 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="__ADMIN__/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="__ADMIN__/Styles/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    <span class="action-span"><a href="#">商品分类</a></span>
    <span class="action-span1"><a href="#">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 添加分类 </span>
    <div style="clear:both"></div>
</h1>
<div class="main-div">
    <form action="" method="post" name="theForm" enctype="multipart/form-data">
        <table width="100%" id="general-table">
            <tr>
                <td class="label">属性名称:</td>
                <td>
                    <input type='text' name='attr_name' maxlength="20" value='<?php echo $info['attr_name']; ?>' /><font color="red">*</font>
                </td>
            </tr>
            <tr>
                <td class="label">所属类型:</td>
                <td>
                    <select name="type_id">
                        <?php if(is_array($type) || $type instanceof \think\Collection || $type instanceof \think\Paginator): $i = 0; $__LIST__ = $type;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <option value="<?php echo $vo['id']; ?>" <?php if($info['type_id'] == $vo['id']): ?>selected="selected" <?php endif; ?>><?php echo $vo['type_name']; ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="label">本身类型:</td>
                <td>
                   <input type="radio" name="attr_type" value="1" <?php if($info['attr_type'] == '1'): ?>checked="checked"<?php endif; ?>>唯一属性
                   <input type="radio" name="attr_type" value="2" <?php if($info['attr_type'] == '2'): ?>checked="checked"<?php endif; ?>>单选属性
                </td>
            </tr>
            <tr>
                <td class="label">属性值录入方式:</td>
                <td>
                   <input type="radio" name="attr_input_type" value="1" <?php if($info['attr_input_type'] == '1'): ?>checked="checked"<?php endif; ?>>手工输入
                   <input type="radio" name="attr_input_type" value="2" <?php if($info['attr_input_type'] == '2'): ?>checked="checked"<?php endif; ?>>列表选择
                </td>
            </tr>
            <tr>
                <td class="label">默认值:</td>
                <td>
                   <textarea name="attr_values" style="min-height:100px; width: 200px; "><?php echo $info['attr_values']; ?></textarea>(当录入方式为列表选择必须设置 多个值英文逗号隔开)
                </td>
            </tr>
        </table>
        <div class="button-div">
            <input type="submit" value=" 确定 " />
            <input type="reset" value=" 重置 " />
        </div>
    </form>
</div>

<div id="footer">
共执行 3 个查询，用时 0.162348 秒，Gzip 已禁用，内存占用 2.266 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>

</body>
</html>