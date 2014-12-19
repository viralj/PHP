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


// class of User management starts from here

class Users {
	
	
	//this function will fetch users and user details
	
	public static function get_users(){
		include $_SERVER['DOCUMENT_ROOT'].'/core/db_config_inc.php';
		
		$fetch_users = "SELECT * FROM `users` WHERE `type` IN ('free', 'pro', 'busi') AND `active` = '0' ORDER BY `uid` DESC";
		
		if($result = $db->query($fetch_users)){
			
			if($result->num_rows > 0 AND $rows = $result->fetch_all(MYSQLI_ASSOC)){
				echo '<div class="widget widget-table action-table"><div class="widget-header"> <i class="icon-user"></i><h3>Active users of b89.in [ Total '.number_format($result->num_rows).' user(s) ]</h3></div><div class="widget-content"><table class="table table-striped table-bordered"><thead><tr><th width="20%"> Name </th><th width="20%"> Username </th><th width="20%"> Email </th><th width="20%"> Type </th><th width="20%"> Actions </th></tr></thead></table><div id="usersTbl"><table class="table table-striped table-bordered"><tbody>';
				
				foreach($rows as $row){
					echo '<tr><td width="20%">'.$row['fname'].' '.$row['lname'].'</td><td width="20%">'.$row['uname'].'</td><td width="20%">'.$row['email'].'</td><td width="20%"><u>'.$row['type'].'</u> user</td>
					<td class="td-actions" width="20%">
					<a href="javascript:;" onclick="action(100, '.$row['uid'].');" title="Deactivate User" class="btn btn-danger btn-small"><i class="btn-icon-only ">D</i></a>
					<a href="javascript:;" onclick="action(200, '.$row['uid'].');" title="Make Admin" class="btn btn-success btn-small"><i class="btn-icon-only ">A</i></a>
					<a href="javascript:;" onclick="action(300, '.$row['uid'].');" title="Make Free Plan User" class="btn btn-success btn-small"><i class="btn-icon-only ">F</i></a>
					<a href="javascript:;" onclick="action(400, '.$row['uid'].');" title="Make Professional Plan User" class="btn btn-success btn-small"><i class="btn-icon-only ">P</i></a>
					<a href="javascript:;" onclick="action(500, '.$row['uid'].');" title="Make Business Plan User" class="btn btn-success btn-small"><i class="btn-icon-only ">B</i></a></td>
					</tr>';
				}
				
			echo '</tbody></table></div></div></div>';	
			}
			else{
				echo '<h3>No user found in system.</h3>';
			}
			
		}
		else{
			echo '<h3>Unable to get Users and details. Check connection or codes.</h3>';
		}
		
	}

	//this function will update details of users
	
	public static function take_action($a, $b){
		include $_SERVER['DOCUMENT_ROOT'].'/core/db_config_inc.php';
		$a = trim($db->real_escape_string(htmlentities($a)));
		$b = trim($db->real_escape_string(htmlentities($b)));
		
		
		//if $a is 100 then we will deactivate user's account
		
		if($a == 100){
			
			$deactivate_user = "UPDATE `users` SET `active` = '1' WHERE `uid` = '$b' AND `active` = '0'";
			
			if($db->query($deactivate_user) AND $db->affected_rows > 0){
				echo '<h4>Success! User\'s account is deactivated.</h4>';
				exit();
			}else{
				echo '<h4>Error! Please try again or refresh the page.</h4>';
				exit();
			}
			
		}else
		
		//if $a is 200 then we will make user as admin
		
		if($a == 200){
			$make_user_admin = "UPDATE `users` SET `type` = 'admin' WHERE `uid` = '$b' AND `active` = '0' AND `type` != 'admin'";
			
			if($db->query($make_user_admin) AND $db->affected_rows > 0){
				echo '<h4>Success! User\'s account is updated to admin account.</h4>';
				exit();
			}else{
				echo '<h4>Error! Please try again or refresh the page.</h4>';
				exit();
			}
		}else
		
		//if $a is 300 then we will make user as free plan user
		
		if($a == 300){
			$make_user_pro = "UPDATE `users` SET `type` = 'free' WHERE `uid` = '$b' AND `active` = '0' AND `type` != 'free'";
			
			if($db->query($make_user_pro) AND $db->affected_rows > 0){
				echo '<h4>Success! User\'s account is updated to Free User account.</h4>';
				exit();
			}else{
				echo '<h4>Error! Please try again or refresh the page.</h4>';
				exit();
			}
		}else
		
		//if $a is 400 then we will make user as professional plan user
		
		if($a == 400){
			$make_user_pro = "UPDATE `users` SET `type` = 'pro' WHERE `uid` = '$b' AND `active` = '0' AND `type` != 'pro'";
			
			if($db->query($make_user_pro) AND $db->affected_rows > 0){
				echo '<h4>Success! User\'s account is updated to Professional User account.</h4>';
				exit();
			}else{
				echo '<h4>Error! Please try again or refresh the page.</h4>';
				exit();
			}
		}else
		
		//if $a is 500 then we will make user as business plan user
		
		if($a == 500){
			$make_user_busi = "UPDATE `users` SET `type` = 'busi' WHERE `uid` = '$b' AND `active` = '0' AND `type` != 'busi'";
			
			if($db->query($make_user_busi) AND $db->affected_rows > 0){
				echo '<h4>Success! User\'s account is updated to Business User account.</h4>';
				exit();
			}else{
				echo '<h4>Error! Please try again or refresh the page.</h4>';
				exit();
			}
		}
		
	}
}

////////////////////////////////////////// Users class ends here.....
if( (isset($_POST['action'])) AND (isset($_POST['uid'])) ){
	Users::take_action($_POST['action'], $_POST['uid']);
	exit();
}

$admin_site= $site.'manage/admin/';

if((user_is_logged_in()) AND ($_SESSION['u_type'] === 'admin')){

?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>b89.in &raquo; Admin Manage Users.</title>
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
#usersTbl{min-height:200px;max-height:350px;overflow:scroll;margin:0 auto; margin-bottom:20px;}
#box2000 > div{-webkit-transition:width .2s ease;-moz-transition:width .2s ease;-o-transition:width .2s ease;-ms-transition:width .2s ease;transition:width .2s ease}
#box2000 > div:hover{width:120%!important;cursor:pointer}
</style>
<script type="text/javascript"> 
    $(document).ready(function () {
    $("#usersTbl").niceScroll({ autohidemode: true })
    });
</script>
<script type="text/javascript">function action(a,b){var a = a;var b = b;$('#result').html('');$.post('<?php echo $admin_site;?>users', {action:a,uid:b},function(data){$('#result').html(data+'<br>');});}</script>
</head>
<body>
<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container"> <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><span
                    class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </a><a class="brand" href="<?php echo $admin_site;?>users">b89.in admin manage users</a>
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
        <li><a href="<?php echo $admin_site;?>bugs"><i class="icon-list-alt"></i><span>Bug reports</span> </a> </li>
		<li><a href="<?php echo $admin_site;?>sendEmail"><i class="icon-envelope-alt"></i><span>Send Email</span> </a> </li>
		<li class="active"><a href="<?php echo $admin_site;?>users"><i class="icon-user"></i><span>Users</span> </a> </li>
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

			<div id="result"></div>
<?php
Users::get_users();
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