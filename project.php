<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<title> KISA </title>
	<link rel="stylesheet" type="text/css" href="styles.css">
	<script type="text/javascript">  //HERE
	
		function validate() {
			var validFName = validateFName();
			var validLName = validateLName();
			var validEmail = validateEmail();
			var validPassword = validatePassword();
			var validType = validateType();
			var validPhone = validatePhone();
			var validAdd = validateAddress();

			if(validFName && validLName && validEmail && validPassword && validType && validAdd && validPhone) {
				return true; 
			}
			else {
				return false;
			}
		}
		
		function validateFName() {
			var firstn= document.getElementById("firstname").value;
			if(firstn.length < 1 ) {
				var errorrpt = document.getElementById("fnameerror");
				errorrpt.innerHTML = "Please enter your name";
				return false;
			}
			var errorrpt = document.getElementById("fnameerror");
			errorrpt.innerHTML = "";
			return true;
		}
		
		function validateLName() {
			var lastn = document.getElementById("lastname").value;
			if(lastn.length<1) {
				var errorrpt = document.getElementById("lnameerror");
				errorrpt.innerHTML = "Please enter your name";
				return false;
			}
			var errorrpt = document.getElementById("lnameerror");
			errorrpt.innerHTML = "";
			return true;
		}
		
		function validateEmail() {
			var theemail = document.getElementById("email").value;
			if(theemail.length < 1) {
				var errorrpt = document.getElementById("emailerror");
				errorrpt.innerHTML = "Please enter the valid email";
				return false;
			}
			var errorrpt = document.getElementById("emailerror");
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
		
		function validateAddress() {
			var theemail = document.getElementById("address").value;
			if(theemail.length < 1) {
				var errorrpt = document.getElementById("addresserror");
				errorrpt.innerHTML = "No address";
				return false;
			}
			var errorrpt = document.getElementById("addresserror");
			errorrpt.innerHTML = "";
			return true;
		}
		
		function validatePhone() {
			var thephone = document.getElementById("phone").value;
			var ph = new RegExp("^[0-9]{3}-[0-9]{3}-[0-9]{4}$");
			if(!ph.test(thephone)) {
				var errorrpt = document.getElementById("phoneerror");
				errorrpt.innerHTML = "No phone<br> ex)123-456-7890";
				return false;
			}
			var errorrpt = document.getElementById("phoneerror");
			errorrpt.innerHTML = "";
			return true;
		}
			
		function validateType() {
			var type = document.forms["myform"].membershiptype;
			var typelength = type.length;
			for(var i = 0; i < typelength; i ++ ) {
				if(type[i].checked) {
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
	
	&nbsp &nbsp &nbsp <h1> Welcome to KISA! </h1>
<?php
	if(isset($_GET['join'])) {
		displayuserform();
	} else {
	displayForm();
	handleform();
}
?>


</body>
</html>
<?php
function displayForm(){
?>
	<fieldset>
	<img src = "kisa.jpg" alt="picture">
	<br>
	<a href = "https://www.facebook.com/groups/101185056632545/"> Go to KISA Facebook page </a>
	<br><br><br>
	
	<div id="login">
	<table id="menu">
	<form method="get" action="menu.php">
	<tr class="menu">
		<td><input type="submit" class="menu" name="introduction" value="Introduction"/></td>
	</tr>
 	<tr class="menu">
    	<td><input type="submit" class="menu" name="eboard" value="E-Board"/></td>
  	</tr>
	<tr class="menu">
    	<td><input type="submit" class="menu" name="soccer" value="Soccer Team"/></td>
    </tr>
	<tr class="menu">
    	<td><input type="submit" class="menu" name="events" value="Events"/></td>
  	</tr>
    <tr class="menu">
    	<td><input type="submit" class="menu" name="announcements" value="Announcements"/></td>
  	</tr>
  	</form>
	</table>	

	
	<form method="post"> 
	&nbsp &nbsp &nbsp
	<label>USERNAME</label>
	<input name="username" type="text" value="">
	<br>
	
	&nbsp &nbsp &nbsp
	<label>PASSWORD</label>
	<input name="password" type="password" value="">
	<input name="login" type="submit" value="login">
	</form>
	
	
	<br><br><br><br><br><br><br>
	<form method="get">
	<input type = "submit" name = "join" value = "Join KISA"/>

	</form>
	
	<form method="get" action="dboperation.php">
	<input type = "submit" name = "forgot" value="I forgot my password"/>
	
	</form>
	
	<form method="get" action="admin.php">
	<input type= "submit" name="admin" value="Admin Login"/>
	</form>
	
	</div>
</fieldset>


	
<?php
}


function handleform() {
	if(isset($_POST['login'])) {
		if($_POST['username'] == "" || $_POST['password'] == "") {
			echo "Invalid username and password.";
		} else {
			echo "Welcome back!";
		}
	}	
	
}

	
function displayuserform() {
 
 	echo "<fieldset><legend> Please fill out the form </legend>";
 	echo "<br><br>";
 	echo "<form name = \"myform\" method = \"post\" action =\"dboperation.php\" onsubmit=\"return validate();\">";
 	echo "<table>
 			<tr>
 				<td><label> Firstname :</label></td>
 				<td><input type=\"text\" name = \"firstname\" id=\"firstname\"/></td>
 				<td><span class=\"ereport\" id=\"fnameerror\"></span></td>
 			</tr>
 			<tr>
 				<td><label>LastName :</label></td>
 				<td><input type=\"text\" name =\"lastname\" id=\"lastname\"/></td>
 				<td><span class=\"ereport\" id=\"lnameerror\"></span></td>
 			</tr>
 			<tr>
				<td><label> Address: </label></td>
				<td><input type=\"text\" name=\"address\" id=\"address\"/></td>
				<td><span class=\"ereport\" id=\"addresserror\"></span></td>
			</tr>
			<tr>
				<td><label> Phone: </label></td>
				<td><input type=\"text\" name=\"phone\" id=\"phone\"/></td>
				<td><span class=\"ereport\" id=\"phoneerror\"></span></td>
			</tr>
 			<tr>
 				<td><label>Email :</label></td>
 				<td><input type=\"text\" name=\"email\" id=\"email\"/></td>
 				<td><span class=\"ereport\" id=\"emailerror\"></span></td>
 			</tr>
 			<tr>
 				<td><label>Password :</label></td>
 				<td><input type=\"password\" name=\"password\" id=\"password\"/></td>
 				<td><span class=\"ereport\" id=\"passworderror\"></span></td>
 			</tr>
 			<tr>
 				<td><label> Confirm password:</label></td>
 				<td><input type=\"password\" name=\"repassword\" id=\"repassword\"/></td>
 				<td> 	</td>
 			</tr>
 			<tr>
 				<td><label> Membership Type: </label></td>
 				<td><input type=\"radio\" name=\"membershiptype\" id=\"radio1\" value=\"admin\"/> Admin<br>
 				<input type=\"radio\" name=\"membershiptype\" id=\"radio2\" value=\"eboard\"/> E-Board<br>
 				<input type=\"radio\" name=\"membershiptype\" id=\"radio3\" value=\"member\"/> Member<br>
 				<td><span class=\"ereport\" id=\"typeerror\"></span></td>
			</tr>
			<tr>
 			<td><input type=\"submit\" name=\"submit\" id=\"submit\" value=\"Join the club\"></td>
 			<td> </td>
 			<td></td>
 			</tr>
 		</table>
 		</form></fieldset>";
 	
}

?>
