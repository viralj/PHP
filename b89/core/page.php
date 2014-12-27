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
	# if contact form is not allowing to submit form on first try,
	# use below codes to remove form session.

if(isset($_SESSION['form'])){
	unset($_SESSION['form']);
}

*/
ini_set('session.gc_probability', 1);
//session_save_path($_SERVER['DOCUMENT_ROOT']."/sessionfiles");
session_start();
date_default_timezone_set('America/Chicago');	

error_reporting(0);

require 'genfunc.php';

include 'cron.php';
include 'db_config_inc.php';

/*
These codes are to redirect users to domain website.

For example, if you have hosted this on vps or dedicated server and
someone is trying to access website by ip then you can redirect them
to domain.

http://123.123.123.123 will be redirected to http://site.name

just edit codes given below

if($_SERVER['SERVER_NAME'] != 'site.name'){
	header("Location: http://site.name");
}
*/



//we are facing some temporary session issues so below codes are temporary solution

if((isset($_SESSION['fname'])) AND (empty($_SESSION['fname']))){
	unset($_SESSION['fname']);
}
if((isset($_SESSION['lname'])) AND (empty($_SESSION['lname']))){
	unset($_SESSION['lname']);
}
if((isset($_SESSION['uname'])) AND (empty($_SESSION['uname']))){
	unset($_SESSION['uname']);
}





//find visitor ip

	$http_client_ip = @$_SERVER['HTTP_CLIENT_IP'];
	$http_x_forwarded_for = @$_SERVER['HTTP_X_FORWARDED_FOR'];
	$remote_addr = @$_SERVER['REMOTE_ADDR'];
	
	if(!empty($http_client_ip)){
		$ip_add = $http_client_ip;
	}
	if(!empty($http_x_forwarded_for)){
		$ip_add = $http_x_forwarded_for;
	}
	else{
	$ip_add = $remote_addr;
	}
	
	//session ip set
	$_SESSION['ip'] = $ip_add;
	
	if(isset($_SESSION['ip']) AND isset($_SESSION['CSRF_TOKEN']) AND !isset($_SESSION['session_logged'])){
		$time = time();
		$insert_csrf_token = "INSERT INTO `session` (`ip`, `csrf_token`, `time`) VALUES ('{$_SESSION['ip']}', '{$_SESSION['CSRF_TOKEN']}', '$time');";
		
		if($result = $db->query($insert_csrf_token) AND $db->affected_rows > 0){
			$_SESSION['session_logged'] = 'true';
		}else {
			header("Location: $site");
		}
	}

	function CheckURL($var){
		include 'db_config_inc.php';
		 if($var){
			if($result = $db->query("SELECT `u_email` FROM  `url_table` WHERE BINARY `code` =  '$var' AND `archived` = 0")){
				if($result->num_rows > 0 AND $rows = $result->fetch_array(MYSQLI_ASSOC)){
					$email = $rows['u_email'];
					
					if($result = $db->query("SELECT `uname` FROM  `users` WHERE BINARY `email` =  '$email' AND `active` = 0")){
						if($result->num_rows > 0){
							return true;
						}
					}				
				}
			}
		}	
	}

//we are going to disable this function for while.

/*
	function CheckBugId($var){
		include 'db_config_inc.php';
		 if($var){
			$var = rtrim($var, '/');
			$var = explode('/', $var);
			if((isset($var[0])) AND (isset($var[1]))){
				$new_var = $var[0].'/'.$var[1];
				if(($new_var) AND ($var[0] == 'bugreport') AND ($var[1])){
					if($result = $db->query("SELECT * FROM  `vul_report` WHERE BINARY `vul_id` =  '{$var[1]}' ")){
						if($result->num_rows > 0){
							$_POST['bug_id'] = $var[1];
							include "pages/bugview.php";
							exit;
						} else{
							$_POST['bug_id'] = $var[1];
							include "pages/bugview.php";
							exit;
						}
					}
				}
			}			
		}	
	}

*/
	
	function checkTicket($var){
		include 'db_config_inc.php';
		 if($var){
			$var = rtrim($var, '/');
			$var = explode('~', $var);
			if((isset($var[0])) AND (isset($var[1]))){
				$new_var = $var[0].'~'.$var[1];
				if(($new_var) AND ($var[0] === 'user/v1/support/tickets') AND ($var[1])){
					$_POST['ticket_id'] = $var[1];
					include "user/ticket.php";
					exit;
				}
				
				else
				if(($new_var) AND ($var[0] === 'manage/admin/tickets') AND ($var[1])){
					$_POST['ticket_id'] = $var[1];
					include "admin/tickets.php";
					exit;
				}
				
			}			
		}
	}
	
	function checkGenContact($var){
		include 'db_config_inc.php';
		 if($var){
			$var = rtrim($var, '/');
			$var = explode('~', $var);
			if((isset($var[0])) AND (isset($var[1]))){
				$new_var = $var[0].'~'.$var[1];
				
				if(($new_var) AND ($var[0] === 'manage/admin/genContact') AND ($var[1])){
					$_POST['contact_id'] = $var[1];
					include "admin/genContact.php";
					exit;
				}
				
			}			
		}
	}
	
	function checkBugs($var){
		include 'db_config_inc.php';
		 if($var){
			$var = rtrim($var, '/');
			$var = explode('~', $var);
			if((isset($var[0])) AND (isset($var[1]))){
				$new_var = $var[0].'~'.$var[1];
				
				if(($new_var) AND ($var[0] === 'manage/admin/bugs') AND ($var[1])){
					$_POST['bug_id'] = $var[1];
					include "admin/bugs.php";
					exit;
				}
				
			}			
		}
	}
	
	
//$site = 'http://f1a.c/';
//$analytics = '<!-- analytics codes goes here. -->';


/*
//	# to check all session to understand pages and construction of website
echo '<pre>';
print_r($_SESSION);
echo '</pre>';
*/



$_req = rtrim($_GET['req'], '/');
$_req = explode('/', $_req );


$bug_num = '';

//starts url masking
if (isset($_GET['req']))
{
    switch($_GET['req'])
    {
				
		
// pages set for common interface		
       
	   case 'home':
       include "pages/home.php";
       break;
	   	   	   
       case 'terms':
       include "pages/terms.php";
       break;
	   
	   case 'privacy':
       include "pages/privacy.php";
       break;
	   
	   case 'about':
       include "pages/about.php";
       break;
	   
       case 'register':
       include "pages/register.php";
       break;
	   
       case 'login':
       include "pages/login.php";
       break;
	   
       case 'logout':
       include "pages/logout.php";
       break;
	   
       case 'bugreport':
       include "pages/bug.php";
       break;

/*	   
	   case 'developers':
       include "pages/developers.php";
       break;
	   
	   case 'developers/':
       include "404.php";
       break;
	   
	   case 'developers/api':
       include "pages/api.php";
       break;
*/	   
	   case 'bugreport/':
       include "404.php";
       break;
	   
	   case 'bugreport/hall-of-fame':
       include "pages/halloffame.php";
       break;
	   
	   case 'status':
       include "pages/status.php";
       break;   	   

/*	   
//check for bug id
	   case CheckBugId($_GET['req']):
	   return true;
	   break;
*/	   
       case 'forgotpass':
       include "pages/forgot.php";
       break;
	   
       case 'deactivated':
       include "pages/deactivated.php";
       break;


//crawler page to crawl whole website links
       case 'crawler':
       include "pages/crawler.php";
       break;
	   
	   
	   //user files and pages
       case 'user/v1/home':
       include "user/home.php";
       break;
	   
	   case checkTicket($_GET['req']):
	   return true;
	   break;
	   
       case 'user/v1/manage':
       include "user/manage.php";
       break;	   

       case 'user/v1/support/tickets':
       include "user/ticket.php";
       break; 
	  
	   
//       case 'user/v1/settings':
//       include "user/settings.php";
//       break;

       case 'user/v1/profile':
       include "user/profile.php";
       break;
	   
       case 'user/v1/support':
       include "user/support.php";
       break;

       case 'user/v1/reports':
       include "user/reports.php";
       break;
	   
       case 'user/v1/chart':
       include "user/chart.php";
       break;

       case 'user/v1/purchase':
       include "user/purchase.php";
       break;
		
	   case 'user/v1/payment':
       include "user/Payment.php";
       break;	   
	   
	   //admin files and pages
	   case 'manage/admin/home':
       include "admin/home.php";
       break;
	   
	   case 'manage/admin/news':
       include "admin/news.php";
       break;

	   case 'manage/admin/genContact':
       include "admin/genContact.php";
       break;	   

	   case 'manage/admin/bugs':
       include "admin/bugs.php";
       break;

	   case 'manage/admin/tickets':
       include "admin/tickets.php";
       break;
	   
	   case 'manage/admin/sendEmail':
       include "admin/sendEmail.php";
       break;
	   
	   case 'manage/admin/users':
       include "admin/users.php";
       break;
	   
	   case 'manage/admin/profile':
       include "admin/profile.php";
       break;
	   
	   case 'manage/admin/SendBulkEmail':
       include "admin/bulkemail.php";
       break;

	   case 'manage/admin/addBugReporters':
       include "admin/bugreporter.php";
       break;	   
	  
	   case checkGenContact($_GET['req']):
	   return true;
	   break;	   

	   case checkBugs($_GET['req']):
	   return true;
	   break;	   

/*	   
	   //manager files and 
	   case 'manage/home':
       include "manage/home.php";
       break;
	   
	   case 'manage/support':
       include "manage/support.php";
       break;
*/


//check for url which is in database
	   case CheckURL($_GET['req']):
	   $_POST['u_code'] = $_GET['req'];
	   include 'pages/redirect.php';
       break;
	   

//defualt page 404 Error page is set	   
	   default;
	   $_POST['req'] = $_GET['req'];
	   include '404.php';
       break;
	}
}

else {
	header("Location: $site");	
}
