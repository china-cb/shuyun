<?php
namespace Shuyun;

use Shuyun\Open\Config\CommonConfig;
use Shuyun\Open\Config\ShuyunConfig;
use Shuyun\Open\Config\HttpConfig;
use Shuyun\Open\Helper\ShuyunHelper;


class Demo
{
    //[数云]同步会员信息
    public static function ChangeSyVipUser($data)
    {
        
        $intefacetype = "同步会员信息接口";
        $Method = 'shuyun.loyalty.member.register';
        $signdata = array(
            'Gateway-Request-Time' => ShuyunHelper::msectime()
        );
        $body  = array(
            "id" => $data['phone'],
            "platCode" => 'OFFLINE',
            "shopId" => $data['shop_code'],
            "name" => $data['receiver'],
            "mobile" => $data['phone'],
            "guideId" => $data['guideId'],
            "birthday" => $data['birthday'],
            "gender" => $data['gender'],
            "created" => $data['created'],
            "grade" => 1,
            "point" => 0
        );
        
        $requestType = "Post";
        $res = ShuyunHelper::syRequest($Method,$signdata,$body,$intefacetype,$requestType);
        $res = json_decode($res[1],true);
        return $res;

        return $res['data'];
    }

    //数云修改会员信息
    public static function SyVipinfo($data)
    {
       
        $intefacetype = "修改会员信息接口";
        $Method = 'shuyun.loyalty.member.modify';
        $signdata = array(
            'Gateway-Request-Time' => ShuyunHelper::msectime()
        );
        $body  = array(
            "id" => $data['phone'],
            "platCode" => 'OFFLINE',
            "shopId" => $data['shopId']
        );

        $requestType = "Put";
        $res = ShuyunHelper::syRequestsyRequest($Method,$signdata,$body,$intefacetype,$requestType);
        $res = json_decode($res[1],true);
        return $res;
    }


    //数云获取会员个人信息
    public function getSyVipinfoSearch($data)
    {
        $Auth = new MemberController();
        $intefacetype = "查询会员个人信息";
        
        $Method = 'shuyun.loyalty.member.get';
        $signdata = array(
            'Gateway-Request-Time' => ShuyunHelper::msectime()
        );
        $body  = array(
            'platCode' => 'OFFLINE',
            'shopId' => $data['shopId'],
            ' id' => $data['id'],
        );
        
        $requestType = "Get";
        $res = ShuyunHelper::syRequestsyRequest($Method,$signdata,$body,$intefacetype,$requestType);
        return $res;
    }

    //数云批量获取会员信息(全量)
    public function getSyVipinfo($cardPlanId,$datatime,$page)
    {
        
        $intefacetype = "会员信息批量查询";
        $Method = 'shuyun.loyalty.member.batch.query';
        $signdata = array(
            'Gateway-Request-Time' => ShuyunHelper::msectime()
        );
        
        $body  = array(
            'cardPlanId' => intval($cardPlanId),
            'modifiedStartTime' => $datatime['modifiedStartTime'],
            'modifiedEndTime' => $datatime['modifiedEndTime'],
            'fields' => 'cardPlanId,memberId,cardNumber,bindMobile,name,birthday,gender,platCode,shopId,guideId,availablePoint,totalPoint,consumedPoint,expiredPoint,grade,gradePeriod,created,modified',
            'pageSize' => 20,
            'currentPage' => $page
        );
       
        $requestType = "Get";
        $res = ShuyunHelper::syRequest($Method,$signdata,$body,$intefacetype,$requestType);
        return $res;
    }

    //数云批量获取会员积分变更信息
    public function getSyVipPointinfo($cardPlanId,$datatime,$page)
    {
        $Auth = new MemberController();
        $intefacetype = "会员积分变更批量查询";
        $Method = 'shuyun.loyalty.member.point.changelog.batch.query';
        $signdata = array(
            'Gateway-Request-Time' => ShuyunHelper::msectime()
        );
        
        $body  = array(
            'cardPlanId' => intval($cardPlanId),
            'changeStartTime' => $datatime['changeStartTime'],
            'changeEndTime' => $datatime['changeEndTime'],
            'fields' => 'cardPlanId,memberId,changeValue,changeTime,actionType,source,id',
            'pageSize' => 20,
            'currentPage' => $page
        );
        
        $requestType = "Get";
        $res = ShuyunHelper::syRequest($Method,$signdata,$body,$intefacetype,$requestType);
        return $res;
    }


    //数云批量获取会员等级变更信息
    public function getSyVipGradeinfo($cardPlanId,$datatime,$page)
    {
        
        $intefacetype = "会员等级变更批量查询";
        $Method = 'shuyun.loyalty.member.grade.changelog.batch.query';
        $signdata = array(
            'Gateway-Request-Time' => ShuyunHelper::msectime()
        );
      
        $body  = array(
            'cardPlanId' => intval($cardPlanId),
            'changeStartTime' =>  $datatime['changeStartTime'],
            'changeEndTime' => $datatime['changeEndTime'],
            'fields' => 'cardPlanId,memberId,gradeBeforeChange,gradeAfterChange,gradePeriod,changeTime,changeType,changeSource,id',
            'pageSize' => 20,
            'currentPage' => $page
        );
       
        $requestType = "Get";
        $res = ShuyunHelper::syRequest($Method,$signdata,$body,$intefacetype,$requestType);
        return $res;
    }

    //数云批量获取卡计划信息
    public function getSyCardinfo()
    {
        
        $intefacetype = "卡计划查询";
        $Method = 'shuyun.loyalty.cardplan.query';
        $signdata = array(
            'Gateway-Request-Time' => ShuyunHelper::msectime()
        );
        $body  = array(
            'fields' => 'cardPlanId',
        );
        $requestType = "Get";
        $res = ShuyunHelper::syRequest($Method,$signdata,$body,$intefacetype,$requestType);
        return $res;
    }

    //[数云]数云修改会员手机号
    public function ChangeSyVipPhone($data)
    {
        
        $intefacetype = "修改会员手机号信息接口";
        $Method = 'shuyun.loyalty.member.mobile.modify';
        $signdata = array(
            'Gateway-Request-Time' => ShuyunHelper::msectime()
        );
        $body  = array(
            "id" => $data['wdid'],
            "platCode" => $data['platCode'],
            "shopId" => $data['shopId'],
            "mobile" => $data['mobile']
        );
        
        $requestType = "Put";
        $res = ShuyunHelper::syRequest($Method,$signdata,$body,$intefacetype,$requestType);
        $res = json_decode($res[1],true);
        return $res;
    }

    //[数云]同步店铺信息
    public function ChangeSyShops($data)
    {
       
        $intefacetype = "同步店铺接口";
        $Method = 'shuyun.base.shop.batch.register';
        $signdata = array(
            'Gateway-Request-Time' => ShuyunHelper::msectime()
        );
        $shops[] = [
            'shop_name' => $data['shop_name'],
            'shop_id' => $data['shop_id'],
            'plat_code' => 'offline',
            "open_date" => "",
            "status" => 1,
            "modified" => $data['modified'],
            "shop_desc" => "",
            "shop_logo" => "",
            "country" => "",
            "state" => "",
            "city" => "",
            "district" => "",
            "town" => "",
            "address" => ""
        ];
       
        $body  = [
            'tenant_name' =>  ShuyunConfig::ENV_ZH, //租户名称
            'shops' => $shops,
            'app_id' => ShuyunConfig::ENV_APPID,
            'app_secret' => ShuyunConfig::ENV_SECURITY
        ];
    
        $requestType = "Post";
        $res = ShuyunHelper::syRequest($Method,$signdata,$body,$intefacetype,$requestType);
        $res = json_decode($res[1],true);
        return $res;
    }

    //数云批量店铺信息
    public function getSyShopinfo($fields)
    {
        
        $intefacetype = "店铺查询";
        $Method = 'shuyun.base.shop.query';
        $signdata = array(
            'Gateway-Request-Time' => ShuyunHelper::msectime()
        );
        $body  = array(
            'fields' => $fields,
        );
        $requestType = "Get";
        $res = ShuyunHelper::syRequest($Method,$signdata,$body,$intefacetype,$requestType);
        return $res;
    }

    public function ChangeSyCategory($data)
    {
        
        $intefacetype = "同步商品类目接口";
        $Method = 'shuyun.base.product.category.sync';
        $signdata = array(
            'Gateway-Request-Time' => ShuyunHelper::msectime()
        );
        $body  = array(
            
            "parent_category_id" => $data['parent_category_id'],
            "category_name" => $data['category_name'],
            "category_id" => $data['category_id'],
            "created" => $data['created'],
            "modified" => $data['modified']
    
        );
        $requestType = "Post";
        $res = ShuyunHelper::syRequest($Method,$signdata,$body,$intefacetype,$requestType);
        $res = json_decode($res,true);
        return $res;
    }

    //[数云]同步商品信息
    public function ChangeSyProduct($data)
    {
        
        $intefacetype = "同步商品信息接口";
        $Method = 'shuyun.base.product.sync';
        $signdata = array(
            'Gateway-Request-Time' =>  ShuyunHelper::msectime()
        );
        $body = $data;
        $requestType = "Post";
        $res = ShuyunHelper::syRequest($Method,$signdata,$body,$intefacetype,$requestType);
        return $res;
    }

    //[数云]同步订单信息
    public function ChangeSyOrders($data)
    {
        
        $intefacetype = "同步订单接口";
        $Method = 'shuyun.base.trade.sync';
        $signdata = array(
            'Gateway-Request-Time' => ShuyunHelper::msectime()
        );

        $orders = array();
        $size = 0;
       
        //重新修改订单商品详情结构
        foreach($data['order_data'] as $k=>$v){
            $orders[$k]['product_id'] = $v['product_code'];
            $orders[$k]['product_num'] = $v['product_num'];
            $orders[$k]['price'] = $v['product_cost_price'];
            $orders[$k]['order_item_id'] = $data['trade_no'].'-'.$k;
            $orders[$k]['is_refund'] = 0;
            $orders[$k]['adjust_fee'] = 0;
            $orders[$k]['discount_fee'] = 0;
        }


        $body  =  array(
            //'consign_time' => !empty($res['send_time']) ? date('Y-m-d H:i:s', $res['send_time'] / 1000) : 0, //发货时间
            //'first_fee_paytime' => '',
            'post_fee' => $data['post_fee'], //邮费金额
            // 'receiver_city' => !empty($res['city']) ? $res['city'] : '', //收货人城市
            'adjust_fee' => $data['adjust_fee'], //手工调整优惠金额
            // 'receiver_state' => !empty($res['province']) ? $res['province'] : '',
            //'guide_id' => 0,
            'order_status' => $data['order_status'],
            'delivery_type' => $data['delivery_type'], //物流方式
            'receiver_name' => $data['receiver'], //收货人,
            'modified' => $data['order_modify_time'], //订单更新时间
            'payment' =>  $data['order_price'], //应付金额
            // 'receiver_country' => !empty($res['country']) ? $res['country'] : '',
            'is_refund' => $data['is_refund'], //是否退单 SY_REFUND_NONE 无退单 SY_REFUND_ALL 全部退单 SY_REFUND_PART 部分退单
            //'presale_status' => 0, //预售订单状态 SY_FRONT_NOPAID_FINAL_NOPAID 定金未付尾款未付 SY_FRONT_PAID_FINAL_NOPAID 定金已付尾款未付 SY_FRONT_PAID_FINAL_PAID 定金和尾款都付
            'is_presale' => $data['is_presale'], //是否为预售订单，1:是 0:否
            //'trade_discount_fee' => 0, //订单级优惠金额
            'created' => $data['order_create_time'], //订单创建时间下单时间
            // 'receiver_district' => !empty($res['district']) ? $res['district'] : '',
            //'receiver_town' => 0,
            'endtime' => $data['order_create_time'],
            //'seller_remark' => 0,
            'product_num' => $data['product_num'],
            'trade_source' => $data['trade_source'],  //订单交易来源
            'receiver_mobile' => $data['phone'], //收货人手机号
            'plat_account' => $data['plat_account'], //平台账号,
            'shop_id' => $data['shop_code'],  //店铺编号
            // 'buyer_remark' => !empty($res['remark']) ? $res['remark'] : '',
            //'last_fee_paytime' => 0,
            //'refund_fee' => 0,
            'trade_type' =>  $data['trade_type'], //交易类型
            // 'receiver_address' => !empty($res['delivery_type_name']) ? $res['delivery_type_name'] : '', //收货人地址
            'orders' => $orders,
            'order_id' => $data['trade_no'],
            // 'pay_time' => !empty($res['pay_time']) ? date('Y-m-d H:i:s', $res['pay_time'] / 1000) : '' //订单支付时间
        );

        
    
        $requestType = "Post";
        $res = ShuyunHelper::syRequest($Method,$signdata,$body,$intefacetype,$requestType);
        return $res;
    }

    //[数云]同步客户信息
    public function ChangeSyUser($data)
    {
        $intefacetype = "同步客户信息接口";
        $Method = 'shuyun.base.customer.sync2';
        $signdata = array(
            'Gateway-Request-Time' => ShuyunHelper::msectime()
        );
        $body  = array(
            
            "plat_account" => $data['plat_account'],
            "mobile" => $data['phone'],
			"modified" => $data['modified']
    
        );
        $requestType = "Post";
        $res = ShuyunHelper::syRequest($Method,$signdata,$body,$intefacetype,$requestType);
        $res = json_decode($res[1],true);
        return $res;
    }

    //[数云]修改会员等级
    public function ChangeSyUserGrade($data)
    {
        
        $intefacetype = "同步会员等级接口";
        $Method = 'shuyun.loyalty.member.grade.change';
        $signdata = array(
            'Gateway-Request-Time' => ShuyunHelper::msectime()
        );
        $body  = array(
            
            "platCode" => isset($data['platCode'])?$data['platCode']:'TAOBAO',
            "sequence" => date("Y-m-d").'_'.$data['mobile'],
            "created" => date("Y-m-d H:i:s"),
            "grade" => $data['grade'],
            "id" => $data['mobile'],
            "shopId" => isset($data['shopId'])?$data['shopId']:'145850013',
            "source" => isset($data['source'])?$data['source']:'IMPORT',
            "desc" => isset($data['desc'])?$data['desc']:''
    
        );
        $requestType = "Post";
        $res = ShuyunHelper::syRequest($Method,$signdata,$body,$intefacetype,$requestType);
        $res = json_decode($res[1],true);
        return $res;
    }

    
}