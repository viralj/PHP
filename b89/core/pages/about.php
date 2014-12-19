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
if(isset($_GET['ad']) AND $_GET['ad'] == 'yes'){
	$_SESSION['ad'] = 'yes';
	$redirect_contact = $site.'about#contact';
	header("Location: $redirect_contact");
}
*/

if(isset($_POST['send']) AND ($_POST['send'] == 'true')){
	
	//lets secure site from sql-injection and xss
	
	$name		= trim($db->real_escape_string(htmlentities($_POST['name'])));
	$email		= trim($db->real_escape_string(htmlentities($_POST['email'])));
	$subject	= trim($db->real_escape_string(htmlentities($_POST['subject'])));
	$msg		= trim($db->real_escape_string(htmlentities($_POST['msg'])));
	$honeypot	= trim($db->real_escape_string(htmlentities($_POST['honeypot'])));
	$humancheck	= trim($db->real_escape_string(htmlentities($_POST['humancheck'])));
	$cool		= trim($db->real_escape_string(htmlentities($_POST['cool'])));
	//$errors[] = array();
	
	
	//lets check for input data and empty post data
	
	if(empty($name)){
		$errors[] = 'Your name is required.';
	}
	if(empty($email)){
		$errors[] = 'Your email is required.';
	}
	if(empty($subject)){
		$errors[] = 'Contact subject is required.';
	}
	if(empty($msg)){
		$errors[] = 'Message must not be empty.';
	}
	if(strlen($name) < 3){
		$errors[] = 'Is this your name or pet name? Its too short for us.';
	}
	if(strlen($name) > 50){
		$errors[] = 'Is this your name? Its too long for us.';
	}
	if(strlen($subject) < 3){
		$errors[] = 'Tell us more why your contacting us so we can help you better.';
	}
	if(strlen($subject) > 200){
		$errors[] = 'You said too much about your subject. Tell us in brief about subject.';
	}
	if(strlen($msg) < 5){
		$errors[] = 'Tell us more so we can help you better.';	
	}
	if(strlen($msg) > 5000){
		$errors[] = 'Oooohhhh!!! Lots of things you said that we can\'t handle.';
	}
	if($honeypot != 'ThisIsSpamProtection'){
		$errors[] = 'We do not accept spam mails.';
	}
	if($humancheck != ''){
		$errors[] = 'We want feedback only from human.';
	}
	if($cool != $_SESSION['CSRF_TOKEN']){
		$errors[] = 'We feel that you are not human. Sorry but we can\'t accept your form.';
	}

	if(!empty($errors)){
	
	//if there is any error occord, we need to display it
	
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

	} else {
		$ip = $_SESSION['ip'];
		$time = time();
		//else we can proceed for further
		$query = "INSERT INTO `gen_contact` (`name`, `email`, `sub`, `msg`, `ip`, `time`, `read`) 
				  VALUES 
				 ('$name', '$email', '$subject', '$msg', '$ip', '$time', '0')";
		
		//lets prevent from form submission for twice.
		if(isset($_SESSION['form']) AND ($_SESSION['form'] = $_SESSION['CSRF_TOKEN'].'/'.$email)){
			$alert = '
		<script>
		bootbox.dialog({
		  message: "<div align=\"left\">You don\'t need to submit your form twice. If you refreshed your page by mistake, it is okay.</div>",
		  title: "We got your form.",
		  buttons: {
			
			danger: {
			  label: "Okay!",
			  className: "btn-warning",
			},    
		  }
		});
		</script>';
		} else {
		
		//lets process form subission
		
			if($result = $db->query($query) AND $db->affected_rows > 0){
				
				$_SESSION['form'] = $_SESSION['CSRF_TOKEN'].'/'.$email;
				
				$alert = '<script>
			bootbox.dialog({
			  message: "<div align=\"left\">Thank you for contacting us. We have received your message and we will try to get back to you as soon as we can. Usually we respond within 48 hours depending on volume of customer\'s contact.</div>",
			  title: "We got your message.",
			  buttons: {
				
				danger: {
				  label: "Okay!",
				  className: "btn-success",
				},    
			  }
			});
			</script>';
			} else {
				
				$alert = '<script>
						bootbox.dialog({
						  message: "<div align=\"left\">We are very sorry that we were not able to process your contact form. We request you to try again or contact us after some time.<br><hr><h3>What should have happened?</h3><br><ul><li>We might be facing connection issue with server.</li><li>There might me some technical issue.</li></ul><br><hr><h3>What you can do now?</h3><br><ul><li>Try once again to contact us now.</li><li>Try to contact us after sometime.</li><li>If you are user of our service, you can log into your account and can submit a ticket.</li></ul></div>",
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
	}
}

?>
<!DOCTYPE html>
<html>
  <head>
    <title>b89.in &raquo; About us</title>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="shortcut icon" href="<?php echo $site;?>flat-ui/images/favicon.ico">
    <link href="<?php echo $site;?>css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="<?php echo $site;?>css/style2.css" rel="stylesheet" media="screen">
	<link href="<?php echo $site;?>color/default.css" rel="stylesheet" media="screen">
	<link href='http://fonts.googleapis.com/css?family=Armata' rel='stylesheet' type='text/css'>
	<script src="<?php echo $site;?>js/modernizr.custom.js"></script>
    <script src="<?php echo $site;?>js/jquery.js"></script>
    <script src="<?php echo $site;?>js/bootstrap.min.js"></script>
    <script src="<?php echo $site; ?>js/bootbox.min.js"></script>
<style>.hdrlg{font-family:Armata;font-size:56px;color:#f77165;cursor:default;display:block;min-height:50px}
@font-face{font-family:Armata;font-style:normal;font-weight:400;src:local(Armata), local(Armata-Regular), url(<?php echo $site; ?>fonts/Armata.woff) format(woff)}</style> 
   </head>
  <body>
	<?php if(isset($alert)){echo $alert;}?>
    <div class="menu-area">
			<div id="dl-menu" class="dl-menuwrapper">
						<button class="dl-trigger">Open Menu</button>
						<ul class="dl-menu">
							<li>
								<a href="<?php echo $site;?>">Home</a>
							</li>
							<li><a href="<?php echo $site;?>about">About</a>
								<ul class="dl-submenu">
									<li><a href="#about">Team</a></li>
									<li><a href="#career">Your career</a></li>
									<li><a href="#services">Services</a></li>
								</ul>
							</li>
							<li><a href="<?php echo $site;?>terms">Terms</a></li>
							<li><a href="<?php echo $site;?>privacy">Privacy Polices</a></li>
							<li><a href="#contact">Contact</a></li>
                            <?php 
										if(user_is_logged_in()){
								   ?>
<form id="loform" action="<?php echo $site;?>logout" method="POST">
<input type="hidden" name="cool" value="<?php echo $_SESSION['CSRF_TOKEN']?>" /><input type="hidden" name="lo" value="logout" /><input type="hidden" name="em" value="<?php echo substr(md5($_SESSION['email']), 0, 10);?>" /><input type="hidden" name="ut" value="<?php echo substr(md5($_SESSION['u_type']), 0, 10); ?>" />
						<li><a href="javascript:{}" onclick="document.getElementById('loform').submit();">Log Out</a></li>
</form>
								   <?php 
									   } else {
									   echo '<li><a href="'.$site.'login">Sign In</a></li>';
									   }
								   ?>
							
							
						</ul>
					</div><!-- /dl-menuwrapper -->
	</div>	

	  <!-- intro area -->	  
	  <div id="intro">
	  
			<div class="intro-text">
				<div class="container">
					<div class="row">
					
						
					<div class="col-md-12">
			
						<div class="brand">
							<h1><div class="hdrlg">b89<font color="#000000">.</font><font style="color:rgb(250,209,49)">in</font></div></h1>
							<div class="line-spacer"></div>
							<p><span>About us. What we are and what we do!!!<br>Have a look down.</span></p>
						</div>
					</div>
					</div>
				</div>
		 	</div>
			
	 </div>
	  

	  
	  
	  <!-- About -->
	  <section id="about" class="home-section bg-white">
		<div class="container">
			  <div class="row">
				  <div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
					 <h2>About us</h2> <h6>Meet the TEAM, be the TEAM</h6>
					 <p>We’ve been building unique digital products, platforms, and experiences for us and our users.<br>
					 We are group of those dedicated people who works from home. We don't need office to prove ourselves.</p>
					</div>
				  </div>
			  </div>
			  <div class="row">
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
					<div class="box-team wow bounceInDown" data-wow-delay="0.1s">
                    <img src="<?php echo $site;?>img/team/Viral_Joshi.jpg" alt="Viral Joshi" title="Viral Joshi" class="img-responsive" />
                    <h4>Viral Joshi</h4>
                    <p>Founder,<br>Senior Web developer,<br>Security Engineer</p>
					</div>
                </div>
<?php
/*				
	                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" data-wow-delay="0.3s">
					<div class="box-team wow bounceInDown">
                    <img src="<?php echo $site;?>img/team/Nandan_Pandya.jpg" alt="Nandan Pandya" title="Nandan Pandya" class="img-responsive" />
                    <h4>Nandan Pandya</h4>
                    <p>Mobile App Developer (Coming Soon)</p>
					</div>
                </div>
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" data-wow-delay="0.5s">
					<div class="box-team wow bounceInDown">
                    <img src="<?php echo $site;?>img/team/Kumaran.jpg" alt="Kumaran V R" title="Kumaran V R" class="img-responsive" />
                    <h4>Kumaran V R</h4>
                    <p>Security Engineer</p>
					</div>
                </div>
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" data-wow-delay="0.7s">
					<div class="box-team wow bounceInDown">
                    <img src="<?php echo $site;?>img/team/Bhavesh_Patel.jpg" alt="Bhavesh Patel" title="Bhavesh Patel" class="img-responsive" />
                    <h4>Bhavesh Patel</h4>
                    <p>Senior Marketing Researcher</p>
					</div>
                </div>			
*/				
?>				
				<div>&nbsp;</div><div>&nbsp;</div>
				<div>&nbsp;</div><div>&nbsp;</div>
				<div>&nbsp;</div><div>&nbsp;</div>
				<div>&nbsp;</div><div>&nbsp;</div>
				<div>&nbsp;</div><div>&nbsp;</div>
				<div>&nbsp;</div><div>&nbsp;</div>
				<div>&nbsp;</div><div>&nbsp;</div>
				<div>&nbsp;</div><div>&nbsp;</div>
				<div>&nbsp;</div><div>&nbsp;</div>
				<div>&nbsp;</div><div>&nbsp;</div>
				<div>&nbsp;</div><div>&nbsp;</div>
			
			<section id="career" class="home-section bg-white">	
				<div>&nbsp;</div><div>&nbsp;</div>
				
				<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" data-wow-delay="0.9s" >
					<div class="box-team wow bounceInDown">
                    <img src="<?php echo $site;?>img/team/you.png" alt="We see you" title="We see you" class="img-responsive" />
                   </div>
                </div>
				<div>
					<h4>This can be you</h4>
                    <p>We see you, working with us. We are on mission to change the world. If you can join the train, if you want to join the train, we will give you the TICKET.<br>Tell us about your skills.<br><a href="mailto:jobs@b89.in?subject=I want to be awesome.&body=I want to catch the train. Give me the TICKET. (Tell us about yourself that will rock us.)" target="_blank">jobs@b89.in</a></p>
				</div>	
				<div>&nbsp;</div><div>&nbsp;</div>
			<div>&nbsp;</div><div>&nbsp;</div>
			</section>  
			  
			  </div>			  
		  </div>	  
	  </section>
	  
		<!-- spacer -->	  
		<section id="spacer1" class="home-section spacer">	
           <div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="color-light">
						<h2 class="wow bounceInDown" data-wow-delay="1s">Details are the key for perfection</h2>
						<p class="lead wow bounceInUp" data-wow-delay="2s">We mix all detailed things together.</p>	
						</div>
					</div>				
				</div>
            </div>
		</section>	  
	  
	  <!-- Services -->
	 <section id="services" class="home-section bg-white">
		<div class="container">
			  <div class="row">
				  <div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
					 <h2>Services</h2>
					 <p>b89.in is an online service for everyone where user can make shorten links and also can earn money with their created shorten links.</p>
					</div>
				  </div>
			  </div>
			  <div class="row">
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
					<div class="service-box wow bounceInDown" data-wow-delay="0.1s">
						<br><i class="fa fa-code fa-4x"></i>
						<h4>Easy stucture</h4>
						<p>We have designed easy and user friendly layout to understand and use, just to make your experience better.</p>
						<a class="btn btn-primary">Ohhh yeah!!!	</a>
					</div>
                </div>
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" data-wow-delay="0.3s">
					<div class="service-box wow bounceInDown" data-wow-delay="0.1s">
						<br><i class="fa fa-cog fa-4x"></i>
						<h4>Easy to Customize</h4>
						<p>Few settings with high performance to configure your account and manage everything at one place.</p>
						<a class="btn btn-primary">Huurraayy!!!	</a>
					</div>
                </div>
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" data-wow-delay="0.5s">
					<div class="service-box wow bounceInDown" data-wow-delay="0.1s">
						<br><i class="fa fa-desktop fa-4x"></i>
						<h4>Responsive Layout</h4>
						<p>Accessible from your mobile devices so you can access our service through anything, anywhere.</p>
						<a class="btn btn-primary">Sounds cool!!!	</a>
					</div>
                </div>
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" data-wow-delay="0.7s">
					<div class="service-box wow bounceInDown" data-wow-delay="0.1s">
						<br><i class="fa fa-dropbox fa-4x"></i>
						<h4>Ready to use</h4>
						<p>Add your personal details, your really boring long links and we will manage everything.</p>
						<a class="btn btn-primary">Aaahhaa!!! </a>
					</div>
                </div>
			  </div>	
		</div>
	</section>
	

	  
	 <!-- Contact -->
	  <section id="contact" class="home-section bg-white">
	  	<div class="container">
			  <div class="row">
				  <div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
					 <h2>Contact us</h2>
					 <p>Contact us via form below for your general inquiry or advertising inquiry on our website and we will get in touch with you within 2-3 business days. </p>
					</div>
				  </div>
			  </div>

	  		<div class="row">
	  			<div class="col-md-offset-1 col-md-10">
<div id="response"><!-- form response --></div>
				<form class="form-horizontal" method="post" id="contactForm" role="form" action="<?php echo $site;?>about">
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
					  <input type="text" class="form-control" id="inputName" name="name" required 
					  
					    <?php 
							if((isset($_SESSION['fname'])) AND (isset($_SESSION['lname']))){
							echo 'value="'.$_SESSION['fname'].' '.$_SESSION['lname'].'"';
							} else {
								echo 'placeholder="Name"';
							}
						?>
					  
					  >
					</div>
				  </div>
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
					  <input type="email" class="form-control" id="inputEmail" name="email" required 
					  	<?php 
							if(isset($_SESSION['email'])){
							echo 'value="'.$_SESSION['email'].'"';
							} else {
								echo 'placeholder="Email"';
							}
						?>
					  >
					</div>
				  </div>
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
					  <input type="text" class="form-control" id="inputSubject" name="subject" required
					  <?php 
							if(isset($_GET['ad'])){
							echo 'value="Advertising on b89.in"';
							} else {
								echo 'placeholder="Subject"';
							}
						?>
					  
					  >
					</div>
				  </div>
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
					  <textarea class="form-control" rows="3" name="msg" id="msg" required placeholder="Message"></textarea>
					</div>
				  </div>
              <input type="hidden" name="honeypot" id="honeypot" value="ThisIsSpamProtection" />
              <input type="hidden" name="humancheck" id="huancheck" class="clear" value="" /> 
              <input type="hidden" name="cool" id="cool" class="clear" value="<?php echo $_SESSION['CSRF_TOKEN'];?>" /> 
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
	<button type="submit" id="submit" class="btn btn-theme btn-lg btn-block" name="send" value="true">Send message</button>
					</div>
				  </div>
				</form>
				</div>
			
				
	  		</div>
			<?php
			/*
			<div class="row mar-top30 ">
				<div class="col-md-offset-2 col-md-8">
					<h5>We're on social networks</h5>
					<ul class="social-network">
						<li><a href="#">
						<span class="fa-stack fa-2x">
							<i class="fa fa-circle fa-stack-2x"></i>
							<i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
						</span></a>
						</li>
						<li><a href="#">
						<span class="fa-stack fa-2x">
							<i class="fa fa-circle fa-stack-2x"></i>
							<i class="fa fa-dribbble fa-stack-1x fa-inverse"></i>
						</span></a>
						</li>
						<li><a href="#">
						<span class="fa-stack fa-2x">
							<i class="fa fa-circle fa-stack-2x"></i>
							<i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
						</span></a>
						</li>
						<li><a href="#">
						<span class="fa-stack fa-2x">
							<i class="fa fa-circle fa-stack-2x"></i>
							<i class="fa fa-pinterest fa-stack-1x fa-inverse"></i>
						</span></a>
						</li>
					</ul>
				</div>				
			</div>
			*/
			?>
	  	</div>
	  </section>  

	<footer>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<p>Copyright &copy; <?php echo date("Y");?> b89.in.</p>
				</div>
			</div>		
		</div>	
	</footer>
	 
	 <!-- js -->
    <script src="<?php echo $site;?>js/jquery.smooth-scroll.min.js"></script>
	<script src="<?php echo $site;?>js/jquery.dlmenu.js"></script>
	<script src="<?php echo $site;?>js/wow.min.js"></script>
	<script src="<?php echo $site;?>js/custom.js"></script>
 
<?php 
if(isset($analytics)){
	echo $analytics;
	} 
 
?> </body>	
</html>