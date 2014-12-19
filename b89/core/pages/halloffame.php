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
		<div class="corgi_feed_well">
            <div class="individual_feed_item">
              <div class="feed_item">
                <div class="feed_body">
                  <div class="row">
                    <div class="feed_profile_pic">
                      <img src="img/boxer.jpg" alt="meta image" class="meta_image">
                    </div>
                    <div class="feed_text">
                      <p>Click on the comment link in the lower right. It has a hidden dropdown comment area built in. Woof!</p>
                    </div>
                  </div>
                </div>
                
                <hr class="feed_hr">
                <div class="bottom_meta">
                  <div class="row">
                    <div class="bottom_left">
                      <div class="share_wrapper">
                        <div class="share"><a href="#" class="share_button"><i class="icon-heart"></i></a></div>
                        <div class="share_hidden">
                          <ul class="hover_heart">
                            <span class="internal_heart"><i class="icon-heart"></i> Share This Post</span> 
                            <div class="social_links">
                              <li><span><i class="icon-twitter"></i> Twitter</span></li>
                              <li><span><i class="icon-facebook"></i> Facebook</span></li>
                              <li><span><i class="icon-pinterest"></i> Pinterest</span></li>
                            </div>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="bottom_right">
                      <a>Sir_woofs_alot</a> <span>|</span> 2 days ago
                    </div> 
                  </div>
                </div>
              </div>
            </div>
          </div>
*/



//Hall Of Fame list class starts from here

class HallOfFame {
	
	public static function get_reporters(){
		include $_SERVER['DOCUMENT_ROOT'].'/core/db_config_inc.php';
	
		$select_reporter = "SELECT * FROM `vul_reporters` ORDER BY `id` DESC";
	
		if($result = $db->query($select_reporter)){
			
			if($result->num_rows > 0 AND $rows = $result->fetch_all(MYSQLI_ASSOC)){
			
			$links = '';
			foreach($rows as $row){
			
				//we will check for reports public profile and links
				if(!empty($row['fb'])){
					$links .= '<li><span style="margin-right:15px;"><i class="icon-facebook"></i> Facebook profile of <a style="color:white;text-decoration:underline;" target="_blank" href="'.html_entity_decode(nl2br(stripslashes($row['fb']))).'">'.html_entity_decode(nl2br(stripslashes($row['reporter']))).'</a></span></li>';
				}
				if(!empty($row['twt'])){
					$links .= '<li><span style="margin-right:15px;"><i class="icon-twitter"></i> Twitter profile of <a style="color:white;text-decoration:underline;" target="_blank" href="'.html_entity_decode(nl2br(stripslashes($row['twt']))).'">'.html_entity_decode(nl2br(stripslashes($row['reporter']))).'</a></span></li>';
				}
				if(!empty($row['gplus'])){
					$links .= '<li><span style="margin-right:15px;"> Google+ profile of <a style="color:white;text-decoration:underline;" target="_blank" href="'.html_entity_decode(nl2br(stripslashes($row['gplus']))).'">'.html_entity_decode(nl2br(stripslashes($row['reporter']))).'</a></span></li>';
				}
				if(!empty($row['li'])){
					$links .= '<li><span style="margin-right:15px;"> LinkedIn profile of <a style="color:white;text-decoration:underline;" target="_blank" href="'.html_entity_decode(nl2br(stripslashes($row['li']))).'">'.html_entity_decode(nl2br(stripslashes($row['reporter']))).'</a></span></li>';
				}
				if(!empty($row['pers_web'])){
					$links .= '<li><span style="margin-right:15px;"> Personal website of <a style="color:white;text-decoration:underline;" target="_blank" href="'.html_entity_decode(nl2br(stripslashes($row['pers_web']))).'">'.html_entity_decode(nl2br(stripslashes($row['reporter']))).'</a></span></li>';
				}
				
				if(empty($row['pic'])){
					$pic = $site.'vr/img/reporter.jpg';
				}
				
				
				echo '<section id="'.html_entity_decode(nl2br(stripslashes($row['bug_id']))).'"><div class="corgi_feed_well">
            <div class="individual_feed_item">
              <div class="feed_item">
                <div class="feed_body">
                  <div class="row">
                    <div class="feed_profile_pic">
                      <img src="'.html_entity_decode(nl2br(stripslashes($row['pic']))).'" alt="'.html_entity_decode(nl2br(stripslashes($row['reporter']))).'" title="'.html_entity_decode(nl2br(stripslashes($row['reporter']))).'" class="meta_image">
                    </div>
                    <div class="feed_text">
                      <p>'.html_entity_decode(nl2br(stripslashes($row['text']))).'</p>
                    </div>
                  </div>
                </div>
                
                <hr class="feed_hr">
                <div class="bottom_meta">
                  <div class="row">
                    <div class="bottom_left">
                      <div class="share_wrapper">
                        <div class="share"><a href="#" class="share_button"><i class="icon-heart"></i></a></div>
                        <div class="share_hidden">
                          <ul class="hover_heart">
                            <span class="internal_heart"><i class="icon-heart"></i> Share this with friends,<br> Copy this link: '.$site.'bugreport/hall-of-fame#'.$row['bug_id'].'</span> 
                            <div class="social_links">
                              '.$links.'
                            </div>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="bottom_right">
                      <a>'.html_entity_decode(nl2br(stripslashes($row['reporter']))).'</a> <span>|</span> '.html_entity_decode(nl2br(stripslashes($row['time']))).'
                    </div> 
                  </div>
                </div>
              </div>
            </div>
          </div></section>';
			
			$links = '';
			}		
			
			
			}
			else{
				echo 'We do not have any bug reporter yet. You can be first if you\'ve found any vulnerability in our system. Just report it to use <a href="'.$site.'bugreport">here</a>.';
			}
			
		}else{
			echo 'We are facing some issues to get details. Please refresh page or report this to us at <a href="'.$site.'about?redirect#contact">here</a>.';
		}
	
	}
	
}
////class ends here

?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>b89.in &raquo; Hall of Fame - Security Reserchers.</title>
    <meta name="description" content="A new bootstrap theme">
    <meta name="author" content="Damian Sowers">
    <link rel="shortcut icon" href="<?php echo $site;?>flat-ui/images/favicon.ico">
    <link href="<?php echo $site;?>vr/css/bootstrap.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Raleway:400,600' rel='stylesheet' type='text/css'>
    <link href='<?php echo $site;?>vr/css/corgi.css' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="<?php echo $site;?>vr/css/elusive-webfont.css">
    <script src="<?php echo $site;?>vr/js/jquery.min.js" type="text/javascript"></script>
    <script src="<?php echo $site;?>vr/js/corgi.js" type="text/javascript"></script>
	<script src="<?php echo $site;?>user/js/scroller.js"></script>
    <!-- elusive icons ie7 support -->
    <!--[if lte IE 7]><script src="<?php echo $site;?>vr/js/lte-ie7.js"></script><![endif]-->

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="<?php echo $site;?>vr/js/html5shiv.js"></script>
    <![endif]-->
<style>
      body {
        padding-top: 80px; /* Only include this for the fixed top bar */
      }

@font-face{font-family:Armata;font-style:normal;font-weight:400;src:local(Armata), local(Armata-Regular), url(<?php echo $site;?>fonts/Armata.woff) format(woff)}
.hdrlg{font-family:Armata;font-size:46px;padding-top:5px;color:#f77165;cursor:default;display:block;min-height:50px}

#list{min-height:20px;max-height:650px;overflow:scroll;margin:0 auto}
#box2000 > div{-webkit-transition:width .2s ease;-moz-transition:width .2s ease;-o-transition:width .2s ease;-ms-transition:width .2s ease;transition:width .2s ease}
#box2000 > div:hover{width:120%!important;cursor:pointer}
</style>
<script type="text/javascript"> 
    $(document).ready(function () {
    $("#list").niceScroll({ autohidemode: true })
    });
</script>	
  </head>
  <body>
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="<?php echo $site;?>">
			<div class="hdrlg">b89<font color="#000000">.</font><font style="color:rgb(250,209,49)">in</font></div>
		  </a>
          <div class="nav-collapse collapse">
            <ul class="nav pull-right">
              <li><a href="<?php echo $site;?>">Home</a></li>
              <li><a href="<?php echo $site;?>about">About</a></li>
              <li><a href="<?php echo $site;?>about?redirect#contact">Contact</a></li>
              <li><a href="<?php echo $site;?>terms">Terms</a></li>
              <li><a href="<?php echo $site;?>privacy">Privacy</a></li>
              <li><a href="<?php echo $site;?>bugreport">Bug Report</a></li>
              <li class="active"><a href="<?php echo $site;?>bugreport/hall-of-fame">Hall of Fame</a></li>
<?php 
if(user_is_logged_in()){
?>
<li><a href="javascript:{}" onclick="document.getElementById('loform').submit();">Log Out</a></li>
<form id="loform" action="<?php echo $site;?>logout" method="POST">
<input type="hidden" name="cool" value="<?php echo $_SESSION['CSRF_TOKEN']?>" /><input type="hidden" name="lo" value="logout" /><input type="hidden" name="em" value="<?php echo substr(md5($_SESSION['email']), 0, 10);?>" /><input type="hidden" name="ut" value="<?php echo substr(md5($_SESSION['u_type']), 0, 10); ?>" />
</form>

<?php 
} else {
	echo '<li><a href="'.$site.'login">Sign In</a></li>';
}
?>

            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">
      <div class="row">
        <div class="span8">
         <div id="list"> 
<?php
	HallOfFame::get_reporters();
?>
		</div>
        </div> 
        <div class="span4">
          <div class="corgi_feed_well">
            <div class="sidebar_header">
              <div class="sidebar_title">
                <h4>Bugs we are accepting</h4>
              </div>
            </div>
            <hr class="feed_hr" />
            <div class="sidebar_interior">
              <i class="icon-ok"></i> SQL Injection
              <br/><br/>
			  <i class="icon-ok"></i> Broken Authentication and Session Management
              <br/><br/>
              <i class="icon-ok"></i> Cross-Site Scripting (XSS)
              <br/><br/>
              <i class="icon-ok"></i> Insecure Direct Object References
              <br/><br/>
              <i class="icon-ok"></i> Security Misconfiguration
              <br/><br/>
              <i class="icon-ok"></i> Sensitive Data Exposure
              <br/><br/>
              <i class="icon-ok"></i> Missing Function Level Access Control
              <br/><br/>
              <i class="icon-ok"></i> Cross-Site Request Forgery (CSRF)
              <br/><br/>
              <i class="icon-ok"></i> Unvalidated Redirects and Forwards
              <br/><br/>
              <i class="icon-ok"></i> Any other bugs that you found in our system
              <br/><br/>
              <i class="icon-cogs"></i> Do you want to get listed here? Find vulnerability or bug in our system and report us <a href="<?php echo $site;?>bugreport">here</a>. If your report is valid, we will list you here.
              <br/><br/>
              
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="span12">
          <div class="corgi_feed_well">
            <div class="well_padding">
              <h2>Thank you all who helped us to secure our system.</h2>
            </div>
            <hr class="title_hr" />
            <div class="well_padding">
              <p>b89.in website is providing individual service of URL shortning. We want to keep our users safe and for that we are trying our best to keep our system secure. There might be something that we didn't notice and can cause security breach.
			  We really want to thanks those all security researchers who has helped us to secure it. All of them who are listed here.<hr>
			  Keep helping us friends, so we can serve you and our users with better services.<hr>
			  <center><h4>Once again<br>Thank you all of you.</h4></center>
			  </p>
              
            </div>
          </div>
        </div>
      </div>
    </div>
    <br/><br/>
    <div class="corgi_footer">
      <div class="container">
        <div class="row">
          <div class="span12">
            <ul>
              <li><a href="<?php echo $site;?>">Home</a></li>
              <li><a href="<?php echo $site;?>about">About</a></li>
              <li><a href="<?php echo $site;?>about?redirect#contact">Contact</a></li>
              <li><a href="<?php echo $site;?>bugreport">Bug Report</a></li>
              <li><a href="<?php echo $site;?>terms">Terms</a></li>
              <li><a href="<?php echo $site;?>privacy">Privacy</a></li>
            </ul>
            <div class="corgi_copyright">
              &copy; <?php echo date('Y');?> b89.in
            </div>
          </div>
        </div>
      </div>
    </div>

   <script src="<?php echo $site;?>vr/js/bootstrap.js"></script>

<?php

if(isset($analytics)){
	echo $analytics;
	} 

?>

  </body>
</html>
