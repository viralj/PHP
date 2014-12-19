<?php


/*
 *	Author Name: Viral Joshi
 *
 *	Join me on 	 github		: /viralj
 *				 facebook	: /viral4ever
 *				 google+	: /+ViralJoshi
 *				 twitter	: /viralhj
 *				 linkedin	: /in/viralj
 *
 *
 */

/*
	# This file is created to create cron class and functions.
	# This file be loaded every time user visit website.
	
	# This cron system will help us to clean unwanted data for being displyed.

*/


class Cron {
	
	//this function will perform when user is logged in
	public static function do_as_said(){
		
		Cron::remove_reported_chat();
		Cron::check_user_policy_violation();
		Cron::check_user_to_deactivate();			
		Cron::check_total_link_views();
		
	}
		
	
	
	//this function will check user's policy violation report 
	public static function check_user_policy_violation(){
		include 'db_config_inc.php';
		
		$check_reported_links = "SELECT * FROM `reported_links` WHERE BINARY `email` = '{$_SESSION['email']}' AND `report_generated` = '0'";
		
		if($result = $db->query($check_reported_links) AND $result->num_rows > 0 AND $rows = $result->fetch_all(MYSQLI_ASSOC)){
			
			foreach($rows as $row){
				if($row['total_count'] > 15){
					//UPDATE `chat` SET `display` = '1' WHERE BINARY (`id` = '{$row['id']}' AND `u_email` = '{$row['u_email']}' AND `uname` = '{$row['uname']}')
					
					$rep_text = 'Hello <u>'.$_SESSION['fname'].' '.$_SESSION['lname'].'</u> (<b>'.$_SESSION['uname'].'</b>),
								<br>
								One of your link is been visited so frequently and that way it is violating our policies. We suggest you to take care of it else it will cause deactivation of your account.
								<br>
								Here is that link: <u>'.$row['site'].$row['code'].'</u>
								<br>
								Our expectation from you is your co-operation.
								<br>
								Team b89.in<br>
								';
					$rep_time = date('l\, jS \of F Y h:i:s A');
					
					$generate_report_query = "INSERT INTO `user_reports` (
											  `fname`, `lname`, `email`, `report_type`, `report_title`, `report_text`, `time`
											  ) 
											  VALUES (
											  '{$_SESSION['fname']}', '{$_SESSION['lname']}', '{$_SESSION['email']}', '3', 'Policy Violation', '$rep_text', '$rep_time'
											  )";
											  
					$update_reported_link = "UPDATE `reported_links` SET `report_generated` = '1' WHERE BINARY 
											(`site` = '{$row['site']}' AND
											 `code` = '{$row['code']}' AND 
											 `email` = '{$_SESSION['email']}')";
					
					
					$db->query($generate_report_query);
					$db->query($update_reported_link);
				}
			}
		}
		
	}	
	
	
	//this function will check user's chat report. If it it is reported more then 5 times, it will not disable that chat visibility
	public static function remove_reported_chat(){
		include 'db_config_inc.php';
		
		$get_all_chat_of_user = "SELECT `id`,`u_email`,`uname`,`report` FROM `chat` WHERE BINARY (`display` = '0'  AND `archived` = '0')";
	
		if($result = $db->query($get_all_chat_of_user) AND $result->num_rows > 0 AND $rows = $result->fetch_all(MYSQLI_ASSOC)){
			
			foreach($rows as $row){
				if($row['report'] > 5){
					$update_query = "UPDATE `chat` SET `display` = '1' WHERE BINARY (`id` = '{$row['id']}' AND `u_email` = '{$row['u_email']}' AND `uname` = '{$row['uname']}')";
					$db->query($update_query);
				}
			}
		}
	
	}
	
	//this function will check policy violating users and will deactivate their account
	public static function check_user_to_deactivate(){
		include 'db_config_inc.php';
		
		if(!isset($_SESSION['check_u_to_deactivate'])){
		
			$select_reported_user_query = "SELECT * FROM `user_reports` WHERE BINARY `email` = '{$_SESSION['email']}' AND `report_type` = '3'";
		
			if($result = $db->query($select_reported_user_query) AND $result->num_rows > 0){
				
				$total_report = $result->num_rows;
				
				$check_for_user_report = "SELECT `count` FROM `user_report_count` WHERE BINARY `email` = '{$_SESSION['email']}'";
				
				if($result = $db->query($check_for_user_report) AND $result->num_rows > 0 AND $rows = $result->fetch_array(MYSQLI_ASSOC)){
					
					if($rows['count'] != $total_report){
						$db->query("UPDATE `user_report_count` SET `count` = '$total_report' WHERE `email` ='{$_SESSION['email']}' ");
					}
					$_SESSION['check_u_to_deactivate'] = 'true';
				} else {
					$db->query("INSERT INTO `user_report_count` (`email`, `count`) VALUE ('{$_SESSION['email']}', '$total_report')");
					$_SESSION['check_u_to_deactivate'] = 'true';
				}
			
			}
		
		}
		
	}
	
	
	//this function will deactivate user who is reported for policy violation more then 5 times
	public static function deactivate_user(){
		include 'db_config_inc.php';
		
		if(!isset($_SESSION['deactivate_user'])){

			$get_count_user = "SELECT * FROM `user_report_count` WHERE `count` >= '5' AND `deactivated` = '0'";
			if($result = $db->query($get_count_user) AND $result->num_rows > 0 AND $rows = $result->fetch_all(MYSQLI_ASSOC)){

				foreach($rows as $row){
					$db->query("UPDATE `users` SET `active` = '1' WHERE BINARY `email` = '{$row['email']}' AND `active` = '0'");
					$db->query("UPDATE `user_report_count` SET `deactivated` = '1' WHERE BINARY `email` = '{$row['email']}' AND `deactivated` = '0'");				
				}
				$_SESSION['deactivate_user'] = 'true';
			}
		}
		
	}
		
	
	//this function will check for total valid and invalid visit of logged in user link
	public static function check_total_link_views(){
		include 'db_config_inc.php';
		
		//if(!isset($_SESSION['check_link_views'])){
			
			$month = date("F");
			$year = date("Y");
			
			
			//this will check for valid link views
			$check_valid_link = "SELECT * FROM `url_visit` WHERE BINARY `email` = '{$_SESSION['email']}' AND `month` = '$month' AND `year` = '$year'";
			
			if($result = $db->query($check_valid_link) AND $result->num_rows > 0){
				$total_vaild_views = $result->num_rows;
				
				$month_year = $month.'/'.$year;
				
				$update_valid_link_views = "SELECT * FROM `user_chart` WHERE BINARY `email` = '{$_SESSION['email']}' AND `month_year` = '$month_year'";
				if($result = $db->query($update_valid_link_views) AND $result->num_rows > 0 AND $rows = $result->fetch_array(MYSQLI_ASSOC)){
					if($rows['valid_link'] < $total_vaild_views){
						$db->query("UPDATE `user_chart` SET `valid_link` = '$total_vaild_views' WHERE BINARY `email` = '{$_SESSION['email']}' AND `month_year` = '$month_year'");
					}			
				}
				else {
					$db->query("INSERT INTO `user_chart` (`email`, `month_year`, `valid_link`) VALUES ('{$_SESSION['email']}', '$month_year', '$total_vaild_views')");
				}
				
			}
			
			//this will check for invalid link views
			$check_invalid_link = "SELECT SUM(total_count) AS total_count FROM `reported_links` WHERE BINARY `email` = '{$_SESSION['email']}' AND `month` = '$month' AND `year` = '$year'";
			
			if($result = $db->query($check_invalid_link) AND $result->num_rows > 0 AND $rows = $result->fetch_array(MYSQLI_ASSOC)){
				$total_invaild_views = $rows['total_count'];
				
				$month_year = $month.'/'.$year;
				
				$update_invalid_link_views = "SELECT * FROM `user_chart` WHERE BINARY `email` = '{$_SESSION['email']}' AND `month_year` = '$month_year'";
				if($result = $db->query($update_invalid_link_views) AND $result->num_rows > 0 AND $rows = $result->fetch_array(MYSQLI_ASSOC)){
					if($rows['invalid_link'] < $total_invaild_views){
						$db->query("UPDATE `user_chart` SET `invalid_link` = '$total_invaild_views' WHERE BINARY `email` = '{$_SESSION['email']}' AND `month_year` = '$month_year'");
					}			
				}
				else {
					$db->query("INSERT INTO `user_chart` (`email`, `month_year`, `invalid_link`) VALUES ('{$_SESSION['email']}', '$month_year', '$total_invaild_views')");
				}
				
			}
		
		
		//}
		
	}
	
	
	
	//public static function(){}
	//public static function(){}
	
	
}

//lets check user type and allow to display page else redirect to user's page
$u_type = array('free', 'pro', 'busi');

if((user_is_logged_in()) AND (in_array($_SESSION['u_type'], $u_type))){
Cron::do_as_said();
}

Cron::deactivate_user();
?>