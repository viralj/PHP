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
	# This is redirect class of whole system which will perform some tasks before it redirects user
	  to the link. 
	
	# It will check that user is logged in or not.
	# It will check that if user is logged in then user is owner of link or not.
	# It will check that requested link was last visited when and from which IP.
	# It will also count that how many times each links is getting viewed without counted it as true visit.
	# More then 10 times visited and counted as not real visit, will be informed to user as policy violation.
	
	
	# To count unique and real visitor, we need to check everything.
	# We do not want to loose Google AdSense account as it is only the income source for the website for now.
	
	//////---------------------------------------------//////
	
	All other important notes will be written down from here for this class.

	#############################################################################################################
	#																											#
	# --> Due to we are not permitted to advertise and earn money via this website								#
	#	  we had to shut down showing ads on website. Still all other functions will work properly				#
	#	  and when we get permitted to run ads on website, we will need to remove commented lines and			#
	#	  everything will go live.																				#
	#																											#
	# --> Remember, we don't have user's revenue count system yet, so when we will start showing ads,			#
	#	  we will need to add some functions that will count user's revenue.									#
	#																											#
	#############################################################################################################
	
	
/--------------------------
	### below HTML codes are about our ad space. Put advertising codes in to divs
<center>
		<div id="bigAdUnit">
			<img src="http://plato.stanford.edu/entries/mental-imagery/dsee.gif" />
		</div>
		<div id="adUnit2">
			<img src="http://rs110.pbsrc.com/albums/n114/corsiphoto/photos-part2/orangutan-4.jpg~c200" />
		</div>
		<div id="adUnit3">
			<img src="http://images.all-free-download.com/images/graphicmedium/flower_bouquet_leaf_221411.jpg" />
		</div>
		<div id="adUnit4">
			<img src="http://horrid-henrygames.com/wp-content/themes/NextWPA/images/728.png" />
		</div>
</center>
/--------------------------
	
	
	//below codes are made to count visit as real visit and show ads.
		// but we are not allowed to show ads on website for now so will stop these codes from working.
		// when ads will be allowd we will need to remove comment section only.
	
	//-----------------remove this line----------------
	
	
*/
class Redirect {	
	
	//this function will check for logged in user and owner	
	public static function check_for_loggedIn_user(){
		
		if(isset($_SESSION['email']) AND isset($_POST['u_code'])){
			
			include $_SERVER['DOCUMENT_ROOT'].'/core/db_config_inc.php';			
			
			$check_link_owner_query = "SELECT `id`, `url` FROM `url_table` WHERE BINARY (`code` = '{$_POST['u_code']}' AND `u_email` = '{$_SESSION['email']}')";
			
			if($result = $db->query($check_link_owner_query) AND $result->num_rows > 0 AND $rows = $result->fetch_array(MYSQLI_ASSOC)){
				
				Redirect::forward_to_url(3, $rows['url']);
				
				$resulturl = $rows['url'];
				$suburl = substr($resulturl, 0, 30);
				$newurl = strlen($resulturl);
						
				if($newurl > 30){
					$theurl = $suburl.'...';
				} else {
					$theurl = $suburl;
					}
				
				throw new Exception ('You own this link. So this is not valid visit. We believe that you came here to check it is working or not.<br> Don\'t worry, you will be redirected to the destination link or you can click link below.<br><br>-->&nbsp;&nbsp;&nbsp;<a style="color:white" href="'.$rows['url'].'">'.$theurl.'</a>&nbsp;&nbsp;&nbsp;<--<br><br><strong>Remember</strong> we do have strict <a style="color:yellow;" href="'.$site.'terms" target="_blank"><u>terms</u></a> (click to read) and policies for publishers.<br>If you have any problem or need support, fell free to contact us.');
				
				return false;
			} else {
				
				Redirect::last_when_visited_link();
				return true;
			}
			
		}else {
			Redirect::last_when_visited_link();
			return true;
			
		}
	}	
	
	public static function last_when_visited_link(){
		include $_SERVER['DOCUMENT_ROOT'].'/core/db_config_inc.php';
				
			$year = date('Y');
			$month = date('F');
			
			/*
				### Due to problem with session remove after closing browser we had to remove csrf_token check from database
					and we had to keep only ip address to prevent.
					
				*** Older code of sql query is below
				
				$check_last_visited_query = "SELECT * FROM `url_visit` WHERE BINARY 
										(`code` = '{$_POST['u_code']}' AND 
										 `csrf_token` =  '{$_SESSION['CSRF_TOKEN']}' AND
										 `ip` = '{$_SESSION['ip']}' AND
										 `month` = '$month' AND
										 `year` = '$year'
										 )
										 ORDER BY `id` DESC LIMIT 1 ";
				
			*/
			$check_last_visited_query = "SELECT * FROM `url_visit` WHERE BINARY 
										(`code` = '{$_POST['u_code']}' AND 
										 `ip` = '{$_SESSION['ip']}' AND
										 `month` = '$month' AND
										 `year` = '$year'
										 )
										 ORDER BY `id` DESC LIMIT 1 ";
			//echo $check_last_visited_query.'<br><br>'.time().'<br><br>'.(time()+180);
			
			if($result = $db->query($check_last_visited_query) AND $result->num_rows > 0 AND $rows = $result->fetch_array(MYSQLI_ASSOC)){
				$time = time();
				
				$if_paid_user = "SELECT `uid` FROM `users` WHERE BINARY `email` = '{$rows['email']}' AND `type` IN ('pro', 'busi')";	
				
				if($result = $db->query($if_paid_user) AND $result->num_rows > 0){
					Redirect::show_ads_with_valid_count($_POST['u_code']);
					return true;
				}
				else
				
				if($time > $rows['expire_time']){
					//echo '<br>yes<br>'.$rows['id'].'  '.$rows['expire_time'];
					
					Redirect::show_ads_with_valid_count($_POST['u_code']);
					return true;
				}				
				else {
					//echo '<br>no<br>'.$rows['id'].'  '.$rows['expire_time'];
					
					Redirect::count_as_reported_link();
					return false;
				}
				
			}
			
			Redirect::show_ads_with_valid_count($_POST['u_code']);
			return true;
			
		
	}
	
	
	//this function will show ads and it will count the link as valid visit
	public static function show_ads_with_valid_count($code){
		include $_SERVER['DOCUMENT_ROOT'].'/core/db_config_inc.php';
		
		$get_data_from_url_table_query = "SELECT `url`,`u_email` FROM `url_table` WHERE BINARY `code` = '$code' AND `archived` = 0"; 
		
		if($result = $db->query($get_data_from_url_table_query) AND $result->num_rows > 0 AND $rows = $result->fetch_array(MYSQLI_ASSOC)){
		
		$url = $rows['url'];
		$year = date('Y');
		$month = date('F');
		$expire_time = time()+180;
		$valid_visit_count_query = "INSERT INTO `url_visit` 
									(`url`, `site`, `code`, `email`, `csrf_token`, `ip`, `expire_time`, `month`, `year`) 
									VALUES 
									('$url', '$site', '{$_POST['u_code']}', '{$rows['u_email']}', '{$_SESSION['CSRF_TOKEN']}', '{$_SESSION['ip']}', '$expire_time', '$month', '$year')";
									
				
			if($result = $db->query($valid_visit_count_query) AND $db->affected_rows > 0){
	
			$if_free_user = "SELECT `uid` FROM `users` WHERE BINARY `email` = '{$rows['u_email']}' AND `type` = 'free'";	
		
				if($result = $db->query($if_free_user) AND $result->num_rows > 0){
					echo '
					<noscript>JavaScript needs to be enabled in order to be able to download.</noscript>
					<script type="application/javascript">
					(function(){
					   var message = "%d seconds before download link appears";
					   // seconds before download link becomes visible
					   var count = 5;
					   var countdown_element = document.getElementById("countdown");
					   var goTO = document.getElementById("goTO");
					   var timer = setInterval(function(){
						  // if countdown equals 0, the next condition will evaluate to false and the else-construct will be executed
						  if (count) {
							  // display text
							  countdown_element.innerHTML = "Please wait...<br> %d seconds".replace("%d", count);
							  // decrease counter
							  count--;
						  } else {
							  // stop timer
							  clearInterval(timer);
							  // hide countdown
							  countdown_element.style.display = "none";
							  // show download link
							  goTO.style.display = "";
							  goTO.href = "'.$url.'";
						  }
					   }, 1000);
					   
					})();
					</script>
				<center> <!--- test ad slot -->
<div style="margin-top:-50px">

<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- 970*250 -->
<ins class="adsbygoogle"
     style="display:inline-block;width:970px;height:250px"
     data-ad-client="ca-pub-7229801886740050"
     data-ad-slot="7977010921"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
<br><br><br><br>
</div><br><br>
<br>
<!-- test ad slot ends here -->

							<div id="bigAdUnit">
								<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
								<!-- 700*300 -->
								<ins class="adsbygoogle"
									 style="display:inline-block;width:700px;height:300px"
									 data-ad-client="ca-pub-7229801886740050"
									 data-ad-slot="1560864129"></ins>
								<script>
								(adsbygoogle = window.adsbygoogle || []).push({});
								</script>
							</div>
							<div id="adUnit2">
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- 336*280 -->
<ins class="adsbygoogle"
     style="display:inline-block;width:336px;height:280px"
     data-ad-client="ca-pub-7229801886740050"
     data-ad-slot="2196237727"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>

							</div>
							<div id="adUnit3">
								<a href="'.$site.'about?ad&redirect#contact" target="_blank"><img src="'.$site.'img/show_ad_336_280.png" /></a>
							</div>
							<div id="adUnit4">
								<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
									<!-- 728*90 new -->
									<ins class="adsbygoogle"
										 style="display:inline-block;width:728px;height:90px"
										 data-ad-client="ca-pub-7229801886740050"
										 data-ad-slot="7311520925"></ins>
									<script>
									(adsbygoogle = window.adsbygoogle || []).push({});
									</script>
<br>

<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- 728*90 new -->
<ins class="adsbygoogle"
style="display:inline-block;width:728px;height:90px" 
data-ad-client="ca-pub-7229801886740050"
data-ad-slot="7311520925"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
<br>

</div>


<!--- another test ad codes starts from here -->


<script type="text/javascript">
(function() {
  var a, s = document.getElementsByTagName("script")[0];
  a = document.createElement("script");
  a.type="text/javascript";  a.async = true;
  a.src = "http://www.luminate.com/widget/async/11c0dab2d93/";
  s.parentNode.insertBefore(a, s);
})();
</script>


<!--- ad codes ends here -->


					</center>

				';
				
				}
				else{
				Redirect::forward_to_url(0, $rows['url']);
				return false;
				}
		//-------remove this line----------*/
			
			//also remove below lines
			//Redirect::forward_to_url(0, $rows['url']);
			//return true;
			
			}
			else {
				Redirect::forward_to_url(0, $rows['url']);
				return false;
			}
		
		}
		else {
		
		throw new Exception ('We are facing some connectivity issues. Please refresh the page. If you keep seeing this, please report it to us.');
		
		}	
		
	}
	
	//this function will insert each link into database to help us to keep real users as active.
	
	public static function count_as_reported_link(){
		//Redirect::forward_to_url(0, $rows['url']);
		//return false;
		
		include $_SERVER['DOCUMENT_ROOT'].'/core/db_config_inc.php';
		
		$get_link_details_from_db = "SELECT * FROM `url_table` WHERE BINARY `code` = '{$_POST['u_code']}'";
	
		
		if($result = $db->query($get_link_details_from_db) AND $result->num_rows > 0 AND $rows = $result->fetch_array(MYSQLI_ASSOC)){
		
		$email = $rows['u_email'];
		$link_site = $rows['site'];
		$url = $rows['url'];
		$code = $_POST['u_code'];
		$time = time();
		
		$month = date("F");
		$year = date("Y");
		
			$check_as_reported_link = "SELECT `total_count`,`url` FROM `reported_links` WHERE BINARY (`code` = '$code' AND `email` = '$email')";
			
			$insert_as_reported_link = "INSERT INTO `reported_links` (
									`url`, `site`, `code`, `time`, `ip`, `csrf_token`, `email`, `total_count`, `month`, `year`
									) 
									VALUES (
									'$url', '$link_site', '$code', '$time', '{$_SESSION['ip']}', '{$_SESSION['CSRF_TOKEN']}', '$email', '1', '$month', '$year'
									)";
			
				if($result = $db->query($check_as_reported_link) AND $result->num_rows > 0 AND $rows = $result->fetch_array(MYSQLI_ASSOC)){
					
					$result = $db->query("UPDATE `reported_links` SET `total_count` = (`total_count` + 1) WHERE BINARY `code` = '$code' AND `month` = '$month' AND `year` = '$year'");
					
					if($result AND $db->affected_rows > 0){
						Redirect::forward_to_url(0, $rows['url']);
						return false;
					} else {
						Redirect::forward_to_url(0, $rows['url']);
						return false;
					}
					
				}
				
				else 
				if($result = $db->query($insert_as_reported_link) AND $db->affected_rows > 0){
					Redirect::forward_to_url(0, $rows['url']);
					return false;
				}
				
				else {
				throw new Exception ('We faced some issue. Please report us this error #00001');
				}
			
		
		} else {
			throw new Exception ('We faced some issue. Please report us this error #00002');
		}
	
	}
	
	
	
	
	//public static function (){}
	
	
	
	//this function is to check that what functions are returning
	public static function check_all_functions(){
		
		try {
			Redirect::check_for_loggedIn_user();
		} 
		catch(Exception $e) {
			  
			echo '<b>Message:</b> ' .$e->getMessage();
			
		}
		
		
	}
	
	//this function will redirect to the site after defined seconds
	public static function forward_to_url($sec, $url){
		if($sec == 0){
			header("Location: $url");
		}
		else{
			header("Refresh: $sec; url= $url");
		}
	}
	
}
// Redirect class ends here

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <title>b89.in &raquo; The URL shornter website, redirection page.</title>
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<link rel="shortcut icon" href="<?php echo $site;?>flat-ui/images/favicon.ico">
    <link href="<?php echo $site;?>r/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $site;?>r/css/redirect.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $site;?>r/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Armata' rel='stylesheet' type='text/css'>
    <!-- IE8 support for HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="<?php echo $site;?>r/js/html5shiv.js"></script>
      <script src="<?php echo $site;?>r/js/respond.min.js"></script>
    <![endif]-->
<style>
.hdrlg{font-family:Armata;font-size:56px;color:#f77165;cursor:default;display:block;max-width:15%;float:left;min-height:50px;text-transform:lowercase}
#bigAdUnit{height:300px;width:700px;margin-top:-117px}
#adUnit2{height:336px;width:280px;margin-left:-400px;margin-top:3px;margin-bottom:-80px}
#adUnit3{height:336px;width:280px;margin-right:-290px;margin-top:-336px;margin-bottom:-135px}
#adUnit4{width:728px;height:190px;margin-top:82px;margin-bottom:-97px;}
#mainContainer{min-height:260px;}
</style>
</head>

<body id="page-top" class="index">

    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div class="hdrlg">b89<font color="#000000">.</font><font style="color:rgb(250,209,49)">in</font>
				</div>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    <li class="page-scroll">
                        <a target="_blank" href="<?php echo $site;?>about?ad&amp;redirect#contact">Advertise here</a>
                    </li>
                    <li class="page-scroll">
                        
                    </li>
                    <li class="page-scroll">
                        <a id="countdown"></a>
						<a id="goTO"  style="display:none;">Visit Link</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <header>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div id="mainContainer" class="intro-text">

<?php 
if(isset($_POST['u_code'])){
	
	
	$code = $_POST['u_code'];
	
	Redirect::check_all_functions();
	
}
?>
					
					</div>
                </div>
            </div>
        </div>
    </header>


    <footer class="text-center">
        
        <div class="footer-below">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        Copyright &copy; <?php echo date('Y');?> b89.in
                    </div>
                </div>
            </div>
        </div>
    </footer>


    <script src="<?php echo $site;?>r/js/jquery-1.10.2.js"></script>
    <script src="<?php echo $site;?>r/js/bootstrap.min.js"></script>
    <script src="<?php echo $site;?>r/js/jquery.easing.min.js"></script>
    <script src="<?php echo $site;?>r/js/classie.js"></script>
    <script src="<?php echo $site;?>r/js/cbpAnimatedHeader.js"></script>
    <script src="<?php echo $site;?>r/js/freelancer.js"></script>

<?php 
if(isset($analytics)){
	echo $analytics;
	}  
	

?>

</body>
</html>
