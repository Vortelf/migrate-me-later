<style type="text/css">

	@keyframes show-error {
		from {opacity: 0;}
		to {opacity: 100%;}
	}
	@-webkit-keyframes show-error {
		from {opacity: 0;}
		to {opacity: 100%;}
	}
	.error-msg {
		-webkit-animation-name: show-error;
		-webkit-animation-duration: 0.5s;
		-webkit-animation-iteration-count: 1;
		/*animation: show-error 0.5s 1;*/
		display: none;
		color: #F44336;
		float: right;
		font-weight: bold;
	}
</style>

<script src="../application/views/md5.js"></script>

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
		document.getElementById("validation_check").value = MD5(form.user_name.value);
		hideElement("password-error");
		return true;
	}

	

	
</script>

<div id="content">
	<div class="reg_form">
		<div class="form_title">Sign Up</div>
		<div class="form_sub_title">It's free and anyone can join</div>
		<?php $attributes = array('onsubmit' => 'return checkForm(this);', 'id' => 'register');?>
		<?php echo form_open("oauth/register", $attributes); ?>
		<p>
			<label for="user_name">User Name:</label><p class="error-msg" id="username-error"></p>
			<input type="text" id="user_name" name="user_name" value="<?php echo set_value('user_name'); ?>" />
		</p>
		<p>
			<label for="email">Your Email:</label><p class="error-msg" id="email-error"></p>
			<input type="text" id="email" name="email" value="<?php echo set_value('email'); ?>" />
		</p>
		<p>
			<label for="password">Password:</label><p class="error-msg" id="password-error"></p>
			<input type="password" id="password" name="password" value="<?php echo set_value('password'); ?>" />
		</p>
		<p>
			<label for="con_password">Confirm Password:<p></p>
			<input type="password" id="con_password" name="con_password" value="<?php echo set_value('con_password'); ?>" />
		</p>
		<p>
			<button type="submit" name='submit' class="button">Submit</button>
		</p>
			<input type="hidden" id="validation_check" name="validation_check" value="default" />
		<?php echo form_close(); ?>
		<?php echo validation_errors('<p class="error-msg" style="display:block;">'); ?>
		
	</div><!--<div class="reg_form">-->
</div><!--<div id="content">-->