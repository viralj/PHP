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

function send_email($email_id, $sub, $msg){

include $_SERVER['DOCUMENT_ROOT'].'/core/db_config_inc.php';

$to = $email_id;

//message body
$msg_body = wordwrap($msg, 70, "\r\n");

$msg_body = trim(htmlentities($msg_body));

// message
$message = '
<!DOCTYPE html>
<html lang="en" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-family: sans-serif;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;font-size: 62.5%;-webkit-tap-highlight-color: rgba(0,0,0,0);">
<head style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;">
<meta charset="utf-8" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;">
<meta http-equiv="X-UA-Compatible" content="IE=edge" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;">
</head>
<body style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;margin: 0;font-family: Georgia, &quot;Times New Roman&quot;, Times, serif;font-size: 14px;line-height: 1.42857143;color: #555;background-color: #fff;">
<div class="blog-masthead" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;background-color: #428bca;box-shadow: inset 0 -2px 5px rgba(0,0,0,.1);">
<div class="container" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;margin-right: auto;margin-left: auto;padding-left: 15px;padding-right: 15px;">
<nav class="blog-nav" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;display: block;">
<a class="blog-nav-item" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;background: 0 0;color: #cdddeb;text-decoration: underline;position: relative;display: inline-block;padding: 10px;font-weight: 500;"></a>
</nav>
</div>
</div>
<div class="container" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;margin-right: auto;margin-left: auto;padding-left: 15px;padding-right: 15px;">
<div class="blog-header" style="padding-top: 0px;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding-bottom: 20px;">
<h1 class="blog-title" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-size: 60px;margin: .67em 0;font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;font-weight: normal;line-height: 1.1;color: #333;margin-top: 30px;margin-bottom: 0;"><img alt="b89.in" title="b89.in" src="'.$site.'img/logo.png" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;border: 0;vertical-align: middle;page-break-inside: avoid;max-width: 100%!important;"></h1>
</div>
<div class="row" style="width: 100%;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;margin-left: -15px;margin-right: -15px;">
<div class="col-sm-8 blog-main" style="width: 100%;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;position: relative;min-height: 1px;padding-left: 15px;padding-right: 15px;font-size: 18px;line-height: 1.5;">
<div class="blog-post" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;margin-bottom: 60px;">
<br style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;">
'.nl2br($msg_body).'<div>&nbsp;</div>
<div class="blog-footer" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 40px 0;color: #999;text-align: center;background-color: #f9f9f9;border-top: 1px solid #e5e5e5;">
<p style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;orphans: 3;widows: 3;margin: 0 0 10px;font-size:12px;">&copy; 2014 b89.in</p>
<font style="font-size:12px">Contact us at <a href="mailto:support@b89.in" target="_blank">support@b89.in</a></font>
</div>
</div>
</div>
</div>
</div>
</body>
</html>

';

// To send HTML mail, the Content-type header must be set
$headers  = '"MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type:text/html;charset=UTF-8' . "\r\n";

// Additional headers
$headers .= 'To:  <'.$to.'>' . "\r\n";
$headers .= 'From: no-reply@b89.in' . "\r\n";
$headers .= 'Message-Id: <no-reply@b89.in>' . "\r\n";
$headers .= 'Return-Path: support@b89.in' . "\r\n";


// Mail it      

	if(mail($to, $sub, $message, $headers)){
		echo 'Mail sent successfully to '.$to.'.</br>';
	}
	else{
		echo 'Failed to send email to '.$to.'.</br>';
	}
	
}



if((isset($_POST['sub'])) AND (isset($_POST['msg']))){
	
	$sub = $_POST['sub'];
	$msg = $_POST['msg'];
	
	$fetch_users = "SELECT `email` FROM `users` WHERE `active` = '0' AND `type` IN ('free', 'pro', 'busi')";
	
	if($result = $db->query($fetch_users)){
		
		if($result AND $result->num_rows > 0 AND $rows = $result->fetch_all(MYSQLI_ASSOC)){
			
			//from here we will start sending bulk emails.
			foreach($rows as $row){
			
				send_email($row['email'], $sub, $msg);
				usleep(100);
			
			}
			exit();
		}
		else{
			echo '<h3>No active user found.</h3>';
			exit();
		}		
	}
	else{
		echo '<h3>Connection problem. Check connection or codes.</h3>';
		exit();
	}	
}



$admin_site= $site.'manage/admin/';

if((user_is_logged_in()) AND ($_SESSION['u_type'] === 'admin')){

?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>b89.in &raquo; Admin send bulk email.</title>
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
<script type="text/javascript">
function sendEmail(){
	var sub = $('#sub').val();
	var msg = $('#msg').val();
		if(sub == ''){
			alert('Subject is required.');
		}else
		
		if(msg == ''){
			alert('Message is required.');
		}
		else{
			$('#result').html('Working <img src="<?php echo $site;?>img/loading.gif" /><br>');
			$.post('<?php echo $admin_site;?>SendBulkEmail', {sub:sub,msg:msg},
			function(data){
				$('#result').html(data);				
			});
		}		
	}
</script>
</head>
<body>
<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container"> <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><span
                    class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </a><a class="brand" href="<?php echo $admin_site;?>SendBulkEmail">b89.in admin send bulk email</a>
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
		<li><a href="<?php echo $admin_site;?>users"><i class="icon-user"></i><span>Users</span> </a> </li>
		<li class="active"><a href="<?php echo $admin_site;?>SendBulkEmail"><i class="icon-envelope-alt"></i><span>Send bulk email</span> </a> </li>
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
				<span id="result"><br></span>
				<div class="tab-content">
									<div class="tab-pane active" id="formcontrols">
								<form id="sendEmail" class="form-horizontal" enctype="multipart/form-data" method="POST" action="<?php echo $admin_site;?>sendEmail" autocomplete="off">
									<fieldset>
										
										<div class="control-group">											
											<label class="control-label" for="title">To</label>
											<div class="controls">
												<input disabled type="text" class="span6" id="to" name="to" value="All active users" />
												
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
										<div class="control-group">											
											<label class="control-label" for="title">Subject</label>
											<div class="controls">
												<input required type="text" class="span6" id="sub" name="sub" placeholder="Email subject">																								
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
										
										<div class="control-group">											
											<label class="control-label" for="text">Message</label>
											<div class="controls">
												<textarea required type="text" class="span6" rows="8" id="msg" name="msg" placeholder="Your message." ></textarea>
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
									
									<br>
											
										<div class="form-actions">
										<input type="hidden" class="span6" name="cool" value="<?php echo $_SESSION['CSRF_TOKEN'];?>">
											<button type="button" class="btn btn-primary" name="submit" value="sendEmail" onclick="sendEmail();">Submit</button> 
											<button type="reset" class="btn">Cancel</button>
										</div> <!-- /form-actions -->
									
									
									
									</fieldset>
								</form>
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