<?php
	
	
	if (isset($_GET['hide'])){
		$cookie = $_GET['cookie'].", ". $_GET['title3'];
		setcookie('omitCookie', $cookie);
 		header('Location: menu.php?events=Events?status=updatecookie');
 		}
 
 
 
 	if(isset($_GET['clear'])){
 		setcookie('omitCookie', 0, time()-3600);
 		header('Location:menu.php?events=Events?status=clearcookie');
 		}
 		
 ?>
