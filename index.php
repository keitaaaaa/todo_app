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
	<title>Task Manegement</title>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
	<link rel='stylesheet' href='style.css' />
	<link href='http://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700' rel='stylesheet' type='text/css'>
	
</head>
<body>
	<div class="header">
		<h1>Task Management</h1>
		<ul>
			<li>
				<?php echo "Logout"; ?>
			</li>
		</ul>
	</div>

	<div class="main">
		<div class="side">
			<ul id="tasks">
				<h2>Your Tasks</h2>
				<?php foreach ($tasks as $task) : ?>
					<li id="task_<?php echo h($task['id']); ?>"
						data-id="<?php echo h($task['id']); ?>" >
						<span class="<?php echo h($task['type']); ?>">
							<?php echo h($task['title']); ?></span>

						<span class="drag">移動</span>
						<span class="deleteTask">削除</span>
					</li>
				<?php endforeach; ?>
			</ul>
			<div class="add">
				<p>
					<form>
				<input type="text" id="title" style="width: 260px; float: left;">
				<button class="button" id="addTask">Add</button>
				</form>
				</p>
			</div>
		</div>
		
		<div class="this_week">
			<ul class="accordion">
				<h2>This Week</h2>
				<li>
					<p><span>Mon 5</span></p>
					<ul>
						<li><a>リスト 1-1</a></li>
						<li><a>リスト 1-2</a></li>
						<li><a>リスト 1-3</a></li>
					</ul>
				</li>
				<li>
					<p><span>Tue 6</span></p>
					<ul>
						<li><a>リスト 2-1</a></li>
						<li><a>リスト 2-2</a></li>
						<li><a>リスト 2-3</a></li>
					</ul>
				</li>
				<li>
					<p><span>Wed 7</span></p>
					<ul>
						<li><a>リスト 3-1</a></li>
						<li><a>リスト 3-2</a></li>
						<li><a>リスト 3-3</a></li>
					</ul>
				</li>
				<li>
					<p><span>Thu 8</span></p>
					<ul>
						<li><a>リスト 4-1</a></li>
						<li><a>リスト 4-2</a></li>
						<li><a>リスト 4-3</a></li>
					</ul>
				</li>
				<li>
					<p><span>Fri 9</span></p>
					<ul>
						<li><a>リスト 5-1</a></li>
						<li><a>リスト 5-2</a></li>
						<li><a>リスト 5-3</a></li>
					</ul>
				</li>
				<li>
					<p><span>Sat 10</span></p>
					<ul>
						<li><a>リスト 6-1</a></li>
						<li><a>リスト 6-2</a></li>
						<li><a>リスト 6-3</a></li>
					</ul>
				</li>
				<li>
					<p><span>Sun 11</span></p>
					<ul>
						<li><a>リスト 7-1</a></li>
						<li><a>リスト 7-2</a></li>
						<li><a>リスト 7-3</a></li>
					</ul>
				</li>	
			</ul>
		</div>
		<div class="next_week">
			<ul class="accordion">
				<h2>Next Week</h2>
				<li>
					<p><span>Mon 12</span></p>
					<ul>
						<li><a>リスト 1-1</a></li>
						<li><a>リスト 1-2</a></li>
						<li><a>リスト 1-3</a></li>
					</ul>
				</li>
				<li>
					<p><span>Tue 13</span></p>
					<ul>
						<li><a>リスト 2-1</a></li>
						<li><a>リスト 2-2</a></li>
						<li><a>リスト 2-3</a></li>
					</ul>
				</li>
				<li>
					<p><span>Wed 14</span></p>
					<ul>
						<li><a>リスト 3-1</a></li>
						<li><a>リスト 3-2</a></li>
						<li><a>リスト 3-3</a></li>
					</ul>
				</li>
				<li>
					<p><span>Thu 15</span></p>
					<ul>
						<li><a>リスト 4-1</a></li>
						<li><a>リスト 4-2</a></li>
						<li><a>リスト 4-3</a></li>
					</ul>
				</li>
				<li>
					<p><span>Fri 16</span></p>
					<ul>
						<li><a>リスト 5-1</a></li>
						<li><a>リスト 5-2</a></li>
						<li><a>リスト 5-3</a></li>
					</ul>
				</li>
				<li>
					<p><span>Sat 17</span></p>
					<ul>
						<li><a>リスト 6-1</a></li>
						<li><a>リスト 6-2</a></li>
						<li><a>リスト 6-3</a></li>
					</ul>
				</li>
				<li>
					<p><span>Sun 18</span></p>
					<ul>
						<li><a>リスト 7-1</a></li>
						<li><a>リスト 7-2</a></li>
						<li><a>リスト 7-3</a></li>
					</ul>
				</li>	
			</ul>
		</div>
	</div>

	<div class="footer">
		<ul>
			<li>
				<?php echo "ご利用規約"; ?>
			</li>
			<li>
				<?php echo "お問い合わせ"; ?>
			</li>
		</ul>

	</div>
<script>
/* タスク追加操作 */
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
				'<span class="drag">移動</span>' + 
				'<span class="deleteTask">削除</span> ' + 
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

/* アコーディオン */
$(function(){
	$(".accordion p").click(function(){
		$(this).next("ul").slideToggle();
		$(this).children("span").toggleClass("open");
	});

	$(".accordion dt").click(function(){
		$(this).next("dd").slideToggle();
		$(this).next("dd").siblings("dd").slideUp();
		$(this).toggleClass("open");
		$(this).siblings("dt").removeClass("open");
	});
});
</script>
</body>
</html>
