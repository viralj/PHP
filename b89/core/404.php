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


if(isset($site)){
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>b89.in &raquo; Nothing that we can find.</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<link rel="shortcut icon" href="<?php echo $site;?>flat-ui/images/favicon.ico">
<link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,200italic' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Open+Sans&subset=latin,greek-ext,cyrillic,latin-ext' rel='stylesheet' type='text/css'>
<style>body{font-family: 'Open Sans', sans-serif;font-size:15px/22px;} ins{color:grey;text-decoration:none;}
#centerDiv{padding-left:400px;padding-right:400px;padding-top:150px;width:400px;}
</style>
</head>
<body>
<div id="centerDiv">
<div><a href="<?php echo $site;?>"><img src="<?php echo $site;?>img/logo.png" alt="b89.in" title="b89.in" /></a></div>
<br><b>Error</b>: Request is not possible to process. 
<p>Nothing like 
<?php 

if(isset($_POST['req'])){
		if($_POST['req'] != 404 ){
			echo '/'.$_POST['req'];
		}else{
			echo $_SERVER['REQUEST_URI'];
		}
	}else {
		echo '/';
	}

?> found in our system.</p>
<p>And you got this error on <br><ins><?php echo date('l\, jS \of F Y').'</ins> at <ins>'.date('h:i:s A');?></ins>.</p>
</div>
<?php 
if(isset($analytics)){
	echo $analytics;
	} 
 
?> 
</body>
</html>

<?php 
} else {
	$home = 'http://'.$_SERVER['SERVER_NAME'];
	header("Location: $home");
}
?>