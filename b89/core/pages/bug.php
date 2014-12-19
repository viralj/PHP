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


 if(isset($_POST['submit']))
 {
    $name  = trim($db->real_escape_string(htmlentities($_POST['name'])));
	$email = trim($db->real_escape_string(htmlentities($_POST['email'])));
	$title = trim($db->real_escape_string(htmlentities($_POST['title'])));
	$msg   = trim($db->real_escape_string(htmlentities($_POST['message'])));
	$level = trim($db->real_escape_string(htmlentities($_POST['level'])));
	$cool  = trim($db->real_escape_string(htmlentities($_POST['cool'])));

	//if session and $cool are same, proceed for form submission
	
	if(isset($cool) AND ($cool == $_SESSION['CSRF_TOKEN'])){
	
		if(!isset($_SESSION['submit'])){
	
			//lets check that post data are empty or not.
			
			if(empty($name)){
				$errors[] = 'Your name is required.';
			}
			if(empty($email)){
				$errors[] = 'Your email is required.';
			}
			if(empty($title)){
				$errors[] = 'Please tell us about bug in brief.';
			}
			if(empty($msg)){
				$errors[] = 'Please tell us what have you found in our system.';
			}
			if(empty($level)){
				$errors[] = 'Please tell us the effect level of vulnerability you found in our system.';
			}
			//check level value
			$vul_level= array('low', 'medium', 'high');
			if(!in_array($level, $vul_level)){
				$errors[] = 'We need to now effect level only.';
			}	
			
			//check message string length
			if(strlen($msg) < 100){
				$errors[] = 'Please describe what you found in our system.';
			}
			if(strlen($msg) > 8000){
				$errors[] = 'You\'ve said to much about vulnerability you found in our system.';
			}
			
			
			//check description length
			if(strlen($title) < 5){
				$errors[] = 'Your bug description is too small.';
			}
			if(strlen($title) > 200){
				$errors[] = 'Your bug description is too large to read.';
			}
			
			
			//if errors accord then show errors
			if(!empty($errors)){
			
				$error = '';
				foreach($errors as $err){
				$error .= '<li>'.$err.'</li>';
				}
		
			$alert = '
			<script>
			bootbox.dialog({
			  message: "<div align=\"left\"><b>Errors:</b><br><ul>'.$error.'</ul></div>",
			  title: "We got some errors.",
			  buttons: {
				
				danger: {
				  label: "Okay!",
				  className: "btn-danger",
				},    
			  }
			});
			</script>';
			
			}	
			//else proceed to stylesheet
			else {
							
				$charset = '0123456789ABCD';
				$len = 7;
				$numrows = 1;
				$code = '';
			
				while($numrows != 0){
					for($i = 0; $i <= $len; $i++){
						$rand = rand()% strlen($charset);
						$temp = substr($charset, $rand, 1);
						$code .= $temp;
					}
				
					$find = $db->query("SELECT * FROM `vul_report` WHERE BINARY `vul_id` = '$code'");
					$numrows = $find->num_rows;
				}
				
				$ip = $_SESSION['ip'];
				$date = date("F j, Y, g:i a");
				 $query = "INSERT INTO `vul_report` (`name`, `email`, `title`, `msg`, `level`, `date`, `vul_id`, `ip`, `read`) VALUES ('$name', '$email', '$title', '$msg', '$level', '$date', '$code', '$ip', '0');";

				
				//lets try to put data in database
				
					if($result = $db->query($query) AND $db->affected_rows > 0){
						$_SESSION['submit'] = $name.'/'.$email.'/'.$code;

// recipients
$to = $email;

// subject
$subject = 'Thank you for reporting bug to b89.in';

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
<p><h3>Thank you '.$name.',</h></p>
We have received your bug report and we will process for it soon. You can also check status of your reported bug at <a target="_blank" href="'.$site.'status">'.$site.'status</a>.<br><br>
We will notify you by email when we will patch this bug. If you want to know status of your bug by email, please contact us <a target="_blank" href="'.$site.'about?redirect#contact">here</a> and don\'t forget to mention your bug id #<b>'.$code.'</b>.<br><br>
<strong>Note:</strong> Do not tell anyone about this vulnerability in b89.in system until we fix it else you will be violating our policies by doing this.<br><br>
You co-operation is valuable.<br>
Team b89.in
<div>&nbsp;</div>
<div class="blog-footer" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 40px 0;color: #999;text-align: center;background-color: #f9f9f9;border-top: 1px solid #e5e5e5;">
<p style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;orphans: 3;widows: 3;margin: 0 0 10px;font-size:12px;">&copy; 2014 b89.in</p>
<br>
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
$headers .= 'To: '.$name.' <'.$email.'>' . "\r\n";
$headers .= 'From: no-reply@b89.in' . "\r\n";
$headers .= 'Message-Id: <no-reply@b89.in>' . "\r\n";
$headers .= 'Return-Path: support@b89.in' . "\r\n";


// Mail it      

	mail($to, $subject, $message, $headers);
	

						$alert = '<script>
							bootbox.dialog({
							message: "<div align=\"left\">Thank you <b>'.$name.'</b> for reporting us vulnerability in our system. We have sent you conformation email to your email account at <b>'.$email.'</b>.<hr>Please check your email inbox or spam folder for more information. We do not spam anyone.<hr>** Your bug id is <b><u>'.$code.'</u></b> that you can use to track process.</div>",
							title: "We have received your report.",
							buttons: {
													
								danger: {
								label: "Okay!",
								className: "btn-success",
								},    
								}
								});
							</script>';					
					}
						//else show error that we could not proceed
						else {
						
						$alert = '<script>
						bootbox.dialog({
						message: "<div align=\"left\">We are sorry but please try once again. We got an error while processing.</div>",
						title: "There was an error.",
						buttons: {
												
							danger: {
							label: "Okay!",
							className: "btn-danger",
							},    
							}
							});
						</script>';					
						}
				
								
			}
		} else {
			$alert = '<script>
				bootbox.dialog({
				message: "<div align=\"left\">You\'ve just submit a vulnerability report to us and we have received it. Please check your inbox for more information.</div>",
				title: "There was an error.",
				buttons: {
										
					danger: {
					label: "Okay!",
					className: "btn-danger",
					},    
					}
					});
				</script>';
					
					
		}
	
	} else {
	
		$alert = '<script>
			bootbox.dialog({
			message: "<div align=\"left\">We just faced some unexpected error. Please try again.</div>",
			title: "We faced a problem.",
			buttons: {
									
				danger: {
				label: "Okay!",
				className: "btn-danger",
				},    
				}
				});
			</script>';
	
	}
	
  }
/*
  <script>
bootbox.dialog({
message: "<div align=\"left\">We are very sorry that we were not able to process your contact form. We request you to try again or contact us after some time.<hr><h3>What should have happened?</h3><ul><li>We might be facing connection issue with server.</li><li>There might me some technical issue.</li></ul><hr><h3>What you can do now?</h3><ul><li>Try once again to contact us now.</li><li>Try to contact us after sometime.</li><li>If you are user of our service, you can log into your account and can submit a ticket.</li></ul></div>",
title: "We faced a problem.",
buttons: {
						
	danger: {
	label: "Okay!",
	className: "btn-danger",
	},    
	}
	});
</script>
 */ 
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>b89.in &raquo; Report a security vulnerability to us.</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?php echo $site;?>flat-ui/images/favicon.ico">
    <link href="<?php echo $site;?>css/bootstrap.min2.css" rel="stylesheet">
    <link href="<?php echo $site;?>css/bootstrap-responsive.min.css" rel="stylesheet">
	
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Icons -->
    <link href="<?php echo $site;?>css/general_foundicons.css" media="screen" rel="stylesheet" type="text/css" />  
    <link href="<?php echo $site;?>css/social_foundicons.css" media="screen" rel="stylesheet" type="text/css" />
    <!--[if lt IE 8]>
        <link href="<?php echo $site;?>css/general_foundicons_ie7.css" media="screen" rel="stylesheet" type="text/css" />
        <link href="<?php echo $site;?>css/social_foundicons_ie7.css" media="screen" rel="stylesheet" type="text/css" />
    <![endif]-->
    <link rel="stylesheet" href="<?php echo $site;?>css/font-awesome.min2.css">
    <!--[if IE 7]>
        <link rel="stylesheet" href="<?php echo $site;?>css/font-awesome-ie7.min.css">
    <![endif]-->

    <link href="<?php echo $site;?>css/style3.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $site;?>css/yoxview.css" rel="stylesheet" type="text/css" />
    <link href="http://fonts.googleapis.com/css?family=Syncopate" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Abel" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Pontano+Sans" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Oxygen" rel="stylesheet" type="text/css">
	
    <script src="<?php echo $site;?>js/jquery.js"></script>
    <script src="<?php echo $site;?>js/bootstrap.min.js"></script>
    <script src="<?php echo $site; ?>js/bootbox.min.js"></script>
	

    <link href="<?php echo $site;?>css/custom.css" rel="stylesheet" type="text/css" />
<!-- input validation.  
 <script src="<?php echo $site;?>js/validation.js" type="text/javascript"></script>
-->
<style>
h4{border-bottom:1px solid #fff;padding-top:10px}
.btn-danger{color:#fff;background-color:#d9534f;outline:0;-webkit-border-radius:0;-moz-border-radius:0;text-transform:uppercase;text-shadow:none;-webkit-box-shadow:none;-moz-box-shadow:none;box-shadow:none;display:inline-block;font-weight:400;text-align:center;vertical-align:middle;cursor:pointer;background-image:none;border:1px solid transparent;white-space:nowrap;font-size:14px;line-height:1.42857143;border-radius:4px;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;-webkit-appearance:button;overflow:visible;font:inherit;box-sizing:border-box;align-items:flex-start;letter-spacing:normal;word-spacing:normal;text-indent:0;border-color:#d43f3a;margin:0;padding:6px 12px}
</style>
</head>
<body >

<?php
if(isset($alert)){
	echo $alert;
}
?>

<div id="divBoxed" class="container">

    <div class="transparent-bg" style="position: absolute;top: 0;left: 0;width: 100%;height: 100%;z-index: -1;zoom: 1;"></div>

    <div class="divPanel notop nobottom">
            <div class="row-fluid">
                <div class="span12">

                    <div id="divLogo" class="pull-left">
                        
                        <img src="<?php echo $site;?>img/logo.png" title="b89.in"/>
                        
                    </div>

                    <div id="divMenuRight" class="pull-right">
                    <div class="navbar">
                        <button type="button" class="btn btn-navbar-highlight btn-large btn-primary" data-toggle="collapse" data-target=".nav-collapse">
                        NAVIGATION <span class="icon-chevron-down icon-white"></span>
                        </button>
                            <div class="nav-collapse collapse">
                            <ul class="nav nav-pills ddmenu">
                            <li><a href="<?php echo $site;?>">Home</a></li>
                            <li class="dropdown">
								<a>More <b class="caret"></b></a>
								<ul class="dropdown-menu">                            
									<li><a href="<?php echo $site;?>about">About</a></li>
									<li><a href="<?php echo $site;?>terms">Terms</a></li>
									<li><a href="<?php echo $site;?>privacy">Privacy Policies</a></li>							
								    <?php 
										if(user_is_logged_in()){
								   ?>
<form id="loform" action="<?php echo $site;?>logout" method="POST">
<input type="hidden" name="cool" value="<?php echo $_SESSION['CSRF_TOKEN']?>" /><input type="hidden" name="lo" value="logout" /><input type="hidden" name="em" value="<?php echo substr(md5($_SESSION['email']), 0, 10);?>" /><input type="hidden" name="ut" value="<?php echo substr(md5($_SESSION['u_type']), 0, 10); ?>" />
						<li><a href="javascript:{}" onclick="document.getElementById('loform').submit();">Log Out</a></li>
</form>
								   <?php 
									   }
								   ?>
								
								</ul>
                            </li>
						    <li class="active"><a href="<?php echo $site;?>bugreport">Bug</a></li>
                           <?php 
							if(!user_is_logged_in()){
						   ?>
						   <li><a href="<?php echo $site;?>login">Sign In</a></li>
                           <?php 
						   }
						   ?> 
							
							</ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="row-fluid">
                <div class="span12">
                    <div id="contentInnerSeparator"></div>
                </div>
            </div>
    </div>

    <div class="contentArea">

        <div class="divPanel notop page-content">

            <div class="breadcrumbs">
                <a href="<?php echo $site;?>">Home</a> &nbsp;/&nbsp; <span>Bug report</span>
            </div>
            	
            <div class="row-fluid">
                <div class="span8" id="divMain">

                    <h3>Submit the vulnerability that you found in our system,</h3>
                   	<h3 style="color:#FF6633;"></h3>
					<hr>
			<!--Start Contact form -->		                                                
<form name="enq" method="post" action="<?php echo $site;?>bugreport" autocomplete="off">
  <fieldset>
    
	<input type="text" name="name" id="name" class="input-block-level" 
	
		<?php 
			if((isset($_SESSION['fname'])) AND (isset($_SESSION['lname']))){
			echo 'value="'.$_SESSION['fname'].' '.$_SESSION['lname'].'"';
			} else {
				echo 'placeholder="Name"';
			}
		?>

	required />
    <input type="email" name="email" id="email" class="input-block-level" 
	<?php 
		if(isset($_SESSION['email'])){
		echo 'value="'.$_SESSION['email'].'"';
		} else {
			echo 'placeholder="Email"';
		}
	?>
	 required />
	<input type="text" name="title" class="input-block-level" placeholder="Brief description of bug" required/>
	<input type="hidden" name="cool" value="<?php echo $_SESSION['CSRF_TOKEN'];?>"/>
    <textarea rows="11" name="message" id="message" class="input-block-level" placeholder="Tell us more about what you've found in our system." required></textarea>
    <p>Vulnerability effect level: 
		<select name="level" class="selectpicker" required>
		  <option></option>
		  <option value="low">Low</option>
		  <option value="medium">Medium</option>
		  <option value="high">High</option>
		</select>
	</p>
	<div class="actions">
    <p style="font-size:12px;">By clicking on submit button, you agree to our vulnerability reporting terms and conditions given below.</p>
	<button type="submit" value="submit" name="submit" id="submitButton" class="btn btn-info pull-right" title="Click here to submit your report.">Submit your report	</button>
	</div>
	
	</fieldset>
</form>  				 
			<!--End Contact form -->											 
                </div>
				
			<!--Edit Sidebar Content here-->	
                <div class="span4 sidebar">

                    <div class="sidebox">
                            
                     
					 <!-- Start Side Categories -->
        <h4 class="sidebox-title">We accept reports of following bugs.</h4>
        <ul>
          <li>SQL Injection</li>
          <li>Broken Authentication and Session Management</li>
          <li>Cross-Site Scripting (XSS)</li>
          <li>Insecure Direct Object References</li>
          <li>Security Misconfiguration</li>
          <li>Sensitive Data Exposure</li>
          <li>Missing Function Level Access Control</li>
          <li>Cross-Site Request Forgery (CSRF)</li>
          <li>Unvalidated Redirects and Forwards</li>
          <li>Any other bugs that you found in our system</li>
        </ul>
        
        <!-- <div>View all reported bugs here.</div> -->
					<!-- End Side Categories -->
                    					
                    </div>
					
					
                    
                </div>
			<!--/End Sidebar Content-->
				
				
            </div>			

            <div id="footerInnerSeparator"></div>
        </div>
    </div>

    <div id="footerOuterSeparator"></div>

    <div id="divFooter" class="footerArea">

        <div class="divPanel">

<div>
<h3>Vulnerability reporting policy</h3>
<p>The b89.in security team acknowledges the valuable role that independent security researchers play in Internet security. Keeping our customers’ data secure is our number-one priority, and we encourage responsible reporting of any vulnerabilities that may be found in our site or application. b89.in is committed to working with the security community to verify and respond to any potential vulnerabilities that are reported to us. Additionally, b89.in pledges not to initiate legal action against security researchers for penetrating or attempting to penetrate our systems as long as they adhere to the conditions below.</p>
<h4>Testing for security vulnerabilities</h4>
<p>Conduct all vulnerability testing against Trial or Developer Edition organizations (instances) of our online services to minimize the risk to our customers’ data.</p>
<h4>Reporting a potential security vulnerability</h4>
<ul class="bullet">
    <li>Privately share details of the suspected vulnerability with b89.in by sending details to our security team using our reporting tool with proper evidence which you can send us in image format. We do not accept any images to upload on our server, but you can send us your image link.</li>
    <li>Provide full details of the suspected vulnerability so the b89.in security team may validate and reproduce the issue</li>
</ul>
<h4>b89.in does not permit the following types of security research</h4>
<ul class="bullet">
    <li>Causing, or attempting to cause, a Denial of Service (DoS) condition</li>
    <li>Accessing, or attempting to access, data or information that does not belong to you</li>
    <li>Destroying or corrupting, or attempting to destroy or corrupt, data or information that does not belong to you</li>
</ul>
<h4>The b89.in security team commitment</h4>
<p>To all security researchers who follow this b89.in Vulnerability Reporting Policy, the b89.in security team commits to the following:</p>
<ul class="bullet">
    <li>To respond in a timely manner, acknowledging receipt of your report</li>
    <li>To provide an estimated time frame for addressing the vulnerability</li>
    <li>To notify the reporting individual when the vulnerability has been fixed</li>
</ul>
<h4>No compensation</h4>
<p>b89.in does not compensate people for reporting a security vulnerability, and any requests for such compensation will be considered a violation of the conditions above. All indevidual security resarcher will get listed on our list of Security Hall of Fame at <a href="<?php echo $site;?>bugreport/hall-of-fame">here</a>.</p></div>

<br>
            <div class="row-fluid">
                <div class="span12">
                    <p class="copyright">
                        Copyright © <?php echo date("Y");?> b89.in</p>

                </div>
            </div>

    </div>
</div>


<script src="<?php echo $site;?>js/jquery.min.js" type="text/javascript"></script> 
<script src="<?php echo $site;?>js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo $site;?>js/default.js" type="text/javascript"></script>

<script src="<?php echo $site;?>js/jquery.wookmark.js" type="text/javascript"></script>
<script type="text/javascript">$(window).load(function () {var options = {autoResize: true,container: $('#gridArea'),offset: 10};var handler = $('#tiles li');handler.wookmark(options);$('#tiles li').each(function () { var imgm = 0; if($(this).find('img').length>0)imgm=parseInt($(this).find('img').not('p img').css('margin-bottom')); var newHeight = $(this).find('img').height() + imgm + $(this).find('div').height() + $(this).find('h4').height() + $(this).find('p').not('blockquote p').height() + $(this).find('iframe').height() + $(this).find('blockquote').height() + 5;if($(this).find('iframe').height()) newHeight = newHeight+15;$(this).css('height', newHeight + 'px');});handler.wookmark(options);handler.wookmark(options);});</script>
<script src="<?php echo $site;?>js/yox.js" type="text/javascript"></script>
<script src="<?php echo $site;?>js/jquery.yoxview-2.21.js" type="text/javascript"></script>
<script type="text/javascript">$(document).ready(function () {$('.yoxview').yoxview({autoHideInfo:false,renderInfoPin:false,backgroundColor:'#ffffff',backgroundOpacity:0.8,infoBackColor:'#000000',infoBackOpacity:1});$('.yoxview a img').hover(function(){$(this).animate({opacity:0.7},300)},function(){$(this).animate({opacity:1},300)});});</script>

<?php
/*
<!--<li class="dropdown">
                            <a href="page.html" class="dropdown-toggle">Page <b class="caret"></b></a>
                            <ul class="dropdown-menu">                            
                            <li><a href="full.html">Full Page</a></li>
                            <li><a href="2-column.html">Two Column</a></li>
                            <li><a href="3-column.html">Three Column</a></li>
							<li><a href="../documentation/index.html">Documentation</a></li>
							<li class="dropdown">
                            <a href="#" class="dropdown-toggle">Dropdown Item &nbsp;&raquo;</a>
                            <ul class="dropdown-menu sub-menu">
                            <li><a href="#">Dropdown Item</a></li>
                            <li><a href="#">Dropdown Item</a></li>
                            <li><a href="#">Dropdown Item</a></li>
                            </ul>
                            </li>
                            </ul>
                            </li> -->

*/

if(isset($analytics)){
	echo $analytics;
	} 

?>


</body>
</html>
