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



if((isset($_POST['email'])) AND (isset($_POST['type'])) AND $_POST['type'] === 'forgot'){
	
	$get_user = "SELECT `active` FROM `users` WHERE `email` = '{$_POST['email']}' LIMIT 1";
	
	if($result = $db->query($get_user) AND $result->num_rows > 0 AND $rows = $result->fetch_array(MYSQLI_ASSOC)){
		
		if($rows['active'] == 0){

//lets send email with valid information

$key = md5(time());
$expire_time = time() + 300;
$email = $_POST['email'];

	$insert_forgot_pass = "INSERT INTO `forgot` (
							`email`, `key`, `exptime`
							) VALUES (
							'$email', '$key', '$expire_time'
							)";

							
		if($db->query($insert_forgot_pass) AND $db->affected_rows > 0){
			
			//send email from here.
			
$to = $email;
// subject
$subject = 'Forgot password request.';

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
<div class=blog-post>
<h2 class=blog-post-title>Hello,</h2>
<br>
<p>This email will help you to reset your <b><i>b89.in</i></b> account\'s password. If you didn\'t request for new password please ignore this email. You can change your password from your account. We strongly suggest to change password from your account if you didn\'t request for your this email and also change your email password too.</p>
<hr>
<blockquote>
<p>Please click on link given <em>below</em> to reset your account\'s password. If you can\'t click on that link, please copy this link and paste in your browser.</p>
</blockquote>
<pre><code><a title=\"Reset password\" alt=\"Reset Password\" href='.$site.'forgotpass?e='.$email.'&key='.$key.' target=\"_blank\" >'.$site.'forgotpass?e='.$email.'&key='.$key.'</a></code></pre>
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
</html>';

// To send HTML mail, the Content-type header must be set
$headers  = '"MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type:text/html;charset=UTF-8' . "\r\n";

// Additional headers
$headers .= 'To: '.$to.' <'.$to.'>' . "\r\n";
$headers .= 'From: no-reply@b89.in' . "\r\n";
$headers .= 'Message-Id: <no-reply@b89.in>' . "\r\n";
$headers .= 'Return-Path: support@b89.in' . "\r\n";


// Mail it      

	if(mail($to, $subject, $message, $headers)){
		
		echo 'Mail sent successfully to <u>'.$to.'</u>. Please check your mail inbox for more information.';
		exit();
		
	}
	else{
		echo 'Failed to send email to '.$to.'. Please contact us from <a href="'.$site.'about?redirect#contact">here</a>.<br>';
		exit();
	}


		}
		else{
			echo 'We are unable to process your request. Please try again after sometime or contact us from <a href="'.$site.'about?redirect#contact">here</a>.';
			exit();
		}


//email sending work is completed			
		}
		else{
			echo 'Your account is deactivated.';
			exit();
		}
		
	}
	else {
		echo 'We can\'t find user associated with email address <b>'.$_POST['email'].'</b>. Please check your email address.';
		exit();
	}
	
}

if((isset($_GET['plan']))){
if(($_GET['plan']==='pro') OR ($_GET['plan']==='busi')){
	$alert = '<script language="Javascript">
					bootbox.alert("<b>You need to login to choose your plan.</b><br><br>If you don\'t have account, simply sign up from <a href=\"'.$site.'\">here</a>. Once you create your account, you can choose your plan from your account.<hr>Or if you have b89.in account you can login to purchase plan. ");
					</script>
						';
	
}	
	}

if(isset($_POST['type'])){

	$type = $db->real_escape_string(htmlentities($_POST['type']));

	if($type == 'login'){
	
	include $_SERVER['DOCUMENT_ROOT'].'/core/encryption.php';
	
	$email = trim($db->real_escape_string(htmlentities($_POST['email'])));
	$pass1 = trim($db->real_escape_string(htmlentities($_POST['pass'])));
	$cool  = trim($db->real_escape_string(htmlentities($_POST['cool'])));

$blah = new Encryption();
	$pass  = $blah->encode($pass1);
	
		if($cool == $_SESSION['CSRF_TOKEN']){
			
			//lets check for empty post data
			if(empty($email)){
				$alert = '
					<script language="Javascript">
						bootbox.alert("Your email is required for login.");
					</script>
					';
			}
			
			if(empty($pass1)){
				$alert = '
					<script language="Javascript">
						bootbox.alert("Your password is required for login.");
					</script>
					';
			}
			
			//lets work for login process
			
			
				if($result = $db->query("SELECT * FROM `users` WHERE BINARY (`email` = '$email' OR `uname` = '$email') AND `pass` = '$pass' LIMIT 1") and $result->num_rows){
				$result = mysqli_fetch_assoc($result);
					
				//we also need to check that user account is active or not.
				
					if($result['active'] == 0){
					
						$usr_type = array('admin', 'helper', 'free', 'pro', 'busi');
						if(in_array($result['type'], $usr_type)){
						$_SESSION['u_type'] = $result['type'];
						} else {
							die('We are very sorry but looks like something is really messed up. Please contact us using contact form <a href="'.$site.'about?redirect#contact">here</a>.<br><br>If you\'ve used <b>Username</b> we suggest you to try with your <b>Email</b> to login. Don\'t forget to report us.');
						}
					
						$_SESSION['email']  = $result['email'];
						$_SESSION['uid']    = $result['uid'];
						$_SESSION['hash']   = $result['hash'];
						$_SESSION['usert']  = time();
						$_SESSION['userts'] = md5(md5(time()));
									
						if(!empty($result['uname'])){
							$_SESSION['uname'] = $result['uname'];
						}						
						
						if(!empty($result['fname'])){
							$_SESSION['fname'] = $result['fname'];
						}
						
						if(!empty($result['lname'])){
							$_SESSION['lname'] = $result['lname'];
						}
						
							if($result['type'] == 'admin'){
								$user_area = $site.'manage/admin/home';
							}
							else
							if($result['type'] == 'helper'){
								$user_area = $site.'manage/home';
							}
							else 
							if(($result['type'] == 'free') OR ($result['type'] == 'pro') OR ($result['type'] == 'busi')){
								$user_area = $site.'user/v1/home';
							} else {
								$alert = '
										<script language="Javascript">
											bootbox.alert("We are very sorry but looks like something is really messed up. Please contact us using contact form <a href="'.$site.'about">here</a>.");
										</script>
										';
							}
				
					}
					else {
						$current_u_time = time();
						$enc_time = $blah->encode(time());
						$enc_ip = $blah->encode($_SESSION['ip']);
						$account_deactivated = $site.'deactivated?h='.$result['hash'].'&i='.$enc_ip.'&t='.$enc_time;
						header("Location: $account_deactivated");
					}
				
				
				} else {
				$alert = '
					<script language="Javascript">
						bootbox.alert("<b>Oopppsss!</b><br><br>Check your login detials. You entered incorrect combination.");
					</script>
					';		
				}
						
		} else {
				$alert = '
					<script language="Javascript">
						bootbox.alert("<b>Oopppsss!</b><br><br>We faced some unwanted errors. Please try again.");
					</script>
					';		
				}
	
	} else if($type == 'forgot'){
	$email = $db->real_escape_string(htmlentities($_POST['email']));
	
		
	}
	
}
	
else{

/*$alert = '
	<script language="Javascript">
bootbox.alert("Are you sure?");
</script>
	';
*/
//$alert = '';
}

if((isset($_GET['error'])) AND (isset($_SESSION['lo_er'])) AND (!empty($_SESSION['lo_er']))){
		$alert = '
			<script language="Javascript">
				bootbox.alert("You must be logged in to access.");
			</script>
			';
	unset($_SESSION['lo_er']);
}

if(!user_is_logged_in()){
?><!DOCTYPE html>
<html>
<head>
<title>b89.in &raquo; Login</title>
 <link rel="shortcut icon" href="<?php echo $site; ?>flat-ui/images/favicon.ico">
        <link rel="stylesheet" href="<?php echo $site; ?>flat-ui/bootstrap/css/bootstrap.css">
 		<script src="<?php echo $site; ?>common-files/js/jquery-1.10.2.min.js"></script>
        <script src="<?php echo $site; ?>flat-ui/js/bootstrap.min.js"></script>
        <script src="<?php echo $site; ?>common-files/js/modernizr.custom.js"></script>
        <script src="<?php echo $site; ?>common-files/js/startup-kit.js"></script>
        <script src="<?php echo $site; ?>js/bootbox.min.js"></script>
<script>$(document).ready(function(){$(document).mousemove(function(e){TweenLite.to($('body'),.5,{css:{'background-position':parseInt(event.pageX/8)+"px "+parseInt(event.pageY/12)+"px, "+parseInt(event.pageX/15)+"px "+parseInt(event.pageY/15)+"px, "+parseInt(event.pageX/30)+"px "+parseInt(event.pageY/30)+"px"}})})});</script>
<style>
body{background-color:#444;background:url(<?php echo $site;?>img/login/pinlayer2.png),url(<?php echo $site;?>img/login/pinlayer1.png),url(<?php echo $site;?>img/login/back.png)}
.vertical-offset-100{padding-top:100px}
</style>
<script type="text/javascript">
$(document).ready(function() {
  $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
});
</script>
<script type="text/javascript">
function forgotPass(){
	var type  = $('#type').val();
	var forgemail = $('#forgemail').val();
	var cool = $('#cool').val();
	var submit = $('#submit').val();
	var form = $('#forgotModal').html();
$('#forgotModal').html('Working <img src="<?php echo $site;?>img/loading.gif" /><br>');
		$.post('<?php echo $site;?>login', {type:type,email:forgemail,cool:cool,submit:submit},
		function(data){
			if(forgemail == ''){
				bootbox.alert('Plese enter your email address.');
				$('#forgotModal').html(form);
			}else{
				$('#forgotModal').html(data);
			}
		});
}
</script>
</head>
<body>
<script src="<?php echo $site;?>js/login.js"></script>
<?php if(isset($alert)){echo $alert;}?>
<div class="container">
    <div class="row vertical-offset-100">
    	<div class="col-md-4 col-md-offset-4">
    		<div class="panel panel-default">
			  	<div class="panel-heading">
			    	<div align="center" style="padding-bottom:15px;"><img src="<?php echo $site;?>img/login_logo.png" title="b89.in" alt="b89.in"/></div>
                    <h3 class="panel-title">Please sign in</h3>
			 	</div>
			  	<div class="panel-body">
			    	<form accept-charset="UTF-8" role="form" action="<?php echo $site;?>login" method="post" autocomplete="off">
                    <input required type="hidden" name="type" value="login">
                    <fieldset>
			    	  	<div class="form-group">
	<input class="form-control" placeholder="E-mail or Username" id="email" name="email" autofocus required aria-invalid="true" maxlength="200" autocomplete="off">
			    		</div><p class="help-block"></p>
			    		<div class="form-group">
			    			<input class="form-control" placeholder="Password" name="pass" type="password" required autocomplete="off">
			    		</div>
			    		<div class="checkbox">
                            <label style="float:left">
			    	    		<a href="#" data-toggle="modal" data-target="#forgotPass">Forgot password?</a>
			    	    	</label>
							<label style="float:right; padding-right:20px;">
			    	    		<a href="<?php echo $site;?>" title="Back to home" alt="Back to home">Back to home.</a>
			    	    	</label>
			    	    </div>
                        <input type="hidden" name="cool" id="cool" class="clear" value="<?php echo $_SESSION['CSRF_TOKEN'];?>" /> 
			    		<input class="btn btn-lg btn-success btn-block" type="submit" value="Login">
			    	</fieldset>
			      	</form>

<div class="modal fade" id="forgotPass" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Forgot password?</h4>
      </div>
      
      <div id="forgotModal" class="modal-body">
	  <p><b>Note</b>: Please open your email account in new window so you can access email. Because your reset password link will expire within next <u>5 minutes</u> after sending email. This is for your account's security.</p><hr>
	  
        <form enctype="multipart/form-data" action="<?php echo $site?>login" method="post" autocomplete="off">
    <input id="type" type="hidden" name="type" value="forgot"  required>    
 <input class="form-control" placeholder="Enter your email to get new password." type="email" id="forgemail" name="email" required aria-invalid="true" maxlength="200" autocomplete="off">
	<input type="hidden" name="cool" id="cool" class="clear" value="<?php echo $_SESSION['CSRF_TOKEN'];?>" /> 
            <br><button class="btn btn-primary" type="button" value="submit" id="submit" name="submit" onclick="forgotPass();">Submit</button>
		 </form> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        
      </div>
      
    </div>
  </div>
  

</div>

			    </div>
			</div>
		</div>
	</div>
</div>
<?php 
if(isset($analytics)){
	echo $analytics;
	} 
 
?> 
</body>
</html><?php } else {
				if(isset($_SESSION['u_type'])){
					
					if($_SESSION['u_type'] == 'admin'){
						$user_area = $site.'manage/admin/home';
					}
					else
					if($_SESSION['u_type'] == 'helper'){
						$user_area = $site.'manage/home';
					}
					else 
					if(($_SESSION['u_type'] == 'free') OR ($_SESSION['u_type'] == 'pro') OR ($_SESSION['u_type'] == 'busi')){
						$user_area = $site.'user/v1/home';
					}
				}
	
	header("Location: $user_area");
	}?>