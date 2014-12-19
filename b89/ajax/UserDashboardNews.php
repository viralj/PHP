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

// user's dashboard news widget codes that fetches all new data from server and shows to user.

class UserDashNews {


	public static function fetch_news_from_db(){
		
		include $_SERVER['DOCUMENT_ROOT'].'/core/db_config_inc.php';
		
		$news_fetch_query = "SELECT * FROM `site_news` WHERE `show` = 0 ORDER BY `id` DESC";
		
		if($result = $db->query($news_fetch_query)){
			if(($result) AND ($row = $result->fetch_all(MYSQLI_ASSOC))){
			
				echo '<ul class="news-items">';
                
				foreach($row as $news_result){
					echo'<li style="width:90%">
					  <div class="news-item-date"> <span class="news-item-day">'.$news_result['date'].'</span> <span class="news-item-month">'.$news_result['month'].'<br>'.$news_result['year'].'</span> </div>
					  <div class="news-item-detail"> <a class="news-item-title" target="_blank">'.$news_result['title'].'</a>
						<p class="news-item-preview">'.html_entity_decode(nl2br((stripslashes($news_result['news'])))).'</p>
					  </div>
					</li>';
				}
              echo '</ul>';
			
					
			} 
			else if(empty($row)){
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


/*
<ul class="news-items">
                	
                <li>
                  
                  <div class="news-item-date"> <span class="news-item-day">29</span> <span class="news-item-month">Oct</span> </div>
                  <div class="news-item-detail"> <a href="http://www.egrappler.com/open-source-jquery-php-ajax-contact-form-templates-with-captcha-formify/" class="news-item-title" target="_blank">Open Source jQuery PHP Ajax Contact Form Templates With Captcha: Formify</a>
                    <p class="news-item-preview"> Formify is a contribution to lessen the pain of creating contact forms. The collection contains six different forms that are commonly used. These open source contact forms can be customized as well to suit the need for your website/application.</p>
                  </div>
                  
                </li>
              </ul>
*/

?>
