<?php
session_start();
require 'database.php';

$user_id = $_SESSION['user']['id'];
$user_name = $_SESSION['user']['name'];

$hour = date("H");

if (5 <= $hour && $hour <= 12) {
	$msg = "おはようございます";
} else if (17 < $hour) {
	$msg = "こんばんは";
} else {
	$msg = "こんにちは";
}

var_dump($user_id, $user_name,);
?>
<header class="mb-4">
		<nav class="navbar navbar-expand-sm navbar-light bg-light">
			<a class="navbar-brand fw-bold ml-5" href="../events">CBT APP</a>

			<div class="collapse navbar-collapse" id="nav-bar">
				<ul class="navbar-nav mr-auto"></ul>
				<ul class="navbar-nav">
					<?php if (isset($user_id)) { ?>

						<div class="d-flex align-items-center">
							ID <?php echo $user_id; ?> 番 <?php echo $user_name; ?> さん、<?php echo $msg; ?>　
						</div>
						<li class="nav-item"><a class="nav-link" href="../user/info.php">説明</a></li>
						<li class="nav-item"><a class="nav-link" href="../events">出来事一覧</a></li>
						<li class="nav-item"><a class="nav-link" href="../threecolumns">3コラム一覧</a></li>

						<div class="dropdown mr-5">
							<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								アカウント
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
								<li><a class="nav-link" href="#">ログアウト</a></li>
								<li><a class="nav-link" href="#">退会</a></li>

							</ul>
						</div>

					<?php } else { ?>

						<li class="nav-item"><a class="dropdown-item" href="#">ログイン</a></li>
						<li class="nav-item"><a class="dropdown-item" href="#">会員登録</a></li>
					<?php } ?>
				</ul>
			</div>
		</nav>
</header>
