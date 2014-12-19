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


//this function will update user's link
if(isset($_POST['btn']) AND $_POST['btn'] === "submit"){

$url    = @trim($db->real_escape_string(htmlentities($_POST['url'])));
$lid    = @trim($db->real_escape_string(htmlentities($_POST['lid'])));
$site   = @trim($db->real_escape_string(htmlentities($_POST['site'])));
$nlink1 = @trim($db->real_escape_string(htmlentities($_POST['nlink'])));
$nlink  = preg_replace('/[^a-zA-Z0-9._-]/s', '', $nlink1);
$olink  = @trim($db->real_escape_string(htmlentities($_POST['olink'])));
$cool   = @trim($db->real_escape_string(htmlentities($_POST['cool'])));

$errors = array();

	if($cool = $_SESSION['CSRF_TOKEN']){
	
	
	$check_link_in_db = "SELECT `id` FROM `url_table` WHERE BINARY `code` = '$nlink'";
	
	$link_update_query = "UPDATE `url_table` SET `code` = '$nlink' WHERE BINARY (`u_email` = '{$_SESSION['email']}' AND `id` = '$lid' AND `site` = '$site' AND `url` = '$url' AND `code` = '$olink' AND `archived` = '0') LIMIT 1";
	
		if(strlen($nlink) < 6){
			$errors[] = 'Your custom link must be 6 characters long. If you want to create custom link with minimum characters, please contact us by submitting ticket.';
		}
		if(strlen($nlink) > 100){
			$errors[] = 'Your custom link is too long. Please create short link.';
		}
		if($result = $db->query($check_link_in_db) AND $result->num_rows > 0){
			$errors[] = 'Your custom link is already in use. Please try another.';
		}		
		if($nlink1 != $nlink){
			$errors[] = 'Your custom link is contains invalid characters. Please use A-Z, a-z, 0-9 and special characters like <b>_ - .</b> ';
		}

		
		if(empty($errors)){
			if($result = $db->query($link_update_query) AND $db->affected_rows > 0){
				$errors[] = 'Your links is updated and saved. You can use your custom link now.';
			}else{
				$errors[] = 'We faced some error. Please try again.';
			}
		}
	}
}


$user_site= $site.'user/v1/';

include $_SERVER['DOCUMENT_ROOT'].'/ajax/UserLinks.php';
$usr_links = new UserLinks;


if((user_is_logged_in()) AND ($_SESSION['u_type']=== 'busi')){

?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>b89.in &raquo; Link management.</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<link rel="shortcut icon" href="<?php echo $site;?>flat-ui/images/favicon.ico">
<link href="<?php echo $site;?>user/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo $site;?>user/css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
<link href="<?php echo $site;?>user/css/font-awesome.css" rel="stylesheet">
<link href="<?php echo $site;?>user/css/style.css" rel="stylesheet">
<link href="<?php echo $site;?>user/css/pages/dashboard.css" rel="stylesheet">
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
<script src="<?php echo $site;?>user/js/jquery-1.7.2.min.js"></script> 
<script src="<?php echo $site;?>user/js/scroller.js"></script>
<style>
#linksTbl{min-height:300px;max-height:300px;overflow:scroll;margin:0 auto}
#box2000 > div{-webkit-transition:width .2s ease;-moz-transition:width .2s ease;-o-transition:width .2s ease;-ms-transition:width .2s ease;transition:width .2s ease}
#box2000 > div:hover{width:120%!important;cursor:pointer}
</style> 	
<script type="text/javascript"> 
$('input#inp').keyup(function(){
    str = $(this).val()
    str = str.replace(/\s/g,'')
    $(this).val(str)
});
</script>
<script type="text/javascript"> 
	$(document).ready(function () {
    $("#linksTbl").niceScroll({ autohidemode: true })
    });
	
	setTimeout(function() {
	$("#msgDiv").fadeOut().empty();
	}, 10000);
</script>
<?php 
if(isset($_SESSION['update_error'])){ echo $_SESSION['update_error'];}

?>
</head>
<body>
<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container"> <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><span
                    class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </a><a class="brand" href="<?php echo $user_site;?>manage">b89.in links management</a>
      <div class="nav-collapse">
        <ul class="nav pull-right">
          <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                            class="icon-cog"></i> Account <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="<?php echo $user_site;?>support">Support</a></li>
              <li><a href="<?php echo $user_site;?>support/tickets">Tickets</a></li>
            </ul>
          </li>
          <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                            class="icon-user"></i> b89.in <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="<?php echo $user_site;?>profile">Profile</a></li>
              <li>
					<form id="loform" action="<?php echo $site;?>logout" method="POST">
<input type="hidden" name="cool" value="<?php echo $_SESSION['CSRF_TOKEN']?>" /><input type="hidden" name="lo" value="logout" /><input type="hidden" name="em" value="<?php echo substr(md5($_SESSION['email']), 0, 10);?>" /><input type="hidden" name="ut" value="<?php echo substr(md5($_SESSION['u_type']), 0, 10); ?>" />
						<a href="javascript:{}" onclick="document.getElementById('loform').submit();">Log Out</a>
					</form>	
			  </li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>
<div class="subnavbar">
  <div class="subnavbar-inner">
    <div class="container">
      <ul class="mainnav">
        <li><a  href="<?php echo $user_site;?>home"><i class="icon-dashboard"></i><span>Dashboard</span> </a> </li>
        <li><a href="<?php echo $user_site;?>reports"><i class="icon-list-alt"></i><span>Reports</span> </a> </li>
        <li><a href="<?php echo $user_site;?>purchase"><i class="icon-tags"></i><span>Purchase</span> </a></li>
        <li><a href="<?php echo $user_site;?>chart"><i class="icon-bar-chart"></i><span>Chart</span> </a> </li>
        <li class="active"><a href="<?php echo $user_site;?>manage"><i class="icon-link"></i><span>Manage links</span> </a> </li>
	</ul>
    </div>
  </div>
</div>
<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">
        
        
		<?php 
			if(!empty($errors)){
				echo '<div class="span12" style="padding:15px;" id="msgDiv"><ul>';
				foreach($errors as $error){
					echo '<li>'.$error.'</li>';
				}
				echo '</ul></div>
<script>
$(document).ready(function () {
    // Handler for .ready() called.
    window.setTimeout(function () {
        location.href = "'.$user_site.'manage";
    }, 7000)
});
</script>
				';
			}
		?>
		
        <div class="span12">
          
          <div class="widget widget-table action-table">
            <div class="widget-header"> <i class="icon-th-list"></i>
              <h3>Manage your shorten links. Edit and save links.</h3>
            </div>
			<div class="widget-content" style="min-height:335px">
				<table class="table table-striped table-bordered">
					<thead>
					  <tr style="border-radius: 0px 0px 0px 4px; border-top: 0px none;border-left: medium none;vertical-align: bottom;background: -moz-linear-gradient(center top , #FAFAFA 0%, #E9E9E9 100%) repeat scroll 0% 0% transparent;font-size: 12px;color: #444;font-weight: bold;padding: 8px;line-height: 18px;text-align: left; border-collapse: separate;border-spacing: 0px;">
						<td style="min-width:46.5%;max-width:46.5%;">Links you've added</td>
						<td style="min-width:36.5%;max-width:36.5%;"> Shorten URLs to edit</td>
						<td class="td-actions"> Actions&nbsp;</td>
					  </tr>
					</thead>
				</table>
				<div id="linksTbl">
				<table class="table table-striped table-bordered">
					<tbody>
<?php

$select_url_query = "SELECT * FROM `url_table` WHERE BINARY `u_email` = '{$_SESSION['email']}' AND `archived` = '0' ORDER BY `id` DESC";

if($result = $db->query($select_url_query)){
	if($result->num_rows > 0 AND $rows = $result->fetch_all(MYSQLI_ASSOC)){
		
		foreach($rows as $row){
			echo '<form id="updateLink" action="'.$user_site.'manage" method="post"><tr><td style="min-width:46.5%;max-width:46.5%;"><a href="'.$row['url'].'" target="_blank">'.$row['url'].'</a><input type="hidden" name="url" value="'.$row['url'].'"/><input type="hidden" name="lid" value="'.$row['id'].'"/></td><td style="min-width:36.5%;max-width:36.5%;">'.$row['site'].'<input type="hidden" name="site" value="'.$row['site'].'"/><input type="text" name="nlink" value="'.$row['code'].'" maxlength="200" /><input type="hidden" name="olink" value="'.$row['code'].'"/><input type="hidden" name="cool" value="'.$_SESSION['CSRF_TOKEN'].'"/></td><td class="td-actions"> <button type="submit" class="btn" name="btn" value="submit">Update</button></td></tr></form>';
		}
		
	}
	else {
		echo '<div style="padding:10px; margin:10px; border:1px solid blue; -webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px;">
				Congratulations!!! You\'ve made it. You are member of <b>b89.in</b> website.<br>
				You are just one step away from using our service. Start adding new links from today. Your all shorten links will appear here.<br>
				Remember, we will always be eager to help you. If you have any question, feel free to ask us anytime.<br><br>
				</div>';
	}
}
else {
		echo '<p align="center" style="padding:10px; margin:10px; border:1px solid red; -webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px;">
				We are having some connection issues. Please refresh page. If you keep seeing this, please submit a ticket using `<b>help</b>` portal.</p>';
}
	
?>
					</tbody>
				</table>
				</div>					
			</div>
          </div>
          
        </div>
      </div>
    </div>
  </div>
</div>
<div class="extra">
  <div class="extra-inner">
    <div class="container">
       
    </div>
  </div>
</div>
<div class="footer">
  <div class="footer-inner">
    <div class="container">
      <div class="row">
        <div class="span12"> &copy; <?php echo date("Y");?> b89.in </div>
      </div>
    </div>
  </div>
</div>

<script src="<?php echo $site;?>user/js/bootstrap.js"></script>
 
<script src="<?php echo $site;?>user/js/base.js"></script> 

<?php 
if(isset($analytics)){
	echo $analytics;
	}  
?>
</body>
</html>
<?php 
} else {
	$_SESSION['lo_er'] = 'error';
	$_redirect = $site.'login?error=1';
	header("Location: $_redirect");
}
if(isset($_SESSION['update_error'])){ unset ($_SESSION['update_error']);}
?>