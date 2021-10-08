<?php
session_start();

require '../common/database.php';
require '../common/auth.php';
//var_dump($_SESSION);
//exit();

if (!isLogin()) {
	header('Location: ../../login/');
}

$htmltitle = "出来事編集";

$user_id = getLoginUserId();
$user_name = getLoginUserName();
$event_id = $_GET['event_id'];
var_dump($event_id);
var_dump($user_id);
$database_handler = getDatabaseConnection();
$sql = $database_handler->prepare("SELECT * FROM events WHERE id = :event_id");
//$sql->bindParam(':user_id', $user_id);
$sql->bindParam(':event_id', $event_id);
$sql->execute();

$events = [];

while ( $result = $sql->fetch(PDO::FETCH_ASSOC) ) {
    //array_push($events, $result);
    $events = $result;
    //var_dump($result);
}
//var_dump($events);
var_dump($events['title']);
include('../common/head.php');
?>

<body>
	<?php include('../common/global_menu.php'); ?>

	<div class="container">

		<div class="col-5">
			<h3>id = <?php echo $_GET['event_id']; ?> 番　出来事　編集ページ</h3>
			
			<form method="post" action="action/update.php">
                <input type="hidden" name="event_id" value="<?php echo $events['id']; ?>" >
				<div class="form-group">
					<label>出来事タイトル</label>
					<input type="text" class="form-control" id="title" name="title" 
                    value="<?php echo $events['title']; ?>">
				</div>
				<?php if (isset($_SESSION['error_title'])) {
				echo '<div class="text-danger">';
				
				foreach ($_SESSION['error_title'] as $error) {
					echo "<div>* $error </div>";
				}
				echo '</div>';
				unset($_SESSION['error_title']);
				}
				?>

				<div class="form-group">
					<!-- 内容 -->
					<label for="content">出来事 の 内容</label>
					<textarea class="form-control" id="content" name="content" cols="90" rows="7"><?php echo $events['content']; ?></textarea>
				</div>
				<?php if (isset($_SESSION['error_content'])) {
				echo '<div class="text-danger">';
				//var_dump($_SESSION);
				foreach ($_SESSION['error_content'] as $error) {
					echo "<div>* $error </div>";
				}
				echo '</div>';
				unset($_SESSION['error_content']);
				}
				?>
				<button class="btn btn-primary" type="submit">更新</button>
			</form>
		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
	<script defer src="https://use.fontawesome.com/releases/v5.7.2/js/all.js"></script>
	<script type="text/javascript" src="main.js"></script>
</body>