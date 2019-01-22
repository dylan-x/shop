<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:79:"/Users/dylan/PHP/Project/shop/public/../application/index/view/store/index.html";i:1548077213;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="__HOME__style/base.css" type="text/css">
	<link rel="stylesheet" href="__HOME__style/global.css" type="text/css">
	<link rel="stylesheet" href="__HOME__style/header.css" type="text/css">
	<link rel="stylesheet" href="__HOME__style/index.css" type="text/css">
	<link rel="stylesheet" href="__HOME__style/bottomnav.css" type="text/css">
	<link rel="stylesheet" href="__HOME__style/footer.css" type="text/css">

	<script type="text/javascript" src="__HOME__js/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="__HOME__js/header.js"></script>
	<script type="text/javascript" src="__HOME__js/index.js"></script>
	<style>
		a{
			text-decoration: none;
			color: #3c3c3c;
		}
		a:hover{
			text-decoration: none;
		}
		a:hover div{
			text-decoration: none;
			background-color: #624B47;
		}
	</style>
</head>
<body>
	<!-- 顶部导航 start -->
	<div class="topnav">
		<div class="topnav_bd w1210 bc">
			<div class="topnav_left">
				
			</div>
			<div class="topnav_right fr">
				<ul>
					<?php if(empty(\think\Session::get('user_info.nickname')) || ((\think\Session::get('user_info.nickname') instanceof \think\Collection || \think\Session::get('user_info.nickname') instanceof \think\Paginator ) && \think\Session::get('user_info.nickname')->isEmpty())): ?>
					<li>您好，欢迎来到京西！[<a href="<?php echo url('index/user/login'); ?>">登录</a>] [<a href="<?php echo url('index/user/register'); ?>">免费注册</a>] </li>
					<?php else: ?>
					<li>您好<?php echo \think\Session::get('user_info.nickname'); ?>，欢迎来到京西！[<a href="<?php echo url('index/user/logout'); ?>">退出</a>] 
					<li class="line">|</li>
					<li>我的订单</li>
					<li class="line">|</li>
					<li>客户服务</li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
	</div>

	<!-- 顶部导航 end -->

	<!-- 收藏栏 -->
	<div style="height: 60px;background-color: #202F47">
		<div  style="width: 1200px;height:100%;margin: 0 auto;">
			<a href="<?php echo url('index/index/index'); ?>">
				<div style="width: 120px;height:100%;text-align: center;line-height: 60px;display: inline-block;">
					<span style="font-size: 16px;color: #FFFFFF;">首页</span>
				</div>
			</a>
			<a href="<?php echo url('index/store/index'); ?>">
				<div style="width: 120px;height:100%;text-align: center;line-height: 60px;display: inline-block;">
					<span style="font-size: 16px;color: #FFFFFF;">我的收藏</span>
				</div>
			</a>
		</div>
	</div>
	<!-- 收藏栏 end -->

	<!-- 内容区域 -->
	<div id="box1" style="width: 1200px;height: 100%;margin: 0 auto;">
		<?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
		<div style="display: inline-block;width: 150px;height: 150px;">
			<div id="box" style="width: 150px;height: 150px;display: inline-block;border: 1px solid #f6f6f6;border-radius: 8px;">
				<a href="<?php echo url('index/goods/index','id='.$vo['id']); ?>">
					<img style="width: 150px;height: 150px;" src="__HOME__<?php echo $vo['goods_img']; ?>" >
				</a>
			</div>
			<div style="overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">
				<a href="<?php echo url('index/goods/index','id='.$vo['id']); ?>" style="font-size: 14px;"><?php echo $vo['goods_name']; ?></a>
			</div>
			<div >
				<div style="text-align: center;width: 150px;height: 150px;">
					<span style="color: #f40;">&yen;</span>
					<span style="color: #f40;"><strong><?php echo $vo['shop_price']; ?></strong></span>
				</div>
			</div>
		</div>
		<?php endforeach; endif; else: echo "" ;endif; ?>
	</div>
	<!-- 内容区域 end -->

</body>
</html>














