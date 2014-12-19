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


/*redirect users to only server root if they enter
	# "www.site/Default" or "www.site/Default.php"
	# We will redirect them to "www.site"
	
	to check server details.
	# echo '<pre>'; print_r($_SERVER); echo '</pre>';
*/

error_reporting(E_ALL);

$req_url = ltrim($_SERVER['REQUEST_URI'], '/');
$req_url = explode('?', $req_url);

if(isset($req_url[0]) AND($req_url[0] == 'index.php')){
	if(isset($req_url[1])){
		header("Location: /?$req_url[1]");
		}	 else  
			  header("Location: /");
	}


if(isset($req_url[0]) AND($req_url[0] == 'index')){
	if(isset($req_url[1])){
		header("Location: /?$req_url[1]");
		}
			 else
			 header("Location: /");
	}
	
$_GET['req'] = 'home';
include ($_SERVER['DOCUMENT_ROOT'].'/core/page.php');

?>