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


class UserLinks{

	public static function update_links($var1, $var2, $var3){
		include $_SERVER['DOCUMENT_ROOT'].'/core/db_config_inc.php';
		
		$update_link_query = "UPDATE `url_table` SET `archived` = '1' WHERE BINARY (`hash` = '$var1' AND `id` = '$var3' AND `u_email` = '$var2')";
		
		if($result = $db->query($update_link_query)){
			if($result AND $db->affected_rows > 0){
				return 1;
			} 
			else {
				return false;
			}
		} else {
				return false;
		}
	
	}
	

	public static function get_user_links($var){
		include $_SERVER['DOCUMENT_ROOT'].'/core/db_config_inc.php';
		
		$email = $var;
		
		$link_fetch_query = "SELECT * FROM `url_table` WHERE BINARY `u_email` = '$email' AND `archived` = 0 ORDER BY `id` DESC";
	
		if($result = $db->query($link_fetch_query)){
			if(($result) AND ($row = $result->fetch_all(MYSQLI_ASSOC))){
			
				echo '<table class="table table-striped table-bordered">
					<thead>
					  <tr style="border-radius: 0px 0px 0px 4px; border-top: 0px none;border-left: medium none;vertical-align: bottom;background: -moz-linear-gradient(center top , #FAFAFA 0%, #E9E9E9 100%) repeat scroll 0% 0% transparent;font-size: 12px;color: #444;font-weight: bold;padding: 8px;line-height: 18px;text-align: left; border-collapse: separate;border-spacing: 0px;">
						<td style="min-width:46.5%;max-width:46.5%;">Links you\'ve added</td>
						<td style="min-width:36.5%;max-width:36.5%;"> Shorten URLS&nbsp;</td>
						<td class="td-actions"> Actions&nbsp;</td>
					  </tr>
					</thead>
				</table>
				<div id="linksTbl">
				<table class="table table-striped table-bordered">
					<tbody>';

					/*
					<tr>
						<td> Fresh Web Development Resources </td>
						<td> http://www.egrappler.com/ </td>
						<td class="td-actions"><a href="javascript:;" class="btn btn-small btn-success"><i class="btn-icon-only icon-ok"> </i></a><a href="javascript:;" class="btn btn-danger btn-small"><i class="btn-icon-only icon-remove"> </i></a></td>
					  </tr>
					*/
					
				foreach($row as $link_details){
					$resulturl = $link_details['url'];
					$suburl = substr($resulturl, 0, 35);
					$newurl = strlen($resulturl);
							
					if($newurl > 35){
					
						$theurl = $suburl.'...';
					} else {
						$theurl = $suburl;
						}
				
				echo '<tr>
						<td style="min-width:46.5%;max-width:46.5%;"> '.$theurl.' </td>
						<td style="min-width:36.5%;max-width:36.5%;"> <a href="'.$link_details['site'].$link_details['code'].'" target="_blank">'.$link_details['site'].'<b>'.$link_details['code'].'</b></a> </td>
						<td class="td-actions">
							<!-- <a href="javascript:;" class="btn btn-small btn-success"><i class="btn-icon-only icon-ok"> </i></a> -->
							<a href="'.$site.'user/v1/home?h='.$link_details['hash'].'&e='.$_SESSION['email'].'&lid='.$link_details['id'].'" class="btn btn-danger btn-small"><i class="btn-icon-only icon-remove"> </i></a>
						</td>
					  </tr>';
				}
				
				echo '</tbody>				
				</table>    
			</div>';
			
			} 
			else if(empty($row)){
				echo '<div style="padding:10px; margin:10px; border:1px solid blue; -webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px;">
				Congratulations!!! You\'ve made it. You are member of <b>b89.in</b> website.<br>
				You are just one step away from using our service. Start adding new links from today. Your all shorten links will appear here.<br>
				Remember, we will always be eager to help you. If you have any question, feel free to ask us anytime.<br><br>
				</div>';
			}
			
			else {
				echo '<p align="center" style="padding:10px; margin:10px; border:1px solid red; -webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px;">
				We are having some connection issues. Please refresh page. If you keep seeing this, please submit a ticket using `<b>help</b>` portal.</p>';
			}
			
		} else {
			echo '<p align="center" style="padding:10px; margin:10px; border:1px solid red; -webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px;">
			We are having some connection issues. Please refresh page. If you keep seeing this, please submit a ticket using `<b>help</b>` portal.</p>';
		}
	
	}
} 

?>
