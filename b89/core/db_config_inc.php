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


$db = new mysqli ('localhost', 'root', '', 'b89');
$db_err = $db->connect_errno;
if($db->connect_errno){
	die('Sorry, we are having some connection issue with database. Please check configuration file.<br>'.$db_err);
	}
	else {
		include_once 'session.php';
		}
	
$site = 'http://b89.in/';
$analytics = "";



