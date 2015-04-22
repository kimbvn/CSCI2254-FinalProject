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
	
		
		function validateEmail2() {
			var theemail = document.getElementById("email2").value;
			if(theemail.length < 1) {
				var errorrpt = document.getElementById("emailerror2");
				errorrpt.innerHTML = "Please enter the valid email";
				return false;
			}
			var errorrpt = document.getElementById("emailerror2");
			errorrpt.innerHTML = "";
			return true;
		}
	
	</script>
</head>
<body>
	<h1> Welcome to KISA! </h1>
<?php

if(isset($_POST['submit'])) {
	handleform();
}	else if(isset($_GET['forgot'])) {
	findpassword();
}	else if(isset($_GET['reset2'])) {
	handlereset();
}
 ?>
 </body>
 </html>
 <?php

function handleform() {
	$proceed = 1;
	
	if($_POST['password'] != $_POST['repassword']) {
		echo "The passwords do not match. Please fill the form again.<br>";
		echo "<a href=\"index.php\">  Return to fill the form</a>";
	}
	else {
		$duplicate = duplicate_email($_POST['email']);
		if(!$duplicate && $proceed != 0) {
			insert_user($_POST['firstname'],$_POST['lastname'],$_POST['address'],$_POST['phone'],$_POST['email'],$_POST['password'],$_POST['membershiptype']);
		}
		else {	
			echo "The email is already in use. Please type other email.<br>";
			echo "<a href=\"index.php\">  Return to fill the form</a>";

		}
	}
}
	
?>
<?php
function duplicate_email($email) {
	$dbc = connectToDB();
	$query = "SELECT* FROM KISA where Email='$email'";
	$result = performQuery($dbc,$query);
	while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
		if(mysqli_num_rows($result) == !0) {
			return true;
		}
		else {
			return false;// no duplicate so can insert
		}
	}
	disconnectFromDB($dbc,$result);
}

function insert_user($firstname,$lastname,$address,$phone,$email,$password,$membershiptype) {
	$encode = sha1($password);
	$dbc = connectToDB();
	$query = "INSERT INTO KISA(Firstname,Lastname,Address,Phone,Email,Password,RegistrationDate,MembershipType) VALUES('$firstname','$lastname','$address','$phone','$email','$encode',now(),'$membershiptype')";
	$result = performQuery($dbc,$query);
	if($result == 1) {
		echo "Successfully registered!<br><br>";
		echo "Thank you $firstname, you are now registered.<br>";
		echo "<a href=\"project.php\"> Return to the Home Page</a><br>";
	}
	else {
		echo "Error. Please fill the form again.<br>";
		$_GET['operation'];
		}
	disconnectFromDB($dbc,$result);
}

function findpassword() {
	echo "<fieldset><legend> Please fill out the form to find the password </legend>
			<form name = \"form2\" method=\"get\" action=\"dboperation.php\" onsubmit=\"return validate2();\">";
		echo "<label> Email: </label>";
		echo "<input type=\"text\" name = \"email2\" id=\"email2\"/>";
		echo "<span class=\"ereport\" id=\"emailerror2\"></span>";
		echo "<br><br>";
		echo "<input type=\"submit\" name=\"reset\" value=\"Reset the password\">";
		echo "<input type=\"hidden\" name=\"reset2\" value=\"reset\">";
		echo "</form></fieldset>";
}

function handlereset() {
	$duplicate = duplicate_email($_GET['email2']);
	$email = $_GET['email2'];
	if($duplicate) {
		$newpassword = create_password();
		sendemail($email,$newpassword);
		update_user($email,$newpassword);
	}
	else {
		echo "$email do not exists in our database.<br>";
		echo "Please try again.";
		echo "<a href=\"project.php\">  Return to reset the password</a><br>";
	}
}

function create_password(){
      $letters = "abcdefghijkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789";
      $pw = "";
      for($i=1; $i<=8; $i=$i+1) {
        $index = rand(0, strlen($letters)-1);
        $nextLetter = substr($letters, $index, 1);
        $pw = $pw . $nextLetter;
      }
      return $pw;
}

function update_user($email, $newpassword){
	$dbc= connectToDB();
	$password = sha1($newpassword);
	$query = "UPDATE KISA SET Password=\"$password\" WHERE Email=\"$email\"";
	$result = performQuery($dbc, $query);
	if($result == 1){
		echo "Thank you, your new password has been sent to your email.<br>";
		echo "<a href=\"project.php\">Return to Home</a>";
	}
}

function sendemail($email, $newpassword){
	$to=$email;
	$subject='Your password has been reset';
	$body="Your password has been reset to: ".$newpassword;
	$headers = 'From: KISA';
	if (mail($to, $subject, $body, $headers)) {
		echo "<h3>Email was sent successfully </h3>";
	} else {
		echo "Email was not sent<br><a href=\"project.php\">Return to Home</a>";
	}
}
?>
	
