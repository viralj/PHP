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

//lets check user type and allow to display page else redirect to user's page
$u_type = array('free', 'pro', 'busi');

if((user_is_logged_in()) AND (in_array($_SESSION['u_type'], $u_type))){


//echo date('l jS \of F Y h:i:s A', time());

?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>b89.in &raquo; Purchase plans.</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<link rel="shortcut icon" href="<?php echo $site;?>flat-ui/images/favicon.ico">
<link href="<?php echo $site;?>user/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo $site;?>user/css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
<link href="<?php echo $site;?>user/css/font-awesome.css" rel="stylesheet">
<link href="<?php echo $site;?>user/css/style.css" rel="stylesheet">
<link href="<?php echo $site;?>user/css/pages/plans.css" rel="stylesheet">
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
<script src="<?php echo $site;?>user/js/jquery-1.7.2.min.js"></script> 
</head>
<body>
<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container"> <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><span
                    class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </a><a class="brand" href="<?php echo $user_site;?>purchase">b89.in purchase plans</a>
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
        <li class="active"><a href="<?php echo $user_site;?>purchase"><i class="icon-tags"></i><span>Purchase</span> </a></li>
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
	      		
	      		<div class="widget">
						
					<div class="widget-header">
						<i class="icon-th-large"></i>
						<h3>Choose Your Plan</h3>
					</div> 
					<div class="widget-content">
						
						<div class="pricing-plans plans-3">
							
						<div class="plan-container">
					        <div class="plan">
						        <div class="plan-header">
					                
						        	<div class="plan-title">
						        		Basic	        		
					        		</div> 
						            <div class="plan-price">
					                	$0<span class="term">Free For Life</span>
									</div> 
						        </div> 
						        <div class="plan-features">
									<ul>
										<li>Create <strong>Unlimited</strong> links/month</li>
										<li>Status of your links</li>
										<li>Absolutely free</li>
										<li>No <strong>hidden</strong> charges or fees</li>
									</ul>
								</div> 
								<div class="plan-actions">				
									
									
<?php
if($_SESSION['u_type'] === 'free'){
echo '<a href="javascript:;" class="btn">Default</a>';
} else {
echo '<a href="javascript:;" class="btn">Will be Default</a>';	
}

?>				
								</div> 
							</div> 
					    </div> 					    
					    
					    <div class="plan-container">
					        <div class="plan green">
						        <div class="plan-header">
					                
						        	<div class="plan-title">
						        		Professional	        		
					        		</div> 
						            <div class="plan-price">
					                	$15.95<span class="term">Per Month</span>
									</div> 
						        </div> 
						        <div class="plan-features">
									<ul>					
										<li>Create <strong>Unlimited</strong> links/month</li>
										<li>Status of your links</li>
										<li>Pay every month</li>
										<li>No <strong>hidden</strong> charges or fees</li>
										<li>Email support 24*7</li>
									</ul>
								</div> 
								<div class="plan-actions">				
<?php
	if($_SESSION['u_type'] === 'pro'){
	echo '<a href="javascript:;" class="btn">Current Plan</a>';
	}
	else {
		echo '<a href="javascript:;" data-toggle="modal" data-target="#ProPlan" class="btn">Purchase</a>
		<!-- Pro Plan Modal -->
		<div class="modal fade" id="ProPlan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Professional plan</h4>
			  </div>
			  <div class="modal-body">
				You are about to choose Professional plan. To purchase this plan, you will have to pay amount of <b>$15.95</b> and the price is for a month. To renew this plan, you have to pay monthly. When you purchase this plan, it will be activated for 30 days from the day of purchase.
				<hr>
				By clicking on <b>Purchase</b> button, you will be redirected to new page where you will pay the amount to purchase this plan. You can buy this plan with debit/credit card or paypal account.
				<hr>
				<b>Remember</b>, we will not refund your payment after purchasing this or any plan. If you have any question, please contact us by submitting <a href="'.$site.'user/v1/support">ticket</a>.
				<hr>
			   <p><u><b>Note</b></u>: Please contact us by submitting ticket if you want to purchase this plan. Because we are currently reviewing our system, we are not allowing users to purchase any plan through our system.</p>
			  </div>
			  <div class="modal-footer">
				<button disabled type="button" class="btn btn-primary" style="padding:5px;">Purchase</button>
			  </div>
			</div>
		  </div>
		</div>
		';
		}
?>				
								</div> 
							</div>
					    </div> 					    
					    <div class="plan-container">
					        <div class="plan">
						        <div class="plan-header">
					                
						        	<div class="plan-title">
						        		Business	        		
					        		</div>					                
						            <div class="plan-price">
					                	$25.95<span class="term">Per Month</span>
									</div>	
						        </div>
						        <div class="plan-features">
									<ul>
										<li>Create <strong>Unlimited</strong> links/month</li>
										<li>Custom shorten link</li>
										<li>Status of your links</li>
										<li>Pay every month</li>
										<li>No <strong>hidden</strong> charges or fees</li>
										<li>Email support 24*7</li>
									</ul>
								</div> 
								<div class="plan-actions">				
<?php
	if($_SESSION['u_type'] === 'busi'){
	echo '<a href="javascript:;" class="btn">Current Plan</a>';
	}
	else {
		echo '<a href="javascript:;" data-toggle="modal" data-target="#busiPlan" class="btn">Purchase</a>
		<!-- busi Plan Modal -->
		<div class="modal fade" id="busiPlan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Business plan</h4>
			  </div>
			  <div class="modal-body">
				You are about to choose Business plan. To purchase this plan, you will have to pay amount of <b>$25.95</b> and the price is for a month. To renew this plan, you have to pay monthly. When you purchase this plan, it will be activated for 30 days from the day of purchase.
				<hr>
				By clicking on <b>Purchase</b> button, you will be redirected to new page where you will pay the amount to purchase this plan. You can buy this plan with debit/credit card or paypal account.
				<hr>
				<b>Remember</b>, we will not refund your payment after purchasing this or any plan. If you have any question, please contact us by submitting <a href="'.$site.'user/v1/support">ticket</a>.
				<hr>
			   <p><u><b>Note</b></u>: Please contact us by submitting ticket if you want to purchase this plan. Because we are currently reviewing our system, we are not allowing users to purchase any plan through our system.</p>
			  </div>
			  <div class="modal-footer">
				<button disabled type="button" class="btn btn-primary" style="padding:5px;">Purchase</button>
				</div>
			</div>
		  </div>
		</div>
		';	
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