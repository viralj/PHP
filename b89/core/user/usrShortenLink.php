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


class Shorten{
	
		public static function check_archived_link($link, $user_email){

		include $_SERVER['DOCUMENT_ROOT'].'/core/db_config_inc.php';
		
		$check_archived_query = "SELECT * FROM `url_table` WHERE BINARY (`url` = '$link' AND `u_email` = '$user_email' AND `archived` != '0')";
		
		if($result = $db->query($check_archived_query)){
			if($result AND $db->affected_rows > 0){
			
				$update_archived_link = "UPDATE `url_table` SET `archived` = '0' WHERE BINARY (`url` = '$link' AND `u_email` = '$user_email')";
			
				if(($db->query($update_archived_link)) AND ($db->affected_rows > 0)){
					throw new Exception('Your entered link is already in use with your account and it was deactivated by you. We\'ve activated your link.<br>');
					return true;
				} else {
					throw new Exception('Your entered link is already in use with your account and it was deactivated by you. We tried to activate the links but we got some error. Please try again.<br>');
				}
			
			}			
			else {
				self::check_link($link, $user_email);
			}
		}
		
		else {
			throw new Exception('We faced some unwanted errors. Please try once again.<br>');
		}
	
	}
	
	public static function check_link($link, $user_email){
		
		include $_SERVER['DOCUMENT_ROOT'].'/core/db_config_inc.php';
			
		$check_query = "SELECT * FROM `url_table` WHERE BINARY (`url` = '$link' AND `u_email` = '$user_email')";
		
		if($result = $db->query($check_query)){
			if($result AND $db->affected_rows > 0){
				throw new Exception('Your entered link is already in use with your account. We don\'t do duplicates.<br>');
			} 
			
		}
		
		else {
			throw new Exception('We faced some unwanted errors. Please try once again.<br>');
		}
		
	}
	
	public static function check_details_from_db($link, $user_email){
		include $_SERVER['DOCUMENT_ROOT'].'/core/db_config_inc.php';
		
		if(!filter_var($link, FILTER_VALIDATE_URL)){
			throw new Exception('Entered link is not in valid format. Please check it.<br>');
		} else 
		
		if(strlen($link) > 1000){
			throw new Exception('Entered link is too long to process.<br>');
		} else 
		
		//check links are in database and archived or not
			self::check_archived_link($link, $user_email) ;
		
	}
	
	public static function gen_code(){
			include $_SERVER['DOCUMENT_ROOT'].'/core/db_config_inc.php';
					
					//generate random code for shorten url
			
					$charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_';
					$len = 5;
					$numrows = 1;
					$code = '';
					$code = empty($code);
				
					while($numrows != 0 AND strlen($code) < 7 ){
						for($i = 0; $i <= $len; $i++){
							$rand = rand()% strlen($charset);
							$temp = substr($charset, $rand, 1);
							$code .= $temp;
						}
					
						$find = $db->query("SELECT `id` FROM `url_table` WHERE BINARY `code` = '$code'");
						$numrows = $find->num_rows;
					}
		return $code;
	}
	
	public static function insert_link($link, $user_email, $blah){
		
		include $_SERVER['DOCUMENT_ROOT'].'/core/db_config_inc.php';
		
		try {
			self::check_details_from_db($link, $user_email);
		} 
		catch(Exception $e) {
			  echo '<b>Message:</b> ' .$e->getMessage();
		}
			
		if(empty($e)){
			
			$code = self::gen_code();
			if(strlen($code) > 7){
				$code = empty($code);
				$code = self::gen_code();
				
			}
			
			$ip = $_SESSION['ip'];
			$date = time();
			$site_name = $site;
			
			$hash_string = $user_email.'/'.$date.'/'.$ip.'/'.$code;
			$hash  = $blah->encode($hash_string);
			
			$insert_link_query = "INSERT INTO `url_table` (`url`, `site`, `code`, `u_email`, `create_time`, `ip`, `hash`, `archived`) 
								  VALUES ('$link', '$site_name', '$code', '$user_email', '$date', '$ip', '$hash', '0')";
			

				if($result = $db->query($insert_link_query)){
					if($result AND $db->affected_rows > 0){
						echo '<b>Message:</b> Successful! Check your all links at right side. You can manage all links from the same table.<br>';
						$refresh_url = $site.'user/v1/home';						
					} else {
						echo '<b>Message:</b> We got an error. Please try again.<br>';
					}
				} else {
					echo '<b>Message:</b> Ooopps! We got an error. Please try again.<br>';
				}  
		}
	
			
	}

	public static function new_shorten_link($post_links){
		include $_SERVER['DOCUMENT_ROOT'].'/core/db_config_inc.php';
		
		$cool = $db->real_escape_string(htmlentities($post_links['cool']));
		$user_email = $_SESSION['email'];
		include $_SERVER['DOCUMENT_ROOT'].'/core/encryption.php';
		$blah = new Encryption;	
			foreach($post_links['link'] as $links){
				$link = $db->real_escape_string(htmlentities($links));
				
				if(!empty($link)){
					$code = '';
					self::insert_link($link, $user_email, $blah);
					$code = empty($code);
					
					// Sleep for a millisecond
					usleep(100);
				}
			}
		
	}
	

	
}

?>