<?php
include('dbconn.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<title> KISA </title>
	<link rel="stylesheet" type="text/css" href="styles.css">
	<script type="text/javascript">  //HERE
	
	
	function validate() {
			var validSubject = validateSubject();
			var validMsg = validateMessage();
			var validPw = validatePassword();
			var validType = validateType();

			if(validSubject && validMsg && validPw && validType) {
				return true; 
			}
			else {
				return false;
			}
		}
		
	function validateSubject() {
		var firstn= document.getElementById("subject").value;
		if(firstn.length < 1 ) {
			var errorrpt = document.getElementById("subjecterror");
			errorrpt.innerHTML = "Please enter the subject";
			return false;
		}
		var errorrpt = document.getElementById("subjecterror");
		errorrpt.innerHTML = "";
		return true;
	}
		
	function validateMessage() {
		var message = document.getElementById("message").value;
		var format = new RegExp("[A-Za-z0-9]+");
		if(!format.test(message)) {
			var errorrpt = document.getElementById("messageerror");
			errorrpt.innerHTML = "No message";
			return false;
		}
		var errorrpt = document.getElementById("messageerror");
		errorrpt.innerHTML = "";			
		return true;
	}
	

	
	function validatePassword() {
			var thepw = document.getElementById("password").value;
			if(thepw.length < 1) {
				var errorrpt = document.getElementById("passworderror");
				errorrpt.innerHTML = "Password is too short";
				return false;
			}
			var errorrpt = document.getElementById("passworderror");
			errorrpt.innerHTML = "";
			return true;
		}
			
	function validateType() {
		var types = document.forms["myform"].types;
		var typelength = types.length;
		for(var i = 0; i < typelength; i ++ ) {
			if(types[i].checked) {
				var errorrpt = document.getElementById("typeerror");
				errorrpt.innerHTML = "";
				return true;
			}
		}
		var errorrpt = document.getElementById("typeerror");
		errorrpt.innerHTML = "Please select membership type";
		return false;
	}
	
		function validate2() {
			var validTitle = validateTitle();
			var validMonth = validateMonth();
			var validDate = validateDate();
			var validTime = validateTime();
			var validDescrption = validateDescription();

			if(validTitle && validMonth && validDate && validTime && validDescription) {
				return true; 
			}
			else {
				return false;
			}
		}
		
		
	function validateTitle() {
		var firstn= document.getElementById("title").value;
		if(firstn.length < 1 ) {
			var errorrpt = document.getElementById("titleerror");
			errorrpt.innerHTML = "Please enter a title";
			return false;
		}
		var errorrpt = document.getElementById("titleerror");
		errorrpt.innerHTML = "";
		return true;
	}
	
	
	function validateMonth() {
		var firstn= document.getElementById("month").value;
		if(firstn == "" ) {
			var errorrpt = document.getElementById("montherror");
			errorrpt.innerHTML = "Please enter the month";
			return false;
		}
		var errorrpt = document.getElementById("montherror");
		errorrpt.innerHTML = "";
		return true;
	}
	
	
	function validateDate() {
		var firstn= document.getElementById("date").value;
		if(firstn == "" ) {
			var errorrpt = document.getElementById("dateerror");
			errorrpt.innerHTML = "Please enter the date";
			return false;
		}
		var errorrpt = document.getElementById("dateerror");
		errorrpt.innerHTML = "";
		return true;
	}
	
	function validateTime() {
		var firstn= document.getElementById("time").value;
		if(firstn.length < 1 ) {
			var errorrpt = document.getElementById("timeerror");
			errorrpt.innerHTML = "Please enter the time";
			return false;
		}
		var errorrpt = document.getElementById("timeerror");
		errorrpt.innerHTML = "";
		return true;
	}
	
	function validateDescription() {
		var message = document.getElementById("description").value;
		var format = new RegExp("[A-Za-z0-9]+");
		if(!format.test(message)) {
			var errorrpt = document.getElementById("descriptionerror");
			errorrpt.innerHTML = "Please enter a description";
			return false;
		}
		var errorrpt = document.getElementById("descriptionerror");
		errorrpt.innerHTML = "";			
		return true;
	}
	
	
	
		
	</script>
</head>
<body>
<h1> KISA Admin Page</h1>
<?php
	if(isset($_POST['send'])) {
		handleform();
	} 
	if (isset($_POST['make'])){
		makeevent();
	}
	if(isset($_GET['admin'])) {
		displayLogin();
	}
	if(isset($_POST['adminlogin'])) {
			$adminpw = "1785ed6ccf537856a2e5d0935a1ffb2dde2d3ab5";
			if(sha1($_POST['password']) == "1785ed6ccf537856a2e5d0935a1ffb2dde2d3ab5") {
				displayform();
				}
				else {
					echo "The Admin password is wrong.";
				}
	}
	if(isset($_GET['email'])) {
		email();
	}
	if(isset($_GET['announcement'])) {
		event();
	}
?>

</body>
</html>

<?php
function displayform() {
	echo "<fieldset><legend> Club Members </legend>";
	echo "<table>
			<tr><th>Name</th>
				<th>Type</th>
				<th>Address</th>
				<th>Phone</th>
				<th>Email</th>
				<th>Registration Date</th>
			</tr>";

	$dbc = connectToDB();
	$query = "SELECT * FROM KISA";
	$result = performQuery($dbc,$query);
	
	while(@extract($row = mysqli_fetch_array($result, MYSQLI_ASSOC))) {
		$firstname = $row['FirstName'];
		$lastname = $row['LastName'];
		$type = $row['MembershipType'];
		$address = $row['Address'];
		$phone = $row['Phone'];
		$email = $row['Email'];
		$date = $row['RegistrationDate'];

	echo "<tr>
			<td>$firstname $lastname</td>
			<td>$type</td>
			<td>$address</td>
			<td>$phone</td>
			<td>$email</td>
			<td>$date</td>
			</tr>";
			
	}
	echo"</table></fieldset>";
	disconnectFromDB($dbc,$result);
	
	echo"<form method=\"get\">";
	echo"<input type=\"submit\" name=\"email\" value=\"Create Group Email\"/>";
	echo"<input type=\"submit\" name=\"announcement\" value=\"Make announcements\"/>";
	echo"</form>";
}

function email() {	
	echo "<fieldset class=\"admin\"><legend>Create Group Mail</legend>";
	echo "<form name=\"myform\" method=\"post\" action=\"admin.php\" onsubmit=\"return validate();\">";
	echo "<table>
		<tr>
		<td><label> Subject </label></td>
		<td><input type=\"text\" name=\"subject\" id=\"subject\"/></td>
		<td><span class=\"ereport\" id=\"subjecterror\"></span></td>
		</tr>
		
		<tr>
		<td><label> Message </label></td>
		<td><textarea name=\"message\" cols=\"50\" rows=\"10\" id=\"message\"> </textarea></td>
		<td><span class=\"ereport\" id=\"messageerror\"></span></td>
		</tr>
		
		<tr>
		<td><label> Admin Password </label></td>
		<td><input type=\"password\" name=\"password\" id=\"password\"/></td>
		<td><span class=\"ereport\" id=\"passworderror\"></span></td>
		</tr>
		
		<tr>
		<td><label> Membership Type</label></td>
		<td><input type=\"checkbox\" name=\"types\" id=\"radio1\" value=\"admin\"/> Admin<br>
 				<input type=\"checkbox\" name=\"types\" id=\"radio2\" value=\"board\"/> E-Board<br>
 				<input type=\"checkbox\" name=\"types\" id=\"radio4\" value=\"member\"/> Member<br></td>
 				
 		<td>		<span class=\"ereport\" id=\"typeerror\"></span></td>
 		</tr>
 		<tr>
 		<td><input type=\"submit\" name=\"send\" id=\"send\" value=\"Send\"/></td>
 		<td> </td>
 		<td> </td>
 		</tr>
 		</table>
 		</form></fieldset>";

}

function event() {
	echo "<fieldset class=\"admin\"><legend>Create Event</legend>";
	echo "<form name=\"eventform\" method=\"post\" action=\"admin.php\" onsubmit=\"return validate2();\">";
	echo "<table>
		<tr>
		<td><label> Title </label></td>
		<td><input type=\"text\" name=\"title\" id=\"title\"/></td>
		<td><span class=\"ereport\" id=\"titleerror\"></span></td>
		</tr>
		<tr>
		<td><label> Month </label></td>
		<td><select name = 'month1' id = 'month'>
				<option value = ''> </option>
				<option value = 'Jan'>January</option>
				<option value = 'Feb'>February</option>
				<option value = 'Mar'>March</option>
				<option value = 'Apr'>April</option>
				<option value = 'May'>May</option>
				<option value = 'Jun'>June</option>
				<option value = 'Jul'>July</option>
				<option value = 'Aug'>August</option>
				<option value = 'Sep'>September</option>
				<option value = 'Oct'>October</option>
				<option value = 'Nov'>November</option>
				<option value = 'Dec'>December</option>
			</select></td>
		<td><span class=\"ereport\" id=\"montherror\"></span></td>
		</tr>
		<tr>
		<td><label> Date </label></td>
		<td><select name = 'date1' id = 'date'>
				<option value = ''> </option>
				<option value = '1'>1</option>
				<option value = '2'>2</option>
			 	<option value = '3'>3</option>
				<option value = '4'>4</option>
				<option value = '5'>5</option>
				<option value = '6'>6</option>
				<option value = '7'>7</option>
				<option value = '8'>8</option>
				<option value = '9'>9</option>
				<option value = '10'>10</option>
				<option value = '11'>11</option>
				<option value = '12'>12</option>
				<option value = '13'>13</option>
				<option value = '14'>14</option>
				<option value = '15'>15</option>
				<option value = '16'>16</option>
				<option value = '17'>17</option>
				<option value = '18'>18</option>
				<option value = '19'>19</option>
				<option value = '20'>20</option>
				<option value = '21'>21</option>
				<option value = '22'>22</option>
				<option value = '23'>23</option>
				<option value = '24'>24</option>
				<option value = '25'>25</option>
				<option value = '26'>26</option>
				<option value = '27'>27</option>	
				<option value = '28'>28</option>
				<option value = '29'>29</option>
				<option value = '30'>30</option>
				<option value = '31'>31</option>
			</select></td>
		<td><span class=\"ereport\" id=\"dateerror\"></span></td>
		</tr>
		<tr>
		<td><label> Time </label></td>
		<td><input type=\"text\" name=\"time\" id=\"time\"/></td>
		<td><span class=\"ereport\" id=\"timeerror\"></span></td>
		<td><input type = 'radio' name = 'ampm' value = 'am' checked = 'checked'> AM 
		<input type = 'radio' name = 'ampm' value = 'pm' > PM
		</td>
		</tr>
		<tr>
		<td><label> Description </label></td>
		<td><textarea name=\"description\" cols=\"50\" rows=\"10\" id=\"description\"> </textarea></td>
		<td><span class=\"ereport\" id=\"descriptionerror\"></span></td>
		</tr>
		<tr>
 		<td><input type=\"submit\" name=\"make\" id=\"make\" value=\"Make Event!\"/></td>
 		<td> </td>
 		<td> </td>
 		</tr>
 		</table>
 		</form></fieldset>";

}


function displayLogin() {
	echo "<form method=\"post\"/>";
	echo "<input type=\"password\" name=\"password\" />";
	echo "<input type=\"submit\" name=\"adminlogin\" value=\"Log In\"/>";
	echo "</form>";
}

function handleform() {
	$subject = $_POST['subject'];
	$password = $_POST['password'];
	$message = $_POST['message'];
	$types = $_POST['types'];
	$adminpw = "1785ed6ccf537856a2e5d0935a1ffb2dde2d3ab5";
	if(sha1($password) == $adminpw) {
		$dbc = connectToDB();
		$query = "SELECT * FROM KISA WHERE MembershipType=\"$types\"";
		$result = performQuery($dbc,$query);
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$email = $row['Email'];
			sendemail($subject,$email,$message);
		}
		disconnectFromDB($dbc,$result);
		echo "Message was sent successfully.<br>";
		echo "<a href=\"http://cscilab.bc.edu/~kimbvn/hw11/admin.php\">Return to the admin page</a><br>";
	}
	else {
		echo "Admin Password is incorrect.<br>";
	}
}

function sendemail($subject,$email,$message) {
	$to = $email;
	$subject = $subject;
	$letter = $message;
	$headers = 'From: Ellen Club';
	mail($to,$subject,$letter,$headers);
}

function makeevent(){
	$title = $_POST['title'];
	$month1 = $_POST['month1'];
	//echo"$month";
	$date1 = $_POST['date1'];
	//echo"$date";
	$time = $_POST['time'];
	$AMPM = $_POST['ampm'];
	echo"$AMPM";
	$description = $_POST['description'];
	insert_event($title, $month, $date1, $time1, $AMPM, $description);
	
}


function insert_event($title, $month, $date, $time, $AMPM, $description) {
	$dbc = connectToDB();
	$query = "INSERT INTO KISAEVENTS(title, date, time, description, lastupdated ) VALUES('$title', '$month' . '$date', '$time' . '$AMPM', '$description', now())";
	$result = performQuery($dbc,$query);
	if($result == 1) {
		echo "Event Successfully Made!<br><br>";
		echo "<a href=\"project.php\"> Return to the Home Page</a><br>";
	}
	else {
		echo "Error. Please fill the form again.<br>";
		$_GET['operation'];
		}
	disconnectFromDB($dbc,$result);
}



?>
		
	
		
