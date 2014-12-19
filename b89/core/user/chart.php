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
	//line chart
        var lineChartData = {
            labels: ["January", "February", "March", "April", "May", "June", "July"],
            datasets: [
				{
				    fillColor: "rgba(220,220,220,0.5)",
				    strokeColor: "rgba(220,220,220,1)",
				    pointColor: "rgba(220,220,220,1)",
				    pointStrokeColor: "#fff",
				    data: [65, 59, 90, 81, 56, 55, 40]
				},
				{
				    fillColor: "rgba(151,187,205,0.5)",
				    strokeColor: "rgba(151,187,205,1)",
				    pointColor: "rgba(151,187,205,1)",
				    pointStrokeColor: "#fff",
				    data: [28, 48, 40, 19, 96, 27, 100]
				}
			]

        }

        var myLine = new Chart(document.getElementById("area-chart").getContext("2d")).Line(lineChartData);

		//bar chart
        var barChartData = {
            labels: ["January", "February", "March", "April", "May", "June", "July"],
            datasets: [
				{
				    fillColor: "rgba(220,220,220,0.5)",
				    strokeColor: "rgba(220,220,220,1)",
				    data: [65, 59, 90, 81, 56, 55, 40]
				},
				{
				    fillColor: "rgba(151,187,205,0.5)",
				    strokeColor: "rgba(151,187,205,1)",
				    data: [28, 48, 40, 19, 96, 27, 100]
				}
			]

        }

var myLine = new Chart(document.getElementById("bar-chart").getContext("2d")).Bar(barChartData);


*/
//here we will fetch some information of user, user's links and user's revenue from database.

//////////////////////////////////-------------------------------------------------

//first we will fetch data of valid link visits and invalid link visits.

$query = $db->query("SELECT * FROM `user_chart` WHERE BINARY `email` = '{$_SESSION['email']}' ORDER BY `id` DESC LIMIT 5");

if($query AND $query->num_rows > 1 AND $rows = $query->fetch_all(MYSQLI_ASSOC)){
		
		$month = '';
		$valid_link = '';
		$invalid_link = '';

	
	foreach($rows as $row){
		$row_month = explode('/', $row['month_year']);
		$month .= ('"'.$row_month[0].'", ');
		$valid_link .= $row['valid_link'].', ';
		$invalid_link .= $row['invalid_link'].', ';
	}

		$script = '//line chart
        var lineChartData = {
            labels: ['.$month.'],
            datasets: [
				{
				    fillColor: "rgba(220,220,220,0.5)",
				    strokeColor: "rgba(220,220,220,1)",
				    pointColor: "rgba(220,220,220,1)",
				    pointStrokeColor: "#fff",
				    data: ['.$invalid_link.']
				},
				{
				    fillColor: "rgba(151,187,205,0.5)",
				    strokeColor: "rgba(151,187,205,1)",
				    pointColor: "rgba(151,187,205,1)",
				    pointStrokeColor: "#fff",
				    data: ['.$valid_link.']
				}
			]

        }

        var myLine = new Chart(document.getElementById("area-chart").getContext("2d")).Line(lineChartData);
';

}



$user_site= $site.'user/v1/';

//lets check user type and allow to display page else redirect to user's page
$u_type = array('free', 'pro', 'busi');

if((user_is_logged_in()) AND (in_array($_SESSION['u_type'], $u_type))){

?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>b89.in &raquo; User links chart.</title>
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
<?php
if(isset($script)){
?>
<script src="<?php echo $site;?>user/js/scroller.js"></script>
<style>
#linksStatus{max-height:200px;overflow:scroll;margin:0 auto;}
#box2000 > div{-webkit-transition:width .2s ease;-moz-transition:width .2s ease;-o-transition:width .2s ease;-ms-transition:width .2s ease;transition:width .2s ease;}
#box2000 > div:hover{width:120%!important;cursor:pointer;}
table{width:100%;border-collapse:separate;border-spacing: 5px;}
th{border:1px grey solid;width:30%;font-size:16px;-webkit-border-radius:15px;-moz-border-radius:15px;border-radius:15px;}
td{width:30%;text-align:center;font-size:14px;}
</style>
<script type="text/javascript"> 
    $(document).ready(function () {
    $("#linksStatus").niceScroll({ autohidemode: true })
    });
</script>
<?php
}
?>
<style>
table{width:100%;border-collapse:separate;border-spacing: 5px;}
th{border:1px grey solid;width:30%;font-size:16px;-webkit-border-radius:15px;-moz-border-radius:15px;border-radius:15px;}
td{width:30%;text-align:center;font-size:14px;}
</style>
</head>
<body>
<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container"> <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><span
                    class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </a><a class="brand" href="<?php echo $user_site;?>chart">b89.in user links chart</a>
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
        <li><a href="<?php echo $user_site;?>home"><i class="icon-dashboard"></i><span>Dashboard</span> </a> </li>
        <li><a href="<?php echo $user_site;?>reports"><i class="icon-list-alt"></i><span>Reports</span> </a> </li>
        <li><a href="<?php echo $user_site;?>purchase"><i class="icon-tags"></i><span>Purchase</span> </a></li>
        <li class="active"><a href="<?php echo $user_site;?>chart"><i class="icon-bar-chart"></i><span>Chart</span> </a> </li>
<?php		
	if($_SESSION['u_type'] === 'busi'){
		echo '<li><a href="'.$user_site.'manage"><i class="icon-link"></i><span>Manage links</span> </a></li>';
	}	
?>		
      </ul>
    </div>
  </div>
</div>
<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">
			<div style="min-height:360px;">
			
			
			<div class="span6">
<?php
/*                      
					  <div class="widget">
                            <div class="widget-header">
                                <i class="icon-bar-chart"></i>
                                <h3>
                                    Your total earnings compare to other publishers.</h3>
                            </div>
                            <div class="widget-content">
                                <canvas id="bar-chart" class="chart-holder" width="538" height="250">
                                </canvas>
                            </div>
                        </div>
 */?>                      
                        
                    </div>
                    <div class="span12">
                        <div class="widget">
                            <div class="widget-header">
                                <i class="icon-bar-chart"></i>
                                <h3>
                                    Your valid visited links VS invalid views.</h3>
                            </div>
                            <div class="widget-content">
<?php
if(isset($script)){
	echo '<canvas id="area-chart" class="chart-holder" width="900" height="350"></canvas>
		  <div style="color:rgba(220,220,220,2);"><u>Invalid links</u></div>
			<div style="color:rgba(151,187,205,2);"><u>Valid links</u></div>';
}else {
	echo 'We do not have your link report yet. Please come back later.';
}
?>
							</div>
                        </div>                        
                    </div>
<?php
$query = $db->query("SELECT * FROM `user_chart` WHERE BINARY `email` = '{$_SESSION['email']}' ORDER BY `id` DESC");
if($query AND $query->num_rows > 0 AND $rows = $query->fetch_all(MYSQLI_ASSOC)){
	
	echo '	<div class="span12">
        <div class="widget">
            <div class="widget-header">
				<h3>
                Total valid and invalid links count</h3>
            </div>
			<div class="widget-content">
			<p><b>Note</b>: Status of your links are not 100% accurate. If you have deactivated your any link recently, it will take time to get updated in your account.</p>	
				<table>
					<tr>
						<th>Month and Year</th><th>Valid links</th><th>Invalid links</th>
					<tr>
				</table>
				<br>
			<div id="linksStatus">
				<table>';
	
	foreach($rows as $row){
		$row_month = explode('/', $row['month_year']);
		echo '<tr><td style="text-align:left;">'.$row_month[0].' '.$row_month[1].'</td><td>'.$row['valid_link'].'</td><td>'.$row['invalid_link'].'</td></tr>';
	}
		
	echo '</table>
			</div>
			</div>
		</div>
	</div>';
}
?>										
								
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

	<script src="<?php echo $site;?>user/js/excanvas.min.js"></script>
    <script src="<?php echo $site;?>user/js/chart.min.js" type="text/javascript"></script>
    <script src="<?php echo $site;?>user/js/bootstrap.js"></script>
    <script src="<?php echo $site;?>user/js/base.js"></script>

<?php
	if(isset($script)){
		echo '<script>'.$script.'</script>';
	}
?>	

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