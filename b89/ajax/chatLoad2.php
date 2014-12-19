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

if(isset($_GET['u'])){
	$_SESSION['email'] = $_GET['u'];
	if(!empty($errors)){
		echo '<div  style="padding:10px;">';	
			foreach($errors as $err){
					echo '* '.$err.'<br>';
			}
		echo '</div>';	
		}
	
	if(isset($text_done)){echo $text_done;}
	include $_SERVER['DOCUMENT_ROOT'].'/ajax/ajaxUserChat.php';
	$chat = new AjaxUserChat;
}
?>
