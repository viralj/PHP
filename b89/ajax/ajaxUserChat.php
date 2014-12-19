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

//this is ajax php user chat class file.

class AjaxUserChat{
	
	function __construct(){
		
		if($this->check_user_names() === true){
			echo '<div id="chatInput" style="height:80px; margin-top:5px; margin-bottom:15px; padding:10px;">
					
						<input type="hidden" id="cool" name="cool" value="'.$_SESSION['CSRF_TOKEN'].'" />
					    <textarea type="text" required id="text" name="text" placeholder="Tell everyone what you are up to..." spellcheck="true" style="width:80%; padding:5px; float:left;" autocomplete="off"></textarea>
						<button class="btn btn-primary" style="padding:10px; margin-left:25px" id="tell" name="tell" value="tell" onClick="javascript:usrUpto();">Tell </button>
					
				</div>';
				
			$this->display_user_chat();
		} 
		
	}
	
	public static function display_user_chat(){
	
	include $_SERVER['DOCUMENT_ROOT'].'/core/db_config_inc.php';
	$chat_fetch_query = "SELECT * FROM `chat` WHERE `archived` = 0 ORDER BY `id` DESC LIMIT 100";
	
	if($result = $db->query($chat_fetch_query)){
		if(($result) AND ($rows = $result->fetch_all(MYSQLI_ASSOC))){
			
				//echo '<pre>';
				//print_r($row);
				//echo '</pre>';
		
			echo '<ul id="msg_lo" class="messages_layout">';
				
				$i = 1;
				foreach ($rows as $row){
				
				//lets divide chat id so we can show where to show chat.
				$var1 = $i;
				$var2 = 2;
				$divided = $var1 / $var2;
				
				if(is_float($divided)){
					//$side = 'by_myself left';
					$img = 'message_avatar2.png';
				} else {
					//$side = 'by_myself left';
					$img = 'message_avatar1.png';
				}
				
				//lets check that logged in user is viewer or not
						
					if($row['u_email'] == $_SESSION['email']){
					//	$commentator = '<div class="info"> <a class="name" id="usrSelf" >'.$row['fname'].' '.$row['lname'].' { <u>'.$row['uname'].'</u> } (myself) </a> <span class="time">'.relativetime($row['date']).'</span>';
						$side = 'by_myself right';	
						$commentator = '<div class="info"> <a class="name" id="usrSelf" > ME </a> <span class="time">'.relativetime($row['date']).'</span>';	
						$chat_option_button = '<li><a href="'.$site.'user/v1/home?h='.$row['chat_hash'].'&e='.$_SESSION['email'].'&u='.$_SESSION['uname'].'&cid='.$row['id'].'&c='.$_SESSION['CSRF_TOKEN'].'&do=delete"><i class=" icon-trash icon-large"></i> Delete</a></li>';
					} else {
						$side = 'by_myself left';
						$commentator = '<div class="info"> <a class="name">'.$row['fname'].' '.$row['lname'].' { <u>'.$row['uname'].'</u> } </a> <span class="time">'.relativetime($row['date']).'</span>';
						$chat_option_button = '<li><a href="'.$site.'user/v1/home?h='.$row['chat_hash'].'&e='.$_SESSION['email'].'&u='.$_SESSION['uname'].'&cid='.$row['id'].'&c='.$_SESSION['CSRF_TOKEN'].'&do=report"><i class=" icon-share-alt icon-large"></i> Report</a></li>';
					}
				
				//lets see that chat is allowed to display or not
				
				if($row['display'] == 0){
					$text = html_entity_decode(nl2br((stripslashes($row['text']))));
				}else {
					$text = 'This chat <u><b>text</b></u> is not allowed to display due to reported content.<br>We suggest you not to write stuffs that can disturb other users.<br><br><b>ACT LIKE YOU ARE WITH YOUR FAMILY.</b>';
				}
				
				
			echo '<li class="'.$side.'"> <a class="avatar"><img src="'.$site.'user/img/'.$img.'"/></a>
					  <div class="message_wrap" style="min-width:400px"> <span class="arrow"></span>
						'.$commentator.'
						  <div class="options_arrow">
							<div class="dropdown pull-right"> <a class="dropdown-toggle " id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="#"> <i class=" icon-caret-down"></i> </a>
							  <ul class="dropdown-menu " role="menu" aria-labelledby="dLabel">
								'.$chat_option_button.'								
							  </ul>
							</div>
						  </div>
						</div>
						<div class="text" >'.$text.'</div>
					  </div>
					</li>';				
				
				$i++;
				}		
			echo '</ul>';	
			
			
		} 
		else if(empty($rows)){
			echo '<div style="padding:10px; margin:10px; border:1px solid blue; -webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px;">
				There is no user who is up to something. If you are, tell everyone. See other\'s opinion or ask for help.<br>
				Enjoy all precious moments. :D
				</div>';
		}
		
		else {
			echo '<div style="border:1px solid blue; opacity: 0.2;filter: alpha(opacity=50); background:white; padding:5px; min-height:100%; min-width:90%; -webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px;"><p style="opacity: 1.9;filter: alpha(opacity=50); padding:5px; color:black; z-index: 2;">We are facing some connectivity issues. Please refresh the page.</p></div>';
		}
	}

	}
	
	public static function check_user_names(){
		
		//lets check that user has added his first and last names or not
		// in not then user will not be able to use chat system
		
		include $_SERVER['DOCUMENT_ROOT'].'/core/db_config_inc.php';
		
		$check_name_query = "SELECT `fname`,`lname`, `uname` FROM `users` WHERE BINARY `email` = '{$_SESSION['email']}'";
		if($result = $db->query($check_name_query)){
			if(($result) AND ($row = $result->fetch_array(MYSQLI_ASSOC))){
				
				if(empty($row['fname']) OR empty($row['lname']) OR empty($row['uname'])){
					echo '<div style="border:1px solid red; padding:5px; min-height:100%; min-width:90%; -webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px;"><p style="padding:5px;">You need to update your profile to use this service.</p>
					<hr>
					<h4 style="padding:5px;">You can use this communication system for...</h4>
							
					<ul>
							<li>Asking for help,</li><li>Share anything that you want to share with other users,</li><li>Help other users who is facing trouble with our system</li><li>Suggest us features that you want us to add.</li>
					</ul><hr>
					<p style="padding:5px;"><b>Remember</b>, we do not want anyone to harass any other user. So please behave like you are in home.</p>
					</div>';
				
				}else {
				$_SESSION['fname'] = $row['fname'];
				$_SESSION['lname'] = $row['lname'];
				return true;
				}
				
			} else {
				echo 'You need to add your name in your profile to start chatting with other users.';
			}
		} else {
			echo 'Sorry but we are having some connection errors. Please refresh page.';
		}
	
	}
	


}






/*			  
<ul id="msg_lo" class="messages_layout">
                <li class="from_user left"> <a href="#" class="avatar"><img src="<?php echo $site;?>user/img/message_avatar1.png"/></a>
                  <div class="message_wrap"> <span class="arrow"></span>
                    <div class="info"> <a class="name">John Smith</a> <span class="time">1 hour ago</span>
                      <div class="options_arrow">
                        <div class="dropdown pull-right"> <a class="dropdown-toggle " id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="#"> <i class=" icon-caret-down"></i> </a>
                          <ul class="dropdown-menu " role="menu" aria-labelledby="dLabel">
                            <li><a href="#"><i class=" icon-share-alt icon-large"></i> Reply</a></li>
                            <li><a href="#"><i class=" icon-trash icon-large"></i> Delete</a></li>
                            <li><a href="#"><i class=" icon-share icon-large"></i> Share</a></li>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="text"> As an interesting side note, as a head without a body, I envy the dead. There's one way and only one way to determine if an animal is intelligent. Dissect its brain! Man, I'm sore all over. I feel like I just went ten rounds with mighty Thor. </div>
                  </div>
                </li>
                <li class="by_myself right"> <a href="#" class="avatar"><img src="<?php echo $site;?>user/img/message_avatar2.png"/></a>
                  <div class="message_wrap"> <span class="arrow"></span>
                    <div class="info"> <a class="name">Bender (myself) </a> <span class="time">4 hours ago</span>
                      <div class="options_arrow">
                        <div class="dropdown pull-right"> <a class="dropdown-toggle " id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="#"> <i class=" icon-caret-down"></i> </a>
                          <ul class="dropdown-menu " role="menu" aria-labelledby="dLabel">
                            <li><a href="#"><i class=" icon-share-alt icon-large"></i> Reply</a></li>
                            <li><a href="#"><i class=" icon-trash icon-large"></i> Delete</a></li>
                            <li><a href="#"><i class=" icon-share icon-large"></i> Share</a></li>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="text"> All I want is to be a monkey of moderate intelligence who wears a suit… that's why I'm transferring to business school! I had more, but you go ahead. Man, I'm sore all over. I feel like I just went ten rounds with mighty Thor. File not found. </div>
                  </div>
                </li>
                
              </ul>			  
*/			  

?>
