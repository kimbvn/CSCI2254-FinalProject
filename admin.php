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
		
	</script>
</head>
<body>
<h1> KISA Admin Page</h1>
<?php
	if(isset($_POST['send'])) {
		handleform();
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
	if(isset($_GET['announcements'])) {
		announcement();
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

function announcement() {






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

?>
		
	
		
