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

class BugsView{

	public static function fetch_all_bug_reports(){
		
		BugsView::fetch_open_bugs();
		BugsView::fetch_closed_bugs();
		
	}
	
	public static function fetch_open_bugs(){
		include $_SERVER['DOCUMENT_ROOT'].'/core/db_config_inc.php';
		
		$fetch_all_bugs = "SELECT * FROM `vul_report` WHERE `read` = '0'";
		
		if($result = $db->query($fetch_all_bugs)){
			
			if($result->num_rows > 0 AND $rows = $result->fetch_all(MYSQLI_ASSOC)){
				echo'<div id="openBugs"><h5>Open bugs.</h5>';
					$i = 1;
				foreach($rows as $row){
					echo $i.' ) <a href="'.$site.'manage/admin/bugs~'.$row['vul_id'].'">'.$row['title'].'</a> <code>'.$row['level'].'</code><br>';
					$i++;
				}
				echo '</div>';
			}
			else{
				echo '<h3>No open bug found.</h3>';
			}
			
			
		}
		else{
			echo '<h3>Some connection issue. Please check connection or codes.</h3>';
		}
	}
	
	public static function fetch_closed_bugs(){
		include $_SERVER['DOCUMENT_ROOT'].'/core/db_config_inc.php';
		
		$fetch_all_bugs = "SELECT * FROM `vul_report` WHERE `read` != '0' ORDER BY `id` DESC";
		
		if($result = $db->query($fetch_all_bugs)){
			
			if($result->num_rows > 0 AND $rows = $result->fetch_all(MYSQLI_ASSOC)){
				echo'<div>&nbsp;</div><div id="closedBugs"><h5>Closed bugs.</h5>';
					$i = 1;
				foreach($rows as $row){
					echo $i.' ) <a href="'.$site.'manage/admin/bugs~'.$row['vul_id'].'">'.$row['title'].'</a> <code>'.$row['level'].'</code><br>';
					$i++;
				}
				echo '</div>';
			}
			else{
				echo '<br><br><h3>No bug is closed yet.</h3>';
			}
			
			
		}
		else{
			echo '<h3>Some connection issue. Please check connection or codes.</h3>';
		}
	
	}
	
	public static function fetch_bug_by_id($var){
		include $_SERVER['DOCUMENT_ROOT'].'/core/db_config_inc.php';
		
		$var = trim($db->real_escape_string(htmlentities($var)));
		
		$fetch_bug = "SELECT * FROM `vul_report` WHERE BINARY `vul_id` = '$var'";
	
		if($result = $db->query($fetch_bug)){
			
			if($result->num_rows > 0 AND $rows = $result->fetch_array(MYSQLI_ASSOC)){
				
				if($rows['read'] == 0){
					$close_btn = '<font style="float:right"><a href="'.$site.'manage/admin/sendEmail?mailto='.$rows['email'].'&sub=Your bug report to b89.in ('.$rows['vul_id'].')" target="_new">Send Email</a> to reporter or <a href="'.$site.'manage/admin/bugs~'.$rows['vul_id'].'?vid='.$rows['vul_id'].'&re='.$rows['email'].'&id='.$rows['id'].'">Close</a> this bug.</font>';
				}
				else{
					$close_btn = '<font style="float:right">This bug is closed, would you like to <a href="'.$site.'manage/admin/sendEmail?mailto='.$rows['email'].'&sub=Your bug report to b89.in ('.$rows['vul_id'].')" target="_new">Send Email</a> to reporter.</font>';
				}
				
				
				echo'
				
				Bug id is <b>#'.$rows['vul_id'].'</b>, reported by <b>'.$rows['name'].'</b> (<u>'.$rows['email'].'</u>)'.$close_btn.'<br><br>
				Title: <b>'.$rows['title'].'</b><br><br>
				<u>Description</u>: <br><div id="bug">'.html_entity_decode(nl2br(($rows['msg']))).'
				</div>';
			}
			else{
				echo '<br><br><h3>No bug found that your are looking for.</h3>';
			}
			
			
		}
		else{
			echo '<h3>Some connection issue. Please check connection or codes.</h3>';
		}
	
	}

}
// bugs view class ends here.

$admin_site= $site.'manage/admin/';

if((user_is_logged_in()) AND ($_SESSION['u_type'] === 'admin')){

?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>b89.in &raquo; Admin Bug Reports.</title>
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
#bug{min-height:100px;max-height:300px;overflow:scroll;margin:0 auto;}
#openBugs{min-height:100px;max-height:300px;overflow:scroll;margin:0 auto;}
#closedBugs{min-height:100px;max-height:300px;overflow:scroll;margin:0 auto; margin-bottom:20px;}
#box2000 > div{-webkit-transition:width .2s ease;-moz-transition:width .2s ease;-o-transition:width .2s ease;-ms-transition:width .2s ease;transition:width .2s ease}
#box2000 > div:hover{width:120%!important;cursor:pointer}
</style>
<script type="text/javascript"> 
    $(document).ready(function () {
    $("#bug").niceScroll({ autohidemode: true })
    });
	
	$(document).ready(function () {
    $("#openBugs").niceScroll({ autohidemode: true })
    });
	
	$(document).ready(function () {
    $("#closedBugs").niceScroll({ autohidemode: true })
    });
	
</script>
</head>
<body>
<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container"> <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><span
                    class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </a><a class="brand" href="<?php echo $admin_site;?>bugs">b89.in admin bug reports</a>
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
        <li><a href="<?php echo $admin_site;?>news"><i class="icon-list-alt"></i><span>News</span> </a> </li>
        <li><a href="<?php echo $admin_site;?>tickets"><i class="icon-list-alt"></i><span>Tickets</span> </a> </li>
        <li><a href="<?php echo $admin_site;?>genContact"><i class="icon-envelope-alt"></i><span>General Contact</span> </a> </li>
        <li class="active"><a href="<?php echo $admin_site;?>bugs"><i class="icon-list-alt"></i><span>Bug reports</span> </a> </li>
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
			<div class="span12" style="min-height:350px;">
<?php 

	if((isset($_GET['vid'])) AND (isset($_GET['re'])) AND (isset($_GET['id']))){
		
		$vid = trim($db->real_escape_string(htmlentities($_GET['vid'])));
		$re  = trim($db->real_escape_string(htmlentities($_GET['re'])));
		$id  = trim($db->real_escape_string(htmlentities($_GET['id'])));
		
		if($db->query("UPDATE `vul_report` SET `read` = '1' WHERE BINARY `vul_id`= '$vid' AND `id` = '$id' AND BINARY `email` = '$re' AND `read` = '0'") AND $db->affected_rows > 0){
			echo '<h3>System updated successfully . Bug #<u>'.$vid.'</u> is closed now.</h3>';
		}
		else{
			echo '<h3>Unable to update system. Please check parameters or codes.</h3>';
		}
		
		
	}
	else 
	if(isset($_POST['bug_id'])){
		BugsView::fetch_bug_by_id($_POST['bug_id']);
	}
	else{
		BugsView::fetch_all_bug_reports();
	}

?>
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
}
else{
	$login = $site.'login';
	header("Location: $login");
}
?>