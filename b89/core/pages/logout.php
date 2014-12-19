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
unset($_SESSION['email'],
	  $_SESSION['uid'],
	  $_SESSION['hash'],
	  $_SESSION['usert'],
	  $_SESSION['userts'],
	  $_SESSION['u_type']);

//session_destroy();


header("Location: $site");
*/

if(isset($_POST)){

	//lets check for post data and still we will need to clean data
	$_cool   = $db->real_escape_string(htmlentities($_POST['cool']));
	$_lo     = $db->real_escape_string(htmlentities($_POST['lo']));
	$_em     = $db->real_escape_string(htmlentities($_POST['em']));
	$_ut     = $db->real_escape_string(htmlentities($_POST['ut']));
	$_errors = array();


	if(isset($_cool) AND ($_cool != $_SESSION['CSRF_TOKEN'])){
		$_errors[] = 1;
	}

	if(isset($_lo) AND ($_lo != 'logout')){
		$_errors[] = 2;
	}
	
	
	if(isset($_em) AND ($_em != substr(md5($_SESSION['email']), 0, 10))){
		$_errors[] = 3;
	}
	
	if(isset($_ut) AND ($_ut != substr(md5($_SESSION['u_type']), 0, 10))){
		$_errors[] = 4;
	}
	
		if(empty($_errors)){
		
				if(isset($_SESSION['submit'])){
					unset($_SESSION['submit']);
				}
				if((isset($_SESSION['text'])) AND ($_SESSION['text'] = $_SESSION['fname'].'/'.$_SESSION['lname'].'/'.$_SESSION['email'])){
					unset($_SESSION['text']);
				}
				if((isset($_SESSION['form'])) AND ($_SESSION['form'] = $_SESSION['CSRF_TOKEN'].'/'.$_SESSION['email'])){
					unset($_SESSION['form']);
				}
				if((isset($_SESSION['deactivate_user'])) AND ($_SESSION['deactivate_user'] == 'true')){
					unset($_SESSION['deactivate_user']);
				}
				if((isset($_SESSION['check_u_to_deactivate'])) AND ($_SESSION['check_u_to_deactivate'] == 'true')){
					unset($_SESSION['check_u_to_deactivate']);
				}
				if((isset($_SESSION['check_link_views'])) AND ($_SESSION['check_link_views'] == 'true')){
					unset($_SESSION['check_link_views']);
				}
				
								
			unset($_SESSION['ip'],
				  $_SESSION['fname'],
				  $_SESSION['lname'],
				  $_SESSION['email'],
				  $_SESSION['uname'],
				  $_SESSION['uid'],
				  $_SESSION['hash'],
				  $_SESSION['usert'],
				  $_SESSION['userts'],
				  $_SESSION['u_type']);
				  
				  
				  
echo "<!DOCTYPE html><html lang=\"en\"><head><title>b89.in &raquo; Logout.</title><link href='http://fonts.googleapis.com/css?family=Open+Sans&subset=latin,greek-ext,cyrillic,latin-ext' rel='stylesheet' type='text/css'><link rel=\"shortcut icon\" href=\"".$site."flat-ui/images/favicon.ico\"><style>body{font-family: 'Open Sans', sans-serif;}</style></head><body>Please wait....</body></html>";
			header("refresh:1;url=$site");
			
		} else {
			header("Location: $site");
			}
	
} else {
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

?>