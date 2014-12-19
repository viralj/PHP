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

if((isset($_POST['submit'])) AND ($_POST['submit'] === 'submit') AND (isset($_POST['cool'])) AND ($_POST['cool'] === $_SESSION['CSRF_TOKEN'])){
	
	$reporter = trim($db->real_escape_string(htmlentities($_POST['reporter'])));
	$bug_id   = trim($db->real_escape_string(htmlentities($_POST['bugid'])));
	$txt	  = trim($db->real_escape_string(htmlentities($_POST['txt'])));
	$time	  = date('l jS \of F Y\, h:i:s A');
	
	
	//lets set public profile links
	
	if(!empty($_POST['fb'])){
		$fb = trim($db->real_escape_string(htmlentities($_POST['fb'])));
	}
	else{
		$fb = '';
	}
	
	if(!empty($_POST['twt'])){
		$twt = trim($db->real_escape_string(htmlentities($_POST['twt'])));
	}
	else{
		$twt = '';
	}
	
	if(!empty($_POST['li'])){
		$li = trim($db->real_escape_string(htmlentities($_POST['li'])));
	}
	else{
		$li = '';
	}
	
	if(!empty($_POST['gplus'])){
		$gplus = trim($db->real_escape_string(htmlentities($_POST['gplus'])));
	}
	else{
		$gplus = '';
	}
	
	if(!empty($_POST['persweb'])){
		$persweb = trim($db->real_escape_string(htmlentities($_POST['persweb'])));
	}
	else{
		$persweb = '';
	}
	
	if(!empty($_POST['pic'])){
		$pic = trim($db->real_escape_string(htmlentities($_POST['pic'])));
	}
	else{
		$pic = $site.'vr/img/reporter.jpg';
	}
	
	
	$insert_reporter = "INSERT INTO `vul_reporters` (
						`bug_id`, `reporter`, `pic`, `fb`, `twt`, `gplus`, `li`, `pers_web`, `text`, `time`
						) 
						VALUES (
						'$bug_id', '$reporter', '$pic', '$fb', '$twt', '$gplus', '$li', '$persweb', '$txt', '$time'
						)";
	
	if($result = $db->query($insert_reporter) AND $db->affected_rows > 0){
		echo '<h3>Bug reporter updated.</h3><br>';
		exit();
	}
	else{
		echo '<h3>Unable to insert data. Please check connection or codes.</h3><br>';
		exit();
	}
	
}


$admin_site= $site.'manage/admin/';

if((user_is_logged_in()) AND ($_SESSION['u_type'] === 'admin')){

?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>b89.in &raquo; Admin add bug reporter.</title>
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
<script type="text/javascript">
function addreporter(){
	var reporter = $('#reporter').val();
	var bugid = $('#bugid').val();
	var pic = $('#pic').val();
	var cool = $('#cool').val();
	var fb = $('#fb').val();
	var twt = $('#twt').val();
	var li = $('#li').val();
	var gplus = $('#gplus').val();
	var persweb = $('#persweb').val();
	var txt = $('#txt').val();
	var submit = $('#submit').val();
		
		if(reporter == ''){
			alert('Reporter name is required.');
		}
		else
		
		if(bugid == ''){
			alert('Bug ID is required.');
		}
		else
		
		if(txt == ''){
			alert('Appreciation message is required.');
		}
		else{
			$('#result').html('Working <img src="<?php echo $site;?>img/loading.gif" /><br>');
			$.post('<?php echo $admin_site;?>addBugReporters', {reporter:reporter,cool:cool,bugid:bugid,pic:pic,fb:fb,twt:twt,li:li,gplus:gplus,persweb:persweb,txt:txt,submit:submit},
			function(data){
				$('#result').html(data);				
			});
		}		
	}
</script>
</head>
<body>
<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container"> <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><span
                    class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </a><a class="brand" href="<?php echo $admin_site;?>addBugReporters">b89.in admin add bug reporter</a>
      <div class="nav-collapse">
        <ul class="nav pull-right">
          
          <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                            class="icon-user"></i> b89.in <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="<?php echo $admin_site;?>profile">Profile</a></li>
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
        <li><a href="<?php echo $admin_site;?>home"><i class="icon-dashboard"></i><span>Dashboard</span> </a> </li>
        <li><a href="<?php echo $admin_site;?>news"><i class="icon-list-alt"></i><span>News</span> </a> </li>
        <li><a href="<?php echo $admin_site;?>tickets"><i class="icon-list-alt"></i><span>Tickets</span> </a> </li>
        <li><a href="<?php echo $admin_site;?>genContact"><i class="icon-envelope-alt"></i><span>General Contact</span> </a> </li>
        <li><a href="<?php echo $admin_site;?>bugs"><i class="icon-list-alt"></i><span>Bug reports</span> </a> </li>
		<li><a href="<?php echo $admin_site;?>sendEmail"><i class="icon-envelope-alt"></i><span>Send Email</span> </a> </li>
		<li><a href="<?php echo $admin_site;?>users"><i class="icon-user"></i><span>Users</span> </a> </li>
		<li><a href="<?php echo $admin_site;?>SendBulkEmail"><i class="icon-envelope-alt"></i><span>Send bulk email</span> </a> </li>
		<li class="active"><a href="<?php echo $admin_site;?>addBugReporters"><i class="icon-user"></i><span>Hall-of-fame</span> </a> </li>
      </ul>
    </div>
  </div>
</div>
<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">
			<div style="min-height:350px;" class="span12">
				<span id="result"><br></span>
				<div class="tab-content">
									<div class="tab-pane active" id="formcontrols">
								<form id="sendEmail" class="form-horizontal" enctype="multipart/form-data" method="POST" action="<?php echo $admin_site;?>sendEmail" autocomplete="off">
									<fieldset>
										
										<div class="control-group">											
											<label class="control-label" for="title">Reporter</label>
											<div class="controls">
												<input  type="text" class="span6" id="reporter" name="reporter" placeholder="Name" />
												
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
										<div class="control-group">											
											<label class="control-label" for="title">Bug ID</label>
											<div class="controls">
												<input  type="text" class="span6" id="bugid" name="bugid" placeholder="Bug ID">																								
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
										<div class="control-group">											
											<label class="control-label" for="title">Picture</label>
											<div class="controls">
												<input  type="text" class="span6" id="pic" name="pic" placeholder="https://xyz.com/pic.jpg">																								
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
										<div class="control-group">											
											<label class="control-label" for="title">Facebook</label>
											<div class="controls">
												<input  type="text" class="span6" id="fb" name="fb" placeholder="https://fb.com/">																								
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
										<div class="control-group">											
											<label class="control-label" for="title">Twitter</label>
											<div class="controls">
												<input  type="text" class="span6" id="twt" name="twt" placeholder="https://twitter.com/">																								
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										

										<div class="control-group">											
											<label class="control-label" for="title">Google+</label>
											<div class="controls">
												<input  type="text" class="span6" id="gplus" name="gplus" placeholder="https://www.google.com/+">																								
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										

										<div class="control-group">											
											<label class="control-label" for="title">LinkedIn</label>
											<div class="controls">
												<input  type="text" class="span6" id="li" name="li" placeholder="https://www.linkedin.com/">																								
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										

										<div class="control-group">											
											<label class="control-label" for="title">Personal website</label>
											<div class="controls">
												<input  type="text" class="span6" id="persweb" name="perswrb" placeholder="http://xyz.com/">																								
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
										
										<div class="control-group">											
											<label class="control-label" for="text">Appreciation</label>
											<div class="controls">
												<textarea  type="text" class="span6" rows="8" id="txt" name="txt" placeholder="Say thanks to reporter." ></textarea>
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
									
									<br>
											
										<div class="form-actions">
										<input type="hidden" class="span6" name="cool" id="cool" value="<?php echo $_SESSION['CSRF_TOKEN'];?>">
											<button type="button" class="btn btn-primary" id="submit" name="submit" value="submit" onclick="addreporter();">Submit</button> 
											<button type="reset" class="btn">Cancel</button>
										</div> <!-- /form-actions -->
									
									
									
									</fieldset>
								</form>
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
}
else{
	$login = $site.'login';
	header("Location: $login");
}
?>