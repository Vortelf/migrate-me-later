<head>
	<title>Application Registration - Oauthsterix</title>
</head>

<?php echo validation_errors(); ?>

<div class="CONTENT_">
	<div id="reg_form">
		<div class="form_title"><h2>Register Your Application</h2></div>
		<?php $attributes = array('onsubmit' => 'return checkForm(this);', 'id' => 'register');?>
		<?php echo form_open("oauth/application_registration", $attributes); ?>
		<fieldset>
			<legend for="credentials">Application Info:</legend>
			<p>
				<label for="application_name">Application Name:</label><p class="error-msg" id="application_name-error"></p>
				<input type="text" id="application_name" name="application_name" value="<?php echo set_value('application_name'); ?>" />
			</p>
			<p>
				<label for="redirect_uri">Redirect URI:</label><p class="error-msg" id="redirect_uri-error"></p>
				<input type="redirect_uri" id="redirect_uri" name="redirect_uri" value="<?php echo set_value('redirect_uri'); ?>" />
			</p>
		</fieldset>

		<p>
			<button type="submit" name='submit' class="button">Submit</button>
		</p>
			<input type="hidden" id="validation_check" name="validation_check" value="default" />
		<?php echo form_close(); ?>
		
		
	</div><!--<div class="reg_form">-->
</div><!--<div id="content">-->