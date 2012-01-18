<?php session_start(); ?>
<html>
	<head>
		<title>CMS</title>
		<style type="text/css">
			td { vertical-aling: top;}
		</style>
	</head>
	<body>
		<h1>Commic Book Appreciation</h1>
<?php
		if (isset($_SESSION['name'])) {
			echo '<p>You are currently logged in as: ' . $_SESSION['name'] . '</p>';
		}
?>
		<div id="navright">
			<form method="get" action="search.php">
				<div>
					<label for="search">Search</label>
<?php
					echo '<input type="text" id="search" name="search" ';
					if (isset($GET['keywords'])) {
						echo ' value="' . htmlspecialchars($_GET['keywords']) . '" ';
					}
					echo '/>';
?>
					<input type="submit" value="Search" />
				</div>
			</form>
		</div>
		<div id="navigation">
			<a href="index.php">Articles</a>
<?php
			if (isset($_SESSION['user_id'])) {
				echo ' | <a href="compose.php">Compose</a>';
				if ($_SESSION['access_level'] > 1) {
					echo ' | <a href="pending.php">Review</a>';
				}
				if ($_SESSION['access_level'] > 2) {
					echo ' | <a href="admin.php">Admin</a>';
				}
				echo ' | <a href="cpanel.php">Control Panel</a>';
				echo ' | <a href="transact_user.php?action=Logout">Logout</a>';
			} else {
				echo ' | <a href="login.php">Login</a>';
			}
?>
		</div>
		<div id="articles">

