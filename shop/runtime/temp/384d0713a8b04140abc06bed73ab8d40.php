<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:77:"/Users/dylan/PHP/Project/shop/public/../application/admin/view/goods/add.html";i:1547988601;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 添加新商品 </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="__ADMIN__/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="__ADMIN__/Styles/main.css" rel="stylesheet" type="text/css" />
<script>
    
</script>
</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo url('index'); ?>">商品列表</a>
    </span>
    <span class="action-span1"><a href="<?php echo url('admin/index/index'); ?>">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 添加新商品 </span>
    <div style="clear:both"></div>
</h1>

<div class="tab-div">
    <div id="tabbar-div">
        <p>
            <span class="tab-front" id="general-tab">通用信息</span>
            <span class="tab-front" id="general-tab">商品描述</span>
            <span class="tab-front" id="general-tab">商品属性</span>
            <span class="tab-front" id="general-tab">商品相册</span>
        </p>
    </div>
    <div id="tabbody-div">
        <form enctype="multipart/form-data" action="" method="post">
            <table width="90%" class="table" id="general-table" align="center">
                <tr>
                    <td class="label">商品名称：</td>
                    <td><input type="text" name="goods_name" value=""size="30" />
                    <span class="require-field">*</span></td>
                </tr>
                <tr>
                    <td class="label">商品货号： </td>
                    <td>
                        <input type="text" name="goods_sn" value="" size="20"/>
                        <span id="goods_sn_notice"></span><br />
                        <span class="notice-span"id="noticeGoodsSN">如果您不输入商品货号，系统将自动生成一个唯一的货号。</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">商品分类：</td>
                    <td>
                        <select name="cate_id">
                            <option value="0">请选择...</option>
                            <?php if(is_array($category) || $category instanceof \think\Collection || $category instanceof \think\Paginator): $i = 0; $__LIST__ = $category;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                <option value="<?php echo $vo['id']; ?>"><?php echo str_repeat("&nbsp;&nbsp;",$vo['lev']); ?><?php echo $vo['cate_name']; ?></option>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                        <span class="require-field">*</span>
                    </td>
                </tr>

                <tr>
                    <td class="label">本店售价：</td>
                    <td>
                        <input type="text" name="shop_price" value="" size="20"/>
                        <span class="require-field">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">加入推荐：</td>
                    <td>
                        <input type="checkbox" name="is_hot" value="1" /> 热卖 
                        <input type="checkbox" name="is_new" value="1" /> 新品 
                        <input type="checkbox" name="is_rec" value="1" /> 推荐
                    </td>
                </tr>

                <tr>
                    <td class="label">市场售价：</td>
                    <td>
                        <input type="text" name="market_price" value="" size="20" />
                    </td>
                </tr>

                <tr>
                    <td class="label">商品图片：</td>
                    <td>
                        <input type="file" name="goods_img" size="35" />
                    </td>
                </tr>
            </table>
            <table width="90%"  class="table" align="center" style="display: none;">
                <tr>
                    <td class="label">商品描述：</td>
                    <td>
                        <!-- 加载编辑器的容器 -->
                        <script id="container" name='goods_body' type="text/plain" ></script>
                        <!-- 配置文件 -->
                        <script type="text/javascript" src="/static/ueditor/ueditor.config.js"></script>
                        <!-- 编辑器源码文件 -->
                        <script type="text/javascript" src="/static/ueditor/ueditor.all.js" ></script>
                        <!-- 实例化编辑器 -->
                        <script type="text/javascript">
                            var ue = UE.getEditor('container');
                        </script>
                    </td>
                </tr>
            </table>
            <table width="90%"  class="table" align="center" style="display: none;">
               <tr>
                <td class="label">商品类型:</td>
                   <td>
                    <select name="type_id" id="type_id">
                        <option value="0">选择类型</option>
                        <?php if(is_array($type) || $type instanceof \think\Collection || $type instanceof \think\Paginator): $i = 0; $__LIST__ = $type;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <option value="<?php echo $vo['id']; ?>"><?php echo $vo['type_name']; ?></option>
                       <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                   </td>
               </tr>
               <tr>
                   <td colspan="2" id="showAttr"></td>
               </tr>
            </table>
            <table width="90%"  class="table pic" align="center" style="display: none;">
               <tr>
                <td class="label"></td>
                <td><input type="button" value="增加图片" id="addPic" /></td>
               </tr>
               <tr>
                   <td class="label">上传图片:</td>
                   <td>
                        <input type="file" name="pic[]" />
                    </td>
               </tr>
            </table>
            <div class="button-div">
                <input type="submit" value=" 确定 " class="button"/>
                <input type="reset" value=" 重置 " class="button" />
                <?php echo token(); ?>
            </div>
        </form>
    </div>
</div>

<div id="footer">
共执行 9 个查询，用时 0.025161 秒，Gzip 已禁用，内存占用 3.258 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>
<script type="text/javascript" src="__ADMIN__/Js/jquery-1.8.3.min.js"></script>
<script type="text/javascript">
    $('#tabbar-div span').click(function() {
        //将所有的选项设置隐藏
        $('.table').hide();
        //获取点击的选项的index
        var index = $(this).index();
        //将点击的选项显示
        $('.table').eq(index).show();
    });

    //根据类型获取属性信息
    $('#type_id').change(function() {
        //获取选中的type_id
        var type_id = $(this).val();
        if (type_id == 0) {
            $('#showAttr').html('选择类型');
            return;
        }

        //发送AJAX请求
        $.ajax({
            url: '<?php echo url("showAttr"); ?>',
            type: 'post',
            data: {'type_id': type_id},
            success:function(response){
                $('#showAttr').html(response);
            }
        })
    });
    
    function cloneThis(obj)
        {
            // [+],则增加
            if ($(obj).html() == '[+]') {
                var newTr = $(obj).parent().parent().clone();
                newTr.find('a').html('[-]');
                //追加
                $(obj).parent().parent().after(newTr);
            }else{
                //删除
                $(obj).parent().parent().remove();
            }
        }

    $('#addPic').click(function(){
        //复制上传框
        var newTr = $(this).parent().parent().next().clone();
        $('.pic').append(newTr);
    });
</script>
















