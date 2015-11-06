 jQuery(function(){
	 jQuery("#name").validate({
		expression: "if (VAL) return true; else return false;",
		message: "Please enter User Name"
	});	
	 jQuery("#username").validate({
		expression: "if (VAL.length>=6) return true; else return false;",
		message: "Please enter min 6 letters "
	});	
	jQuery("#message").validate({
		expression: "if (VAL) return true; else return false;",
		message: "Please enter message"
	});
	jQuery("#captcha").validate({
		expression: "if (VAL) return true; else return false;",
		message: "Please enter captcha"
	});
	 jQuery("#password").validate({
		expression: "if (VAL) return true; else return false;",
		message: "Please enter a Password"
	});
	 jQuery("#password").validate({
		expression: "if (VAL.length > 5) return true; else return false;",
		message: "Please enter a min 5 letters "
	});
	 jQuery("#repassword").validate({
		expression: "if (VAL) return true; else return false;",
		message: "Please enter retype password"
	});	
	jQuery("#repassword").validate({
		expression: "if ((VAL == jQuery('#password').val()) && VAL) return true; else return false;",
		message: "Please enter same password"
	});	
	jQuery("#fname").validate({
		expression: "if (VAL) return true; else return false;",
		message: "Please enter Firstname"
	});
	jQuery("#lname").validate({
		expression: "if (VAL) return true; else return false;",
		message: "Please enter the Lastname"
	});
	jQuery("#email").validate({
		expression: "if (VAL.match(/^[^\\W][a-zA-Z0-9\\_\\-\\.]+([a-zA-Z0-9\\_\\-\\.]+)*\\@[a-zA-Z0-9_]+(\\.[a-zA-Z0-9_]+)*\\.[a-zA-Z]{2,4}$/)) return true; else return false;",
		message: "Please enter a valid Email ID"
	});
	jQuery("#dob").validate({
		expression: "if (VAL) return true; else return false;",
		message: "Please enter date-of-birth"
	});
	jQuery("#address").validate({
		expression: "if (VAL) return true; else return false;",
		message: "Please enter Address"
	});
	jQuery("#phone").validate({
		expression: "if (!isNaN(VAL) && VAL && VAL.length == 10 ) return true; else return false;",
		message: "Enter Valid Phone Number"
	});  
	jQuery("#uname").validate({
		expression: "if (VAL) return true; else return false;",
		message: "Please enter User Name"
	});	
	 jQuery("#pwd").validate({
		expression: "if (VAL.length>=6) return true; else return false;",
		message: "Please enter min 6 letters "
	});	
	
	 
});
