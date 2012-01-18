<?php
require_once 'db.inc.php';
require_once 'http_functions.inc.php';
session_start();

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or 
	die('Unable to connect. Check your connection parameters.');
mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

if (isset($_REQUEST['action'])) {
	
	switch ($_POST['action']) {
		case 'Submit New Article':
		
			$title = (isset($_POST['title'])) ? $_POST['title'] : '';
			$article_text = (isset($_POST['article_text'])) ? $_POST['article_text'] : '';
			if (isset($_SESSION['user_id']) && !empty($title) && !empty($article_text)) {
				echo 'asfsadf';
				$sql = 'INSERT INTO cms_articles
						(user_id, submit_date, title, article_text)
					VALUES
						(' . $_SESSION['user_id'] . ',
						"' . date('Y-m-d H:i:s') . '",
						"' . mysql_real_escape_string($title, $db) . '",
						"' . mysql_real_escape_string($article_text, $db) . '")';
				mysql_query($sql, $db) or die(mysql_error($db));
			}
			redirect('index.php');
			break;
			
		case 'Edit':
			redirect('compose.php?action=edit&article_id=' . $_POST['article_id']);
			break;
			
		case 'Save Changes':
			$article_id = (isset($_POST['article_id'])) ? $_POST['article_id'] : '';
			$title = (isset($_POST['title'])) ? $_POST['title'] : '';
			$user_id = (isset($_POST['user_id'])) ? $_POST['user_id'] : '';
			$article_text = (isset($_POST['article_text'])) ? $_POST['article_text'] : '';
			if (!empty($article_id) && !empty($title) && !empty($article_text)) {
				$sql = 'UPDATE cms_articles SET
						title = "' . mysql_real_escape_string($title, $db) . '",
						article_text = "' . mysql_real_escape_string($article_text, $db) . '",
						submit_date = "' . date('y-m-d H:i:s') . '"
					WHERE
						article_id = ' . $article_id;
				if (!empty($user_id)) {
					$sql .= ' AND user_id = ' . $user_id;
				}
				mysql_query($sql, $db) or die(mysql_error($db));
			}
			if (empty($user_id)) {
				redirect('pending.php');
			} else {
				redirect ('cpanel.php');
			}
			break;
			
		case 'Publish':
			$article_id = (isset($_POST['article_id'])) ? $_POST['article_id'] : '';
			if (!empty($article_id)) {
				$sql = 'UPDATE cms_articles SET
						is_published = TRUE,
						publish_date = "' . date('Y-m-d H:i:s') . '"
					WHERE
						article_id = ' . $article_id;
				mysql_query($sql, $db) or die(mysql_error($db));
			}
			redirect('pending.php');
			break;
			
		case 'Retract': 
			$article_id = (isset($_POST['article_id'])) ? $_POST['article_id'] : '';
			if (!empty($article_id)) {
				$sql = 'UPDATE cms_articles SET
						is_published = FALSE,
						publish_date = "0000-00-00 00:00:00"
					WHERE
						article_id = ' . $article_id;
				mysql_query($sql, $db) or die(mysql_error($db));
			}
			redirect('pending.php');
			break;
			
		case 'Delete':
			$article_id = (isset($_POST['article_id'])) ? $_POST['article_id'] : '';
			if (!empty($article_id)) {
				$sql = 'DELETE a, c FROM
						cms_articles a LEFT JOIN cms_comments c ON
						a.article_id = c.article_id
					WHERE
						a.article_id = ' . $article_id . ' AND
						is_published = FALSE';
				mysql_query($sql, $db) or die(mysql_error($db));
			}
			redirect('pending.php');
			break;
			
		case 'Submit Comment':
			$article_id = (isset($_POST['article_id'])) ? $_POST['article_id'] : '';
			$comment_text = (isset($_POST['comment_text'])) ? $_POST['comment_text'] : '';
			if (isset($_SESSION['user_id']) && !empty($article_id) && !empty($comment_text)) {
				$sql = 'INSERT INTO cms_comments
						(article_id, user_id, comment_date, comment_text)
					VALUES
						(' . mysql_real_escape_string($article_id, $db) . ',
						"' . $_SESSION['user_id'] . '",
						"' . date('Y-m-d H:i:s') . '",
						"' . mysql_real_escape_string($comment_text, $db) . '")';
				mysql_query($sql, $db) or die(mysql_error($db));
			}
			redirect('view_article.php?article_id=' . $article_id);
			break;
		
		default:
			redirect('index.php');
	}
} else {
	redirect('index.php');
}
?>
