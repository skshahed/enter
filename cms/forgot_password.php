<?php include 'header.inc.php'; ?>
<h1>Email Password Reminder</h1>
<form method="POST" action="transact_user.php">
	<div>
		<label for="email">Email Address:</label></td>
		<input type="text" id="email" name="email" maxlength="100" />
		<input type="submit" name="action" value="Send my reminder!" />	
	</div>
</form>
<?php include 'footer.inc.php'; ?>
