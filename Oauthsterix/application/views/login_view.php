<head>
	<title>Login - Oauthsterix</title>
</head>


<?php echo validation_errors(); ?>

<div class="CONTENT_ SIGNIN_">
	<div id="signin_form">
		<?php echo form_open("oauth/login"); ?>
			<label for="email">Email:</label>
			<input type="text" id="email" name="email" value="<?php echo set_value('email'); ?>" />
			<p></p>
			<label for="password">Password:</label>
			<input type="password" id="password" name="password" value="" />
			<input type="submit" class="" value="Sign in" />
		<?php echo form_close(); ?>
	</div><!--<div class="signin_form">-->
</div><!--<div id="content">-->