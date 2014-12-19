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

//SELECT COUNT(`uid`) AS `active`, (SELECT COUNT(`uid`) FROM `users` WHERE `active` != '0' AND `type` IN ('free', 'pro', 'busi')) AS `deactive` FROM `users` WHERE `active` = '0' AND `type` IN ('free', 'pro', 'busi')
$admin_site= $site.'manage/admin/';

if((user_is_logged_in()) AND ($_SESSION['u_type'] === 'admin')){

?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>b89.in &raquo; Admin dashboard.</title>
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
<style>#big_stats .stat .value {font-size:25px;}</style>
</head>
<body>
<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container"> <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><span
                    class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </a><a class="brand" href="<?php echo $admin_site;?>home">b89.in admin dashboard</a>
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
        <li class="active"><a href="<?php echo $admin_site;?>home"><i class="icon-dashboard"></i><span>Dashboard</span> </a> </li>
        <li><a href="<?php echo $admin_site;?>news"><i class="icon-list-alt"></i><span>News</span> </a> </li>
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

			<div class="span12" >
			<div class="widget widget-nopad">
            <div class="widget-header"> <i class="icon-list-alt"></i>
              <h3> Total Users</h3>
            </div>

            <div class="widget-content">
              <div class="widget big-stats-container">
                <div class="widget-content">
                  <div id="big_stats" class="cf">
                    
<?php
					
$fetch_user_count = "SELECT COUNT(`uid`) AS `active`, (SELECT COUNT(`uid`) FROM `users` WHERE `active` != '0' AND `type` IN ('free', 'pro', 'busi')) AS `deactive` FROM `users` WHERE `active` = '0' AND `type` IN ('free', 'pro', 'busi')";

if($result = $db->query($fetch_user_count) AND $result->num_rows > 0 AND $rows = $result->fetch_array(MYSQLI_ASSOC)){
	echo '<div class="stat"> <i class="icon-thumbs-up-alt" style="color:green;"></i> <span class="value" style="padding:5px">'.number_format($rows['active']).' active user(s)</span></div><div class="stat"> <i class="icon-thumbs-down-alt" style="color:red;"></i> <span class="value" style="padding:5px">'.number_format($rows['deactive']).' deactivated user(s)</span> </div>';
}else {
	echo '<div class="stat">Some connection issues. Please check codes or connection.</div>';
}


?>
                  </div>
                </div>
              </div>
            </div>
          </div>
		 			<div class="widget widget-nopad">
            <div class="widget-header"> <i class="icon-list-alt"></i>
              <h3> Total Valid and Invalid Links views</h3>
            </div>

            <div class="widget-content">
              <div class="widget big-stats-container">
                <div class="widget-content">
                  <div id="big_stats" class="cf">
                    
<?php
$month_year = date("F").'/'.date("Y");					
$fetch_links_count = "SELECT SUM(`valid_link`) AS `valid`, (SELECT SUM(`invalid_link`) FROM `user_chart` WHERE `month_year` = '$month_year') AS `invalid` FROM `user_chart` WHERE `month_year` = '$month_year'";
					  
if($result = $db->query($fetch_links_count) AND $result->num_rows > 0 AND $rows = $result->fetch_array(MYSQLI_ASSOC)){
	echo '<div class="stat"> <i class="icon-thumbs-up-alt" style="color:green;"></i> <span class="value" style="padding:5px">'.number_format($rows['valid']).' valid link view(s) of this month</span> and counting</div><div class="stat"> <i class="icon-thumbs-down-alt" style="color:red;"></i> <span class="value" style="padding:5px">'.number_format($rows['invalid']).' invalid link view(s) of this month</span> and counting</div>';
}else {
	echo '<div class="stat">Some connection issues. Please check codes or connection.</div>';
}


?>
                  </div>
                </div>
              </div>
            </div>
          </div>

<div class="widget widget-nopad">
            <div class="widget-header"> <i class="icon-list-alt"></i>
              <h3> Status of shorten links of users</h3>
            </div>

            <div class="widget-content">
              <div class="widget big-stats-container">
                <div class="widget-content">
                  <div id="big_stats" class="cf">
                    
<?php


//this will fetch total active links of active users from database 
$fetch_active_users = "SELECT `email` FROM `users` WHERE `active` = '0' AND `type` IN ('free', 'pro', 'busi')";
 
if($result = $db->query($fetch_active_users) AND $result->num_rows > 0 AND $rows = $result->fetch_all(MYSQLI_ASSOC)){
	
	$i = 0;
	
	foreach($rows as $row){
		
		$count_active_links = "SELECT COUNT(`id`) AS `total_links` FROM `url_table` WHERE BINARY `u_email` = '{$row['email']}' AND `archived` = '0'";
		
		if($result = $db->query($count_active_links) AND $result->num_rows > 0 AND $rows = $result->fetch_array(MYSQLI_ASSOC)){
			$i = $i + $rows['total_links'];
		}else{
			die ('<div class="stat">Some connection issues. Please check codes or connection. Error #000001</div>');
			
		}		
	}
	echo '<div class="stat"> <i class="icon-thumbs-up-alt" style="color:green;"></i> <span class="value" style="padding:5px">'.number_format($i).' active link(s) of all active users.</span></div>';
}else {
	die ('<div class="stat">Some connection issues. Please check codes or connection. Error #000002</div>');
}

$fetch_link_as_type = "SELECT COUNT(`id`) AS `total`, (SELECT COUNT(`id`) FROM `url_table` WHERE `archived` != '0') AS `inactive_links` FROM `url_table`";

if($result = $db->query($fetch_link_as_type) AND $result->num_rows > 0 AND $rows = $result->fetch_array(MYSQLI_ASSOC)){
	echo '<div class="stat"> <i class="icon-thumbs-up-alt" style="color:green;"></i> <span class="value" style="padding:5px"> Total '.number_format($rows['total']).' link(s)</span></div>  <div class="stat"> <i class="icon-thumbs-down-alt" style="color:red;"></i> <span class="value" style="padding:5px">'.number_format($rows['inactive_links']).' inactive link(s)</span><br>of all users (<font style="font-style:italic; color:red;"> active and deactivated users </font>)</div>';
}else {
	die ('<div class="stat">Some connection issues. Please check codes or connection. Error #000003</div>');
}


?>
                  </div>
                </div>
              </div>
            </div>
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
}
else{
	$login = $site.'login';
	header("Location: $login");
}
?>