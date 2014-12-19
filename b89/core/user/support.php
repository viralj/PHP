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
 
 
 
if((isset($_POST['submit'])) AND (isset($_POST['cool'])) AND ($_POST['cool'] === $_SESSION['CSRF_TOKEN'])){

	//$_SESSION['update_info'] = '<script>alert(\'posted\')</script><script>self.location='.$support.';</script>';

	$support = $site.'user/v1/support';
	
	$que  = @trim($db->real_escape_string(htmlentities($_POST['question'])));
	$cat  = @trim($db->real_escape_string(htmlentities($_POST['category'])));
	$msg  = @trim($db->real_escape_string(htmlentities($_POST['message'])));
	$cool = @trim($db->real_escape_string(htmlentities($_POST['cool'])));
	
	//lets process ticket submit.
	
	//first we will neet ot check that the question user is submitting is already asked by same user before?
	$check_que_by_user = "SELECT `id` FROM `tickets` WHERE BINARY `email` = '{$_SESSION['email']}' AND `question` = '$que'";
	
	if($result = $db->query($check_que_by_user) AND $result->num_rows > 0){
		$_SESSION['update_info'] = "<script>alert('You have asked same question before. Please check all your submitted tickets.')</script><script>self.location='$support';</script>";
	}
	else
	
	//then we will need to check for question string length.
	if(strlen($que) > 499){
		$_SESSION['update_info'] = "<script>alert('Your question is too long.')</script><script>self.location='$support';</script>";
	}
	else
	
	//then we will need to check for category string length.
	if(strlen($cat) > 199){
		$_SESSION['update_info'] = "<script>alert('Your category is too long.')</script><script>self.location='$support';</script>";
	}
	else
	
	//then we will need to check for message string length.
	if(strlen($que) > 9999){
		$_SESSION['update_info'] = "<script>alert('Your message is too long.')</script><script>self.location='$support';</script>";
	}
	else
	
	//if there is no error then we will process form.
	if(empty($_SESSION['update_info'])){
		
		function gen_code(){
			include $_SERVER['DOCUMENT_ROOT'].'/core/db_config_inc.php';	
			//generate random code for shorten url
			
					$charset = '0123456789ABCDEF';
					$len = 9;
					$numrows = 1;
					$code = '';
				
					while($numrows != 0 AND strlen($code) < 11 ){
						for($i = 0; $i <= $len; $i++){
							$rand = rand()% strlen($charset);
							$temp = substr($charset, $rand, 1);
							$code .= $temp;
						}
					
						$find = $db->query("SELECT `id` FROM `tickets` WHERE BINARY `ticket_id` = '$code'");
						$numrows = $find->num_rows;
					}
			return $code;
		}
		
		$time = date('l\, jS \of F Y h:i:s A');
		$ticket_id = gen_code();
		
		//depending user's type, we provide support faster.
		if($_SESSION['u_type'] == 'free'){
			$priority = 0;
		}else {
			$priority = 1;
		}
		
		$insert_query = "INSERT INTO `tickets` (
						 `ticket_id`, `type`, `response_to`, `response_by`, `email`, `priority`, `read`, `question`, `category`, `text`, `time`, `closed`
						 ) VALUES (
						 '$ticket_id', 'question', 'webmaster', '{$_SESSION['email']}', '{$_SESSION['email']}', '$priority', '0', '$que', '$cat', '$msg', '$time', '0'
						 )";
			
			
			if($result = $db->query($insert_query) AND $db->affected_rows > 0){
				$_SESSION['update_info'] = "<script>alert('We have received your ticket. Please check your submitted tickets for more information.')</script><script>self.location='$support';</script>";
			} else {
				$_SESSION['update_info'] = "<script>alert('We faced some unwanted error. Please submit your ticket once again.')</script><script>self.location='$support';</script>";
			}
	
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
<title>b89.in &raquo; User help and support.</title>
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
<?php 
if(isset($_SESSION['update_info'])){
	echo $_SESSION['update_info'];
}
?>
</head>
<body>
<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container"> <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><span
                    class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </a><a class="brand" href="<?php echo $user_site;?>support">b89.in user help and support</a>
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
<div class="widget-header"><h3>Welcome to b89.in support center</h3></div>
<br><p>
We are trying to help our users as much as we can. And for that we have built this system where you can find solution of your question.

</p><h4>Check all your submitted tickets <a href="<?php echo $user_site;?>support/tickets">here</a> or you can ask for help by filling form below.</h4>		
<br>
							<form id="edit-profile" class="form-horizontal" method="POST" action="<?php echo $user_site;?>support" autocomplete="off">
									<fieldset>
									
										
										<div class="control-group">											
											<label class="control-label" for="firstname">Question</label>
											<div class="controls">
												<input type="text" class="span6" name="question" placeholder="What is your question?" required> 											
											</div>				
										</div> 
										
										
										<div class="control-group">											
											<label class="control-label" for="lastname">Category</label>
											<div class="controls">
												<input type="text" class="span6" name="category" placeholder="Tell use what is your question about?" required> 
											</div>				
										</div> 
										
										
										<div class="control-group">											
											<label class="control-label" for="email">Message</label>
											<div class="controls">
												<textarea name="message" class="span6" rows="8" placeholder="Tell us in details." required></textarea>
											</div> 				
										</div> 
										
										
											<br />
										
											
										<div class="form-actions">
											<input type="hidden" name="cool" value="<?php echo $_SESSION['CSRF_TOKEN'];?>" />
											<button type="submit" name="submit" class="btn btn-primary" value="submit">Submit</button> 
											<button type="reset" class="btn">Cancel</button>
										</div> 
									</fieldset>
								</form>


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

if(isset($_SESSION['update_info'])){
	unset($_SESSION['update_info']);
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