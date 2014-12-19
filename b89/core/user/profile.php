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


//this function will keep checking for username, fname and lname are updated or not.

if($result = $db->query("SELECT * FROM `users` WHERE BINARY `email` = '{$_SESSION['email']}' LIMIT 1") AND $result->num_rows > 0 AND $rows = $result->fetch_array(MYSQLI_ASSOC)){
	if((!isset($_SESSION['uname'])) AND (!isset($_SESSION['fname'])) AND (!isset($_SESSION['lname']))){
	
		$_SESSION['lname'] = $rows['lname'];
		$_SESSION['fname'] = $rows['fname'];
		$_SESSION['uname'] = $rows['uname'];

		
	}
}


//this function is to check for available username
if(isset($_POST["u"]) && $_POST["u"] != ""){
   
    $username = preg_replace('/[^a-zA-Z0-9_-]/s', '', $_POST['u']); 
    $sql_uname_check = $db->query("SELECT * FROM `users` WHERE `uname` ='$username'"); 
    $uname_check = $sql_uname_check->num_rows;
    
	
	if (strlen($username) < 4) {
	    echo '4 - 32 characters please. <img src="'.$site.'img/Cross.png"/>';
	    exit();
    }
	if (is_numeric($username[0])) {
	    echo 'First character must be a letter. <img src="'.$site.'img/Cross.png"/>';
	    exit();
    }		
    if ($uname_check > 0) {
	    echo '<strong>' . $username . '</strong> is taken. <img src="'.$site.'img/Cross.png"/>';
	    exit();
    }		
	else {
	    echo '<strong>' . $username . '</strong> is available. <b>Remember</b> username is case-sensitive. <img src="'.$site.'img/Tick.png"/><input name="usernamev" type="hidden" value="true"/>';
	    exit();
    }
}


//lets process to update profile

if((isset($_POST['submit'])) AND ($_POST['submit'] == 'submit') AND (isset($_POST['pass']))){
	
	$profile = $site.'user/v1/profile';
	
	include_once $_SERVER['DOCUMENT_ROOT'].'/core/encryption.php';
	$blah = new Encryption;
	
	$pass1 = @trim($db->real_escape_string(htmlentities($_POST['pass'])));
	
	$pass = $blah->encode($pass1);
	
	$npass1 = @trim($db->real_escape_string(htmlentities($_POST['npass'])));
	$cpass1 = @trim($db->real_escape_string(htmlentities($_POST['cpass'])));
	$passv  = @trim($db->real_escape_string(htmlentities($_POST['passwordv'])));
	
	
	$npass = $blah->encode($npass1);
	$cpass = $blah->encode($cpass1);
	
	/*
	
		#	from here, we will need to work smart. So I can work smart this way.
		#	if user sessions fname, lname and uname are set then some codes wont work so user wont be able to bypass system to update fname, lname and uname.
	
	*/
	
	if((isset($_SESSION['uname'])) AND (!empty($_SESSION['uname'])) AND (isset($_SESSION['fname']))  AND (!empty($_SESSION['fname'])) AND (isset($_SESSION['lname']))  AND (!empty($_SESSION['lname']))){
		//these codes will work to update password only.
		
		if($npass1 != $cpass1){
			$_SESSION['profile_update'] = "<script>alert('Your new password and confirm password are not same. Please enter correct password.')</script><script>self.location='$profile';</script>";
		} 
		else 
		if(!isset($passv) OR $passv !== 'true'){
			$_SESSION['profile_update'] = "<script>alert('Check your password requirement.')</script><script>self.location='$profile';</script>";
		}
		else {
		
			$change_pass_querry = "UPDATE `users` SET `pass` = '$npass' WHERE BINARY (`email` = '{$_SESSION['email']}' AND `pass` = '$pass'  AND `fname` = '{$_SESSION['fname']}' AND `lname` = '{$_SESSION['lname']}' AND `uname` = '{$_SESSION['uname']}') LIMIT 1";
			
			if($result = $db->query($change_pass_querry) AND $db->affected_rows > 0){
				
				$_SESSION['profile_update'] = "<script>alert('Congratulation! Your password is changed.')</script><script>self.location='$profile';</script>";
			}
			else {
				$_SESSION['profile_update'] = "<script>alert('We faced some issue to update your profile. Please try again.')</script><script>self.location='$profile';</script>";
			}
			
			
		}
			
	}
	else 
	if((isset($_POST['usernamev'])) AND ($_POST['usernamev'] == 'true')){
		//these codes will work to update fname, lname and uname.
	
		$uname = preg_replace('/[^a-zA-Z0-9_-]/s', '', $_POST['username']);
		$uname = @trim($db->real_escape_string(htmlentities($uname)));
		
		$fname = @trim($db->real_escape_string(htmlentities($_POST['firstname'])));
		$lname = @trim($db->real_escape_string(htmlentities($_POST['lastname'])));
		
		$update_user_query = "UPDATE `users` SET `fname` = '$fname', `lname` = '$lname', `uname` = '$uname' WHERE BINARY (`email` = '{$_SESSION['email']}' AND `pass` = '$pass'  AND `fname` = '' AND `lname` = '' AND `uname` = '') LIMIT 1";
	
		if($result = $db->query($update_user_query) AND $db->affected_rows > 0){

			//lets set sessions here so user can not update fname, lname and uname anymore.
if(!empty($uname)){
	$_SESSION['uname'] = $uname;
}

if(!empty($fname)){
	$_SESSION['fname'] = $fname;
}

if(!empty($lname)){
	$_SESSION['lname'] = $lname;
}



			//also we will show that user's profile is updated
			$_SESSION['profile_update'] = "<script>alert('Congratulation! Your profile is updated. Enjoy our service.')</script><script>self.location='$profile';</script>";
			
		}
		else {
			
			$_SESSION['profile_update'] = "<script>alert('We faced some issue to update your profile. Did you enter correct password? Please try again.')</script><script>self.location='$profile';</script>";
		}
	
	}
	
	
}


//we are facing some temporary session issues so below codes are temporary solution

if((isset($_SESSION['fname'])) AND (empty($_SESSION['fname']))){
	unset($_SESSION['fname']);
}
if((isset($_SESSION['lname'])) AND (empty($_SESSION['lname']))){
	unset($_SESSION['lname']);
}
if((isset($_SESSION['uname'])) AND (empty($_SESSION['uname']))){
	unset($_SESSION['uname']);
}



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

<?php
	//this condition is to set to check username availability and password strength
	
	if((!isset($_SESSION['uname'])) AND (!isset($_SESSION['fname'])) AND (!isset($_SESSION['lname']))){
	echo '<script type="text/javascript" language="javascript">
		function checkusername(){
			var status = document.getElementById("usernamestatus");
			var u = document.getElementById("username").value;
			if(u != ""){
				status.innerHTML = "<img src=\''.$site.'img/loader.gif\'/>";
				var hr = new XMLHttpRequest();
				hr.open("POST", "'.$user_site.'profile", true);
				hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				hr.onreadystatechange = function() {
					if(hr.readyState == 4 && hr.status == 200) {
						status.innerHTML = hr.responseText;
					}
				}
			var v = \'u=\'+u;
			hr.send(v);
			}
		}
		
		setTimeout("window.location.reload(1)",15000);
		</script>';
	}
	

	else 
	{
	echo'
	<script src="'.$site.'js/pass.js"></script> 
	<script language="javascript">
		jQuery(document).ready(function() {
			$("#npass").keyup(function(){$("#result").html(passwordStrength($("#npass").val(),$("#username").val()))});
		
			$("#cpass").change(function(){
				 if($(this).val() != $("#npass").val()){
					//alert("values do not match");
				 d = "<b>Your passwords are not matching.</b>";
				 $("#confpass").html(d);
				 }else{
				d = "<b>Your passwords are matching.</b>";
				$("#confpass").html(d);
				 }
			});
		})
	</script>';
		
	}

//--------------------------------------------------------------------------	
	
if(isset($_SESSION['profile_update'])){echo $_SESSION['profile_update'];}
 ?>
</head>
<body>
<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container"> <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><span
                    class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </a><a class="brand" href="<?php echo $user_site;?>profile">b89.in user profile</a>
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
	      		
	      		<div class="widget ">
	      			
	      			<div class="widget-header">
	      				<i class="icon-user"></i>
	      				<h3>Your Account</h3>
	  				</div>
					
					<div class="widget-content">
						
					
					<form id="edit-profile" class="form-horizontal" method="POST" action="<?php echo $user_site;?>profile" autocomplete="off">
									<fieldset>
										
										<div class="control-group">											
											<label class="control-label" for="username">Username</label>
											<div class="controls">
												<input type="text" class="span6" name="username" id="username" 
												<?php
												if(isset($_SESSION['uname'])){
													echo 'placeholder="'.$_SESSION['uname'].'" disabled> <p class="help-block">You can\'t change your username.</p>';
												} else {
													echo 'placeholder="Username" onBlur="checkusername()" required><p class="help-block"><span id="usernamestatus">Set your username to access your account. </span></p>';
												}
												?>
												
											</div> 				
										</div> 
										
										
										<div class="control-group">											
											<label class="control-label" for="firstname">First Name</label>
											<div class="controls">
												<input type="text" class="span6" name="firstname" id="firstname" 
												<?php
												if(isset($_SESSION['fname'])){
													echo 'placeholder="'.$_SESSION['fname'].'" disabled> <p class="help-block">You can\'t change your first name.</p>';
												} else {
													echo 'placeholder="First name" required> <p class="help-block">Please add your first name in your account.</p>';
												}
												?>
												
												
											</div>				
										</div> 
										
										
										<div class="control-group">											
											<label class="control-label" for="lastname">Last Name</label>
											<div class="controls">
												<input type="text" class="span6" name="lastname" id="lastname" 
												<?php
												if(isset($_SESSION['lname'])){
													echo 'placeholder="'.$_SESSION['lname'].'" disabled> <p class="help-block">You can\'t change your last name.</p>';
												} else {
													echo 'placeholder="Last name" required> <p class="help-block">Please add your last name in your account.</p>';
												}
												?>
																																				
											</div>				
										</div> 
										
										
										<div class="control-group">											
											<label class="control-label" for="email">Email Address</label>
											<div class="controls">
												<input type="text" class="span6 disabled" name="email" id="email" placeholder="<?php echo $_SESSION['email'];?>" disabled>
												<p class="help-block">You can't change your login email.</p>
											</div> 				
										</div> 
										
										
										<br /><hr>
										
										<div class="control-group">											
											<div class="controls">
												<?php
												if((isset($_SESSION['uname'])) AND (isset($_SESSION['fname'])) AND (isset($_SESSION['lname']))){
													echo '<p class="help-block"><u>Change your password.</u></p>';
												}
												?>
												
											</div> 
										</div>
										
										<div class="control-group">											
											<label class="control-label" for="password1">Current Password</label>
											<div class="controls">
												<input type="password" class="span6" name="pass" id="password1" placeholder="ThisIsPassword" required>
											</div> 
										</div> 
										
										<br />
										
										<div class="control-group">											
											<label class="control-label" for="password1">New Password</label>
											<div class="controls">
												<input type="password" class="span6" name="npass" id="npass"
												
												<?php
												if((isset($_SESSION['uname'])) AND (isset($_SESSION['fname'])) AND (isset($_SESSION['lname']))){
													echo 'placeholder="ThisIsPassword" required >';
												} else {
													echo 'placeholder="ThisIsPassword" disabled>';
												}
												?>
												<p class="help-block" id="result"></p>							
											</div> 
										</div>
										
										<div class="control-group">											
											<label class="control-label" for="password2">Confirm Password</label>
											<div class="controls">
												<input type="password" class="span6" name="cpass" id="cpass"
												
												<?php
												if((isset($_SESSION['uname'])) AND (isset($_SESSION['fname'])) AND (isset($_SESSION['lname']))){
													echo 'placeholder="ThisIsPassword" required >';
												} else {
													echo 'placeholder="ThisIsPassword" disabled>';
												}
												?>
												<p class="help-block" id="confpass"></p>
												<input type="hidden" name="cool" id="cool" value="<?php echo $_SESSION['CSRF_TOKEN'];?>">
											</div> 				
										</div> 
										<?php
											if((isset($_SESSION['uname'])) AND (isset($_SESSION['fname'])) AND (isset($_SESSION['lname']))){
										?>
										<div class="control-group">											
											<div class="controls">
												<p class="help-block"><b>Note</b>: If you want to change your name, please submit ticket to us. Remember, if you have entered wrong name by mistake, then only we will help you. We require ID proof.</p>
											</div> 
										</div>
										<?php 
										} 
										?>	
										 <br />
										
											
										<div class="form-actions">
											<button type="submit" name="submit" class="btn btn-primary" value="submit">Save</button> 
											<button type="reset" class="btn">Cancel</button>
										</div> 
									</fieldset>
								</form>
						
						
					</div>
				</div></div>
			
			
			
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

if(isset($_SESSION['profile_update'])){ unset($_SESSION['profile_update']); }

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
