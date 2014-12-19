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


////////////////// This is ticket class to fetch tickets from database.
class TicketSystem {

	public static function fetch_all_tickets(){
		
		TicketSystem::fetch_users();
		
	}	
	
	public function fetch_users(){
		include $_SERVER['DOCUMENT_ROOT'].'/core/db_config_inc.php';
		
		$fetch_user = "SELECT `email` FROM `users` WHERE `type` IN ('free', 'pro', 'buis') AND `active` = '0'";
	
		if($result = $db->query($fetch_user) AND $result->num_rows > 0 AND $rows = $result->fetch_all(MYSQLI_ASSOC)){
		
			echo '<div id="openTickets"><h3>Open tickets by users.</h3>';
			
			foreach($rows as $row){
				TicketSystem::fetch_open_tickets($row['email']);
			}
			echo '<br></div>';
		
		}else {
			echo '<div id="openTickets"><h4>You don\'t have any active ticket from users.</h4></div>';
		}
		
	}
	
	
	public static function fetch_open_tickets($var){
		include $_SERVER['DOCUMENT_ROOT'].'/core/db_config_inc.php';
		
		$fetch_tickets = "SELECT `ticket_id`,`question`,`priority` FROM `tickets` WHERE BINARY `email` = '$var' AND `type` = 'question' AND`closed` = '0' AND `read` = '0' ORDER BY `id` DESC";
		
		if($result = $db->query($fetch_tickets)){
			
			if($result->num_rows > 0 AND $rows = $result->fetch_all(MYSQLI_ASSOC)){
				
				foreach($rows as $row){
					echo ' --> <a href="'.$site.'manage/admin/tickets~'.$row['ticket_id'].'">'.$row['question'].'</a> <code>'.$row['priority'].'</code><br>';
				}
				
			}
			
			
		} else {
			echo '<b>We are facing some issue to fetch all your submitted tickets. Please refresh page.</b>';
		}
	}
	
	
	
	public static function fetch_ticket_by_id($var){
	
		include $_SERVER['DOCUMENT_ROOT'].'/core/db_config_inc.php';
		
		$get_ticket_by_id = "SELECT * FROM `tickets` WHERE BINARY `ticket_id` = '$var' AND `closed` = '0' ORDER BY `id` DESC";
		$admin_ticket = $site.'manage/admin/tickets~'.$_POST['ticket_id'];
		if($result = $db->query($get_ticket_by_id) AND $result->num_rows > 0 AND $rows = $result->fetch_all(MYSQLI_ASSOC)){
			
			
			$reply_form = '<center><form action="'.$admin_ticket.'" method="POST" autocomplete="off"><textarea class="span8" rows="8" name="reply" placeholder="Reply"></textarea><input type="hidden" name="cool" value="'.$_SESSION['CSRF_TOKEN'].'"/><input type="hidden" name="tid" value="'.$_POST['ticket_id'].'"/><br><button name="replybtn" value="replyTrue" class="btn">Reply</button></form></center>';
			
			
			echo '<p>Go back to your all <a href="'.$site.'manage/admin/tickets">tickets</a>.</p><div class="widget widget-nopad"><div class="widget-header"> <i class="icon-list-alt"></i><h3>Q. '.$rows[0]['question'].'</h3></div><div class="widget-content"><div class="widget big-stats-container"><div class="widget-content" style="min-height:310px;">';
			
			echo '<div id="tickets">';
			foreach($rows as $row){
			
				if($row['response_by'] === 'webmaster'){
					$by = '<b>By <u>you</u></b>';
				}else {
					$by = 'By <u>'.$row['email'].'</u>';
				}
				echo '<div style="padding:15px">'.$by.' <h5>Updated on '.$row['time'].'</h5><br><p>'.html_entity_decode(nl2br((stripslashes($row['text'])))).'</p></div><hr>';
			}
			echo '</div>';	
				
			echo $reply_form.'</div></div></div></div>';
			
		}
		else {
			echo '<h3>We can\'t find ticket <u>'.$var.'</u>. Please check your ticket number.</h3>';
		}
	}

}
/////////////// ticket class ends here /////////////////



// this function will post reply to the ticket

if((isset($_POST['replybtn'])) AND ($_POST['replybtn'] === 'replyTrue') AND (isset($_POST['cool'])) AND ($_POST['cool'] === $_SESSION['CSRF_TOKEN']) AND (isset($_POST['cool'])) AND ($_POST['tid'] === $_POST['ticket_id'])){
	
	$ticket = $site.'manage/admin/tickets~'.$_POST['ticket_id'];
	
	$tid  = @trim($db->real_escape_string(htmlentities($_POST['tid'])));
	$reply  = @trim($db->real_escape_string(htmlentities($_POST['reply'])));
	
	$fetch_ticket = "SELECT * FROM `tickets` WHERE BINARY `ticket_id` = '$tid' AND `type` = 'question'";
	
	if($result = $db->query($fetch_ticket) AND $result->num_rows > 0 AND $rows = $result->fetch_array(MYSQLI_ASSOC)){
		
		$ticket_id   = $rows['ticket_id'];
		$type		 = 'reply';
		$response_to = $rows['email'];
		$response_by = 'webmaster';
		$question	 = $rows['question'];
		$cat 		 = $rows['category'];
		$time		 = date('l\, jS \of F Y h:i:s A');		

		//depending user's type, we provide support faster.
		if($_SESSION['u_type'] == 'free'){
			$priority = 0;
		}else {
			$priority = 1;
		}

		
		$post_reply = "INSERT INTO `tickets` (
					    `ticket_id`, `type`, `response_to`, `response_by`, `email`, `priority`, `question`, `category`, `text`, `time`, `closed`
						)
						VALUES (
						'$ticket_id', '$type', '$response_to', '$response_by', '$response_to', '$priority', '$question', '$cat', '$reply', '$time', '0'
						)";
		
		if($db->query($post_reply) AND $db->affected_rows > 0){
			
			if($db->query("UPDATE `tickets` SET `read` = '1' WHERE BINARY `ticket_id` = '$ticket_id'") AND $db->affected_rows > 0){
				$_SESSION['ticket_update'] = "<script>alert('Your reply has been posted to user.')</script><script>self.location='$ticket';</script>";
			}
			else {
				$_SESSION['ticket_update'] = "<script>alert('Your reply has been posted to user. But system got an error. Please reply user once again to this ticket.')</script><script>self.location='$ticket';</script>";
			}
		}
		else {
			$_SESSION['ticket_update'] = "<script>alert('System was not able to post your reply. Please try again.')</script><script>self.location='$ticket';</script>";
		}
		
	}
	else{
		$_SESSION['ticket_update'] = "<script>alert('System faced some unwanted error. Please try again. Ref #000002')</script><script>self.location='$ticket';</script>";
	}
	
}



$admin_site= $site.'manage/admin/';

if((user_is_logged_in()) AND ($_SESSION['u_type'] === 'admin')){

?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>b89.in &raquo; Admin Help Ticket Post.</title>
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
#openTickets{min-height:300px;max-height:300px;overflow:scroll;margin:0 auto;}
#tickets{min-height:200px;max-height:350px;overflow:scroll;margin:0 auto; margin-bottom:20px;}
#box2000 > div{-webkit-transition:width .2s ease;-moz-transition:width .2s ease;-o-transition:width .2s ease;-ms-transition:width .2s ease;transition:width .2s ease}
#box2000 > div:hover{width:120%!important;cursor:pointer}
</style>
<script type="text/javascript"> 
    $(document).ready(function () {
    $("#openTickets").niceScroll({ autohidemode: true })
    });
	
	$(document).ready(function () {
    $("#tickets").niceScroll({ autohidemode: true })
    });
	
</script>
<?php 
if(isset($_SESSION['ticket_update'])){
	echo $_SESSION['ticket_update'];
}
?>
</head>
<body>
<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container"> <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><span
                    class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </a><a class="brand" href="<?php echo $admin_site;?>tickets">b89.in admin help ticket portal</a>
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
        <li class="active"><a href="<?php echo $admin_site;?>tickets"><i class="icon-list-alt"></i><span>Tickets</span> </a> </li>
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
if(isset($_POST['ticket_id'])){
	$tid = $_POST['ticket_id'];
	TicketSystem::fetch_ticket_by_id($tid);
}
else {
	TicketSystem::fetch_all_tickets();
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

if(isset($_SESSION['ticket_update'])){
	unset($_SESSION['ticket_update']);
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