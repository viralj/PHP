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


if(isset($_POST['register']) AND (!user_is_logged_in())){

function genRandomString($length, $characters) {
    $string = '';    

    for ($p = 0; $p < $length; $p++) {
        $string .= $characters[mt_rand(0, strlen($characters)-1)];
    }
    return $string;
}

	include $_SERVER['DOCUMENT_ROOT'].'/core/encryption.php';
	$_errors	= array();
	$_email		= @trim($db->real_escape_string(htmlentities($_POST['email'])));
	$_cool		= @trim($db->real_escape_string(htmlentities($_POST['cool'])));
	$_pass1		= @trim($db->real_escape_string(htmlentities($_POST['pass1'])));
	$_pass2		= @trim($db->real_escape_string(htmlentities($_POST['pass2'])));
	
    $blah = new Encryption;
	
	$_pass = $blah->encode($_pass1);	
	$_hash = $blah->encode($_email.'/-'.$_pass.'/-'.time());
	$_ip   = $_SESSION['ip'];
		
		if(isset($_POST['ref'])){
			$_ref = @$db->real_escape_string(htmlentities($_POST['ref']));
		}
		else {
			$_ref = '';
			}
			
			//lets start registration and checking process from here.
			
			//but before that we need to prevent from spam bots
			if($_cool == $_SESSION['CSRF_TOKEN']){
				
				//first lets check for empty post data
				if(empty($_email)){
					$_errors[] = 'You need to enter a valid email address.';
					if(!isset($rgmsg)){$rgmsg = 'Error !!!';}
				}
				
				if(empty($_pass1)){
					$_errors[] = 'Your password is required';
					if(!isset($rgmsg)){$rgmsg = 'Error !!!';}
				}
				
				if(empty($_pass2)){
					$_errors[] = 'Your confirmed password is required';
					if(!isset($rgmsg)){$rgmsg = 'Error !!!';}
				}
				
				//lets check that email address is in database and account is deactivated
				if($result = $db->query("SELECT * FROM `users` WHERE `email` = '$_email' AND `active` != '0'")){
					if($result AND $result->num_rows > 0 AND $rows = $result->fetch_array(MYSQLI_ASSOC)){
						
						$current_u_time = time();
						$enc_time = $blah->encode(time());
						$enc_ip = $blah->encode($_SESSION['ip']);
						$account_deactivated = $site.'deactivated?h='.$rows['hash'].'&i='.$enc_ip.'&t='.$enc_time;
						header("Location: $account_deactivated");
					}			
				}
				
				//lets check that email address is in database or not
				if($result = $db->query("SELECT * FROM `users` WHERE `email` = '$_email'")){
					if($result AND $result->num_rows > 0){
						$_errors[] = 'This email address is already registered with us.';
						if(!isset($rgmsg)){$rgmsg = 'Error !!!';}
					}			
				}
				
				
				//lets check that pass1 and pass2 are matching or not.
				if($_pass1 != $_pass2){
					$_errors[] = 'Your passwords are not matching.';
					if(!isset($rgmsg)){$rgmsg = 'Error !!!';}
				}
				
				//lets check password string length
				if((strlen($_pass1) < 6) OR (strlen($_pass1) > 32) ){
					$_errors[] = 'Your password must be 6 to 32 characters long.';
					if(!isset($rgmsg)){$rgmsg = 'Error !!!';}
				}
				
				
				//lets check email string length
				if((strlen($_email) > 200) ){
					$_errors[] = 'Your Email id is too long.';
					if(!isset($rgmsg)){$rgmsg = 'Error !!!';}
				}
		
				//lets check that referral code is valid or not
				if(isset($_ref) AND !empty($_ref)){
					if($result = $db->query("SELECT * FROM `users` WHERE BINARY `urefcode` = '$_ref'")){
						if($result AND $result->num_rows < 1){
							$_errors[] = 'Your referral code is not valid. Please check it again or click <a href="'.$site.'">here</a> to register without referral code.';
							if(!isset($rgmsg)){$rgmsg = 'Error !!!';}
						}			
					}			
				}
				
			
				//now let's insert user data in database
				if(empty($_errors)){	
					
					$charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
					$len = 5;
					$numrows = 1;
					$key = '';
				
					while($numrows != 0){
						for($i = 0; $i <= $len; $i++){
							$rand = rand()% strlen($charset);
							$temp = substr($charset, $rand, 1);
							$key .= $temp;
						}
					
						$find = $db->query("SELECT * FROM `users` WHERE BINARY `urefcode` = '$key'");
						$numrows = $find->num_rows;
					}
					
					$reg_query = "INSERT INTO `users`(`email`, `pass`, `type`, `hash`, `ref`, `urefcode`, `ip`) VALUES ('$_email', '$_pass', 'free', '$_hash', '$_ref', '$key', '$_ip')";
					
						if($result = $db->query($reg_query) AND $db->affected_rows > 0){
							$_errors[] = 'Congratulations! You\'ve registered successfully.';
							if(!isset($rgmsg)){$rgmsg = 'Ohhhh yyyyeeeeaaaaahhhhh !!!';}
						} else {
							$_errors[] = 'Sorry, we are having some trouble. We can\'t create your account at this moment. Please try again.';
							if(!isset($rgmsg)){$rgmsg = 'Error !!!';}
						}			
						
				}
			}	
			
			//if session is not same then show error message to secure from spam bots
			else {
				$_errors[] = 'Ooooppppsssss! We got some unwanted error. Please try once again.';
				if(!isset($rgmsg)){$rgmsg = 'Error !!!';}
			}				
			
	}
		else {
			$_errors[] = '';
			header("Location: $site");
		}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"> 
        <meta charset="utf-8">
        <title>b89.in &raquo; Register</title>
        <meta name="generator" content="Bootply" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link href="<?php echo $site;?>flat-ui/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        
        <!--[if lt IE 9]>
          <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <link rel="shortcut icon" href="<?php echo $site;?>flat-ui/images/favicon.ico">
        <link rel="apple-touch-icon" href="<?php echo $site;?>bootstrap/img/apple-touch-icon.png">
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo $site;?>bootstrap/img/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="114x114" href="<?php echo $site;?>bootstrap/img/apple-touch-icon-114x114.png">
        <style type="text/css">
            .modal-footer {   border-top: 0px; }
        </style>
    </head>
    
<body style="background-color:#F0F0F0;">

<div id="loginModal" class="modal show" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content">
      <div class="modal-header">
          
         <img src="<?php echo $site;?>img/logo.png" alt="b89.in" title="b89.in"><br><br><h1 class="text-center"><?php echo $rgmsg?></h1>
      </div>
      <div class="modal-body">
          <div class="form col-md-12 center-block">
            <div class="form-group">
              <ul>
			  <?php
			  if(is_array($_errors)){
					foreach ($_errors as $_error) {
						echo '<li>'.$_error.'</li>';
					}
					
					if($rgmsg == 'Error !!!'){
					echo "<br>Click <a href=\"$site\">here</a> to go back for registration.";
					}
				}
			  ?>
			  </ul>
            </div>
            <?php 
				if($rgmsg != 'Error !!!'){	
				?>
			<div class="form-group">
              <a href="<?php echo $site;?>login" alt="Sign In" title="Sign In"><button class="btn btn-primary btn-lg btn-block">Sign In</button></a>
            </div>	
			<?php	
				}
			?>
          </div>
      </div>
      <div class="modal-footer">
          <div class="col-md-12">
          
		  </div>	
      </div>
  </div>
  </div>
</div>
        
        <script type='text/javascript' src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>


        <script type='text/javascript' src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
<?php 
if(isset($analytics)){
	echo $analytics;
	} 
 
?> 
    </body>
</html>