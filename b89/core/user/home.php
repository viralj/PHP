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


$user_site= $site.'user/v1/';

include $_SERVER['DOCUMENT_ROOT'].'/ajax/UserLinks.php';
$usr_links = new UserLinks;

//these codes will perform user's link delete process
if((isset($_GET['h'])) AND (isset($_GET['e'])) AND (isset($_GET['lid']))){
				
		$data = $usr_links::update_links($_GET['h'], $_GET['e'], $_GET['lid']);
		
		if($data == 1){
			$home_page = $user_site.'home';
			header("Location: $home_page");
			
		} else if($data == false){
			$home_page = $user_site.'home';
			$_SESSION['update_error'] = '<script>alert("We got some error. Please try again.")</script>';
			header("Location: $home_page");
			
		}
		
	}


// lets check for chat links. User wants to delete it or report it

if((isset($_GET['h'])) AND (isset($_GET['u'])) AND (isset($_GET['cid'])) AND (isset($_GET['e'])) AND (isset($_GET['c'])) AND (isset($_GET['do'])) AND ($_GET['c'] == $_SESSION['CSRF_TOKEN'])){
	
	include $_SERVER['DOCUMENT_ROOT'].'/ajax/UserChatAction.php';
	$chat_action = new ChatAction;
	$get_data = $_GET;
		
	
	if($_GET['do'] == 'delete'){
		$chat_action = $chat_action::delete_chat();
			
			if($chat_action == 1){
				$home_page = $user_site.'home';
				header("Location: $home_page");
			} else if($chat_action == false){
				$home_page = $user_site.'home';
				$_SESSION['update_error'] = '<script>alert("We got some error. Please try again.")</script>';
				header("Location: $home_page");
			}
			
	}
	else
	if($_GET['do'] == 'report'){
		$chat_action = $chat_action::report_chat();
			
			if($chat_action == 1){
				$home_page = $user_site.'home';
				$_SESSION['update_error'] = '<script>alert("Success. Thank you for reporting to us.")</script>';
				header("Location: $home_page");
			} else if($chat_action == 2){
				$home_page = $user_site.'home';
				$_SESSION['update_error'] = '<script>alert("You have reported this once. You cannot report this twice.")</script>';
				header("Location: $home_page");
			}
			else if($chat_action == false){
				$home_page = $user_site.'home';
				$_SESSION['update_error'] = '<script>alert("We got some error. Please try again.")</script>';
				header("Location: $home_page");
			}
			
	} 

}


	
//this codes will perform what user wants to tell others.	
if(isset($_POST['tell'])){
	
	if((isset($_SESSION['text'])) AND ($_SESSION['text'] == $_SESSION['fname'].'/'.$_SESSION['lname'].'/'.$_SESSION['email'])){
		
		$text_done = '<form method="post">
						<p>You just told everyone what you are up to. Do you want to tell more?</p><button type="submit" name="proceed" value="'.$_SESSION['CSRF_TOKEN'].'" class="btn btn-info">Yes</button>
						</form>';
		
		
	}else {
		
				
		$cool = trim($db->real_escape_string(htmlentities($_POST['cool'])));
		$text = trim($db->real_escape_string(htmlentities($_POST['text'])));
		$errors = array();
		
		//lets check for errors.
	
		if(strlen($text) > 5000){
			$errors[] = 'It is too long to share with other users.';
		}
		
		if(empty($text)){
			$errors[] = 'Are you trying to post empty stuff?';
		}
		
		if($cool != $_SESSION['CSRF_TOKEN']){
			$errors[] = 'We are sorry but we got unexpected error.';
		}
	
		//if errors are empty then we will proceed further or show errors.
		
		if(empty($errors)){
		$date = time();	
		$ip = $_SESSION['ip'];
		
		include $_SERVER['DOCUMENT_ROOT'].'/core/encryption.php';
		$blah = new Encryption();
		$hash_string = $_SESSION['email'].'/'.$date.'/'.$ip;
		$hash  = $blah->encode($hash_string);
		
		$chat_insert_query = "INSERT INTO `chat` (`fname`, `lname`, `u_email`, `uname`, `date`, `text`, `chat_hash`, `ip`, `display`, `archived`) VALUES 
												 ('{$_SESSION['fname']}', '{$_SESSION['lname']}', '{$_SESSION['email']}','{$_SESSION['uname']}',  '$date', '$text', '$hash', '$ip', '0', '0')";
			
		
		
			if($result = $db->query($chat_insert_query)){
							if($result AND $db->affected_rows > 0){
								//$_SESSION['text'] = $_SESSION['fname'].'/'.$_SESSION['lname'].'/'.$_SESSION['email'];
								 
							} else {
								echo '<script>alert("Something went wrong. Please try once again.")</script>';
								
							}			
			}else {
					echo '<script>alert("Something went terribly wrong. Please try once again.")</script>';
					}
			
		} 

		
	}
} 

if((isset($_POST['proceed'])) AND ($_POST['proceed'] == $_SESSION['CSRF_TOKEN'])){
	unset($_SESSION['text']);
}

//lets check user type and allow to display page else redirect to user's page
$u_type = array('free', 'pro', 'busi');

if((user_is_logged_in()) AND (in_array($_SESSION['u_type'], $u_type))){

?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>b89.in &raquo; User dashboard.</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<link rel="shortcut icon" href="<?php echo $site;?>flat-ui/images/favicon.ico">
<link href="<?php echo $site;?>user/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo $site;?>user/css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
<link href="<?php echo $site;?>user/css/font-awesome.css" rel="stylesheet">
<link href="<?php echo $site;?>user/css/style.css" rel="stylesheet">
<link href="<?php echo $site;?>user/css/pages/dashboard.css" rel="stylesheet">
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
<script src="<?php echo $site;?>user/js/jquery-1.7.2.min.js"></script> 
<script src="<?php echo $site;?>user/js/scroller.js"></script>
<style>
<!--
.loform {margin-bottom: -10px;padding-bottom: -10px;}.loform:link {margin: 0;padding: 0;}.loform > a:focus {outline: thin dotted #333;outline-offset: -2px;text-decoration: none;}
-->
#msg_lo{min-height:400px;max-height:400px;overflow:scroll;padding-right:15px;margin:0 auto}
#news_box{min-height:400px;max-height:400px;overflow:scroll;margin:0 auto}
#linksTbl{min-height:300px;max-height:300px;overflow:scroll;margin:0 auto}
#box2000 > div{-webkit-transition:width .2s ease;-moz-transition:width .2s ease;-o-transition:width .2s ease;-ms-transition:width .2s ease;transition:width .2s ease}
#box2000 > div:hover{width:120%!important;cursor:pointer}
#usrSelf{color:grey;text-decoration:none;}
</style> 	
<script type="text/javascript"> 
    $(document).ready(function () {
    $("#msg_lo").niceScroll({ autohidemode: true })
    });
	
	$(document).ready(function () {
    $("#news_box").niceScroll({ autohidemode: true })
    });
	
	$(document).ready(function () {
    $("#linksTbl").niceScroll({ autohidemode: true })
    });
		
setTimeout(function() {
  $("#msgDiv").fadeOut().empty();
}, 5000);

setTimeout(function() {
  $("#ErmsgDiv").fadeOut().empty();
}, 5000);
</script>
<script language="JavaScript" type="text/javascript">
function usrUpto(){
    var hr = new XMLHttpRequest();
    var url = "<?php echo $user_site;?>home";
    var cool = document.getElementById("cool").value;
    var text = document.getElementById("text").value;
	var tell = document.getElementById("tell").value;
    var vars = "tell="+tell+"&cool="+cool+"&text="+text;
    hr.open("POST", url, true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function() {
	    if(hr.readyState == 4 && hr.status == 200) {
		    var return_data = hr.responseText;
			document.getElementById("text").value = '';
			location.reload();
			document.getElementById("ErmsgDiv").innerHTML = return_data;
	    }
    }
    hr.send(vars); 
 //  document.getElementById("ErmsgDiv").innerHTML = "processing...";
}
</script>
<?php 
if(isset($_SESSION['update_error'])){ echo $_SESSION['update_error'];}

?>
</head>
<body>
<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container"> <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><span
                    class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </a><a class="brand" href="<?php echo $user_site;?>home">b89.in user dashboard </a>
      <div class="nav-collapse">
        <ul class="nav pull-right">
          <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                            class="icon-cog"></i> Account <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="<?php echo $user_site;?>support">Support</a></li>
              <li><a href="<?php echo $user_site;?>support/tickets">Tickets</a></li>
            </ul>
          </li>
          <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                            class="icon-user"></i> b89.in <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="<?php echo $user_site;?>profile">Profile</a></li>
              <li>
					<form id="loform" action="<?php echo $site;?>logout" method="POST">
<input type="hidden" name="cool" value="<?php echo $_SESSION['CSRF_TOKEN']?>" /><input type="hidden" name="lo" value="logout" /><input type="hidden" name="em" value="<?php echo substr(md5($_SESSION['email']), 0, 10);?>" /><input type="hidden" name="ut" value="<?php echo substr(md5($_SESSION['u_type']), 0, 10); ?>" />
						<a href="javascript:{}" onclick="document.getElementById('loform').submit();">Log Out</a>
					</form>	
			  </li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>
<div class="subnavbar">
  <div class="subnavbar-inner">
    <div class="container">
      <ul class="mainnav">
        <li class="active"><a  href="<?php echo $user_site;?>home"><i class="icon-dashboard"></i><span>Dashboard</span> </a> </li>
        <li><a href="<?php echo $user_site;?>reports"><i class="icon-list-alt"></i><span>Reports</span> </a> </li>
        <li><a href="<?php echo $user_site;?>purchase"><i class="icon-tags"></i><span>Purchase</span> </a></li>
        <li><a href="<?php echo $user_site;?>chart"><i class="icon-bar-chart"></i><span>Chart</span> </a> </li>
<?php		
	if($_SESSION['u_type'] === 'busi'){
		echo '<li><a href="'.$user_site.'manage"><i class="icon-link"></i><span>Manage links</span> </a></li>';
	}	
?>
	</ul>
    </div>
  </div>
</div>
<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">
        
<?php 
/*
if($_SESSION['u_type'] === 'free'){
echo '<div class="span12" style="background-image:url(\''.$site.'img/notif_bg.png\'); padding:10px;">
			<b>Note:</b> Your account is under review and this is beta version of <b>b89.in</b> website. Because of that, we are not offering any kind of pay out to our publishers.
			However you can create shorten links and invite your friends to join b89.in via referral program. As soon as we start transaction services, you will get paid for your links and your referrals.
			This notification will be removed, once everything goes live.<br>Thank you for being our tester.
		</div>';
}
*/

echo '<div class="span12" style="background-image:url(\''.$site.'img/notif_bg.png\'); padding:10px;">
	<b>Note:</b> This website is still under review and your account too. If you find any problem in our system, please tell us by submitting ticket. We appreciate your help.
	This notification will be removed, once everything goes live.<br>Thank you for being our tester.
</div>'

?>

		<p>&nbsp;</p>
		<div class="span6">
          <div class="widget widget-nopad">
            <div class="widget-header"> <i class="icon-list-alt"></i>
              <h3> Add links to make shorten URL</h3>
            </div>
            <div class="widget-content">
              <div class="widget big-stats-container">
                <div class="widget-content" style="min-height:310px;">
				<p style="padding:5px; margin:5px;">You can insert upto <b>5</b> links at a time.</p>
                  <form method="post" enctype="multipart/form-data" style="padding:10px;" autocomplete="off" >
					<input type="url" style="padding:5px; margin:5px; width:90%" name="link[]" placeholder="Insert link to make shorten url." required />
					<input type="url" style="padding:5px; margin:5px; width:90%" name="link[]" placeholder="Insert link to make shorten url." />
					<input type="url" style="padding:5px; margin:5px; width:90%" name="link[]" placeholder="Insert link to make shorten url." />
					<input type="url" style="padding:5px; margin:5px; width:90%" name="link[]" placeholder="Insert link to make shorten url." />
					<input type="url" style="padding:5px; margin:5px; width:90%" name="link[]" placeholder="Insert link to make shorten url." />
					<input type="hidden" name="cool" value="<?php echo $_SESSION['CSRF_TOKEN'];?>" />
					<button style="padding:5px; margin:5px; float:right;" type="submit" class="btn btn-small btn-success" name="shorten" value="sortn">Shorten</button>
				  </form>
				  <div id="msgDiv" style="padding:10px;">
					<?php
					
					
					if(isset($_POST['shorten']) AND ($_POST['shorten'] == 'sortn')){

					$post_links = $_POST;

					include 'usrShortenLink.php';
					Shorten::new_shorten_link($post_links);
						echo "<meta HTTP-EQUIV=\"REFRESH\" content=\"3; url=$site\">";
					
					}
					?>
					</div>
				  </div>
                
              </div>
            </div>
          </div>
          <div class="widget">
            <div class="widget-header"> <i class="icon-file"></i>
              <h3>Ask for help or chat with other users.</h3>
            </div>

			
            <div id="usrChatDiv" class="widget-content" style="max-height:900px;">
				<div id="ErmsgDiv"></div>
				<?php
					if(!empty($errors)){
						echo '<div  style="padding:10px;">';	
							foreach($errors as $err){
								echo '* '.$err.'<br>';
							}
						echo '</div>';	
						header('refresh:5;url='.$user_site.'home');
					}
				?>
			
			
<?php
if(isset($text_done)){echo $text_done;}


include $_SERVER['DOCUMENT_ROOT'].'/ajax/ajaxUserChat.php';
$chat = new AjaxUserChat;

?>
		
            </div>
          </div>
        </div>
        <div class="span6">
          <div >
            
          </div>
          
          <div class="widget widget-table action-table">
            <div class="widget-header"> <i class="icon-th-list"></i>
              <h3>Your shorten links.</h3>
            </div>
			<div class="widget-content" style="min-height:335px">
					<?php
					$sho_links = $usr_links::get_user_links($_SESSION['email']);
					?>					
					
			</div>
          </div>
          <div class="widget widget-nopad">
            <div class="widget-header"> <i class="icon-list-alt"></i>
              <h3> Recent News</h3>
            </div>
            <div id="news_box" class="widget-content">
              
			  <?php 
			  include $_SERVER['DOCUMENT_ROOT'].'/ajax/UserDashboardNews.php';
			  $news_db = new UserDashNews;
			  
			  $news_display = $news_db->fetch_news_from_db();
			  ?>
			  
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="extra">
  <div class="extra-inner">
    <div class="container">
       
    </div>
  </div>
</div>
<div class="footer">
  <div class="footer-inner">
    <div class="container">
      <div class="row">
        <div class="span12"> &copy; <?php echo date("Y");?> b89.in </div>
      </div>
    </div>
  </div>
</div>

<script src="<?php echo $site;?>user/js/bootstrap.js"></script>
 
<script src="<?php echo $site;?>user/js/base.js"></script> 

<?php 
if(isset($analytics)){
	echo $analytics;
	}  
?>
</body>
</html>
<?php 
} else {
	$_SESSION['lo_er'] = 'error';
	$_redirect = $site.'login?error=1';
	header("Location: $_redirect");
}
if(isset($_SESSION['update_error'])){ unset ($_SESSION['update_error']);}
?>
