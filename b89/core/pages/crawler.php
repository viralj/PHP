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

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>b89.in &raquo; Web crawler area.</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="robots" content="noindex" />
<link rel="shortcut icon" href="<?php echo $site; ?>flat-ui/images/favicon.ico">
<link href='http://fonts.googleapis.com/css?family=Exo+2:200italic' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Open+Sans&subset=latin,greek-ext,cyrillic,latin-ext' rel='stylesheet' type='text/css'>
<style>body{font-family: 'Open Sans', sans-serif;} code{font-size:20px;font-family: 'Exo 2', sans-serif;color:grey;}
#centerDiv{padding-left:400px;padding-right:400px;padding-top:200px;width:400px;}
</style>
</head>
<body>
<a href="<?php echo $site; ?>"  target="_blank"><img src="<?php echo $site; ?>img/logo.png" alt="b89.in" title="b89.in" /></a>
<br><br>
<?php
//if crawl will log in to our system then lets check for parameters.
	//if entered details are true then we will create session for crawl and will show all links.
	
	if((isset($_POST['sub']))   AND ($_POST['sub'] === 'Submit') AND 
	   (isset($_POST['cool']))  AND ($_POST['cool'] === 'true') AND 
	   (isset($_POST['u']))     AND ($_POST['u'] === 'webcrawlerbottocrawlwholewebsite') AND 
	   (isset($_POST['p']))     AND ($_POST['p'] === 'webcrawlerbottocrawlwholewebsite')
		){
		$_SESSION['crawler'] = 'webcrawlerbotsession';
		
		$crawler = $site.'crawler';
		header("Location: $crawler");
	}

	//before we start processing for crawler links we will need to put a link for crawler to logout

	if((isset($_POST['lo']))     AND ($_POST['lo'] === 'true') AND 
	   (isset($_POST['cool']))   AND ($_POST['cool'] === $_SESSION['CSRF_TOKEN']) AND 
	   (isset($_POST['ip']))     AND ($_POST['ip'] === $_SESSION['ip'])
	   ){
		session_destroy();
		header("Location: $site");
	}
	
	//lets start process of fetching links from database.
	
	if((isset($_SESSION['crawler'])) AND ($_SESSION['crawler'] === 'webcrawlerbotsession')){

/*
	$select_links_query = "SELECT `site`, `code` FROM `url_table` WHERE `archived` = '0'";
		
		if($result = $db->query($select_links_query) AND $rows = $result->fetch_all(MYSQLI_ASSOC)){
			$i = 1;
			foreach($rows as $row){
				echo $i.') <a href="'.$row['site'].$row['code'].'" target="_blank">'.$row['site'].$row['code'].'</a><br>';
				$i++;
			}
		} else {
			echo 'We are facing some connectivity issues. Please try again leter.';
		}	
		echo '<a href="'.$site.'crawler?lo=true&cool='.$_SESSION['CSRF_TOKEN'].'&ip='.$_SESSION['ip'].'">logout</a>';
*/

	$select_active_user = "SELECT `email` FROM `users` WHERE `active` = '0'";
		
		if($result = $db->query($select_active_user) AND $rows = $result->fetch_all(MYSQLI_ASSOC)){
			$i = 1;
			foreach($rows as $row){
				
				$select_links_query = "SELECT `site`, `code` FROM `url_table` WHERE BINARY `u_email` = '{$row['email']}' AND `archived` = '0'";
		
				if($result = $db->query($select_links_query) AND $rows = $result->fetch_all(MYSQLI_ASSOC)){
					
					foreach($rows as $row){
						echo '('.$i.') <a href="'.$row['site'].$row['code'].'" target="_blank">'.$row['site'].$row['code'].'</a><br>';
						$i++;
					}
				} 	
				
				
			}echo '<br><br>
			<form id="crawlerlo" action="'.$site.'crawler" method="POST">
			<input type="hidden" name="lo" value="true"/>
			<input type="hidden" name="cool" value="'.$_SESSION['CSRF_TOKEN'].'"/>
			<input type="hidden" name="ip" value="'.$_SESSION['ip'].'"/>
			<a onclick="document.getElementById(\'crawlerlo\').submit();" href="javascript:{}">logout</a>
			</form>';
		}
		
	}else {
?>
<p><strong>Note:</strong> If you are not a web crawler bot then you are not allowed to access this area. Go back to the main website. Leave this area now. This is restricted area for ordinary users.
<br><br>
	<center>
		<strong>LEAVE NOW</strong>
	</center>
</p>
<form id='login' action='<?php echo $site; ?>crawler' method='post' accept-charset='UTF-8' autocomplete="off">
<fieldset >
<legend>Login</legend>
<input type='hidden' name='cool' id='submitted' value='true'/>
 
<label for='username' >UserName*:</label>
<input type='text' name='u' id='username'  maxlength="50" /><br>
 
<label for='password' >Password*:</label>
<input type='password' name='p' id='password' maxlength="50" /><br>
 
<input type='submit' name='sub' value='Submit' />
 
</fieldset>
</form>

<?php
	}

?><br>
<center>
<?php echo date('Y');?> &copy; b89.in
</center>
</body>
</html>
