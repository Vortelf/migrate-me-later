<title>Admin Page</title>

<div class="CONTENT_">
	<div id="profile">
		<p>
		<?php
		// echo "Hello <b id='welcome'><i>" . $name . "</i> !</b>";
		echo "Welcome to Admin Page" . "<br>";
		echo "Your Username is " . $username . "<br>";
		echo "Your Email is " . $email . "<br>";
		echo "Your Password is " . $password . "<br>";
		?>
		</p>
		<b id="logout"><a class="LINK_" href="/oauthsterix/oauth/logout">Logout</a></b>
	</div>
</div>