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


?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>b89.in &raquo; Policies.</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
		<link rel="shortcut icon" href="<?php echo $site;?>flat-ui/images/favicon.ico">
        <link rel="stylesheet" href="<?php echo $site;?>tp/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo $site;?>tp/css/icomoon-social.css">
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,600,800' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="<?php echo $site;?>tp/css/leaflet.css" />
		<!--[if lte IE 8]>
		    <link rel="stylesheet" href="<?php echo $site;?>tp/css/leaflet.ie.css" />
		<![endif]-->
		<link rel="stylesheet" href="<?php echo $site;?>tp/css/main.css">

        <script src="<?php echo $site;?>tp/js/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->
        

        <!-- Navigation & Logo-->
        <div class="mainmenu-wrapper">
	        <div class="container">
	        	<div class="menuextras">
					<div class="extras">
						<ul>
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
					</div>
		        </div>
		        <nav id="mainmenu" class="mainmenu">
					<ul>
						<li class="logo-wrapper"><a href="<?php echo $site;?>"><img src="<?php echo $site;?>img/logo.png" alt="b89.in"></a></li>
						<li>
							<a href="<?php echo $site;?>">Home</a>
						</li>
						<li>
							<a href="<?php echo $site;?>about">About</a>
						</li>
						<li>
							<a href="<?php echo $site;?>about?redirect#contact">Contact</a>
						</li>
					</ul>
				</nav>
			</div>
		</div>

        <!-- Page Title -->
		<div class="section section-breadcrumbs">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<h1>Privacy policy of b89.in website</h1>
					</div>
				</div>
			</div>
		</div>
        
        <div class="section">
	    	<div class="container">
				<div class="row">
					<div class="col-md-12">
						<h4>What is this Privacy Policy for?</h4>
						<p>This privacy policy is for this website [b89.in] and  governs the privacy of its users who choose to use it.</p>
						<p>The policy sets out the different areas where user privacy is concerned and outlines the obligations & requirements of the users, the website and website owners. Furthermore the way this website processes, stores and protects user data and information will also be detailed within this policy.</p>
						<h4>What is listed in privacy?</h4>
						<p>b89.in website is user based system. To join our service, all users must sign up with <b>Real Details</b>. We do not allow fake users or fake details. Details like user's Email address, real name etc. And we also collect other information about user by our system.</p>
						<h5>Our Privacy Policy explains:</h5>
						<ul>
							<li>What information of user's we collect and why we collect it.</li>
							<li>How we use our user's information.</li>
							<li>The services that we offer to user, including how to access and update information.</li>
						</ul>
						<h4>We use third party system to collect information</h4>
						<p>We use third party system to analyse our system, our system's performance and how our system performs with user.</p>
						<h4>Information we share</h4>
						<p>We do not share personal information with companies, organizations and individuals outside of b89.in website.</p>
						<h4>Information security</h4>
						<p>We work hard to protect b89.in website and our users from unauthorized access to or unauthorized alteration, disclosure or destruction of information we hold. For better security service, which we are working on, currently we are asking information from users as low as we can.</p>
						<ul>
							<li>Currently we have encryption in our system to contains encrypted details of user.</li>
							<li>We review informations submitted by user if we need to.</li>
							<li>We do not access and do not allow anyone to access any personal details of user (like password) or share.</li>
						</ul>
						<h4>When this Privacy Policy applies to user?</h4>
						<p>When user sign up for b89.in services our terms-conditions and privacy policy applies to the user. We expect from our users to follow our rules for their own account's security.</p>
						<br><p>This website and its contents are subject to change any time even without notification. We suggest our users to keep visiting this page and our <a href="<?php echo $site;?>terms">terms</a> page for more information. If you find any suspicious activity with your account, please inform us at <a href="<?php echo $site;?>about?redirect#contact">here</a> or submit ticket from your account.</p>
					</div>
				</div>
			</div>
		</div>

	    <!-- Footer -->
	    <div class="footer">
	    	<div class="container">
		    	<div class="row">
		    		
		    		<div class="col-footer col-md-3 col-xs-6">
		    			<h3>Navigate</h3>
		    			<ul class="no-list-style footer-navigate-section">
		    				<li><a href="<?php echo $site;?>">Home</a></li>
		    				<li><a href="<?php echo $site;?>about">About us</a></li>
		    				<li><a href="<?php echo $site;?>about?redirect#services">Services</a></li>
		    				<li><a href="<?php echo $site;?>about?redirect#career">Career</a></li>
		    				<li><a href="<?php echo $site;?>bugreport">Bug report</a></li>
		    				<li><a href="<?php echo $site;?>status">Status</a></li>
		    			</ul>
		    		</div>
		    		
		    		<div class="col-footer col-md-4 col-xs-6">
		    			<h3>Contacts</h3>
		    			<p class="contact-us-details">
	        				Got any question? Don't worry, ask us any time. We are happy to help you. Click <a href="<?php echo $site;?>about?redirect#contact">here</a> to contact us.
	        			</p>
		    		</div>
					<?php 
					/*
		    		<div class="col-footer col-md-2 col-xs-6">
		    			<h3>Stay Connected</h3>
		    			<ul class="footer-stay-connected no-list-style">
		    				<li><a href="#" class="facebook"></a></li>
		    				<li><a href="#" class="twitter"></a></li>
		    				<li><a href="#" class="googleplus"></a></li>
		    			</ul>
		    		</div>
					*/
					?>
		    	</div>
		    	<div class="row">
		    		<div class="col-md-12">
		    			<div class="footer-copyright">&copy; <?php echo date('Y');?> b89.in</div>
		    		</div>
		    	</div>
		    </div>
	    </div>

        <!-- Javascripts -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="<?php echo $site;?>tp/js/jquery-1.9.1.min.js"><\/script>')</script>
        <script src="<?php echo $site;?>tp/js/bootstrap.min.js"></script>
        <script src="http://cdn.leafletjs.com/leaflet-0.5.1/leaflet.js"></script>
        <script src="<?php echo $site;?>tp/js/jquery.fitvids.js"></script>
        <script src="<?php echo $site;?>tp/js/jquery.sequence-min.js"></script>
        <script src="<?php echo $site;?>tp/js/jquery.bxslider.js"></script>
        <script src="<?php echo $site;?>tp/js/main-menu.js"></script>
        <script src="<?php echo $site;?>tp/js/template.js"></script>
<?php 
if(isset($analytics)){
	echo $analytics;
	} 
 
?>
    </body>
</html>