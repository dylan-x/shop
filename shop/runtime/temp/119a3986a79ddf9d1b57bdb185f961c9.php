<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:82:"/Users/dylan/PHP/Project/shop/public/../application/admin/view/goods/showattr.html";i:1547370035;}*/ ?>
<table width="90%"  align="center">
	<?php if(is_array($result) || $result instanceof \think\Collection || $result instanceof \think\Paginator): $i = 0; $__LIST__ = $result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
	<tr>
		<td class="label"><?php if($vo['attr_type'] == '2'): ?><a onclick="cloneThis(this)" href="javascript:;">[+]</a><?php endif; ?><?php echo $vo['attr_name']; ?>:</td>
		<td>
			<input type="hidden" name="attr_ids[]" value="<?php echo $vo['id']; ?>">
			<?php if($vo['attr_input_type'] == '1'): ?>
				<input type="text" name="attr_values[]">
			<?php else: ?>
				<select name="attr_values[]">
					<?php if(is_array($vo['attr_values']) || $vo['attr_values'] instanceof \think\Collection || $vo['attr_values'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['attr_values'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
					<option ><?php echo $v; ?></option>
					<?php endforeach; endif; else: echo "" ;endif; ?>
				</select>
			<?php endif; ?>
		</td>
	</tr>
	<?php endforeach; endif; else: echo "" ;endif; ?>
</table>