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

if(isset($_POST['bug_id'])){

include $_SERVER['DOCUMENT_ROOT'].'/core/db_config_inc.php';


	if($result = $db->query("SELECT * FROM  `vul_report` WHERE BINARY `vul_id` =  '{$_POST['bug_id']}' ")){
		if($result->num_rows > 0){
			echo 'You are looking for bug #<b>'.$_POST['bug_id'].'</b>.';
		}else {
			echo 'Bug #<b>'.$_POST['bug_id'].'</b> is not found in our records.';
		}
	}
} 
?>
