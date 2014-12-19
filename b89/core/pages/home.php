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


if(user_is_logged_in()){

	// check user type and redirect to user area
	 
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
	
		
} else {
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Welcome to b89.in &raquo; The URL shornter website.</title>
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<meta property="description" 
  content="b89.in is all new version of URL Shortning website. This website has some uniqe features for advertisers and publishers. Sign up today to know more." />
	<meta property="og:title" content="b89.in URL Shortner website with amazing new features." />
	<meta property="og:url" content="<?php echo $site;?>" />
	<meta property="og:image" content="<?php echo $site;?>img/logo.png" />
	<meta property="og:description" 
  content="b89.in is all new version of URL Shortning website. This website has some uniqe features for advertisers and publishers. Sign up today to know more." />
	<meta property="og:image:type" content="image/jpeg" />
	<meta property="og:image:width" content="189" />
	<meta property="og:image:height" content="62" />
        <link rel="shortcut icon" href="<?php echo $site;?>flat-ui/images/favicon.ico">
        <link rel="stylesheet" href="<?php echo $site;?>flat-ui/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="<?php echo $site;?>flat-ui/css/flat-ui.css">
        <link rel="stylesheet" href="<?php echo $site;?>common-files/css/icon-font.css">
        <link rel="stylesheet" href="<?php echo $site;?>css/style.css">
<style>
ul.animated{list-style:none;margin:0;padding:0}
ul.animated li{width:100%;clear:left;overflow:hidden}
ul.animated li span{display:block;float:left;min-width:0;margin-bottom:5px;color:#5d5d5d;padding:6px}
ul.animated li:hover span{color:#fff;background:#ce3e3e;border-left:8px solid #8B0000;min-width:450px;-webkit-box-shadow:0 0 5px gray;-moz-box-shadow:0 0 5px gray;box-shadow:0 0 5px gray;-webkit-transition:all .3s ease-out;-moz-transition:all .3s ease-out;-o-transition:all .3s ease-out;transition:all .3s ease-out}
ul.animated li:hover span:before {content: "↣ ";}
</style>		
	</head>

    <body>
        <div class="page-wrapper">
            <!-- header-11 -->
            <header class="header-11">
                <div class="container">
                    <div class="row">
                        <div class="navbar col-sm-12" role="navigation">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle"></button>
                                <a class="brand" ><img src="<?php echo $site;?>img/logo.png" alt="b89.in" title="b89.in"></a>
                            </div>
                            <div class="collapse navbar-collapse pull-right">
                                <ul class="nav pull-left">
                                    <li class="active"><a href="<?php echo $site;?>">Home</a></li>
                                    <li><a href="<?php echo $site;?>about">About</a></li>
                                    <li><a href="<?php echo $site;?>about?redirect#career">Career</a></li>
									
                                </ul>
                                <form class="navbar-form pull-left">
                                    <a class="btn btn-primary" href="login">SIGN IN</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <section class="header-11-sub bg-midnight-blue">
                <div class="background">
                    &nbsp;
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-sm-4">
                            <h3 style="color:white">b89.in URL shortner</h3>
        
                            <div class="signup-form">
                                <form action="register" method="post" autocomplete="off">
                                    <div class="form-group">
                                        <input class="form-control" name="email" type="email" placeholder="Your E-mail" autofocus required aria-invalid="true" maxlength="200" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <div>
                                            <input type="password" name="pass1" maxlength="32" class="form-control" required placeholder="Password" autocomplete="off">
                                        </div>
                                        <div>
                                            <input type="password" name="pass2" maxlength="32" class="form-control" required placeholder="Confirmation" autocomplete="off">
											
										</div>
                                    </div>
									<div>
<?php 
/*                                        
										<input type="text" name="ref" maxlength="32" class="form-control"
										<?php
											if((isset($_GET['ref'])) AND (!empty($_GET['ref']))){
												//echo 'value="'.$_GET['ref'].'"';
												$ref = $_GET['ref'];
											
												if($result = $db->query("SELECT `uid` FROM `users` WHERE BINARY `urefcode` = '$ref'") AND $result->num_rows > 0){
													echo 'value="'.$_GET['ref'].'"';
												}
												else {
													echo 'placeholder="Invalid referral code"';
												}
											
											}
											else {
												echo 'placeholder="Referral code if you have"';
											}
											?>
										autocomplete="off">
*/
?>										
                                    </div><br>
									<input type="hidden" name="cool" id="cool" class="clear" value="<?php echo $_SESSION['CSRF_TOKEN'];?>" /> 
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-block btn-info" name="register" value="true">Sign Up</button>
                                    </div>
                                </form>
                            </div>
                            <div class="additional-links" style="color:#f77165; opacity: 0.7;filter: alpha(opacity=50); padding:4px; background-color:white">
                                By signing up you agree to <a href="terms" >Terms of Use</a> and <a href="privacy">Privacy Policy</a>.
                            </div>
                        </div>
                        <div class="col-sm-7 col-sm-offset-1 player-wrapper">
                            <div class="player" style="opacity: 0.7;filter: alpha(opacity=50); background:white">
								<div style="padding:10px">
							 
							<!-- <p style="color:rgb(255,183,0)"> -->
							
							<p style="color:#5050FF; font-size:22px;">
                                At here, you can create shorten links of your long URL.
                            </p>
								<ul class="animated" style="font-size:18px; color:rgb(247,113,120)">
									<li><span>Easy setup for links,</span></li>
									<li><span>Status of every visited* links and earn from every click,</span></li>
									<li><span>Manage every links easily from dashboard,</span></li>
									<li><span>Paypal as secure payment gateway,</span></li>
									<li><span>Mobile app for Android devices and iPhone (coming soon).</span></li>
									<li><span>Developer tools and API coming soon.</span></li>
									<li><span style="font-size:14px;">** We appreciate all security reports. Click <a href="<?php echo $site;?>bugreport">here</a> to report a vulnerability.</span></li>
								</ul>
								</div>
                            </div> 
                        </div>
                    </div>
                </div>
            </section>

            <section class="logos">
                <div class="container">
                  <div>
				  <?php
					$query = $db->query("SELECT `uid` FROM `users` WHERE `active` =  '0' AND `type` NOT IN ('admin', 'manager')");

					if($query AND $query->num_rows > 0){
					echo 'Become our valuable customer and get listed here. We have total <u><b>'.number_format($query->num_rows).'</b></u> users.';
					}
					
					$total_links_views = $db->query("SELECT COUNT(`id`) AS `total_visits` FROM `url_visit`");

					if($total_links_views AND $total_links_views->num_rows > 0 AND $rows = $total_links_views->fetch_array(MYSQLI_ASSOC)){
					echo '<hr>We have served total <u><b>'.number_format($rows['total_visits']).'</b></u> link visits and counting.';
					}
					
				  /*
				  
				  	<div><img src="img/logos/mashable.png" alt="">
                    </div>
                    <div><img src="img/logos/guardian.png" alt="">
                    </div>
                    <div><img src="img/logos/forbes.png" alt="">
                    </div>
                    <div><img src="img/logos/red-bull.png" alt="">
                    </div>
                    <div><img src="img/logos/ny-times.png" alt="">
                    </div>
				  
				  */
				  ?>
				  </div>

                </div>
            </section>

            <section class="price-1">
                <div class="container">
                    <h3>Take a look to our Membership Plans</h3>
                    <p class="lead">
                        This is a probably the best plans ever born
                    </p>
                    <div class="row plans">
                        <div class="col-sm-4">
                            <div class="plan">
                                <div class="title">Basic</div>
                                <div class="price">Free</div>
                                <div class="description">
                                    Create <b>Unlimited</b> links/month<br>
                                    <b>Status</b> of your links<br>
									<b>Absolutely</b> free<br>
                                    No <b>hidden</b> charges or fees<br>
									No <b>credit</b> card required
                                </div>
                                <a class="btn disabled" href="#">Your Current Plan</a>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="plan">
                                <div class="title">Professional</div>
                                <div class="price">$15.95/month</div>
                                <div class="description">
                                    Create <b>Unlimited</b> links/month<br>
                                    <b>Status</b> of your links<br>
									<b>Pay</b> every month<br>
									No <b>hidden</b> charges or fees<br>
									No <b>credit</b> card required<br>
                                    Email support <b>24*7</b>
                                </div>
									<a class="btn btn-primary" href="<?php echo $site;?>login?plan=pro">Change to this Plan</a>
								<div class="ribbon">Popular</div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="plan">
                                <div class="title">Business</div>
                                <div class="price">$25.95/month</div>
                                <div class="description">
                                    Create <b>Unlimited</b> links/month<br>
                                    <b>Custom</b> shorten link<br>
									<b>Status</b> of your links<br>
									<b>Pay</b> every month<br>
                                    No <b>hidden</b> charges or fees<br>
									No <b>credit</b> card required<br>
									Email support <b>24*7</b>
                                </div>
                                <a class="btn btn-primary" href="<?php echo $site;?>login?plan=busi">Change to this Plan</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>	

            <section class="content-13 subscribe-form bg-turquoise">
                <div class="container">
                    <div class="row">
                        <?php 
						/*
						<form>
                            <div class="col-sm-8">
                                <input type="text" placeholder="Enter your e-mail" spellcheck="false">
                            </div>
                            <div class="col-sm-4">
                                <button class="btn btn-large btn-primary" type="submit">
                                    Subscribe now
                                </button>
                            </div>
                        </form> 
						*/
						?>
                    </div>
                </div>
            </section>

            <footer class="footer-2 bg-midnight-blue">
                <div class="container">
                    <nav class="pull-left">
                        <ul>
                            <li class="active">
                                <a href="<?php echo $site;?>">Home</a>
                            </li>
                            <li>
                                <a href="<?php echo $site;?>about">About</a>
                            </li>
							<li>
                                <a href="<?php echo $site;?>terms">Terms</a>
                            </li>
							<li>
                                <a href="<?php echo $site;?>privacy">Privacy</a>
                            </li>
							<li>
                                <a href="<?php echo $site;?>bugreport">Report bug</a>
                            </li>
                        </ul>
						<ul>
                            <li>
                                <a href="<?php echo $site;?>bugreport/hall-of-fame">Hall Of Fame</a>
                            </li>
							<li>
                                <a href="<?php echo $site;?>about?redirect#career">Career</a>
                            </li>
							<li>
                                <a href="<?php echo $site;?>status">Status</a>
                            </li>
                        </ul>
                    </nav>
                    <?php
					/*
					<div class="social-btns pull-right">
                        <a href="#"><div class="fui-vimeo"></div><div class="fui-vimeo"></div></a>
                        <a href="#"><div class="fui-facebook"></div><div class="fui-facebook"></div></a>
                        <a href="#"><div class="fui-twitter"></div><div class="fui-twitter"></div></a>
                    </div> 
					*/
					?>
					
                    <div class="additional-links">
 Be sure to take a look at our <a href="terms">Terms of Use</a> and <a href="privacy">Privacy Policy</a>.&nbsp;&nbsp;|&nbsp;&nbsp;&copy; <?php echo date("Y");?> b89.in
                    </div>
                </div>
            </footer>
        </div>

        <!-- Placed at the end of the document so the pages load faster -->
        <script src="<?php echo $site;?>common-files/js/jquery-1.10.2.min.js"></script>
        <script src="<?php echo $site;?>flat-ui/js/bootstrap.min.js"></script>
        <script src="<?php echo $site;?>common-files/js/modernizr.custom.js"></script>
        <script src="<?php echo $site;?>common-files/js/startup-kit.js"></script>
        <script src="<?php echo $site;?>js/script.js"></script>
<?php 
if(isset($analytics)){
	echo $analytics;
	}  
?> 
    </body>
</html>


<?php

}
?>
