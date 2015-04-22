<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<title> KISA </title>
	<link rel="stylesheet" type="text/css" href="styles.css">
	<script type="text/javascript">		
		function validate2() {
			var validEmail2 = validateEmail2();
			if(validEmail2) {
				return true;
			} else
				return false;
		}
	</script>
</head>
<body>
<?php
if(isset($_GET['introduction'])) 
	display_introduction();
if(isset($_GET['eboard']))
	display_eboard();
if(isset($_GET['soccer']))
	display_soccer();
if(isset($_GET['events']))
	display_events();
if(isset($_GET['announcements']))
	display_announcements();


?>
</body>
</html>
<?php
function display_introduction() {
	echo "<fieldset><legend><h1> Introduction of KISA </h1></legend>";
	echo "<img src = \"kisa.jpg\" alt=\"picture\">";
	echo "<br><br><br>Korean International Students Association is an unofficial organization of 
		Korean international students at Boston College. ";
	echo "<br><br><br>";
	echo "<h2> 2015 - 2016 </h2>";

	echo "<h2>President        Vice-President</h2>";

	echo "<h3>Sungwon Kim'15      Kyuwon Lee'15 </h3>"; 
	
	echo "<h2> Head Mentors </h2>";
	echo "<h3> CSOM: Hayun Lee'14       A&S: Jee In Seo'15 </h3>";
		

}

function display_eboard() {

}

function display_soccer() {
}

function display_events() {

}
