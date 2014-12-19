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
		
		TicketSystem::fetch_open_tickets();
		TicketSystem::fetch_closed_tickets();
		
	}
	
	
	
	
	public static function fetch_open_tickets(){
		include $_SERVER['DOCUMENT_ROOT'].'/core/db_config_inc.php';
		
		$fetch_tickets = "SELECT `ticket_id`,`question`,`read` FROM `tickets` WHERE BINARY `email` = '{$_SESSION['email']}' AND `type` = 'question' AND`closed` = '0' ORDER BY `id` DESC";
		
		if($result = $db->query($fetch_tickets)){
			
			if($result->num_rows > 0 AND $rows = $result->fetch_all(MYSQLI_ASSOC)){
				$i = 1;
				echo '<div id="openTickets"><h3>Your open tickets.</h3>';
				foreach($rows as $row){
				
					if($row['read'] == 1){
						$read = '<code>You got reply</code>';
					}
					else{
						$read = '';
					}					
				
					echo $i.' ) <a href="'.$site.'user/v1/support/tickets~'.$row['ticket_id'].'">'.$row['question'].'</a> '.$read.'<br>';
					$i++;
			
				}
				echo '<br></div>';
			}
			else {
				echo '<div id="openTickets"><h4>You don\'t have any active ticket.</h4></div>';
			}
			
		} else {
			echo '<b>We are facing some issue to fetch all your submitted tickets. Please refresh page.</b>';
		}
	}
	
	
	public static function fetch_closed_tickets(){
		
		include $_SERVER['DOCUMENT_ROOT'].'/core/db_config_inc.php';
		
		$fetch_tickets = "SELECT `ticket_id`,`question` FROM `tickets` WHERE BINARY `email` = '{$_SESSION['email']}' AND `type` = 'question' AND `closed` != '0' ORDER BY `id` DESC";
		
		if($result = $db->query($fetch_tickets)){
			
			if($result->num_rows > 0 AND $rows = $result->fetch_all(MYSQLI_ASSOC)){
				$i = 1;
				echo '<div id="closedTickets"><h3>Your closed tickets.</h3>';
				foreach($rows as $row){
					
					echo $i.' ) <a href="'.$site.'user/v1/support/tickets~'.$row['ticket_id'].'">'.$row['question'].'</a> <code>Closed</code><br>';
					$i++;
				}
				echo '<br></div>';
			}
			
		} else {
			echo '<b>We are facing some issue to fetch all your submitted tickets. Please refresh page.</b>';
		}
	
	}
	
	
	
	public static function fetch_ticket_by_id($var){
	
		include $_SERVER['DOCUMENT_ROOT'].'/core/db_config_inc.php';
		
		$var = trim($db->real_escape_string(htmlentities($var)));
		
		$get_ticket_by_id = "SELECT * FROM `tickets` WHERE BINARY `ticket_id` = '$var' AND BINARY `email` = '{$_SESSION['email']}' ORDER BY `id` DESC";
		$user_ticket = $site.'user/v1/support/tickets~'.$_POST['ticket_id'];
		if($result = $db->query($get_ticket_by_id) AND $result->num_rows > 0 AND $rows = $result->fetch_all(MYSQLI_ASSOC)){
			
			if($rows[0]['closed'] == 0){
				$close_btn = '<div style="float:right;padding-right:15px"><form action="'.$user_ticket.'" method="POST"><input type="hidden" name="cool" value="'.$_SESSION['CSRF_TOKEN'].'"/><input type="hidden" name="tid" value="'.$_POST['ticket_id'].'"/><button class="btn btn-danger" name="closebtn" value="closeTicket">Close</button> this ticket.</form></div>';
				$reply_form = '<center><form action="'.$user_ticket.'" method="POST" autocomplete="off"><textarea class="span8" rows="8" name="reply" placeholder="Reply"></textarea><input type="hidden" name="cool" value="'.$_SESSION['CSRF_TOKEN'].'"/><input type="hidden" name="tid" value="'.$_POST['ticket_id'].'"/><br><button name="replybtn" value="replyTrue" class="btn">Reply</button></form></center>';
			}
			else {
				$close_btn = '<div style="float:right;padding-right:15px">This ticket is <code>closed</code>.</div>';
				$reply_form = '<center><pre>This ticket is closed by you.</pre><center>';
			}
			
			echo '<p>Go back to your all <a href="'.$site.'user/v1/support/tickets">tickets</a>.</p><div class="widget widget-nopad"><div class="widget-header"> <i class="icon-list-alt"></i><h3>Q. '.$rows[0]['question'].'</h3>'.$close_btn.'</div><div class="widget-content"><div class="widget big-stats-container"><div class="widget-content" style="min-height:310px;">';
			
			echo '<div id="tickets">';
			foreach($rows as $row){
			
				if($row['response_by'] == $_SESSION['email']){
					$by = '<b>By <u>you</u></b>';
				}else {
					$by = 'By <u>customer representative</u>';
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

//this function will close ticket
if(isset($_POST['closebtn']) AND $_POST['closebtn'] === 'closeTicket' AND (isset($_POST['cool'])) AND $_POST['cool'] === $_SESSION['CSRF_TOKEN']){

	$tid  = @trim($db->real_escape_string(htmlentities($_POST['tid'])));

	$ticket = $site.'user/v1/support/tickets~'.$_POST['ticket_id'];
	
	$close_ticket = "UPDATE `tickets` SET `closed` = '1' WHERE BINARY `email` = '{$_SESSION['email']}' AND BINARY `ticket_id` = '$tid'";
	
	if($db->query($close_ticket) AND $db->affected_rows > 0){
		$_SESSION['ticket_update'] = "<script>alert('Your ticket ".$_POST['ticket_id']." is closed.')</script><script>self.location='$ticket';</script>";
	}
	else{
		$_SESSION['ticket_update'] = "<script>alert('We faced some unwanted error. Please try again. Ref #000001')</script><script>self.location='$ticket';</script>";
	}
}


// this function will post reply to the ticket

if((isset($_POST['replybtn'])) AND ($_POST['replybtn'] === 'replyTrue') AND (isset($_POST['cool'])) AND ($_POST['cool'] === $_SESSION['CSRF_TOKEN']) AND (isset($_POST['cool'])) AND ($_POST['tid'] === $_POST['ticket_id'])){
	
	$ticket = $site.'user/v1/support/tickets~'.$_POST['ticket_id'];
	
	$tid  = @trim($db->real_escape_string(htmlentities($_POST['tid'])));
	$reply  = @trim($db->real_escape_string(htmlentities($_POST['reply'])));
	
	$fetch_ticket = "SELECT * FROM `tickets` WHERE BINARY `ticket_id` = '$tid' AND BINARY `email` = '{$_SESSION['email']}' AND `type` = 'question'";
	
	if($result = $db->query($fetch_ticket) AND $result->num_rows > 0 AND $rows = $result->fetch_array(MYSQLI_ASSOC)){
		
		$ticket_id   = $rows['ticket_id'];
		$type		 = 'reply';
		$response_to = 'webmaster';
		$response_by = $_SESSION['email'];
		$question	 = $rows['question'];
		$priority	 = $rows['priority'];
		$cat 		 = $rows['category'];
		$time		 = date('l\, jS \of F Y h:i:s A');		
		
		
		$post_reply = "INSERT INTO `tickets` (
					    `ticket_id`, `type`, `response_to`, `response_by`, `email`, `priority`, `question`, `category`, `text`, `time`, `closed`
						)
						VALUES (
						'$ticket_id', '$type', '$response_to', '$response_by', '{$_SESSION['email']}', '$priority', '$question', '$cat', '$reply', '$time', '0'
						)";
		
		if($db->query($post_reply) AND $db->affected_rows > 0){
			
			if($db->query("UPDATE `tickets` SET `read` = '0' WHERE BINARY `ticket_id` = '$ticket_id' ") AND $db->affected_rows > 0){
				$_SESSION['ticket_update'] = "<script>alert('We have received your reply.')</script><script>self.location='$ticket';</script>";
			}
			else {
				$_SESSION['ticket_update'] = "<script>alert('We have received your reply. But we got en error. Please reply us once again to this ticket.')</script><script>self.location='$ticket';</script>";
			}
		
		}
		else {
			$_SESSION['ticket_update'] = "<script>alert('We were not able to post your reply. Please try again.')</script><script>self.location='$ticket';</script>";
		}
		
	}
	else{
		$_SESSION['ticket_update'] = "<script>alert('We faced some unwanted error. Please try again. Ref #000002')</script><script>self.location='$ticket';</script>";
	}
	
}


$user_site= $site.'user/v1/';

//lets check user type and allow to display page else redirect to user's page
$u_type = array('free', 'pro', 'busi');

if((user_is_logged_in()) AND (in_array($_SESSION['u_type'], $u_type))){

?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>b89.in &raquo; User support tickets.</title>
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
#openTickets{min-height:150px;max-height:300px;overflow:scroll;margin:0 auto}
#closedTickets{min-height:150px;max-height:300px;overflow:scroll;margin:0 auto}
#tickets{min-height:200px;max-height:350px;overflow:scroll;margin:0 auto; margin-bottom:20px;}
#box2000 > div{-webkit-transition:width .2s ease;-moz-transition:width .2s ease;-o-transition:width .2s ease;-ms-transition:width .2s ease;transition:width .2s ease}
#box2000 > div:hover{width:120%!important;cursor:pointer}
</style>
<script type="text/javascript"> 
    $(document).ready(function () {
    $("#openTickets").niceScroll({ autohidemode: true })
    });

	$(document).ready(function () {
    $("#closedTickets").niceScroll({ autohidemode: true })
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
                    class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </a><a class="brand" href="<?php echo $user_site;?>support/tickets">b89.in user support tickets</a>
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
        <li><a href="<?php echo $user_site;?>home"><i class="icon-dashboard"></i><span>Dashboard</span> </a> </li>
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
			<div style="min-height:350px;">

			<div class="span12">
			
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
} else {
	$_SESSION['lo_er'] = 'error';
	$_redirect = $site.'login?error=1';
	header("Location: $_redirect");
}
if(isset($_SESSION['update_error'])){ unset ($_SESSION['update_error']);}
?>