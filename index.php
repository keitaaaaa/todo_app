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
	<title>TODO</title>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
	<style>
	body {
		background-image: url("cloud.jpg");
		background-size: cover;
		background-repeat: no-repeat;
		background-position: center center;
		background-attachment: fixed;
		background-color: #464646;
		color: white;
		text-shadow: 2px 2px 2px #999999;
	}
	h1 {
		font-size: 350%;
		line-height: 10px;
	}
	li {
		list-style-type: upper-roman;
		line-height: 50px;
		font-size: 120%;
		clear: both;
	}

	.main {
		width: 900px;
		margin: 0 auto;
	}
	.add {
		width: 38%;
		float: right;
		margin-top: 20%;
	}
	#tasks {
		width: 50%;
		font-size: 150%;
		margin-top: 16%;
		margin-left: 20px;
		float: left;
	}

	.deleteTask, .drag, .editTask {
		cursor: pointer;
		color: blue;
		font-size: 70%;
		float: right;
		margin-left: 5px;
	}
	.done {
		text-decoration: line-through;
		color: gray;
	}
	.noedit {
		float: right;
		margin-left: 5px;
	}
	.button {
		font-size: 1.2em;
		font-weight: bold;
		padding: 8px 25px;
		border-style: none;
		background-color: #178;
		color: white;
		cursor: pointer;
	}
	</style>
</head>
<body>
	<div class="main">
		<div class="add">
			<h1>Roles</h1>
			<h3>あなたの役割は何ですか？</h3>
			<p>
			<input type="text" id="title" style="width: 250px;"><br>
			<br>
			<button class="button" id="addTask">追加</button>
			</p>
			<!-- <button class="button">Next</button> -->
		</div>
		<ul id="tasks">
			<?php foreach ($tasks as $task) : ?>
			
			<li id="task_<?php echo h($task['id']); ?>"
				data-id="<?php echo h($task['id']); ?>" >
				<!-- <input type="checkbox" class="checkTask"
					<?php if ($task['type'] == "done") {
						echo "checked"; } ?>
				> -->
				<span class="<?php echo h($task['type']); ?>">
					<?php echo h($task['title']); ?></span>

				<!-- <span class="drag">[drag]</span> -->
				<span class="deleteTask">削除</span>
				<!-- <span <?php if ($task['type']=="notyet") {
						echo 'class="editTask"';
					} else {
						echo 'class="noedit"';
					} ?>>[編集]</span> -->
			</li>

		<?php endforeach; ?>
		</ul>
	</div>
<script>
$(function() {
	$('#title').focus();

	$('#addTask').click(function() {
		var title = $('#title').val();
		$.post('_ajax_add_task.php', {
			title: title
		}, function(rs) {
			var e = $(
				'<li id="task_'+rs+'" data-id="'+rs+'">' +
				// '<input type="checkbox" class="checkTask"> ' + 
				'<span></span> ' + 
				// '<span class="drag">[drag]</span>' + 
				'<span class="deleteTask">削除</span> ' + 
				// '<span class="editTask">[編集]</span> ' + 
				'</li>'
			);
			$('#tasks').append(e).find('li:last span:eq(0)').text(title);
			$('#title').val('').focus();
		});
	});

	$(document).on('click', '.editTask', function() {
		var id = $(this).parent().data('id');
		var title = $(this).prev().text();
		$('#task_'+id)
			.empty()
			.append($('<input type="text">').attr('value',title))
			.append('<input type="button" value="更新" class="updateTask">');
		$('#task_'+id+' input:eq(0)').focus();
	});

	$(document).on('click', '.updateTask', function() {
		var id = $(this).parent().data('id');
		var title = $(this).prev().val();
		$.post('_ajax_update_task.php', {
			id: id,
			title: title
		}, function(rs) {
			var e = $(
				'<input type="checkbox" class="checkTask"> ' + 
				'<span></span> ' + 
				'<span class="drag">[drag]</span>' + 
				'<span class="deleteTask">[削除]</span> ' + 
				'<span class="editTask">[編集]</span> '
			);
			$('#task_'+id).empty().append(e).find('span:eq(0)').text(title);
		});
	});

	$('#tasks').sortable({
		axis: 'y',
		opacity: 0.2,
		handle: '.drag',
		update: function() {
			$.post('_ajax_sort_task.php', {
				task: $(this).sortable('serialize')
			});
		}
	});

	$(document).on('click', '.checkTask', function() {
		var id = $(this).parent().data('id');
		var title = $(this).next();
		$.post('_ajax_check_task.php', {
			id: id
		}, function(rs) {
			if (title.hasClass('done')) {
				title
					.removeClass('done')
				.next().next().next()
					.addClass('editTask')
					.removeClass('noedit');
			} else {
				title
					.addClass('done')
				.next().next().next()
					.removeClass('editTask')
					.addClass('noedit');
			}
		});
	});

	$(document).on('click', '.deleteTask', function() {
		if (confirm('本当に削除しますか？')) {
			var id = $(this).parent().data('id');
			$.post('_ajax_delete_task.php', {
				id: id
			}, function(rs) {
				$('#task_'+id).fadeOut(500);
			});
		}
	});
});
</script>
</body>
</html>
