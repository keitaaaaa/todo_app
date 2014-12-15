<?php

require_once('config.php');
require_once('functions.php');

// DBに接続

$dbh = connectDb();

$tasks = array();

$sql = "select * from tasks where type != 'deleted' order by seq";
foreach ($dbh->query($sql) as $row) {
	array_push($tasks, $row);
}

// var_dump($tasks);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>TODOアプリ</title>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
</head>
<body>
<h1>TODOアプリ</h1>
<ul>
	<?php foreach ($tasks as $task) : ?>
	<li>
		<?php echo h($task['title']); ?>
	</li>
<?php endforeach; ?>
</ul>
</body>
</html>
