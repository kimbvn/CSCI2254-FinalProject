<?php
function connectToDB() {
	$dbc = @mysqli_connect("localhost","kimbvn","agTKw48F","kimbvn") or
		die("Connect failed:".mysqli_connect_error());
	return ($dbc);
}

function disconnectFromDB($dbc,$result) {
	mysqli_free_result($result);
	mysqli_close($dbc);
}

function performQuery($dbc,$query) {
	$result = mysqli_query($dbc,$query) or die("bad query".mysqli_error($dbc));
	return ($result);
}

?>
