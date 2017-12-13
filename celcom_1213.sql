/*
Navicat MySQL Data Transfer

Source Server         : 192.168.4.238_celcom
Source Server Version : 50714
Source Host           : 192.168.4.238:21406
Source Database       : celcom

Target Server Type    : MYSQL
Target Server Version : 50714
File Encoding         : 65001

Date: 2017-12-13 16:08:49
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for authority
-- ----------------------------
DROP TABLE IF EXISTS `authority`;
CREATE TABLE `authority` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `method` varchar(255) DEFAULT NULL,
  `route` varchar(255) DEFAULT NULL COMMENT '路由',
  `abits` varchar(255) DEFAULT NULL COMMENT '十进制',
  `active` char(2) NOT NULL DEFAULT '1',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_m_a` (`method`,`route`) USING BTREE COMMENT 'method_route 唯一索引'
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COMMENT='权限表';

-- ----------------------------
-- Records of authority
-- ----------------------------
INSERT INTO `authority` VALUES ('1', '0', '游戏列表', 'GET', '/file/list.html', '1', '1', '2017-12-09 18:28:08', '2017-12-11 19:42:37');
INSERT INTO `authority` VALUES ('2', '1', '游戏添加', 'GET', '/file/add.html', '2', '1', '2017-12-09 18:28:19', '2017-12-11 19:44:20');
INSERT INTO `authority` VALUES ('3', '1', '游戏删除', 'GET', '/file/delcate.html', '4', '1', '2017-12-09 18:29:19', '2017-12-11 19:45:37');
INSERT INTO `authority` VALUES ('4', '1', '游戏编辑', 'GET', '/file/addcate.html', '8', '1', '2017-12-09 18:29:32', '2017-12-11 19:59:04');
INSERT INTO `authority` VALUES ('5', '1', '游戏查询', 'POST', '/file/getgame.html', '16', '1', '2017-12-09 18:30:08', '2017-12-11 19:47:51');
INSERT INTO `authority` VALUES ('6', '0', '图片管理', 'GET', '/file/image.html', '32', '1', '2017-12-09 18:30:29', '2017-12-11 19:51:19');
INSERT INTO `authority` VALUES ('7', '0', '分类列表', 'GET', '/file/cate.html', '64', '1', '2017-12-09 18:30:53', '2017-12-11 19:51:40');
INSERT INTO `authority` VALUES ('8', '7', '删除分类', 'GET', '/file/delcate/*.html', '128', '1', '2017-12-09 18:31:02', '2017-12-11 19:52:05');
INSERT INTO `authority` VALUES ('9', '7', '添加分类', 'POST', '/file/addgame.html', '256', '1', '2017-12-09 18:31:16', '2017-12-11 19:52:20');
INSERT INTO `authority` VALUES ('10', '7', '编辑分类', 'GET', '/file/addcate/*.html', '512', '1', '2017-12-09 18:31:33', '2017-12-11 19:54:26');
INSERT INTO `authority` VALUES ('11', '0', '网站配置', 'GET', '/file/system.html', '1024', '1', '2017-12-09 18:31:45', '2017-12-12 09:58:15');
INSERT INTO `authority` VALUES ('12', '11', '配置修改', 'POST', '/file/system.html', '2048', '1', '2017-12-09 18:32:03', '2017-12-12 10:06:14');
INSERT INTO `authority` VALUES ('13', '0', '权限管理', 'GET', '/file/authority.html', '4096', '1', '2017-12-09 18:33:26', '2017-12-12 10:00:35');
INSERT INTO `authority` VALUES ('14', '13', '添加权限', 'POST', '/file/addauthority.html', '8192', '1', '2017-12-09 18:33:37', '2017-12-12 10:01:15');
INSERT INTO `authority` VALUES ('15', '13', '启用权限', 'GET', '/file/stateauthority/*.html', '16384', '1', '2017-12-09 18:34:11', '2017-12-12 10:07:14');
INSERT INTO `authority` VALUES ('16', '13', '编辑权限', 'GET', '/file/editauthority/*.html', '32768', '1', '2017-12-09 18:34:25', '2017-12-12 10:01:45');
INSERT INTO `authority` VALUES ('17', '13', '删除权限', 'GET', '/file/delauthority/*.html', '65536', '1', '2017-12-09 18:34:46', '2017-12-12 10:02:37');
INSERT INTO `authority` VALUES ('18', '0', '用户列表', 'GET', '/file/sysuser.html', '131072', '1', '2017-12-09 18:35:02', '2017-12-12 10:03:53');
INSERT INTO `authority` VALUES ('19', '18', '添加用户', 'POST', '/file/addsysuser.html', '262144', '1', '2017-12-09 18:35:12', '2017-12-12 10:04:15');
INSERT INTO `authority` VALUES ('20', '18', '删除用户', 'GET', '/file/deluser/*.html', '524288', '1', '2017-12-09 18:35:21', '2017-12-12 10:05:03');
INSERT INTO `authority` VALUES ('21', '18', '编辑用户', null, null, '1048576', '1', '2017-12-09 18:35:35', null);
INSERT INTO `authority` VALUES ('22', '18', '禁用用户', null, null, '2097152', '1', '2017-12-09 18:36:15', null);
INSERT INTO `authority` VALUES ('23', '0', '订阅数据', 'GET', '/file/subdata.html', '4194304', '1', '2017-12-09 18:36:49', '2017-12-12 10:05:22');
INSERT INTO `authority` VALUES ('24', '23', '分析数据', 'POST', '/file/subdata.html', '8388608', '1', '2017-12-09 18:37:17', '2017-12-12 10:05:33');

-- ----------------------------
-- Table structure for contents
-- ----------------------------
DROP TABLE IF EXISTS `contents`;
CREATE TABLE `contents` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cate_id` int(11) NOT NULL DEFAULT '2' COMMENT '类别ID',
  `uid` int(11) DEFAULT NULL COMMENT '发布者ID',
  `title` varchar(64) DEFAULT NULL COMMENT '标题',
  `version` varchar(12) DEFAULT NULL COMMENT '版本',
  `iconurl` varchar(255) DEFAULT NULL COMMENT '游戏图标',
  `thumb` varchar(120) DEFAULT NULL COMMENT '图片缩略图',
  `imgurl` varchar(255) DEFAULT NULL COMMENT '图片',
  `scenes` text COMMENT '游戏场景图',
  `seeds` varchar(255) DEFAULT NULL COMMENT '内容URL/游戏下载地址',
  `texts` text COMMENT '游戏内容介绍',
  `click` int(11) DEFAULT '100' COMMENT ' 下载次数/单击次数',
  `descs` varchar(255) DEFAULT NULL COMMENT '描述',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of contents
-- ----------------------------
INSERT INTO `contents` VALUES ('1', '9', '1', 'Shadow fighting 3', 'v1.6.1', 'http://img02.muzhiwan.com/2017/09/12/com.nekki.shadowfight3_142997/59b75b077ce99.png', null, null, 'http://img02.muzhiwan.com/2017/09/12/com.nekki.shadowfight3_142997/59b75b0de0ca4.jpg', 'http://fhddown.muzhiwan.com/2017/11/21/com.nekki.shadowfight35a1389be60314.gpk', '&lt;p&gt;暗影格斗3 (Shadow Fight 3)是NEKKI开发的一款动作类游戏。&lt;br /&gt;\r\n&lt;br /&gt;\r\n暗影格斗3 (Shadow Fight 3)的介绍&lt;br /&gt;\r\n史诗战斗回归之作！控制暗影，挑战你的敌人！&lt;br /&gt;\r\n进入阴影的世界。揭开所有黑暗的秘密，成为这片土地上最伟大的战士。在这游戏中，你将扮演一个英雄的角色，他的命运还没有确定。你如何看待他的未来?从三种不同的战斗风格中选择，尝试一下，结合你的装备，学习一些新的动作，探索一个充满冒险的世界！享受一场真正的战斗的美，因为现代技术和流畅的动画使之成为可能。&lt;br /&gt;\r\n&lt;br /&gt;\r\n&amp;nbsp;&lt;/p&gt;\r\n', '638', '--提高画质感', '2017-12-12 18:42:26', '2017-12-13 10:53:35');
INSERT INTO `contents` VALUES ('2', '8', '1', '梦幻足球联盟', 'v5.0.2', 'http://img02.muzhiwan.com/2017/11/30/com.firsttouchgames.dls3_146250/5a1fdf78846a9.png', null, null, 'http://img04.muzhiwan.com/2017/11/30/com.firsttouchgames.dls3_146250/5a1fdf852ccf3.jpg,http://img03.muzhiwan.com/2017/11/30/com.firsttouchgames.dls3_146250/5a1fdf75eb6f8.jpg,http://img03.muzhiwan.com/2017/11/30/com.firsttouchgames.dls3_146250/5a1fdf73c9411.jpg', 'http://fhddown.muzhiwan.com/2017/11/30/com.firsttouchgames.dls35a1fdffda1a33.gpk', '&lt;p&gt;梦幻足球联盟2018(Dream League Soccer 2018)是First Touch开发的一款体育竞技类游戏。&lt;br /&gt;\r\n&lt;br /&gt;\r\n梦幻足球联盟2018(Dream League Soccer 2018)的官方介绍&lt;br /&gt;\r\nDream League Soccer 2018已上市，这是史无前例的佳作！正如我们所知，足球已改变，这正是您打造全球最佳球队的良机。通过 Dream League Online，网罗 FIFPro&amp;trade; 授权的真实超级球星，建设自己的球场，与全球的对手一较高下，从而在足球星途上向着荣耀阔步前进！&lt;br /&gt;\r\n&lt;br /&gt;\r\n立刻免费下载 Dream League Soccer 2018！&lt;br /&gt;\r\n*包括平板电脑支持*&lt;br /&gt;\r\n&lt;br /&gt;\r\n&lt;br /&gt;\r\n&amp;nbsp;&lt;/p&gt;\r\n', '256', '* 新用户界面并改进游戏画质\r\n* 全新封面明星 - Gareth Bale &amp;amp; Andres Iniesta！\r\n', '2017-12-12 19:22:11', '2017-12-13 10:03:54');
INSERT INTO `contents` VALUES ('3', '5', '1', '致命框架2', 'v1.1.0', 'http://img02.muzhiwan.com/2017/08/17/com.noodlecake.framed2_141864/5995028c41996.png', null, null, 'http://img03.muzhiwan.com/2017/08/17/com.noodlecake.framed2_141864/599502960032f.jpg', 'http://fhddown.muzhiwan.com/2017/11/23/com.noodlecake.framed25a16908d76cf7.gpk', '&lt;p&gt;致命框架2(FRAMED2)是Noodlecake Studios Inc开发的一款休闲益智类游戏。&lt;br /&gt;\r\n&lt;br /&gt;\r\n致命框架2(FRAMED2)的介绍&lt;br /&gt;\r\n致命框架2是经典冒险解密手游《致命框架》的续作，游戏延续了前作电影史的画面剪辑玩法，在场景设计上加入了大量拥有中文的场景，玩家需要穿越仓库、工地等多种场景中警察的监视，来到达目的地。游戏在画面上延续了前作简约黑暗的风格，游戏将有全新的人物、剧情以及令人期待的关卡，喜欢此类游戏的玩家不要错过哦。&lt;/p&gt;\r\n', '648', '致命框架', '2017-12-12 19:27:48', '2017-12-13 11:38:21');

-- ----------------------------
-- Table structure for menu
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `url` varchar(255) DEFAULT NULL COMMENT '菜单URL',
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `auth_id` int(11) NOT NULL DEFAULT '0' COMMENT '关联外键',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='菜单表';

-- ----------------------------
-- Records of menu
-- ----------------------------

-- ----------------------------
-- Table structure for subscribe
-- ----------------------------
DROP TABLE IF EXISTS `subscribe`;
CREATE TABLE `subscribe` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `msisdn` varchar(255) DEFAULT NULL,
  `pwd` varchar(255) DEFAULT NULL,
  `status` varchar(12) DEFAULT NULL,
  `sptransid` varchar(255) DEFAULT NULL,
  `amount` varchar(18) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `mt_status` varchar(6) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of subscribe
-- ----------------------------
INSERT INTO `subscribe` VALUES ('3', '123456789', 'qwrwqr122', '200', null, '3000', '2017-11-28 17:21:21', null, 'A');
INSERT INTO `subscribe` VALUES ('4', '60132665968', '1', '11', null, '70', '2017-11-29 16:05:34', null, 'A');
INSERT INTO `subscribe` VALUES ('5', '+60132665968', null, 'denied', null, '70.00', '2017-11-30 19:51:59', '2017-11-30 19:51:59', 'N');
INSERT INTO `subscribe` VALUES ('6', '+60132665968', null, 'denied', null, '70.00', '2017-11-30 19:51:59', '2017-11-30 19:51:59', 'N');
INSERT INTO `subscribe` VALUES ('7', '+60132665968', 'agaer23344', 'denied', null, '70.00', '2017-11-30 19:51:59', '2017-11-30 19:51:59', 'N');
INSERT INTO `subscribe` VALUES ('8', '+60132665968', '994156', 'charged', null, '70.00', '2017-12-01 11:00:58', '2017-12-01 11:00:58', 'N');
INSERT INTO `subscribe` VALUES ('9', '+60132665968', '503529', 'charged', null, '1.00', '2017-12-01 14:55:30', null, 'A');
INSERT INTO `subscribe` VALUES ('10', '+60132816305', '895983', 'charged', null, '1.00', '2017-12-13 12:05:41', null, 'A');
INSERT INTO `subscribe` VALUES ('11', '', '', 'charged', null, '1.00', '2017-12-13 12:05:56', null, 'A');
INSERT INTO `subscribe` VALUES ('12', '+60132816305', '895983', 'charged', null, '1.00', '2017-12-13 12:08:41', null, 'A');
INSERT INTO `subscribe` VALUES ('13', '', '', 'charged', null, '1.00', '2017-12-13 12:09:52', null, 'A');
INSERT INTO `subscribe` VALUES ('14', '+60132816305', '895983', 'charged', '2222', '1.00', '2017-12-13 12:59:24', null, 'A');
INSERT INTO `subscribe` VALUES ('15', '+60195330779', '338630', 'charged', '2222', '1.00', '2017-12-13 13:07:30', null, 'A');
INSERT INTO `subscribe` VALUES ('16', '+60195330779', '338630', 'charged', 'SUBS20171211165612369995', '1.00', '2017-12-13 13:25:05', null, 'A');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `pass` varchar(255) DEFAULT NULL,
  `auth_id` varchar(255) DEFAULT NULL,
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'bluepay', '$2y$10$k1CfHj0Qxo04SwmlJva1t.35287U1ZG8P2sqie7IyXKgD6mBOpYpm', '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22', '2017-12-01 18:00:51', '2017-12-12 16:17:43');
INSERT INTO `users` VALUES ('2', 'yuncopy', '$2y$10$IXf7RxMdTNjmhbjzfK7MkOpn1n7aWLR3/mQfLQ8bD722.SEM1c4Eq', '1', '2017-12-09 19:31:59', '2017-12-12 16:01:34');
INSERT INTO `users` VALUES ('3', 'Angela', '$2y$10$rVbjbZDIx6OJNDptKnoOEuDh1gpRq1vkTOzEtrj6cypCXfAEiJUS6', '1', '2017-12-09 19:32:14', '2017-12-12 16:01:42');
INSERT INTO `users` VALUES ('7', 'blueTwo', '$2y$10$BTcgghrcuE4vXovHtJV1Yu/ajfx8HVGp9.D47d8LnhqVDRU0BKKRe', '1,2,3', '2017-12-11 11:22:59', '2017-12-12 16:01:49');
INSERT INTO `users` VALUES ('10', 'GG', '$2y$10$fu65CrEoWZQQP9HxBOFsae6j5Yggu4fy0yoofw9KEQR/WRkCAxkDa', '2,3', '2017-12-12 16:21:06', null);
