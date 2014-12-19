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
        <title>b89.in &raquo; Terms.</title>
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
						<h1>Terms to use b89.in website</h1>
					</div>
				</div>
			</div>
		</div>
        
        <div class="section">
	    	<div class="container">
				<div class="row">
					<div class="col-md-12">
						<h4>Terms to use b89.in website</h4>
						<p>Thank you for using our services of "b89.in" website. By using our services, you agree to all our terms and conditions. Please read our terms carefully.</p>
						<p>These terms and conditions are for this website [b89.in] and governs the privacy of its users who choose to use it.</p>
						<p>Don’t misuse our Services. Don’t interfere with our Services or try to access them using a method other than the interface and the instructions that we provide. We may suspend or stop providing our Services to you if you do not comply with our terms or policies or if we find misbehaviour from your account.</p>
						<h4>The Website</h4>
						<p>This website and it's owners take a proactive approach to user privacy and ensure the necessary steps are taken to protect the privacy of its users throughout their visiting experience.</p>
						<h4>Use of Cookies</h4>
						<p>This website is not using any type of cookies at this moment. But in future we will be using cookies for our user's better experience with our system. This website is connected to third parties who are using cookies to access data from us. We insure our users that we do not have any type of connection with third parties that requires user's personal data and we do not share our user's personal information with any third party.</p>
						<p>Cookies are small files saved to the users computers hard drive that track, save and store information about the users interactions and usage of the website. This allows the website, through it's server to provide the users with a tailored experience within this website.
						Users are advised that if they wish to deny the use and saving of cookies from this website on to their computers hard drive they should take necessary steps within their web browsers security settings to block all cookies from this website and it's external serving vendors.</p>
						<p>This website uses tracking software to monitor it's visitors to better understand how they use it. This software is provided by Google Analytics which uses cookies to track visitor usage. The software will save a cookie to your computers hard drive in order to track and monitor your engagement and usage of the website but will not store, save or collect personal information. You can read Google's privacy policy here for further information [ http://www.google.com/privacy.html ].
						Other cookies may be stored to your computers hard drive by external vendors when this website uses referral programs, sponsored links or adverts. Such cookies are used for conversion and referral tracking and typically expire after 30 days, though some may take longer. No personal information is stored, saved or collected.</p>
						<h4>Contact & Communication</h4>
						<p>Users contacting this website and/or it's owners do so at their own discretion and provide any such personal details requested at their own risk. Your personal information is kept private and stored securely until a time it is no longer required or has no use, as detailed in the Data Protection Act 1998. Every effort has been made to ensure a safe and secure form to email submission process but advise users using such form to email processes that they do so at their own risk.
						This website and it's owners use any information submitted to provide you with further information about the products / services they offer or to assist you in answering any questions or queries you may have submitted. This includes using your details to subscribe you to any email newsletter program the website operates but only if this was made clear to you and your express permission was granted when submitting any form to email process. Or whereby you the consumer have previously purchased from or enquired about purchasing from the company a product or service that the email newsletter relates to. This is by no means an entire list of your user rights in regard to receiving email marketing material. Your details are not passed on to any third parties.</p>
<?php
/*
<h4>Email Newsletter</h4>
<p>This website operates an email newsletter program, used to inform subscribers about products and services supplied by this website. Users can subscribe through an online automated process should they wish to do so but do so at their own discretion. Some subscriptions may be manually processed through prior written agreement with the user.</p>
<p>Subscriptions are taken in compliance with UK Spam Laws detailed in the Privacy and Electronic Communications Regulations 2003. All personal details relating to subscriptions are held securely and in accordance with the Data Protection Act 1998. No personal details are passed on to third parties nor shared with companies / people outside of the company that operates this website. Under the Data Protection Act 1998 you may request a copy of personal information held about you by this website's email newsletter program. A small fee will be payable. If you would like a copy of the information held on you please write to the business address at the bottom of this policy.</p>
<p>Email marketing campaigns published by this website or it's owners may contain tracking facilities within the actual email. Subscriber activity is tracked and stored in a database for future analysis and evaluation. Such tracked activity may include; the opening of emails, forwarding of emails, the clicking of links within the email content, times, dates and frequency of activity [this is by no far a comprehensive list].	This information is used to refine future email campaigns and supply the user with more relevant content based around their activity.</p>
<p>In compliance with UK Spam Laws and the Privacy and Electronic Communications Regulations 2003 subscribers are given the opportunity to un-subscribe at any time through an automated system. This process is detailed at the footer of each email campaign. If an automated un-subscription system is unavailable clear instructions on how to un-subscribe will by detailed instead.</p>
*/
?>						
						<h4>External Links</h4>
						<p>Although this website only looks to include quality, safe and relevant external links users should always adopt a policy of caution before clicking any external web links mentioned throughout this website.</p>
						<p>The owners of this website cannot guarantee or verify the contents of any externally linked website despite their best efforts. Users should therefore note they click on external links at their own risk and this website and it's owners cannot be held liable for any damages or implications caused by visiting any external links mentioned.</p>
						<h4>Adverts and Sponsored Links</h4>
						<p>This website may contain sponsored links and adverts. These will typically be served through our advertising partners, to whom may have detailed privacy policies relating directly to the adverts they serve.</p>
						<p>Clicking on any such adverts will send you to the advertisers website through a referral program which may use cookies and will tracks the number of referrals sent from this website. This may include the use of cookies which may in turn be saved on your computers hard drive. Users should therefore note they click on sponsored external links at their own risk and this website and it's owners cannot be held liable for any damages or implications caused by visiting any external links mentioned.</p>
						<br><p>This website and its contents are subject to change any time even without notification. We suggest our users to keep visiting this page and our <a href="<?php echo $site;?>privacy">privacy</a> page for more information. If you find any suspicious activity with your account, please inform us at <a href="<?php echo $site;?>about?redirect#contact">here</a> or submit ticket from your account.</p>
<?php
/*
<h4>Social Media Platforms</h4>
<p>Communication, engagement and actions taken through external social media platforms that this website and it's owners participate on are custom to the terms and conditions as well as the privacy policies held with each social media platform respectively.</p>
<p>Users are advised to use social media platforms wisely and communicate / engage upon them with due care and caution in regard to their own privacy and personal details. This website nor it's owners will ever ask for personal or sensitive information through social media platforms and encourage users wishing to discuss sensitive details to contact them through primary communication channels such as by telephone or email.</p>
<p>This website may use social sharing buttons which help share web content directly from web pages to the social media platform in question. Users are advised before using such social sharing buttons that they do so at their own discretion and note that the social media platform may track and save your request to share a web page respectively through your social media platform account.</p>

<h4>Shortened Links in Social Media</h4>
<p>This website and it's owners through their social media platform accounts may share web links to relevant web pages. By default some social media platforms shorten lengthy url's [web addresses]. </p>
<p>Users are advised to take caution and good judgement before clicking any shortened url's published on social media platforms by this website and it's owners. Despite the best efforts to ensure only genuine url's are published many social media platforms are prone to spam and hacking and therefore this website and it's owners cannot be held liable for any damages or implications caused by visiting any shortened links.</p>
*/
?>
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