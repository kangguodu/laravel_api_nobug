# 我拼App Api

因为 Jwt Auth一个项目只能有一个验证对象，所以另外开了一个项目

#### 后台队列
1. 用户申请退款，商家48小時未處理，自動退款到用户当中
2. 团购 24小时如果团当中没有足够人数，团自动完成 -- 如果 24小时的团在队列中，需要自动从队列中移除
3. 订单未付款，24小时之后，如果没有付款，订单自动取消
4. 15 天之后 售后自动关闭
5. 积分计划中，确认收货，调用积分计划开始，7天之后开始返利
6. 积分计划中，返利中的订单 每天进行返利


#### 订单状态
| order_status | 说明 |
| ------ | ------ |
| 0 | 待付款 |
| 5 | 待發貨 | 
| 9 | 已發貨 |
| 6 | 已取消 |
| 13 | 确认收货 |

#### 拼团状态
| group_order_status | 说明 |
| ------ | ------ |
| 0 | 待支付,拼团未开始 |
| 1 | 拼团中 | 
| 2 | 拼团失败 |
| 3 | 拼团成功 |

#### 需要同步返利訂單的操作
1. ~~商家後臺同意退貨退款~~ --- 取消返利訂單
2. ~~用戶單獨購買，支付成功之後~~ --- 同步創建返利訂單
3. ~~如果是團購，當團成功的時候~~ --- 同步創建返利訂單

#### 设定
1. 发货时间限制以小时为单位
2. 

```
sudo supervisorctl update
sudo supervisorctl stop all
sudo supervisorctl start all
sudo supervisorctl status
```

### 修改日志

#### 18-05-14

```
ALTER TABLE `rebate_member_credits`
ADD COLUMN `freeze_credits`  decimal(16,2) NOT NULL DEFAULT 0 COMMENT '冻结金额' AFTER `wait_total_credits`;
ALTER TABLE `orders`
ADD COLUMN `payment_fee`  decimal(10,6) NULL DEFAULT 0 COMMENT '其它支付方式金额' AFTER `payment_type`,
ADD COLUMN `integration_fee`  decimal(16,2) NOT NULL DEFAULT 0 COMMENT '积分支付金额' AFTER `payment_fee`;
```

order
 
```
{
  "group_id": 5,
  "address_id": 12,
  "is_app": 1,
  "app_id": 38,
  "version": 1,
  "source_type": 0,
  "source_channel": 0,
  "goods": [
    {
      "sku_id": 147,
      "sku_number": 1,
      "goods_id": 63
    }
  ]
}
```

#### payment type
app_id 

| 编号 | 常量 | 说明 |
|  2   | COD  | 货到付款 |
