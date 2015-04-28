<?php
include('dbconn.php');
?>


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
if(isset($_GET['announcement']))
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

		$omitlist = isset($_COOKIE['omitCookie']) ? $_COOKIE['omitCookie'] : "0";
		echo"$omitlist";
		$dbc= connectToDB("kimbvn");
		$query = "SELECT * FROM KISAEVENTS where event_id NOT IN ($omitlist)";
		$result = performQuery($dbc, $query);
		echo "<fieldset><legend><h1> KISA EVENTS PAGE </h1></legend>";
		echo "<img src = \"kisa.jpg\" alt=\"picture\">";
		echo "<br><br><br>";
		echo "<h2> Schedule of Events: </h2>";
		echo"<form method = 'get' action = 'cookieoperation.php'>
		<input type = 'submit' name = 'clear' value = 'Clear Omit'/>
		</form> <br><br>";
		
		echo "<fieldset>";
		echo "<table>";
		$color = "lightblue";
	
		
		while (@extract(mysqli_fetch_array($result, MYSQLI_ASSOC))) {
			$color = $color == "lightgreen" ? "lightyellow": "lightgreen";
			echo "<tr style='background-color: $color'><td>$title</td>
			<td> $date $time <br><br> </td> <td> $address <br><br><br> </td> <td> $description </td> 
			<td> <form method = 'get' action = 'cookieoperation.php'> 
			<input type = 'hidden' name = 'cookie' value = '$omitlist'/>
			<input type = 'hidden' name = 'id' value = '$event_id'/>
			<input type = 'submit' name = 'hide' value = 'Hide Event'/> </form> </td> </tr>\n";
		}
		echo "</table>";
		echo"</fieldset>";
}
