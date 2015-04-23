<?php
	include('begin.php');
	include('util.inc.php');
	beginHTML('Golb','css/style.css');

	$connected = false;

	if(isset($_POST["login"]) && isset($_POST["password"])) {

		if(($handle = fopen("accounts.csv", "r")) !== false) {
			while(($data = fgetcsv($handle, 1000, ";")) !== false) {
				if(count($data) == 3) {
					if(strtolower($data[0]) == strtolower($_POST["login"])) {
						// Put the real case on the username
						$_POST["login"] = $data[0];
						if(password_verify($_POST["password"], $data[1])) {
							echo "<p>Logged in !</p>";
							$connected = true;
							beginSession();
							if(isset($_GET["page"])) {
								header('Location: '.$_GET["page"]); 
							}
							else {
								header('Location: index.php');
							}
						}
					}
				}
			}
			fclose($handle);
		}
	}

	if(! $connected) {
		echo '<meta http-equiv="refresh" content="0;URL=index.php?error=true#loginModal" /> ';
	}

	endHTML();
?>