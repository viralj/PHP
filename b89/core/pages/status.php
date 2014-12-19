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


class StatusTimeline{
	
	public function fetch_news_as_status(){
	
		include $_SERVER['DOCUMENT_ROOT'].'/core/db_config_inc.php';
		
		$news_fetch_query = "SELECT * FROM `site_news` WHERE `show` = 0 ORDER BY `id` DESC";
		
		if($result = $db->query($news_fetch_query)){
			if(($result) AND ($row = $result->fetch_all(MYSQLI_ASSOC))){
			
				echo '<ul class="timeline">';
                $i = 1;
				foreach($row as $news_result){
					
					
					//below codes are to set side of timeline post
					$var1 = $i;
					$var2 = 2;
					$divided = $var1 / $var2;
					
					if(is_float($divided)){
						$timeline_side = 'class="timeline-inverted"';
					} else {
						$timeline_side = '';
					}
					
					
					//below codes are to check for news type
					if($news_result['news_type'] == 0){
						$timeline_badge = 'success';
					} else 
					if($news_result['news_type'] == 1){
						$timeline_badge = 'danger';
					}
					
					echo'<li '.$timeline_side.'>
					  <div class="timeline-badge '.$timeline_badge.'"><i class="glyphicon glyphicon-check"></i></div>
					  <div class="timeline-panel">
						<div class="timeline-heading">
						  <h4 class="timeline-title">'.$news_result['title'].'</h4>
						</div>
						<h6>'.$news_result['updated'].'</h6>
						<hr>
						<div class="timeline-body">
						  <p>'.html_entity_decode(nl2br(stripslashes($news_result['news']))).'</p>
						</div>
					  </div>
					</li>';
					$i++;
				}
              echo '</ul>';
			
					
			} 
			else if(!empty($row)){
				echo '<div style="padding:10px; margin:10px; border:1px solid green; -webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px;">
				There is nothing to show. We will post news soon as we get updates.
				<hr>
				<h5>You will read news about</h5>
				<ul>
					<li><b>b89.in</b> website\'s new features,</li>
					<li>Latest updates on website,</li>
					<li>Mega companies that has joined <b>b89.in</b></li>				
				</ul>
				<hr>
				<h4>Till then, go green!!!</h4>
				</div>';
			}
			
			else {
				echo '<p align="center" style="padding:10px; margin:10px; border:1px solid red; -webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px;">
				We are having some connection issues. Please refresh page. If you keep seeing this, please submit a ticket using `<b>help</b>` portal.</p>';
			}
		}
		else {
			echo '<p align="center" style="padding:10px; margin:10px; border:1px solid red; -webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px;">
			We are having some connection issues. Please refresh page. If you keep seeing this, please submit a ticket using `<b>help</b>` portal.</p>';
		}
		
	
	}

}



?><!DOCTYPE html>
<html>
<head>
<title>b89.in &raquo; Services status.</title>
 <link rel="shortcut icon" href="<?php echo $site; ?>flat-ui/images/favicon.ico">
        <link rel="stylesheet" href="<?php echo $site; ?>flat-ui/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="<?php echo $site; ?>css/allbugs.css">
		<script src="<?php echo $site; ?>common-files/js/jquery-1.10.2.min.js"></script>
        <script src="<?php echo $site; ?>flat-ui/js/bootstrap.min.js"></script>
		<script src="<?php echo $site;?>user/js/scroller.js"></script>
		
<style>
@font-face {
  font-family: 'Armata';
  font-style: normal;
  font-weight: 400;
  src: local('Armata'), local('Armata-Regular'), url(<?php echo $site;?>fonts/Armata.woff) format('woff');
}
.hdrlg {
font-family: 'Armata';
font-size: 56px;
color: #f77165;
cursor: default;
display: block;
min-height: 50px;
}

#statusTimeline{min-height:400px;max-height:400px;overflow:scroll;padding-right:15px;margin:0 auto}
#box2000 > div{-webkit-transition:width .2s ease;-moz-transition:width .2s ease;-o-transition:width .2s ease;-ms-transition:width .2s ease;transition:width .2s ease}
#box2000 > div:hover{width:120%!important;cursor:pointer}
</style>
<script type="text/javascript"> 
    $(document).ready(function () {
    $("#statusTimeline").niceScroll({ autohidemode: true })
    });
</script>
</head>
<body>

<div class="container">
    <div class="page-header">
        <h1 id="timeline"><div class="hdrlg"><a href="<?php echo $site;?>" title="Home">
        <img src="<?php echo $site;?>img/logo.png" /></a>
    <font color="#000000" style="font-size:18px;">Timeline of b89.in services.</font></div></h1>
    All information posted here is about our service updates, status of our system and new features that we will update in our system.
	</div>
	
	 <?php 
										if(user_is_logged_in()){
								   ?>
<form id="loform" action="<?php echo $site;?>logout" method="POST">
<input type="hidden" name="cool" value="<?php echo $_SESSION['CSRF_TOKEN']?>" /><input type="hidden" name="lo" value="logout" /><input type="hidden" name="em" value="<?php echo substr(md5($_SESSION['email']), 0, 10);?>" /><input type="hidden" name="ut" value="<?php echo substr(md5($_SESSION['u_type']), 0, 10); ?>" />
						<a href="javascript:{}" onclick="document.getElementById('loform').submit();">Log Out</a>
</form>
								   <?php 
									   } else {
									   echo 'Got b89.in account? <a href="'.$site.'login">Sign In</a> here or click to <a href="'.$site.'">Sign Up</a>.';
									   }
								   ?>

			<div>&nbsp;</div>					   
	<div id="statusTimeline">
<?php

	StatusTimeline::fetch_news_as_status();

?>
	</div>
	<footer style="padding-top:15px;">&copy <?php echo date('Y');?> b89.in <font style="float:right;">Stay safe, go <font style="color:green;">green</font>.</font></footer>
</div>
<?php 
if(isset($analytics)){
	echo $analytics;
	} 
 
?> 
</body>
</html>