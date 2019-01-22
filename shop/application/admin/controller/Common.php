<?php 
namespace app\admin\controller;
use think\Controller;
use think\Db;
/**
* 后台公共控制器
*/
class Common extends Controller
{
    //保存用户信息
    public $_user = [];
    //是否要检查权限
    public $is_check_rule = TRUE;
    //创建构造方法
	public function __construct(){
        //执行父类的构造方法
        parent::__construct();

        //token校验
        if(config('is_check_token'))
        {
            //读取配置信息中的is_chekck_token的值
            //判断是否是post请求
            if (request()->isPost()) {
                $token = input('__token__');//获取表单中的token值
                $session_token = session('__token__');//获取session中的token值
                //表单中没有生成令牌 session中没有令牌 令牌比对不正确
                if (!isset($token) || !isset($session_token) || $token != $session_token) {
                    $this -> error('表单令牌错误');
                }
                //销毁session中的令牌
                session('__token__',null);
            }
        }

        //防止翻墙
        if (!cookie('user_info')) {
            //检查cookie中是否存在user_info值
            //没有用户登录信息
            $this -> error('请先登录','login/index');
        }

        //权限校验
        $this ->_user = cookie('user_info');
        //根据角色id查询角色拥有的权限信息
        $this ->_user['rules'] = Db::name('role') -> find($this ->_user['role_id']);
        //获取角色对应的权限
        if ($this->_user['role_id']==1) {
            //超级管理员
            $this ->is_check_rule = FALSE;
            $rules = Db::name('rule') -> select();
        }else{
            //普通用户
            //查找出该角色对应的权限信息
            $rules = Db::name('rule') -> where('id','in',$this ->_user['rules']['rule_ids']) -> select();
        }
        //保存权限信息
        $this ->_user['rule_info'] =[];
        foreach ($rules as $key => $value) {
            //判断是否展示
            if ($value['is_show'] ==1 ) {
                $this->_user['menus'][] = $value;
            }
            $k = strtolower($value['controller_name'].'/'.$value['action_name']);
            if (!in_array($k, $this->_user['rule_info'])) {
                $this ->_user['rule_info'][] = $k;
            }
        }
        //开始校验权限
        if ($this->is_check_rule) {
            //增加后台首页访问权限
            $this->_user['rule'][]='index/index';
            $this->_user['rule'][]='index/top';
            $this->_user['rule'][]='index/menu';
            $this->_user['rule'][]='index/main';
            $url = strtolower(request()->controller().'/'.request()->action());
            if (!in_array($url, $this->_user['rule_info'])) {
                if (request()->isAjax()) {
                    return json(['status'=>0,'msg'=>'没有访问权限']);
                }else{
                    $this -> error('没有访问权限');
                }
            }
        }
        

    }




}
?>