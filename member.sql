/*
Navicat MySQL Data Transfer

Source Server         : wp
Source Server Version : 50631
Source Host           : office.techrare.com:3306
Source Database       : group_buy

Target Server Type    : MYSQL
Target Server Version : 50631
File Encoding         : 65001

Date: 2018-05-23 18:18:39
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for member
-- ----------------------------
DROP TABLE IF EXISTS `member`;
CREATE TABLE `member` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '会员id',
  `email` varchar(50) NOT NULL COMMENT '昵称',
  `gender` tinyint(4) NOT NULL DEFAULT '0' COMMENT '性别',
  `password` varchar(150) DEFAULT NULL COMMENT '密码',
  `social_uid` varchar(256) DEFAULT NULL COMMENT '第三方登陆用户 ID',
  `social_token` varchar(256) DEFAULT NULL COMMENT '第三方登陆用户的令牌',
  `uuid` varchar(128) DEFAULT NULL COMMENT '客户端唯一标识号',
  `source` int(2) DEFAULT NULL COMMENT '用户注册来源(0->iPhone, 1->iPad, 2->Android, 3->微信, 4->H5, 5->网站)',
  `social_source` int(11) DEFAULT NULL COMMENT '第三方登录来源(0->手机, 1->微信, 2->QQ)',
  `birthday` date DEFAULT NULL COMMENT '出生日期',
  `sightml` tinytext COMMENT '个性签名',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  `status` int(2) NOT NULL DEFAULT '1' COMMENT '状态',
  `nickname` varchar(50) DEFAULT NULL,
  `avatar` varchar(500) NOT NULL COMMENT '头像',
  `user_to` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COMMENT='会员';
