<?php
	require '../common/database.php';
	require '../common/auth.php'; 
	session_start();
	$title = 'CBT APP';
	$description = '';

	include('../common/head.php');

	$user_id = getLoginUserId();
	$user_name = getLoginUserName();

    var_dump('GET', $_GET);
    $event_id = $_GET['event_id'];

	var_dump("event_id = " . $event_id, "get['id'] = " . $_GET['id'], "user_id = " . $user_id, 'user_name = ' . $user_name);

	$database_handler = getDatabaseConnection();
	$sql = $database_handler->prepare("SELECT * FROM events WHERE user_id = :user_id AND id = :event_id ORDER BY updated_at DESC");
	
    $sql->bindParam(':user_id', $user_id);
    $sql->bindParam(':event_id', $event_id);

	$sql->execute();

	$events = [];

	while ($result = $sql->fetch(PDO::FETCH_ASSOC) ) {
		array_push($events, $result);
		//var_dump($result);
	}
var_dump($events);


?>

<body>
	<?php include('../common/global_menu.php'); ?>

	<div class="container">
		<h3>出来事 詳細ページ</h3>

		<table class="table table-striped table-bordered">
			<thead>
				<tr class="table-primary">

					<th>出来事id</th>
					<th>タイトル</th>
					<th>内容</th>
					<th>更新日</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $events as $event) {?>
				<tr>
					<td><a href="$event['id']"><?php echo $event['id']; ?></a></td>
					<td><?php echo $event['title']; ?></td>
					<td><?php echo $event['content']; ?></td>
					<td><?php echo $event['updated_at']; ?></td>
				</tr>
				<?php  }?>
			</tbody>
		</table>
		<a href="create.php" class="btn btn-primary btn-lg"role="button" aria-pressed="true">hes</a>
	</div>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
	<script defer src="https://use.fontawesome.com/releases/v5.7.2/js/all.js"></script>
	<script type="text/javascript" src="main.js"></script>
</body>

</html>