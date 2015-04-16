<div id="content">
	<div class="signin_form">
		<?php echo form_open("oauth/login"); ?>
			<label for="email">Email:</label>
			<input type="text" id="email" name="email" value="" />
			<label for="password">Password:</label>
			<input type="password" id="pass" name="pass" value="" />
			<input type="submit" class="" value="Sign in" />
		<?php echo form_close(); ?>
	</div><!--<div class="signin_form">-->
</div><!--<div id="content">-->