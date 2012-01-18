<?php
require 'db.inc.php';
require 'output_functions.inc.php';


$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
	die ('Unable to connect. Check your connection parameters.');
mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

include 'header.inc.php';

$sql = 'SELECT
		article_id
	FROM
		cms_articles
	WHERE
		is_published = TRUE
	ORDER BY
		publish_date DESC';
$result = mysql_query($sql, $db) or die(mysql_error($db));

if (mysql_num_rows($result) == 0) {
	echo '<p><strong>There are currently no articles to view.</strong></p>';
} else {
	while ($row = mysql_fetch_assoc($result)) {
		output_story($db, $row[article_id], TRUE);
	}
}
mysql_free_result($result);

include 'footer.inc.php';
?>
