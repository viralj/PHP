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


//this is class file to perform like unlike task.

class ChatAction {
	
	
	//this function will delete chat. It will change the value to display chat or not.
	public static function delete_chat(){
		include $_SERVER['DOCUMENT_ROOT'].'/core/db_config_inc.php';

		$delete_chat_query = "UPDATE `chat` SET `archived`= '1' WHERE BINARY  (`chat_hash` = '{$_GET['h']}' AND `u_email` = '{$_GET['e']}' AND `uname` = '{$_GET['u']}' AND `id` = '{$_GET['cid']}' AND `archived` = '0')";
		
		if($result = $db->query($delete_chat_query) AND $db->affected_rows > 0){
			return 1;
		}
		else {
			return false;
		}
	
	}
	
	//this function will report chat. It will change that chat report value.
	public static function report_chat(){
		include $_SERVER['DOCUMENT_ROOT'].'/core/db_config_inc.php';
		
		$check_chat_report_query = "SELECT * FROM `chat` WHERE BINARY  (`chat_hash` = '{$_GET['h']}' AND `id` = '{$_GET['cid']}' AND `display` = '0' AND `archived` = '0')";
		
		if($result = $db->query($check_chat_report_query) AND $result->num_rows > 0 AND $result->num_rows < 2 AND $rows = $result->fetch_array(MYSQLI_ASSOC)){
			
			if(empty($rows['reporter'])){
				$new_reporter = $_GET['e'];
			} else {
				$new_reporter = $rows['reporter'].','.$_GET['e'];
			}
			
			$update_chat_query = "UPDATE `chat` SET `report` = (`report` + 1), `reporter` = ('$new_reporter') WHERE BINARY (`chat_hash` = '{$_GET['h']}' AND `id` = '{$_GET['cid']}' AND `display` = '0' AND `archived` = '0')";
			$reporter = explode(',', $rows['reporter']);
			$current_reporter = $_GET['e'];
			
			if(in_array($current_reporter, $reporter)){
				return 2;
			}else {
				
				if($result = $db->query($update_chat_query) AND $db->affected_rows > 0){
					return 1;
				}
				else {
					return false;
				}
				
			}
			
		}
		else {
			return false;
		}
		
		
		
	}
	
}

?>
