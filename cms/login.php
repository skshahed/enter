<?php 
include 'header.inc.php';
?>
<h1>Member Login</h1>
<form method="POST" action="transact_user.php">
	<table>
		<tr>
			<td><label for="email">Email Address:</label></td>
			<td><input type="text" id="email" name="email" maxlength="100" /></td>
		</tr><tr>
			<td><label for="password">Password:</label></td>
			<td><input type="password" id="password" name="password" maxlength="20" /></td>
		</tr><tr>
			<td> </td>
			<td><input type="submit" name="action" value="Login" /></td>
		</tr>
	</table>
</form>
<p>Not a member yet? <a href="user_account.php">Creat a new account!</a></p>
<?php include 'footer.inc.php'; ?>
