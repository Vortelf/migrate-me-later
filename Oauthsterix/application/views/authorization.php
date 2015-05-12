
<head>
	<title>Authorization - Oauthsterix</title>
</head>

<div class="CONTENT_">
	<!-- <?php print_r($application_name) ?> -->
	<h1>Authorize <?php echo isset($application_name)? $application_name : $_GET['application_name']; ?> to use your account?</h1>
	<h4>Using token: <?php echo $token?></h4>
		<?php if(isset($session_info['logged_in']) && $session_info['logged_in']){ ?>
			<p></p>
			<?php } else { ?>
			<?php echo validation_errors(); ?>

			<div class="SIGNIN_" style="width: auto;">
				<div id="signin_form">
					<?php echo form_open("oauth/login"); ?>
					<fieldset class="buttons">
						<label for="email">Email:</label>
						<input type="text" id="email" name="email"  value="<?php echo set_value('email'); ?>" />
						<p></p>
						<label for="password">Password:</label>
						<input type="password" id="password" name="password" value="" />
					</fieldset>
					<?php echo form_close(); ?>
				</div><!--<div class="signin_form">-->
			</div><!--<div id="content">-->
			<?php }
	?>
	<div class="AUTH_SCOPE_">
		<h3>This app wants to use the following information:</h3>
		<ul>
			<li><h4>Your Something</h4></li>
			<li><h4>Your Something</h4></li>
			<li><h4>Your Something</h4></li>
		</ul>
	</div>

	<fieldset>
		<legend>Authorize <?php echo $application_name ?> access to use your account?</legend>
		<input type="submit" value="Authorize Application" id="ALLOW_">

		<input id="CANCEL" name="cancel" type="submit" value="Cancel">

	</fieldset>
</div>