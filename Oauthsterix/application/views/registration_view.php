<head>
	<title>Registration - Oauthsterix</title>
</head>

<script type="text/javascript">
	function showElement(target){
		document.getElementById(target).style.display = 'block';
	}
	function hideElement(target){
		document.getElementById(target).style.display = 'none';
	}

	function checkForm(form) {
		error_handler = document.getElementById("username-error");
		if(form.user_name.value == "") {
			error_handler.innerHTML="Please enter Username.";
			showElement("username-error");
			form.user_name.focus();
			return false;
		} else hideElement("username-error");

		
		error_handler = document.getElementById("email-error");
		if(form.email.value == "") {
			// alert("Error: Моля въведете Вашия имейл. (Той ще Ви служи за вход в сайта.)");
			error_handler.innerHTML="Please enter your email.";
			showElement("email-error");
			form.email.focus();
			return false;
		} else hideElement("email-error");

		re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
		if(!re.test(form.email.value)) {
			error_handler.innerHTML="The entered email is not valid.";
			showElement("email-error");
			form.email.focus();
			return false;
		} else hideElement("email-error");
		

		error_handler = document.getElementById("password-error");
		if(form.password.value != "" && form.password.value == form.con_password.value) {
			if(form.password.value.length < 8) {
				error_handler.innerHTML="Your password length must be at least 8 symbols.";
				showElement("password-error");
				form.password.focus();
				return false;
			} else hideElement("password-error");
			if(form.password.value == form.email.value) {
				error_handler.innerHTML="Your Password must be different from your email.";
				showElement("password-error");
				form.password.focus();
				return false;
			} else hideElement("password-error");
			re = /[0-9]/;
			if(!re.test(form.password.value)) {
				// alert("Error: Паролата Ви трябва да съдържа поне една цифра (0-9).");
				error_handler.innerHTML="Your password must have atleast one digit (0-9).";
				showElement("password-error");
				form.password.focus();
				return false;
			} else hideElement("password-error");
			re = /[A-Z]/;
			if(!re.test(form.password.value)) {
				// alert("Error: Паролата Ви трябва да съдържа поне една малка буква.");
				error_handler.innerHTML="Your password must have al least one UPPERCASE letter.";
				showElement("password-error");
				form.password.focus();
				return false;
			} else hideElement("password-error");

		} else {
			// alert("Error: Моля уверете се, че въведените от Вас пароли съвпадат.");
			error_handler.innerHTML="Entered passwords don't match.";
			showElement("password-error");
			form.password.focus();
			return false;
		}

		// alert("You entered a valid password: " + form.password.value);
		document.getElementById("validation_check").value = 1;
		// alert(MD5(form.user_name.value));
		hideElement("password-error");
		return true;
	}
</script>

	
		<?php echo validation_errors(); ?>

<div class="CONTENT_">
	<div id="reg_form">
		<div class="form_title"><h2>Sign Up</h2></div>
		<?php $attributes = array('onsubmit' => 'return checkForm(this);', 'id' => 'register');?>
		<?php echo form_open("oauth/registration", $attributes); ?>
		<p>
			<label for="user_name">User Name:</label><p class="error-msg" id="username-error"></p>
			<input type="text" id="user_name" name="user_name" value="<?php echo set_value('user_name'); ?>" />
		</p>
		<fieldset>
			<legend for="credentials">Login Credentials:</legend>
			<p>
				<label for="email">Your Email:</label><p class="error-msg" id="email-error"></p>
				<input type="text" id="email" name="email" value="<?php echo set_value('email'); ?>" />
			</p>
			<p>
				<label for="password">Password:</label><p class="error-msg" id="password-error"></p>
				<input type="password" id="password" name="password" value="<?php echo set_value('password'); ?>" />
			</p>
			<p>
				<label for="con_password">Confirm Password:</label><p></p>
				<input type="password" id="con_password" name="con_password" value="<?php echo set_value('con_password'); ?>" />
			</p>
		</fieldset>
		<fieldset>
			<legend for="personal_info">Personal Info:</legend>
			<p>
				<label for="first_name">First Name:</label>
				<input type="text" id="first_name" name="first_name" value="<?php echo set_value('first_name'); ?>" />
			</p>
			<p>
				<label for="last_name">Last Name: </label>
				<input type="text" id="last_name" name="last_name" value="<?php echo set_value('last_name'); ?>" />
			</p>
			<label for="age">Date of Birth:</label>
			<div id="age_select">
				<select id="ageday" name="ageday" value="<?php echo set_value('ageday'); ?>">
					<?php for ($i = 1; $i <= 31; $i++) : ?>
					<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
					<?php endfor; ?>
				</select>
				<select id="agemonth" name="agemonth" value="<?php echo set_value('ageday'); ?>">
					<?php for ($i = 1; $i <= 12; $i++) : ?>
					<option value="<?php echo $i; ?>"><?php echo jdmonthname($i*28,3); ?></option>
					<?php endfor; ?>
				</select>
				<select id="ageyear" name="ageyear" value="<?php echo set_value('ageday'); ?>">
					<?php for ($i = 2015; $i >= 1900; $i--) : ?>
					<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
					<?php endfor; ?>
				</select>
			</div>
			<p>
				<label for="phone">Phone Number: </label>
				<input type="text" id="phone" name="phone" value="<?php echo set_value('phone'); ?>" />
			</p>
			<!-- 
			<input type="number" min="1" max="31" id="ageday" name="ageday" value="<?php echo set_value('ageday'); ?>" placeholder="DD" />
			<input type="number" min="1" max="12" id="agemonth" name="agemonth" value="<?php echo set_value('agemonth'); ?>" placeholder="MM"/>
			<input type="number" min="1900" max="2015" id="ageyear" name="ageyear" value="<?php echo set_value('ageyear'); ?>" placeholder="YYYY" />
		 	-->
		</fieldset>
		<p>
			<button type="submit" name='submit' class="button">Submit</button>
		</p>
			<input type="hidden" id="validation_check" name="validation_check" value="default" />
		<?php echo form_close(); ?>
		
		
	</div><!--<div class="reg_form">-->
</div><!--<div id="content">-->