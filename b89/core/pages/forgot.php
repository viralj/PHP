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


//forgot password class starts from here


class ForgotPass {
	
	public static function get_user(){
		include $_SERVER['DOCUMENT_ROOT'].'/core/db_config_inc.php';
	
	
		if((isset($_GET['e'])) AND (isset($_GET['key']))){
			
			$email = trim($db->real_escape_string(htmlentities($_GET['e'])));
			$key   = trim($db->real_escape_string(htmlentities($_GET['key'])));
			
			$get_forgot_details = "SELECT `exptime` FROM `forgot` WHERE BINARY `email` = '$email' AND BINARY `key` = '$key' ORDER BY `id` DESC LIMIT 1";
			
			if($result = $db->query($get_forgot_details) AND $result->num_rows > 0 AND $rows = $result->fetch_array(MYSQLI_ASSOC)){
				
				if($rows['exptime'] > time()){
				echo '<form accept-charset="UTF-8" role="form" action="'.$site.'forgotpass" autocomplete="off">
                    <input required type="hidden" name="type" value="login">
                    <fieldset>
					<span id="result"></span>
			    	  	<div class="form-group">
	<input class="form-control" placeholder="Password" id="pass1" name="pass1" autofocus required aria-invalid="true" type="password" maxlength="200" autocomplete="off">
			    		</div><p class="help-block"></p>
			    		<div class="form-group">
			    			<input class="form-control" placeholder="Confirm Password" name="pass2" id="pass2" type="password" maxlength="200" required autocomplete="off">
			    		</div>
			    		<div class="checkbox">
                            <label style="float:left">
			    	    		<a href="'.$site.'login" title="Login" alt="Login">Login here.</a>
			    	    	</label>
							<label style="float:right; padding-right:20px;">
			    	    		<a href="'.$site.'" title="Back to home" alt="Back to home">Back to home.</a>
			    	    	</label>
			    	    </div>
                        <input type="hidden" name="e" id="e" class="clear" value="'.$_GET['e'].'" /> 
                        <input type="hidden" name="cool" id="cool" class="clear" value="'.$_SESSION['CSRF_TOKEN'].'" /> 
			    		<input class="btn btn-lg btn-success btn-block" type="button" value="Reset Password" onclick="forgotPass();">
			    	</fieldset>
			      	</form>';
				}
				else{
					echo 'Your links is expired. Please try again to reset your password.<hr>Click <a>here</a> to try again.<hr>Remember, your password reset link will expire after 5 minutes when email was sent.';
				}
				
			}
			else {
				echo 'We are facing some problem. Please try again.';
			}
			
		}
		
		else {
			header("Location: $site");
		}
	
	}

}

///// forgot password class ends here.

if((isset($_POST['pass1'])) AND (isset($_POST['pass2'])) AND (isset($_POST['cool'])) AND $_POST['cool'] == $_SESSION['CSRF_TOKEN']){
	
	if(!isset($_SESSION['pass'])){
		include $_SERVER['DOCUMENT_ROOT'].'/core/encryption.php';
		$blah = new Encryption();
		$pass  = $blah->encode($_POST['pass1']);
		
		$update_pass = "UPDATE `users` SET `pass` = '$pass' WHERE BINARY `email` = '{$_POST['e']}'";
		
		if($db->query($update_pass) AND $db->affected_rows > 0){
			echo 'Congratulations!<br>Your password is now changed.';
			$_SESSION['pass'] = 'true';
			exit();
		}
		else{
			echo 'We faced error to update your password. Please try again or tell us this issue.';
			exit();
		}
	}
	else{
		echo 'You have just changed your password.';
		exit();
	}
}


if(!user_is_logged_in()){
?><!DOCTYPE html>
<html>
<head>
<title>b89.in &raquo; Forgot password</title>
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
	var cool = $('#cool').val();
	var e = $('#e').val();
	var pass1 = $('#pass1').val();
	var pass2 = $('#pass2').val();
		$.post('<?php echo $site;?>forgotpass', {pass1:pass1,pass2:pass2,cool:cool,e:e},
		function(data){
			if(pass1.length < 6 ){
				bootbox.alert('Password is too small. 6-32 characters only.');
			}else
			if(pass1 == '' || pass2 == ''){
				bootbox.alert('Password fields required.');
			}else
			if(pass1 != pass2){
				bootbox.alert('Passwords are not matching.');
			}
			else{
			$('#result').html('Working <img src="<?php echo $site;?>img/loading.gif" /><br>');
			$('#result').html(data);
			
			}
		});
}
</script>
</head>
<body>
<script src="<?php echo $site;?>js/login.js"></script>
<div class="container">
    <div class="row vertical-offset-100">
    	<div class="col-md-4 col-md-offset-4">
    		<div class="panel panel-default">
			  	<div class="panel-heading">
			    	<div align="center" style="padding-bottom:15px;"><img src="<?php echo $site;?>img/login_logo.png" title="b89.in" alt="b89.in"/></div>
                    <h3 class="panel-title">Reset your password here</h3>
			 	</div>
			  	<div class="panel-body">
<?php
	ForgotPass::get_user();
?>			


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