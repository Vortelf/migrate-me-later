<title><?php echo $title?></title>

<script type="text/javascript" src="/oauthsterix/assets/jquery.js"></script>

<script type="text/javascript">
	var obj = <?php echo $json ?>;
	var data = "text/json;charset=utf-8," + encodeURIComponent(JSON.stringify(obj));

	$(document).ready(function(){
		$('<a class="LINK_" id="DOWNLOAD" href="data:' + data + '" download="OauthsterixAppInfo.json">Download Information</a>').appendTo('#LINK_HAND_');
	});
</script>


<div class="CONTENT_">
	<div class="success_wrap">
		<h1>Your Application Has Been Registered</h1>
		<div class="APP_INFO_">
			<h3>Application Information</h3>
			<ul>
				<li><h4>Application Name: 	<p><?= $application_name ?></p></h4></li>
				<li><h4>Clent ID: 			<p><?= $client_id ?></p></h4></li>
				<li><h4>Client Secret: 		<p><?= $client_secret ?></p></h4></li>
				<li><h4>Redirect URI: 		<p><?= $redirect_uri ?></p></h4></li>
			</ul>
		</div>
		<div id="LINK_HAND_">
			<a class="LINK_" href="/oauthsterix" style="width: 100%;">Return Home</a>
		</div></p>

	</div>
</div>