<?php
session_start();
if(isset($_SESSION['username'])){
	
	if(isset($_SESSION['access']) && $_SESSION['access'] == 0){
		print "admin access";
	} 
	print "logged";
}else{
	header("Location: login.php?redirect=restricted.php");
}

?>