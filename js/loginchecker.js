function validate_Input(){
	var valid = new Boolean(true);
	var usernameChecker = document.forms["registerform"]["myusername"].value;
	var emailChecker = document.forms["registerform"]["myemail"].value;
	var passwdChecker = document.forms["registerform"]["password1"].value; 
	var confirmPasswdChecker = document.forms["registerform"]["password2"].value;
	var fNameChecker = document.forms["registerform"]["myfirstname"].value;
	var lNameChecker document.forms["registerform"]["mylastname"].value;

	if(usernameChecker == ""){
		valid = false;
		alert("Please enter your custom username");
	}
	if(emailChecker == ""){
		valid = false;
		alert("Please enter your email");
	}
	if(fNameChecker == ""){
		valid = false;
		alert("Please enter your firstname");
	}
	if(lNameChecker == ""){
		valid = false;
		alert("Please enter your lastname");
	}
	if(!passwdChecker == "" && confirmPasswdChecker == ""){
		if(!passwdChecker == confirmPasswdChecker)
		{
			valid = false;
			alert("Please make sure your passwords are correct");
		}
	}
	else{
		valid = false;
		alert("Please make sure you have set your password");
	}
	return valid;
}