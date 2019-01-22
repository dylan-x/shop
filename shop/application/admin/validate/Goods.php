<?php
namespace app\admin\validate;
use think\Validate;

/**
 * 
 * 商品的验证器
 *
 * 只能验证 商品名 所属分类 市场价格 本店价格
 */
class Goods extends Validate
{
    //验证规则
    protected $rule = [
        'goods_name' => 'require',
        'cate_id' => 'require|gt:0',
        'market_price' => 'require|checkMarketPrice',
        'shop_price' => 'require|gt:0'
    ];

    //错误信息提示
    protected $message = [
        'goods_name' => '商品名称不能为空',
        'cate_id' => '类别id必须大于0',
        'market_price' => '市场价格必须大于本店价格',
        'shop_price' => '本店价格不能小于0'
    ];

    //检查价格
    public function checkMarketPrice($value,$rule,$data)
    {
        //本店价格大于市场价格
        if($data['market_price'] < $data['shop_price'])
        {
            return FALSE;
        }
        return TRUE;
    }



}























?>