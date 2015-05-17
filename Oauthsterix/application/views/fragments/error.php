<title><?php echo $title?></title>
<div class="CONTENT_">
	<div class="error_wrap">
		<h1><?php echo $message?></h1>
		<?php if($action) { ?>
		<p><a class="LINK_" href="<?php echo $url?>"><?php echo $action?></a>.
		<?php } ?>
		<a class="LINK_" href="/oauthsterix">Return Home</a></p>
	</div>
</div>