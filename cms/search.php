<?php
require 'db.inc.php';
require 'output_functions.inc.php';


$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
	die('Unable to connect. Check your connetion parameters.');
mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));


include 'header.inc.php';

$search = (isset($_GET['search'])) ? $_GET['search'] : '';

$sql = 'SELECT
		article_id
	FROM
		cms_articles
	WHERE
		MATCH (title, article_text) AGAINST ("' . mysql_real_escape_string($search, $db) . '" IN BOOLEAN MODE)';
	
$result = mysql_query($sql, $db) or die(mysql_error($db));

if (mysql_num_rows($result) == 0) {
	echo '<p><strong>No articles found that match the search terms.</strong></p>';
} else {
	while ($row = mysql_fetch_assoc($result)) {
		output_story($db, $row['article_id'], TRUE);
	}
}
mysql_free_result($result);

include 'footer.inc.php';
?>
