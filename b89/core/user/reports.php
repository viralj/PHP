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
	# This is Reports class to show user's violation and other reports.
	# Here user will see their status of payment and other things.
*/

class Reports{

	public static function show_user_report(){
	
		include $_SERVER['DOCUMENT_ROOT'].'/core/db_config_inc.php';
		
		/*
		
			#lets check that user has updated first and last name or not
			#if not then show error message to update profile.
	
		*/
		
		if((isset($_SESSION['fname'])) AND (isset($_SESSION['fname']))){
	
		
		$select_user_report_query = "SELECT * FROM `user_reports` WHERE BINARY `email` = '{$_SESSION['email']}' ORDER BY `id` DESC";

			//lets process for data	
			
			if($result = $db->query($select_user_report_query) AND $result->num_rows > 0 AND $rows = $result->fetch_all(MYSQLI_ASSOC)){
				
				/*
					## before we proceed to display user report, we will need to identify that what report we are going to display.
						
						report types are as followed
						
						0 - payment request
						1 - payment transfered
						2 - credit added
						3 - policy violation
					
				*/
				
				//report display div starts here
				echo  '<div id="userReports">';
					
					foreach($rows as $row){
					
						if($row['report_type'] == 0 OR $row['report_type'] == 1){
							echo'<div class="span6">								
										<div class="widget">											
											<div class="widget-content">												
												<h2>'.$row['report_title'].'</h2><font style="font-size:12px; color:grey;"><b>Updated: </b>'.$row['time'].'</font><hr>												
												<p>'.$row['report_text'].'</p>												
											</div> 											
										</div>									
									</div>';
						}
						
						else 
						
						if($row['report_type'] == 2 OR $row['report_type'] == 3){
							if($row['report_type'] == 2){
								$display_type = 'alert-success';
							}else if($row['report_type'] == 3){
								$display_type = 'alert-danger';
							}
							
							echo   '<div class="span12">							
										<div class="widget">											
											<div class="widget-content">
												<div class="alert '.$display_type.'">
												<h2>'.$row['report_title'].'</h2></div><font style="font-size:12px; color:grey;"><b>Updated: </b>'.$row['time'].'</font><hr>
												<p>'.$row['report_text'].'</p>													
											</div> 											
										</div>										
									</div>';
						}
						
					}
				
				//report display div ends here
				echo '</div>';
			
			/*----------------------------------------------------------
				//show referrals
				//Reports::show_refs_from_db();
				
				this function is hiding referrals list. when you want to use this function
				please adjust CSS of id "#userReports" to max height 355px
			*///----------------------------------------------------------
			
			} 
			else {
				echo '<div style="padding:10px; margin:10px; border:1px solid blue; -webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px;">
				Congratulations for your b89.in account. You don\'t have any report for your account. Keep checking this section for your account details.
				<hr>
					<h4 style="padding:5px;">Here you can check reports of...</h4>						
					<ul>
							<li><a title="Terms" href="'.$site.'terms">Terms</a> and Policy violations (this can cause your account deactivation),</li><li>Your payment updates,</li><li>And other more details of your account.</li>
					</ul><hr>
					<p style="padding:5px;"><b>Remember</b>, we do have <b>strict</b> policies for publishers. Keep in mind, do not violate any policies else it will cause your permanent account deactivation.</p>
				</div>';
				
			
				//show referrals
				//Reports::show_refs_from_db();
			
			}
			
		}
		else {
			echo '<div style="border:1px solid red; padding:5px; min-height:100%; min-width:90%; -webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px;"><p style="padding:5px;">You need to update your profile. We will need some of your details to generate reports of your account.</p>
					<hr>
					<h4 style="padding:5px;">Here you can check reports of...</h4>						
					<ul>
							<li><a title="Terms" href="'.$site.'terms">Terms</a> and Policy violations (this can cause your account deactivation),</li><li>Your payment updates,</li><li>And other more details of your account.</li>
					</ul><hr>
					<p style="padding:5px;"><b>Remember</b>, we do have <b>strict</b> policies for publishers. Keep in mind, do not violate any policies else it will cause your permanent account deactivation.</p>
					</div>';
		}

		
	}
	
	//this function will show all referrals of logged in user
	public static function show_refs_from_db(){
		include $_SERVER['DOCUMENT_ROOT'].'/core/db_config_inc.php';
		
		$find_user_ref_code = "SELECT `urefcode` FROM `users` WHERE BINARY `email` = '{$_SESSION['email']}'";
		
		if($result = $db->query($find_user_ref_code) AND $result->num_rows > 0 AND $rows = $result->fetch_array(MYSQLI_ASSOC)){
			$urefcode = $rows['urefcode'];
			
			$find_user_referrals = "SELECT * FROM `users` WHERE BINARY `ref` = '$urefcode'";
			
			//from here, we will fetch referrals details from database
			
			if($result = $db->query($find_user_referrals) AND $result->num_rows > 0 AND $rows = $result->fetch_all(MYSQLI_ASSOC)){
			
				echo   '<br><br><div id="Refs" class="span12" style="margin-left:20px;">							
							<div class="widget">											
								<div class="widget-content">
									<p>Hello '.$_SESSION['fname'].',<br>';
					$refstr = array();
					foreach($rows as $row){
						$refstr[] = '<b>'.$row['fname'].'</b>';
					}
					$ref_result = implode(", ", $refstr);
				echo $ref_result.' are your referrals. Share your referral link with your friends.<br>Your referral code is <b>'.$urefcode.'</b> and you can invite your friends by sharing this link: <a href="'.$site.'?ref='.$urefcode.'">'.$site.'?ref=<b>'.$urefcode.'</b></a>';
				
				echo				'</p>													
								</div> 											
							</div>										
						</div>';				
				
			}
			else {
				
				$refecho = 'You don\'t have any referral yet. You can invite your friends by sharing your referral code which is <b>'.$urefcode.'</b>.<br>Copy this link: <a href="'.$site.'?ref='.$urefcode.'">'.$site.'?ref=<b>'.$urefcode.'</b></a>';
				
				echo   '<br><br><div class="span12" style="max-width:95%">							
							<div class="widget">											
								<div class="widget-content">
									<p>'.$refecho.'</p>													
								</div> 											
							</div>										
						</div>';
				
			}
			
			
		} else {
			echo '<b>Note:</b> We are not able to get your referral code. Please report this to us.';
		}
		
	}
	
	
	//public static function (){}

}
// user report class ends here


//---------------------------------------------------------------------------------------//

$user_site= $site.'user/v1/';

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
#Refs{min-height:100px;max-height:120px;overflow:scroll;margin:0 auto;}
#userReports{min-height:300px;max-height:380px;overflow:scroll;margin:0 auto; padding-top:7px;margin-left:-10px;}
#box2000 > div{-webkit-transition:width .2s ease;-moz-transition:width .2s ease;-o-transition:width .2s ease;-ms-transition:width .2s ease;transition:width .2s ease}
#box2000 > div:hover{width:120%!important;cursor:pointer}
</style>
<script type="text/javascript"> 
    $(document).ready(function () {
    $("#userReports").niceScroll({ autohidemode: true })
    });
	
	$(document).ready(function () {
    $("#Refs").niceScroll({ autohidemode: true })
    });
</script>
</head>
<body>
<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container"> <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><span
                    class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </a><a class="brand" href="<?php echo $user_site;?>reports">b89.in user reports</a>
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
        <li class="active"><a href="<?php echo $user_site;?>reports"><i class="icon-list-alt"></i><span>Reports</span> </a> </li>
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
				<?php
				
					Reports::show_user_report();
				
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
} else {
	$_SESSION['lo_er'] = 'error';
	$_redirect = $site.'login?error=1';
	header("Location: $_redirect");
}
if(isset($_SESSION['update_error'])){ unset ($_SESSION['update_error']);}
?>