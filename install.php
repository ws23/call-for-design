<?php
	require_once(dirname(__FILE__) . "/lib/std.php"); 

/* Create the tables in Database*/

	$DBmain->query('SET FOREIGN_KEY_CHECKS=0;');
	$DBmain->query('SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";'); 
	$DBmain->query('SET time_zone = "+08:00";'); 

	$DBmain->query("
		CREATE TABLE IF NOT EXISTS `admin` (
			`adminID` int(11) NOT NULL AUTO_INCREMENT COMMENT '管理員流水序號',
			`user` varchar(30) NOT NULL COMMENT '管理員帳號',
			PRIMARY KEY (`adminID`),
			KEY `user` (`user`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理員' AUTO_INCREMENT=1 ;
	"); 
	$DBmain->query("
		CREATE TABLE IF NOT EXISTS `department` (
			`deptID` int(11) NOT NULL AUTO_INCREMENT COMMENT '系所流水編號',
			`deptName` varchar(255) NOT NULL COMMENT '系所名稱',
			PRIMARY KEY (`deptID`),
			KEY `deptName` (`deptName`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系所' AUTO_INCREMENT=1 ;
	"); 
	$DBmain->query("
		CREATE TABLE IF NOT EXISTS `draft` (
			`draftID` int(11) NOT NULL AUTO_INCREMENT COMMENT '稿件流水序號',
			`user` varchar(30) NOT NULL COMMENT '投稿使用者',
			`actID` int(11) NOT NULL COMMENT '投稿活動',
			`picItem` varchar(255) NOT NULL COMMENT '稿件附件ID(google drive)',
			`idea` text NOT NULL COMMENT '投稿理念',
			`time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '投稿時間',
			PRIMARY KEY (`draftID`),
			KEY `user` (`user`,`actID`),
			KEY `actID` (`actID`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='稿件' AUTO_INCREMENT=1 ;
	"); 
	$DBmain->query("
		CREATE TABLE IF NOT EXISTS `log` (
			`lID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'log序號',
			`time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'log時間',
			`type` varchar(50) CHARACTER SET utf8 NOT NULL COMMENT 'log類型（info, warning, error）',
			`msg` text CHARACTER SET utf8 COMMENT 'log訊息描述',
			`user` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '留下log的使用者',
			`site` varchar(50) CHARACTER SET utf8 NOT NULL,
			`IP` varchar(50) CHARACTER SET utf8 NOT NULL COMMENT '留下log的IP',
			PRIMARY KEY (`lID`),
			KEY `user` (`user`)
		) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='就是個log，BJ4' AUTO_INCREMENT=1 ;
	"); 
	$DBmain->query("
		CREATE TABLE IF NOT EXISTS `login` (
			`loginID` int(11) NOT NULL AUTO_INCREMENT COMMENT '使用者流水序號',
			`user` varchar(30) NOT NULL COMMENT '使用者名稱',
			 `lastLogin` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '上次登入時間',
			`IP` varchar(30) NOT NULL COMMENT '最新登入IP',
			`name` varchar(30) DEFAULT NULL COMMENT '姓名',
			`deptID` int(11) DEFAULT NULL COMMENT '所屬系所ID',
			`token` varchar(255) NOT NULL COMMENT '登入token',
			PRIMARY KEY (`loginID`),
			UNIQUE KEY `user` (`user`),
			KEY `deptID` (`deptID`),
			KEY `deptID_2` (`deptID`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='使用者資訊' AUTO_INCREMENT=1 ;
	"); 
	$DBmain->query("
		CREATE TABLE IF NOT EXISTS `main` (
			`mainID` int(11) NOT NULL AUTO_INCREMENT COMMENT '活動流水序號',
			`title` varchar(50) NOT NULL COMMENT '活動標題',
			`content` text NOT NULL COMMENT '活動說明',
			`picNum` int(11) NOT NULL COMMENT '所需附件數目',
			`picItemName` varchar(255) DEFAULT NULL COMMENT '附件名稱，以,分隔',
			`startCallForDesign` datetime NOT NULL COMMENT '徵稿開始時間',
			`endCallForDesign` datetime NOT NULL COMMENT '徵稿結束時間',
			`startVote` datetime NOT NULL COMMENT '投票開始時間',
			`endVote` datetime NOT NULL COMMENT '投票結束時間',
			`announceTime` datetime NOT NULL COMMENT '結果公佈時間',
			`voteLimit` int(11) NOT NULL COMMENT '投票數量限制',
			`voteDept` int(11) DEFAULT NULL COMMENT '可投票系所限制',
			`status` int(11) NOT NULL COMMENT '活動狀態（1.上架 2.下架 3.刪除）',
			PRIMARY KEY (`mainID`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='活動資料表' AUTO_INCREMENT=1 ;
	"); 
	$DBmain->query("
		CREATE TABLE IF NOT EXISTS `vote` (
			`voteID` int(11) NOT NULL AUTO_INCREMENT COMMENT '投票流水編號',
			`user` varchar(30) NOT NULL COMMENT '投票使用者',
			`actID` int(11) NOT NULL COMMENT '活動',
			`votes` varchar(255) NOT NULL COMMENT '投的票的稿件ID，以,分隔',
			`time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '投票時間',
			PRIMARY KEY (`voteID`),
			KEY `user` (`user`,`actID`),
			KEY `user_2` (`user`),
			KEY `actID` (`actID`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='投票' AUTO_INCREMENT=1 ;
	");


	$DBmain->query("
		ALTER TABLE `admin`
			ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`user`) REFERENCES `login` (`user`);
	"); 
	$DBmain->query("
		ALTER TABLE `draft`
			ADD CONSTRAINT `draft_ibfk_2` FOREIGN KEY (`actID`) REFERENCES `main` (`mainID`),
			ADD CONSTRAINT `draft_ibfk_1` FOREIGN KEY (`user`) REFERENCES `login` (`user`);
	"); 
	$DBmain->query("
		ALTER TABLE `log`
			ADD CONSTRAINT `log_ibfk_1` FOREIGN KEY (`user`) REFERENCES `login` (`user`);
	"); 
	$DBmain->query("
	ALTER TABLE `login`
		ADD CONSTRAINT `login_ibfk_1` FOREIGN KEY (`deptID`) REFERENCES `department` (`deptID`);
	"); 
	$DBmain->query("
	ALTER TABLE `vote`
		ADD CONSTRAINT `vote_ibfk_2` FOREIGN KEY (`actID`) REFERENCES `main` (`mainID`),
		ADD CONSTRAINT `vote_ibfk_1` FOREIGN KEY (`user`) REFERENCES `login` (`user`);
	"); 
	
	$DBmain->query("SET FOREIGN_KEY_CHECKS=1;"); 

?>
