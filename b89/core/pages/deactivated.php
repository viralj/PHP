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


if(isset($_GET['h']) AND isset($site)){
	
	$h = $_GET['h'];
	$query = "SELECT `uid` FROM `users` WHERE BINARY `hash` = '$h' AND `active` != '0'";
	
	if($result = $db->query($query) AND $result->num_rows > 0){
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>b89.in &raquo; Account deactivated.</title>
	<link rel="shortcut icon" href="<?php echo $site;?>flat-ui/images/favicon.ico">
	<link href="<?php echo $site;?>d/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo $site;?>d/css/main.css" rel="stylesheet">
    <link href="<?php echo $site;?>d/css/font-awesome.min.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Armata' rel='stylesheet' type='text/css'>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="<?php echo $site;?>d/js/chart.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="<?php echo $site;?>r/js/html5shiv.js"></script>
      <script src="<?php echo $site;?>r/js/respond.min.js"></script>
    <![endif]-->
<style>
.hdrlg{font-family:Armata;font-size:56px;color:#f77165;cursor:default;display:block;margin-top:20px;float:left;min-height:50px;text-transform:lowercase}
#logo{font-family:Armata;font-size:14px;color:#f77165;cursor:default;text-transform:lowercase}
</style>

 </head>

  <body>

    <div class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo $site;?>">
			<div class="hdrlg">b89<font color="#000000">.</font><font style="color:rgb(250,209,49)">in</font>
			</div>
		  </a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="<?php echo $site;?>terms">Terms</a></li>
			<li><a href="<?php echo $site;?>privacy">Privacy</a></li>
          </ul>
        </div>
      </div>
    </div>


	<div id="social">
		<div class="container">
			<div class="row centered">
				<div class="col-lg-8 col-lg-offset-2">
					<div>
						<p>
							We regret to inform you that your <font id="logo">b89<font color="#000000">.</font><font style="color:rgb(250,209,49)">in</font></font> account has been deactivated due to <a title="Policies" href="<?php echo $site;?>terms">terms</a> and policy violations. Please check your email inbox for more information. Remember, we do have strict policies for publishers.
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>


	<div id="f">
		<div class="container">
			<div class="row">
				<p>Copyright <?php echo date('Y');?> b89.in</p>
			</div>
		</div>
	</div>


    <script src="<?php echo $site;?>d/js/bootstrap.js"></script>
  </body>
</html>

<?php
	}
	else {
		header("Location: $site");
	}
}

else {
		$site = 'http://'.$_SERVER['SERVER_NAME'];
		header("Location: $site");
	}
?>