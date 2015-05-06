<script type="text/javascript">
		function validate() {
			var validPlayers = validatePlayers();
			var validSchool = validateSchool();
			var validNumber2 = validateNumber2();
			var validAddress = validateAddress();
			var validPhone = validatePhone();
			var validComment = validateComment();
			var validDate = validateDate();

			if(validPlayers && validSchool && validNumber2 &&  validAddress 
			&& validPhone && validComment) {
				return true;
			} return false;
		}
		
		function validateSchool() {
			var firstn= document.getElementById("school").value;
			if(firstn.length < 1 ) {
				var errorrpt = document.getElementById("schooleerror");
				errorrpt.innerHTML = "Enter the name of other school";
				return false;
			}
			var errorrpt = document.getElementById("schoolerror");
			errorrpt.innerHTML = "";
			return true;
		}
		
		function validateDate() {
			var firstn= document.getElementById("date").value;
			var date = new RegExp("/^\d{1,2}\/\d{1,2}\/\d{4}$/;");

			if(!date.test(firstn)) {
				var errorrpt = document.getElementById("dateerror");
				errorrpt.innerHTML = "Please enter the valid date";
				return false;
			}
			var errorrpt = document.getElementById("dateerror");
			errorrpt.innerHTML = "";
			return true;
		}
		
		

		
		function validatePlayers() {
			var lastn = document.getElementById("players").value;
			if(lastn.length<1) {
				var errorrpt = document.getElementById("playerserror");
				errorrpt.innerHTML = "Enter the number of players";
				return false;
			}
			var errorrpt = document.getElementById("playerserror");
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
			
		function validateNumber2() {
			var theurl = document.getElementById("number2").value;
			if(theurl.length<1) {
				var errorrpt = document.getElementById("number2error");
				errorrpt.innerHTML = "Please enter the Number of players of other school";
				return false;
			}
			var errorrpt = document.getElementById("number2error");
			errorrpt.innerHTML = "";
			return true;
		}
		
		function validateComment() {
		var message = document.getElementById("comment").value;
		var format = new RegExp("[A-Za-z0-9]+");
		if(!format.test(message)) {
			var errorrpt = document.getElementById("commenterror");
			errorrpt.innerHTML = "No comment";
			return false;
		}
		var errorrpt = document.getElementById("commenterror");
		errorrpt.innerHTML = "";			
		return true;
	}	
	</script>
