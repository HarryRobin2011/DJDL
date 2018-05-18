-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2018 年 03 月 08 日 16:35
-- 服务器版本: 5.5.53
-- PHP 版本: 5.4.45

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `xiongmao`
--

-- --------------------------------------------------------

--
-- 表的结构 `gs_activity_log`
--

CREATE TABLE IF NOT EXISTS `gs_activity_log` (
  `id` int(11) NOT NULL DEFAULT '0',
  `user_account` int(11) NOT NULL COMMENT '使用者',
  `create_time` int(11) NOT NULL COMMENT '时间',
  `friend_account` int(11) NOT NULL COMMENT '对谁使用',
  `friend_nick` varchar(20) DEFAULT NULL COMMENT '推荐人用户名',
  `nick` varchar(20) DEFAULT NULL COMMENT '用户名',
  `user_nick` varchar(20) DEFAULT NULL COMMENT ' 姓名',
  `wx` varchar(20) DEFAULT NULL,
  `zhifubao` varchar(20) DEFAULT NULL,
  `sex` tinyint(1) DEFAULT NULL COMMENT '1 男0 女'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='资源使用记录';

-- --------------------------------------------------------

--
-- 表的结构 `gs_beltline`
--

CREATE TABLE IF NOT EXISTS `gs_beltline` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `animal_on` char(18) NOT NULL COMMENT '给那个水稻施肥了',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1 生产中 2生产结束,待收取 3收取成功',
  `amount` int(11) NOT NULL COMMENT '生产的个数',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `expired_time` int(11) NOT NULL COMMENT '生产结束的时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='生产线,队列任务' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `gs_bonus_log`
--

CREATE TABLE IF NOT EXISTS `gs_bonus_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `touserid` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  `desc` varchar(125) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='动态奖金记录' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `gs_brooding_log`
--

CREATE TABLE IF NOT EXISTS `gs_brooding_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `animal_on` varchar(125) NOT NULL COMMENT '水稻的编号',
  `number` int(11) NOT NULL COMMENT '孵卵个数',
  `day` int(11) NOT NULL COMMENT '第几天产的苗',
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='拾苗日志' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `gs_clean_log`
--

CREATE TABLE IF NOT EXISTS `gs_clean_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL COMMENT '使用者',
  `rate` float(11,2) NOT NULL DEFAULT '0.00' COMMENT '利润',
  `create_time` int(11) NOT NULL COMMENT '时间',
  `friendid` int(11) NOT NULL COMMENT '对谁使用',
  `task_id` int(1) DEFAULT NULL COMMENT '任务id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='资源使用记录' AUTO_INCREMENT=16983 ;

--
-- 转存表中的数据 `gs_clean_log`
--

INSERT INTO `gs_clean_log` (`id`, `userid`, `rate`, `create_time`, `friendid`, `task_id`) VALUES
(16970, 1, 0.00, 1493365406, 1357, NULL),
(16971, 1, 0.00, 1493449811, 2, NULL),
(16972, 1, 0.63, 1493489976, 1357, NULL),
(16973, 1, 0.00, 1493489976, 1359, NULL),
(16974, 1, 0.00, 1493567566, 2, NULL),
(16975, 1, 0.66, 1493567566, 1357, NULL),
(16976, 1, 0.00, 1493567566, 1359, NULL),
(16977, 1, 0.00, 1493567566, 1361, NULL),
(16978, 1, 0.00, 1493727506, 1362, NULL),
(16979, 1, 0.00, 1520495361, 1363, NULL),
(16980, 1, 0.00, 1520495361, 1364, NULL),
(16981, 1, 0.00, 1520495361, 1365, NULL),
(16982, 1, 0.00, 1520495361, 1366, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `gs_dogmsg`
--

CREATE TABLE IF NOT EXISTS `gs_dogmsg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lev` smallint(6) NOT NULL COMMENT '等级',
  `rate` decimal(4,2) NOT NULL COMMENT '利益利率',
  `upgrade_percent` float(4,2) NOT NULL COMMENT '升级成功率',
  `create_time` int(11) DEFAULT NULL,
  `updatedog_num` int(11) DEFAULT '100' COMMENT '升级稻草人需要的苗',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`lev`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- 转存表中的数据 `gs_dogmsg`
--

INSERT INTO `gs_dogmsg` (`id`, `lev`, `rate`, `upgrade_percent`, `create_time`, `updatedog_num`) VALUES
(1, 2, '0.10', 80.00, 0, 200),
(2, 9, '0.45', 10.00, 1489850447, 900),
(3, 6, '0.30', 40.00, 1489850431, 600),
(5, 3, '0.15', 70.00, 1489850447, 300),
(6, 4, '0.20', 60.00, 1489850447, 400),
(7, 1, '0.05', 99.99, 1489850447, 100),
(8, 5, '0.25', 50.00, 1489850447, 500),
(10, 7, '0.35', 30.00, 1489850447, 700),
(11, 8, '0.40', 20.00, 1489850447, 800);

-- --------------------------------------------------------

--
-- 表的结构 `gs_email`
--

CREATE TABLE IF NOT EXISTS `gs_email` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account` varchar(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  `send` tinyint(1) NOT NULL COMMENT '0未读 1已读',
  `msg` varchar(256) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `gs_email`
--

INSERT INTO `gs_email` (`id`, `account`, `create_time`, `send`, `msg`) VALUES
(1, '18435398677', 1520520571, 0, '恭喜您，成为新田庄主，已配送300只秧苗到仓库中。'),
(2, '666666', 1520522853, 0, '恭喜！在幸运转盘中获得奖品 (六等奖奖励2只水稻)已派送到您的仓库中  ');

-- --------------------------------------------------------

--
-- 表的结构 `gs_farm_log`
--

CREATE TABLE IF NOT EXISTS `gs_farm_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `desc` varchar(125) NOT NULL COMMENT '购买描述',
  `create_time` int(11) NOT NULL,
  `farm_type` int(1) NOT NULL COMMENT '类型:1绿地2金地',
  `number` float(11,2) NOT NULL COMMENT '金额/用富贵苗的个数',
  `farm_id` int(11) DEFAULT NULL COMMENT '地id',
  `type` tinyint(1) DEFAULT NULL COMMENT '1 种水稻 2增种苗',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23972 ;

--
-- 转存表中的数据 `gs_farm_log`
--

INSERT INTO `gs_farm_log` (`id`, `userid`, `desc`, `create_time`, `farm_type`, `number`, `farm_id`, `type`) VALUES
(23954, 1, '', 1493363834, 1, 100.00, 1487, 2),
(23955, 1, '', 1493363971, 1, 600.00, 1487, 2),
(23956, 1, '', 1493364904, 1, 5.00, 1487, 1),
(23957, 1, '', 1493465516, 1, 93.00, 1487, 2),
(23958, 1, '', 1493489823, 2, 3143.00, 1493, 2),
(23959, 1, '', 1493509283, 2, 7188.00, 1501, 1),
(23960, 1, '', 1493522247, 2, 7182.00, 1502, 1),
(23961, 1, '', 1493522273, 2, 901.00, 1489, 2),
(23962, 1, '', 1493567619, 2, 21.00, 1489, 2),
(23963, 1, '', 1493581047, 1, 250.00, 1496, 2),
(23964, 1, '', 1493605276, 1, 9.00, 1499, 2),
(23965, 1, '', 1493606336, 2, 32.00, 1489, 1),
(23966, 1, '', 1493606394, 2, 593.00, 1489, 2),
(23967, 1, '', 1493610423, 2, 3209.00, 1489, 1),
(23968, 1, '', 1493666749, 2, 100.00, 1489, 2),
(23969, 1, '', 1493704448, 1, 200.00, 1487, 2),
(23970, 1357, '', 1493788444, 1, 6.00, 1488, 2),
(23971, 1, '', 1520485986, 1, 581.00, 1487, 1);

-- --------------------------------------------------------

--
-- 表的结构 `gs_lottery`
--

CREATE TABLE IF NOT EXISTS `gs_lottery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL COMMENT '0:鹅 ，1：实物',
  `name` varchar(30) NOT NULL,
  `animal_num` int(11) NOT NULL,
  `percent` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- 转存表中的数据 `gs_lottery`
--

INSERT INTO `gs_lottery` (`id`, `type`, `name`, `animal_num`, `percent`) VALUES
(19, 0, '五等奖奖励8只水稻', 8, 30),
(20, 1, '二等奖奖励50元话费', 0, 0),
(21, 0, '四等奖奖励16只水稻', 16, 2),
(22, 0, '三等奖奖励32只水稻', 32, 1),
(23, 1, '一等奖苹果732G一台', 0, 0),
(24, 0, '六等奖奖励2只水稻', 2, 67);

-- --------------------------------------------------------

--
-- 表的结构 `gs_lottery_record`
--

CREATE TABLE IF NOT EXISTS `gs_lottery_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `animal_num` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `create_time` int(11) NOT NULL,
  `send` tinyint(4) NOT NULL COMMENT '0：未发货 1：已发货',
  `address` varchar(200) NOT NULL,
  `receive` varchar(30) NOT NULL,
  `phone` char(15) NOT NULL,
  `kuaidi` varchar(1024) NOT NULL,
  `lotteryid` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `gs_lottery_record`
--

INSERT INTO `gs_lottery_record` (`id`, `userid`, `animal_num`, `name`, `create_time`, `send`, `address`, `receive`, `phone`, `kuaidi`, `lotteryid`) VALUES
(1, 1, 2, '六等奖奖励2只水稻', 1520522853, 1, '', '', '', '', 24);

-- --------------------------------------------------------

--
-- 表的结构 `gs_market`
--

CREATE TABLE IF NOT EXISTS `gs_market` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `touserid` int(11) NOT NULL,
  `number` int(11) NOT NULL COMMENT '挂卖多少个',
  `price` int(11) NOT NULL COMMENT '价格',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1 挂卖中 2买家锁定 3交易完成',
  `create_time` int(11) NOT NULL,
  `type` int(11) NOT NULL COMMENT '1 市场 2 平台',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='市场' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `gs_market_price`
--

CREATE TABLE IF NOT EXISTS `gs_market_price` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(22) NOT NULL,
  `start` varchar(20) NOT NULL,
  `price` decimal(4,2) NOT NULL COMMENT '利率',
  PRIMARY KEY (`id`),
  UNIQUE KEY `start` (`start`),
  KEY `start_2` (`start`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='市场价格' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `gs_market_price`
--

INSERT INTO `gs_market_price` (`id`, `title`, `start`, `price`) VALUES
(1, '当日利率:2.6%', '2018-03-08', '2.60');

-- --------------------------------------------------------

--
-- 表的结构 `gs_member`
--

CREATE TABLE IF NOT EXISTS `gs_member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '会员编号',
  `account` varchar(20) NOT NULL COMMENT '会员账户',
  `password` varchar(32) NOT NULL DEFAULT '' COMMENT '会员密码',
  `sex` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1男 2女',
  `token` varchar(32) NOT NULL DEFAULT '1' COMMENT '用户token',
  `nickname` varchar(20) DEFAULT '' COMMENT '会员昵称',
  `realname` varchar(20) DEFAULT '' COMMENT '真实姓名',
  `references` varchar(20) DEFAULT '' COMMENT '介绍人',
  `second_generation` varchar(255) DEFAULT NULL COMMENT '二代',
  `three_generations` varchar(255) DEFAULT NULL COMMENT '三代',
  `wechat` varchar(20) DEFAULT NULL COMMENT '会员微信号',
  `phone` varchar(20) DEFAULT NULL COMMENT '手机号',
  `level` tinyint(1) NOT NULL DEFAULT '0' COMMENT '会员等级 0刚注册 未购买 1 购买过  正式玩家',
  `status` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '用户状态0:正常  1:禁用',
  `path` text COMMENT '上级路径',
  `active` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '激活状态 0:未激活 1:激活',
  `active_time` int(11) unsigned DEFAULT NULL COMMENT '激活时间',
  `safe_question` varchar(20) DEFAULT NULL COMMENT '密保问题',
  `safe_answer` varchar(20) DEFAULT NULL COMMENT '密保答案',
  `reg_ip` varchar(20) DEFAULT NULL COMMENT '注册Ip',
  `reg_time` int(13) unsigned DEFAULT NULL COMMENT '注册时间',
  `last_ip` varchar(20) DEFAULT NULL COMMENT '上一次登录ip',
  `last_time` int(13) unsigned DEFAULT NULL COMMENT '上一次登录时间',
  `alipay` varchar(20) DEFAULT NULL COMMENT '支付宝',
  `highpass` char(32) DEFAULT '' COMMENT '二级密码',
  `bank_name` varchar(30) DEFAULT NULL COMMENT '银行名字',
  `bank_account` varchar(12) DEFAULT NULL COMMENT '银行账户名',
  `bank_code` varchar(30) DEFAULT NULL COMMENT '账户号码',
  `bank_address` varchar(120) DEFAULT NULL COMMENT '账户地址',
  `money` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '用户金额',
  `currency` decimal(11,2) DEFAULT '0.00' COMMENT '货币(富贵苗)',
  `action_code` int(11) NOT NULL DEFAULT '0' COMMENT '拥有的激活码个数',
  `feed` int(11) NOT NULL DEFAULT '0' COMMENT '饲料个数 弃用',
  `dog_lev` tinyint(1) DEFAULT '0' COMMENT '稻草人等级',
  `machine` tinyint(1) DEFAULT '0' COMMENT '机器',
  `animal_num` decimal(11,2) DEFAULT '0.00' COMMENT '水稻个数',
  `enclosure_lev` tinyint(1) DEFAULT '0' COMMENT '围栏等级',
  `egg_parent_status` tinyint(1) DEFAULT '1' COMMENT '1上级未打扫 2上级已经打扫',
  `machine_egg` decimal(11,2) DEFAULT '0.00' COMMENT '机器里面的苗',
  `machine_animal` decimal(11,2) DEFAULT '0.00' COMMENT '机器里面的水稻',
  `one_clean` tinyint(1) DEFAULT '0' COMMENT '0 没有 1 有',
  `crean_time` int(11) DEFAULT '0' COMMENT '打扫过期时间',
  `all_rate` decimal(11,2) DEFAULT '0.00' COMMENT '上次任务的所获得总利润',
  `tixian_animal` decimal(11,2) DEFAULT '0.00' COMMENT '课提现的水稻',
  `icon` varchar(64) DEFAULT NULL COMMENT '头像',
  PRIMARY KEY (`id`),
  UNIQUE KEY `account` (`account`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `gs_member`
--

INSERT INTO `gs_member` (`id`, `account`, `password`, `sex`, `token`, `nickname`, `realname`, `references`, `second_generation`, `three_generations`, `wechat`, `phone`, `level`, `status`, `path`, `active`, `active_time`, `safe_question`, `safe_answer`, `reg_ip`, `reg_time`, `last_ip`, `last_time`, `alipay`, `highpass`, `bank_name`, `bank_account`, `bank_code`, `bank_address`, `money`, `currency`, `action_code`, `feed`, `dog_lev`, `machine`, `animal_num`, `enclosure_lev`, `egg_parent_status`, `machine_egg`, `machine_animal`, `one_clean`, `crean_time`, `all_rate`, `tixian_animal`, `icon`) VALUES
(1, '666666', 'e10adc3949ba59abbe56e057f20f883e', 1, '408f73a1cb8e21c45fefe4fa22bfcd37', '666666', '666666', '', NULL, NULL, NULL, '18750628888', 0, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1520526011, NULL, '', NULL, NULL, NULL, NULL, '0.00', '0.00', 0, 0, 0, 0, '697.00', 0, 1, '0.00', '0.00', 0, 0, '0.00', '8.00', NULL),
(2, '18435398677', 'e10adc3949ba59abbe56e057f20f883e', 1, 'ae31c425052835ccf390e4032a80dae9', '小鹏鹏', '杨垚鹏', '666666', '', '', '', '18435398677', 0, 0, NULL, 1, NULL, NULL, NULL, NULL, 1520520571, NULL, 1520521447, '', '', NULL, NULL, NULL, NULL, '0.00', '0.00', 0, 0, 0, 0, '0.00', 0, 1, '0.00', '0.00', 0, 0, '0.00', '0.00', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `gs_member_cash`
--

CREATE TABLE IF NOT EXISTS `gs_member_cash` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '钱包编号',
  `mid` int(10) unsigned NOT NULL COMMENT '会员id',
  `baoli_wallet` int(20) unsigned DEFAULT '0' COMMENT '保利',
  `baotong_wallet` int(20) unsigned DEFAULT '0' COMMENT '宝通',
  `gongyi_wallet` int(20) unsigned DEFAULT '0' COMMENT '公益',
  `gold_wallet` int(20) unsigned DEFAULT '0' COMMENT '金币',
  `baofeng_wallet` int(20) unsigned DEFAULT '0' COMMENT '宝丰',
  `make_wallet` int(20) unsigned DEFAULT '0' COMMENT '每天生产金币',
  `count_wallet` int(20) unsigned DEFAULT '0' COMMENT '累积挂卖金币',
  `test_wallet` int(20) unsigned DEFAULT '0',
  `financial_wallet` decimal(8,2) NOT NULL COMMENT '理财钱包',
  `reward_wallet` decimal(8,2) NOT NULL COMMENT '奖励钱包',
  `drawing_wallet` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '提现钱包',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=12 ;

--
-- 转存表中的数据 `gs_member_cash`
--

INSERT INTO `gs_member_cash` (`id`, `mid`, `baoli_wallet`, `baotong_wallet`, `gongyi_wallet`, `gold_wallet`, `baofeng_wallet`, `make_wallet`, `count_wallet`, `test_wallet`, `financial_wallet`, `reward_wallet`, `drawing_wallet`) VALUES
(1, 2, 0, 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', '0.00'),
(2, 1325, 0, 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', '0.00'),
(3, 1326, 0, 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', '0.00'),
(4, 1327, 0, 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', '0.00'),
(5, 1328, 0, 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', '0.00'),
(6, 1329, 0, 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', '0.00'),
(7, 1359, 0, 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', '0.00'),
(8, 1360, 0, 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', '0.00'),
(9, 1361, 0, 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', '0.00'),
(10, 1365, 0, 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', '0.00'),
(11, 1366, 0, 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', '0.00');

-- --------------------------------------------------------

--
-- 表的结构 `gs_member_cash_log`
--

CREATE TABLE IF NOT EXISTS `gs_member_cash_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '交易记录信息',
  `before_prize` int(20) unsigned DEFAULT '0' COMMENT '当前奖励钱包',
  `prize` int(10) DEFAULT '0' COMMENT '奖励',
  `after_prize` int(20) unsigned DEFAULT '0' COMMENT '获得奖励之后的金额',
  `date` int(13) DEFAULT NULL COMMENT '生成时间',
  `touch_member` varchar(20) NOT NULL COMMENT '触发用户账户',
  `recep_member` varchar(20) NOT NULL COMMENT '接收用户',
  `status` int(1) unsigned DEFAULT '0' COMMENT '状态 0 收益 1支出',
  `content` varchar(128) DEFAULT NULL COMMENT '明细',
  `wallet` int(1) DEFAULT NULL COMMENT '钱包类型0:现金钱包 1:奖励钱包 2:排单币 3 理财钱包 4提现钱包',
  `drawing_name` varchar(122) DEFAULT NULL COMMENT '提款人的姓名',
  `drawing_code` varchar(122) NOT NULL COMMENT '提款人的卡号',
  `zhuangtai` int(1) NOT NULL DEFAULT '1' COMMENT '1 成功 2失败 3ing',
  `orderid` varchar(255) DEFAULT NULL,
  `msg` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=179 ;

--
-- 转存表中的数据 `gs_member_cash_log`
--

INSERT INTO `gs_member_cash_log` (`id`, `before_prize`, `prize`, `after_prize`, `date`, `touch_member`, `recep_member`, `status`, `content`, `wallet`, `drawing_name`, `drawing_code`, `zhuangtai`, `orderid`, `msg`) VALUES
(176, 0, 5000, 5000, 1493318499, '888888', '系统', 0, '系统赠送', 2, NULL, '', 1, NULL, NULL),
(177, NULL, 300, NULL, 1493455995, '123456', '系统', 0, '系统赠送', 1, NULL, '', 1, NULL, NULL),
(178, NULL, 1000, NULL, 1520519117, '666666', '系统', 0, '系统赠送', 1, NULL, '', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `gs_notice`
--

CREATE TABLE IF NOT EXISTS `gs_notice` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '公告显示的id',
  `content` text COMMENT '公告内容',
  `date` int(11) DEFAULT NULL COMMENT '公告时间',
  `title` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `gs_rate_log`
--

CREATE TABLE IF NOT EXISTS `gs_rate_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` int(11) NOT NULL COMMENT '任务id',
  `base_rate` float(6,4) DEFAULT NULL COMMENT '每日利率基础利率',
  `dog_rate` float(6,4) DEFAULT NULL COMMENT '稻草人利率',
  `enclosure_rate` float(6,3) DEFAULT NULL COMMENT '围栏利率',
  `machine_animal` int(11) DEFAULT NULL,
  `machine_rate` float(6,4) DEFAULT NULL,
  `time` varchar(20) DEFAULT NULL COMMENT '时间月 日',
  `all_currency` decimal(11,2) DEFAULT NULL COMMENT '苗数量',
  `userid` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18669 ;

--
-- 转存表中的数据 `gs_rate_log`
--

INSERT INTO `gs_rate_log` (`id`, `task_id`, `base_rate`, `dog_rate`, `enclosure_rate`, `machine_animal`, `machine_rate`, `time`, `all_currency`, `userid`, `create_time`) VALUES
(18665, 26, 0.0250, 0.0030, 0.000, 39, 0.0250, '04-28', '336.00', 1, 1493447895),
(18666, 26, 0.0250, 0.0000, 0.004, 0, 0.0250, '04-28', '6.30', 1357, 1493447895),
(18667, 27, 0.0260, 0.0035, 0.000, 14, 0.0260, '04-29', '772.19', 1, 1493528142),
(18668, 27, 0.0260, 0.0000, 0.004, 0, 0.0260, '04-29', '6.60', 1357, 1493528142);

-- --------------------------------------------------------

--
-- 表的结构 `gs_rate_task`
--

CREATE TABLE IF NOT EXISTS `gs_rate_task` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '任务id',
  `username` varchar(120) NOT NULL,
  `create_time` varchar(11) NOT NULL,
  `task_date` varchar(20) NOT NULL,
  `end_time` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `gs_resource_log`
--

CREATE TABLE IF NOT EXISTS `gs_resource_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL COMMENT '使用者',
  `type` int(11) NOT NULL COMMENT '1激活码 2私聊',
  `counts` int(1) NOT NULL DEFAULT '1' COMMENT '使用数量',
  `create_time` int(11) NOT NULL COMMENT '时间',
  `touserid` int(11) NOT NULL COMMENT '对谁使用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='资源使用记录' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `gs_sms_log`
--

CREATE TABLE IF NOT EXISTS `gs_sms_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mobile` char(11) NOT NULL,
  `code` int(6) NOT NULL,
  `content` varchar(125) NOT NULL,
  `expiration_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mobile` (`mobile`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=162 ;

--
-- 转存表中的数据 `gs_sms_log`
--

INSERT INTO `gs_sms_log` (`id`, `mobile`, `code`, `content`, `expiration_time`) VALUES
(158, '18888888888', 636648, '您正在重设密码，验证码：636648，TEC提醒您注意账号安全【天鹅城】', 1493374464),
(159, '13345565672', 231265, '您正在重设密码，验证码：231265，TEC提醒您注意账号安全【天鹅城】', 1493457320),
(160, '13142411393', 198996, '您正在重设密码，验证码：198996，TEC提醒您注意账号安全【天鹅城】', 1493566435),
(161, '15233333333', 334453, '您正在重设密码，验证码：334453，TEC提醒您注意账号安全【天鹅城】', 1493790107);

-- --------------------------------------------------------

--
-- 表的结构 `gs_system_config`
--

CREATE TABLE IF NOT EXISTS `gs_system_config` (
  `id` int(2) unsigned NOT NULL COMMENT '系统配置表',
  `web_title` varchar(20) DEFAULT NULL COMMENT '网站名字',
  `rank_name` varchar(50) DEFAULT NULL COMMENT '等级名称',
  `max_rank` varchar(2) DEFAULT '0' COMMENT '最大等级',
  `rank_default` varchar(10) DEFAULT '0' COMMENT '等级缺省值',
  `offspring_limit` varchar(50) DEFAULT '0' COMMENT '代数收益限制',
  `dynamic_income` varchar(50) DEFAULT '0' COMMENT '动态收益参数',
  `under_limit` varchar(50) DEFAULT '0' COMMENT '下属要求限制',
  `team_limit` varchar(50) DEFAULT '0' COMMENT '团队要求限制',
  `log_prize_name` varchar(20) DEFAULT NULL COMMENT '交易记录中的奖励名称',
  `debit_under_cash` int(10) unsigned DEFAULT '500' COMMENT '用户不打款扣除上级的费用',
  `ban_member_time` int(10) unsigned DEFAULT NULL COMMENT '用户封号时间',
  `to_start_time` int(11) DEFAULT NULL COMMENT '每日开始时间',
  `to_end_time` int(11) DEFAULT NULL COMMENT '每日结束时间',
  `to_switch_time` int(1) DEFAULT NULL COMMENT '开始结束开关',
  `admin_title` varchar(30) DEFAULT NULL COMMENT '后台标题',
  `limit_help_get` varchar(120) DEFAULT NULL COMMENT '提现限制',
  `limit_help_to` varchar(120) DEFAULT NULL COMMENT '帮助限制',
  `limit_help_get_switch` int(1) DEFAULT NULL COMMENT '提现限制开关0:关1:开',
  `limit_help_to_switch` int(1) DEFAULT NULL COMMENT '帮助限制开关',
  `economic_foam_switch` int(1) DEFAULT NULL COMMENT '烧伤开关',
  `economic_foam_i` int(1) DEFAULT NULL COMMENT '烧伤比例',
  `ticket_switch` int(1) DEFAULT NULL COMMENT '入场券开关 0:关1:开',
  `ticket_msg` varchar(30) DEFAULT NULL COMMENT '入场卷不足提示',
  `limit_to_money` varchar(30) DEFAULT NULL COMMENT '限制提供的钱',
  `limit_get_money` varchar(30) DEFAULT NULL COMMENT '限制取现',
  `member_level_get` varchar(60) DEFAULT NULL COMMENT '等级限制取现',
  `member_level_to` varchar(60) DEFAULT NULL COMMENT '等级限制拍单',
  `ticket_use` varchar(30) DEFAULT NULL COMMENT '入场券使用规则两种模式',
  `init_cash_wallet` int(11) DEFAULT NULL COMMENT '用户注册送钱',
  `init_prize_wallet` int(11) DEFAULT NULL COMMENT '用户',
  `init_ticket_wallet` int(11) DEFAULT NULL COMMENT '初始化入场卷',
  `before_interest` float(11,2) unsigned DEFAULT '0.00' COMMENT '排队利息',
  `after_interest` float(11,2) unsigned DEFAULT '0.00' COMMENT '打款后利息',
  `sms_uid` varchar(20) DEFAULT NULL COMMENT '短信uid',
  `sms_pass` varchar(20) DEFAULT NULL COMMENT '短信密码',
  `sms_type` int(1) DEFAULT NULL,
  `sms_mate` varchar(120) DEFAULT NULL,
  `all_count` varchar(60) DEFAULT NULL COMMENT '拍单数量',
  `prize_day` int(2) unsigned DEFAULT NULL,
  `sms_reg` varchar(60) DEFAULT NULL,
  `bili` varchar(10) DEFAULT NULL,
  `fenhong` int(11) NOT NULL COMMENT '分红百分比',
  `fee` int(2) NOT NULL COMMENT '手续费',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `gs_tool_admin`
--

CREATE TABLE IF NOT EXISTS `gs_tool_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '后台管理',
  `username` varchar(20) DEFAULT NULL COMMENT '管理账号',
  `password` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `gs_tool_admin`
--

INSERT INTO `gs_tool_admin` (`id`, `username`, `password`) VALUES
(10, 'admin', 'e10adc3949ba59abbe56e057f20f883e');

-- --------------------------------------------------------

--
-- 表的结构 `gs_tool_admin_log`
--

CREATE TABLE IF NOT EXISTS `gs_tool_admin_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(30) DEFAULT NULL,
  `content` varchar(120) DEFAULT NULL,
  `date` int(11) DEFAULT NULL,
  `ip` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `gs_tool_admin_log`
--

INSERT INTO `gs_tool_admin_log` (`id`, `user`, `content`, `date`, `ip`) VALUES
(1, 'admin', '登陆后台管理', 1520502927, '113.89.238.173'),
(2, 'admin', '登陆后台管理', 1520508441, '221.230.231.248'),
(3, 'admin', '登陆后台管理', 1520518321, '221.230.231.248'),
(4, 'admin', '登陆后台管理', 1520518382, '39.190.218.72'),
(5, 'admin', '登陆后台管理', 1520518808, '39.190.218.72'),
(6, 'admin', '登陆后台管理', 1520519543, '221.230.231.248'),
(7, 'admin', '登陆后台管理', 1520520867, '39.190.218.72'),
(8, 'admin', '登陆后台管理', 1520522573, '223.104.14.110');

-- --------------------------------------------------------

--
-- 表的结构 `gs_transfer_log`
--

CREATE TABLE IF NOT EXISTS `gs_transfer_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL COMMENT '使用者',
  `price` int(1) NOT NULL DEFAULT '1' COMMENT '使用数量',
  `create_time` int(11) NOT NULL COMMENT '时间',
  `touserid` int(11) NOT NULL COMMENT '对谁使用',
  `type` tinyint(1) DEFAULT '1' COMMENT '1 送水稻 2送苗',
  `realprice` int(11) DEFAULT NULL COMMENT '给对方的数量',
  `status` tinyint(1) DEFAULT '1' COMMENT 'status 1转入2转出。',
  `super` tinyint(1) DEFAULT '0' COMMENT '1 超级转账不需要走流程',
  `paystatus` tinyint(1) DEFAULT '1' COMMENT '1 等待确认付款 2 确认付款 3确认收款',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='资源使用记录' AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `gs_transfer_log`
--

INSERT INTO `gs_transfer_log` (`id`, `userid`, `price`, `create_time`, `touserid`, `type`, `realprice`, `status`, `super`, `paystatus`) VALUES
(1, 1, 330, 1493695898, 1360, 1, 330, 2, 1, 1),
(2, 1, 330, 1493696138, 1362, 1, 330, 2, 1, 1),
(3, 1, 330, 1493696176, 1362, 1, 330, 2, 1, 1),
(4, 1, 330, 1493696210, 1362, 1, 330, 2, 0, 1),
(5, 1, 3000, 1493788226, 1363, 1, 3000, 2, 0, 1),
(6, 1, 3000, 1493788360, 1364, 1, 3000, 2, 0, 1),
(7, 1, 2000, 1493788536, 1357, 1, 2000, 2, 0, 3);

-- --------------------------------------------------------

--
-- 表的结构 `gs_user`
--

CREATE TABLE IF NOT EXISTS `gs_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `gs_user_animal`
--

CREATE TABLE IF NOT EXISTS `gs_user_animal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `animal_on` char(18) NOT NULL COMMENT '水稻的唯一编号',
  `create_time` int(11) NOT NULL COMMENT '购买时间',
  `expired_time` int(11) NOT NULL COMMENT '过期时间',
  `hatchery` int(11) NOT NULL DEFAULT '0' COMMENT '孵卵个数',
  `used_day` int(11) NOT NULL DEFAULT '0' COMMENT '生命过几天--弃用',
  PRIMARY KEY (`id`),
  UNIQUE KEY `animal_on` (`animal_on`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户拥有的水稻' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `gs_user_farm`
--

CREATE TABLE IF NOT EXISTS `gs_user_farm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `type` int(11) NOT NULL COMMENT '1,绿地 2金地',
  `create_time` int(11) NOT NULL,
  `num` int(11) NOT NULL COMMENT '开地用到的稻米数量',
  `add_num` int(11) DEFAULT '0' COMMENT '增量种水稻个数',
  `egg_rate` decimal(11,2) DEFAULT '0.00' COMMENT '今日生产苗个数',
  `egg_allrate` decimal(11,2) DEFAULT '0.00' COMMENT '历史产苗',
  `egg_status` tinyint(1) DEFAULT '2' COMMENT '1未收2已收',
  `task_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1504 ;

--
-- 转存表中的数据 `gs_user_farm`
--

INSERT INTO `gs_user_farm` (`id`, `userid`, `type`, `create_time`, `num`, `add_num`, `egg_rate`, `egg_allrate`, `egg_status`, `task_id`) VALUES
(1487, 1, 1, 1493308800, 300, 0, '11.59', '19.99', 2, 27),
(1488, 1357, 1, 1493308800, 300, 0, '6.60', '6.60', 2, 27),
(1489, 1, 2, 1493308800, 3000, 0, '115.08', '199.08', 2, 27),
(1490, 1, 1, 1493308800, 300, 0, '8.85', '17.25', 2, 27),
(1491, 1, 1, 1493308800, 300, 0, '8.85', '17.25', 2, 27),
(1492, 1, 1, 1493308800, 300, 0, '8.85', '17.25', 2, 27),
(1493, 1, 2, 1493308800, 3000, 0, '88.50', '172.50', 2, 27),
(1494, 1, 1, 1493308800, 300, 0, '8.85', '17.25', 2, 27),
(1495, 1, 1, 1493308800, 300, 0, '8.85', '17.25', 2, 27),
(1496, 1, 1, 1493308800, 300, 0, '8.85', '17.25', 2, 27),
(1497, 1, 1, 1493308800, 300, 0, '8.85', '17.25', 2, 27),
(1498, 1, 1, 1493395200, 300, 0, '8.85', '17.25', 2, 27),
(1499, 1, 1, 1493395200, 300, 0, '8.85', '17.25', 2, 27),
(1500, 1, 2, 1493395200, 3000, 0, '88.50', '172.50', 2, 27),
(1501, 1, 2, 1493395200, 3000, 0, '88.50', '88.50', 2, 27),
(1502, 1, 2, 1493481600, 3000, 0, '300.37', '300.37', 2, 27),
(1503, 2, 1, 1520438400, 300, 0, '0.00', '0.00', 2, 0);

-- --------------------------------------------------------

--
-- 表的结构 `gs_user_finance`
--

CREATE TABLE IF NOT EXISTS `gs_user_finance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `desc` varchar(125) DEFAULT NULL COMMENT '购买描述',
  `create_time` int(11) DEFAULT NULL,
  `type` int(1) DEFAULT NULL COMMENT '类型:1购买牲畜,2购买饲料,3购买激活码',
  `number` float(11,2) DEFAULT NULL COMMENT '金额/用富贵苗的个数',
  `counts` int(11) DEFAULT '1' COMMENT '个数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- 转存表中的数据 `gs_user_finance`
--

INSERT INTO `gs_user_finance` (`id`, `userid`, `desc`, `create_time`, `type`, `number`, `counts`) VALUES
(1, 1, '抽奖花费水稻数量5个', 1520501013, 18, 5.00, 1),
(2, 1, '抽奖赠送水稻数量2个', 1520501013, 18, 2.00, 1),
(3, 1, '抽奖花费水稻数量5个', 1520501028, 18, 5.00, 1),
(4, 1, '抽奖赠送水稻数量2个', 1520501028, 18, 2.00, 1),
(5, 1, '抽奖花费水稻数量5个', 1520501193, 18, 5.00, 1),
(6, 1, '抽奖赠送水稻数量2个', 1520501193, 18, 2.00, 1),
(7, 1, '抽奖花费水稻数量5个', 1520503108, 18, 5.00, 1),
(8, 1, '抽奖赠送水稻数量2个', 1520503108, 18, 2.00, 1),
(9, 1, '激活用户666666扣除水稻300只', 1520520571, 13, 300.00, 1),
(10, 2, '开绿地花费水稻300只', 1520521507, 4, 300.00, 1),
(11, 1, '抽奖花费水稻数量5个', 1520522853, 18, 5.00, 1),
(12, 1, '抽奖赠送水稻数量2个', 1520522853, 18, 2.00, 1);

-- --------------------------------------------------------

--
-- 表的结构 `gs_verify`
--

CREATE TABLE IF NOT EXISTS `gs_verify` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '验证码',
  `code` varchar(6) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `date` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
