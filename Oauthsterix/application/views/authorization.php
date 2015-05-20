
<head>
	<title>Authorization - Oauthsterix</title>
</head>
<?php echo form_open("oauth/Authorization?auth_code=".$auth); ?>
<div class="CONTENT_">
	<h1>Authorize <?php echo isset($application_name)? $application_name : $_GET['application_name']; ?> to use your account?</h1>
	<h4>Using token: <?php echo $token['token']?></h4>
		<?php if($session_exists){ ?>
			<p></p>
			<?php } else { ?>
			<?php echo validation_errors(); ?>

			<?php if(isset($error_message)) { ?>
			<div class="ERROR_" id="VALIDATION_ERROR_"/>
				<?php echo $error_message;?>
			</div>
			<?php }?>

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
		<?php if($scope_description['read'] != "") { ?>
		<h4> To Read:</h4>
		<ul>
			<?php foreach ($scope_description['read'] as $description) { ?>
			<li><h4><?php echo $description?></h4></li>
			<?php } ?>
		</ul>
		<?php } ?>
		<?php if($scope_description['update'] != "") { ?>
		<h4> To Update:</h4>
		<ul>
			<?php foreach ($scope_description['update'] as $description) { ?>
			<li><h4><?php echo $description?></h4></li>
			<?php } ?>
		</ul>
		<?php } ?>
	</div>

	<fieldset>
		<legend>Authorize <?php echo $application_name ?> access to use your account?</legend>
		<input type="submit" value="Authorize Application" id="ALLOW_">

		<input id="CANCEL" name="cancel" type="submit" value="Cancel">

	</fieldset>
</div>

<?php echo form_close(); ?>