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

//this will help to prevent security from span

	function rand_csrf_string() {
		
		include 'db_config_inc.php';
					
					//generate random csrf_token for session
			
					$charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_';
					$len = 7;
					$numrows = 1;
					$csrf_token = '';
				
					while($numrows != 0 AND strlen($csrf_token) < 8 ){
						for($i = 0; $i <= $len; $i++){
							$rand = rand()% strlen($charset);
							$temp = substr($charset, $rand, 1);
							$csrf_token .= $temp;
						}
						
						$time_now = time();
						$required_time = $time_now-3600*24;
						$find_query = "SELECT `id` FROM `session` WHERE BINARY `csrf_token` = '$csrf_token' AND `time` < '$required_time'";
						//echo $find_query;
						$find = $db->query($find_query);
						$numrows = $find->num_rows;
					}
		return $csrf_token;
	}
	
	if(empty($_SESSION['CSRF_TOKEN'])){
	
		$_SESSION['CSRF_TOKEN'] = rand_csrf_string() ;
	
	}
	
?>