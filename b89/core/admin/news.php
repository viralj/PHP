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

$admin_site= $site.'manage/admin/';

if((user_is_logged_in()) AND ($_SESSION['u_type'] === 'admin')){

?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>b89.in &raquo; Admin News post.</title>
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
#newsTbl{min-height:50px;max-height:300px;overflow:scroll;margin:0 auto}
#box2000 > div{-webkit-transition:width .2s ease;-moz-transition:width .2s ease;-o-transition:width .2s ease;-ms-transition:width .2s ease;transition:width .2s ease}
#box2000 > div:hover{width:120%!important;cursor:pointer}
table{width:100%;border-spacing: 10px;border-collapse: separate;}
</style>
<script type="text/javascript"> 
    $(document).ready(function () {
    $("#newsTbl").niceScroll({ autohidemode: true })
    });
</script>
</head>
<body>
<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container"> <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><span
                    class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </a><a class="brand" href="<?php echo $admin_site;?>news">b89.in admin news post</a>
      <div class="nav-collapse">
        <ul class="nav pull-right">
          
          <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                            class="icon-user"></i> b89.in <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="<?php echo $admin_site;?>profile">Profile</a></li>
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
        <li><a href="<?php echo $admin_site;?>home"><i class="icon-dashboard"></i><span>Dashboard</span> </a> </li>
        <li class="active"><a href="<?php echo $admin_site;?>news"><i class="icon-list-alt"></i><span>News</span> </a> </li>
        <li><a href="<?php echo $admin_site;?>tickets"><i class="icon-list-alt"></i><span>Tickets</span> </a> </li>
        <li><a href="<?php echo $admin_site;?>genContact"><i class="icon-envelope-alt"></i><span>General Contact</span> </a> </li>
        <li><a href="<?php echo $admin_site;?>bugs"><i class="icon-list-alt"></i><span>Bug reports</span> </a> </li>
		<li><a href="<?php echo $admin_site;?>sendEmail"><i class="icon-envelope-alt"></i><span>Send Email</span> </a> </li>
		<li><a href="<?php echo $admin_site;?>users"><i class="icon-user"></i><span>Users</span> </a> </li>
		<li><a href="<?php echo $admin_site;?>SendBulkEmail"><i class="icon-envelope-alt"></i><span>Send bulk email</span> </a> </li>
		<li><a href="<?php echo $admin_site;?>addBugReporters"><i class="icon-user"></i><span>Hall-of-fame</span> </a> </li>
      </ul>
    </div>
  </div>
</div>
<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">
			<div style="min-height:350px;" class="span12">
<?php


/*
if(isset($_POST)){
	echo '<pre>';
	print_r($_POST);
	echo '</pre>';
}
*/



//this function is to post news	
if(isset($_POST['submit']) AND $_POST['submit'] === $_SESSION['CSRF_TOKEN'].'~'.$_SESSION['email'] AND $_POST['cool'] === $_SESSION['CSRF_TOKEN']){
	
	include $_SERVER['DOCUMENT_ROOT'].'/core/encryption.php';
	$blah = new Encryption;
	
	$title 	   = trim($db->real_escape_string(htmlentities($_POST['title'])));
	$text      = trim($db->real_escape_string(htmlentities($_POST['text'])));
	$newsType  = trim($db->real_escape_string(htmlentities($_POST['newsType'])));
	$date  	   = date('d');	
	$month 	   = date('F');	
	$year      = date('Y');
	$updated   = date('l jS \of F Y\, h:i:s A');
	$time      = time();
	$hash      = $blah->encode($time.'~'.$title.'~'.$updated.'~'.$_SESSION['ip'].'~'.$_SESSION['email']);

	if((isset($title)) AND (isset($text)) AND (isset($newsType))){
		$insert_news = "INSERT INTO `site_news` (
					`date`, `month`, `year`, `updated`, `title`, `news`, `news_type`, `hash`, `time`, `show`
					) VALUES (
					'$date', '$month', '$year', '$updated', '$title', '$text', '$newsType', '$hash', '$time', '0' 
					)";
		
		if(!isset($_SESSION['news_post'])){
			if($result = $db->query($insert_news) AND $db->affected_rows > 0){
				echo '<div class="span12">Success. News has been posted.</div><br><br>';
				$_SESSION['news_post'] = 'true';
			} else {
				echo '<div class="span12">Some error. Please check connection with database or check codes.</div><br><br>';
			}
		}
		else{
			echo '<form id="submitNews" action="'.$admin_site.'news" method="POST">
				<input type="hidden" name="postNews" value="true"  />
				<input type="hidden" name="newsPoster" value="'.$_SESSION['email'].'"  />
				<div class="span12">You have posted a news. Do you want to post another? <a href="javascript:{}" onclick="document.getElementById(\'submitNews\').submit();">Yes</a>
				</form>
				</div><br><br>';
		}
	}
	else{
		echo '<div class="span12">Input is empty. Please add data to post news.</div><br><br>';
	}
}


//this will remove session to post new news
if((isset($_POST['postNews'])) AND ($_POST['postNews'] === 'true') AND (isset($_POST['newsPoster'])) AND ($_POST['newsPoster'] === $_SESSION['email']) AND isset($_SESSION['news_post'])){
	unset($_SESSION['news_post']);
}

//this will delete news from database.
if((isset($_POST['h'])) AND (isset($_POST['nid']))){
		
	$delete_news = "UPDATE `site_news` SET `show` = '1' WHERE BINARY `hash` = '{$_POST['h']}' AND BINARY `id` = '{$_POST['nid']}' AND `show` = '0'";
	
	if($db->query($delete_news) AND $db->affected_rows > 0){
		echo '<div class="span12">Success. News has been deleted.</div><br><br>';
		$admin_news = $admin_site.'news';
		$success = "<script>alert('Success. This news is deleted from system.')</script><script>self.location='$admin_news';</script>";
	}else{
		echo '<div class="span12">Some error. Please check connection with database or check codes.</div><br><br>';
	}
}

if(isset($success)){
	echo $success;
}
?>	

<div class="tab-content">
								<div class="tab-pane active" id="formcontrols">
								<form id="postNews" class="form-horizontal" enctype="multipart/form-data" method="POST" action="<?php echo $admin_site;?>news" autocomplete="off">
									<fieldset>
										
										<div class="control-group">											
											<label class="control-label" for="title">Title</label>
											<div class="controls">
												<input required type="text" class="span6" id="title" name="title" placeholder="Title">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
										
										<div class="control-group">											
											<label class="control-label" for="text">Text</label>
											<div class="controls">
												<textarea required type="text" class="span6" rows="8" id="text" name="text" placeholder="Enter news" ></textarea>
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
									<br>
									<div class="control-group" required>											
											<label class="control-label">News type</label>
											
                                            
                                            <div class="controls">
                                            <label class="radio inline">
                                              <input required type="radio"  name="newsType" value="0"> Good
                                            </label>
                                            
                                            <label class="radio inline">
                                              <input required type="radio" name="newsType" value="1"> Bad
                                            </label>
                                          </div>	<!-- /controls -->			
										</div>


									<br>
											
										<div class="form-actions">
										<input type="hidden" class="span6" name="cool" value="<?php echo $_SESSION['CSRF_TOKEN'];?>">
											<button type="submit" class="btn btn-primary" name="submit" value="<?php echo $_SESSION['CSRF_TOKEN'].'~'.$_SESSION['email'];?>">Submit</button> 
											<button type="reset" class="btn">Cancel</button>
										</div> <!-- /form-actions -->
									
									
									
									</fieldset>
								</form>
								</div>
								
							</div>			
	

<div class="span12">
	<h3>Delete news</h3><hr>
<table><tr><td>&nbsp;</td><td><u>News title</u></td><td style="width:70%;"><u>News text</u></td><td><u>Action</u></td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></table>

	<div id="newsTbl">


<?php
	$fetch_all_news = "SELECT * FROM `site_news` WHERE `show` = '0' ORDER BY `id` DESC";

	if($result = $db->query($fetch_all_news)){
		if($result AND $result->num_rows > 0 AND $rows = $result->fetch_all(MYSQLI_ASSOC)){
			$i = 1;
			echo '<table>';
			
			foreach($rows as $row){
				echo '<tr><td>'.$i.') </td><td>'.$row['title'].'</td><td style="width:70%;">'.$row['news'].'</td><td><form id="deleteNews~'.$row['id'].'" method="post" action="'.$admin_site.'news">
				<input type="hidden" name="h" value="'.$row['hash'].'" />
				<input type="hidden" name="nid" value="'.$row['id'].'" />
				<a href="javascript:{}" onclick="document.getElementById(\'deleteNews~'.$row['id'].'\').submit();">Delete</a> this post.</form></td></tr>';
				$i++;
			}
			echo '</table>';
		}
		else{
			echo 'No news found in database. Please post news.';
		}
	}
	else{
	echo 'Some problem. Please check connection or codes.';
	}
	
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

if(isset($success)){
	unset($success);
}	
?>
</body>
</html>
<?php 
}
else{
	$login = $site.'login';
	header("Location: $login");
}
?>
