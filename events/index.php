<?php
session_start();
require '../common/database.php';
var_dump($_SESSION);
var_dump()
?>
<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="utf-8">
	<title>CBT APP</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="{{asset('css/main.css')}}">

</head>

<body>
	<header class="mb-4">
		<nav class="navbar navbar-expand-sm navbar-light bg-light">
			<a class="navbar-brand fw-bold ml-5" href="/events">CBT APP</a>

			<div class="collapse navbar-collapse" id="nav-bar">
				<ul class="navbar-nav mr-auto"></ul>
				<ul class="navbar-nav">

					<?php $hour = date("H");
					if (5 <= $hour && $hour <= 12) {
						$msg = "おはようございます";
					} else if (17 < $hour) {
						$msg = "こんばんは";
					} else {
						$msg = "こんにちは";
					}
					?>

					<div class="d-flex align-items-center">
						ID  番  さん、<?php echo $msg; ?>　
					</div>
					<li class="nav-item"></li>
					<li class="nav-item">{!! link_to_route('events', '出来事一覧', [], ['class' => 'nav-link']) !!}</li>
					<li class="nav-item">{!! link_to_route('three_columns', '3コラム一覧', [], ['class' => 'nav-link']) !!}</li>

					<div class="dropdown mr-5">
						<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							アカウント
							<span class="caret"></span>
						</button>
						<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
							<li>{!! link_to_route('logout.get', 'ログアウト', [], ['class' => 'nav-link']) !!}</li>
							<li>{!! link_to_route('users.delete_confirm', '退会', [], ['class' => 'nav-link']) !!}</li>
						</ul>
					</div>

					

					<li class="nav-item">{!! link_to_route('login', 'ログイン', [], ['class' => 'nav-link']) !!}</li>
					<li class="nav-item">{!! link_to_route('signup.get', '会員登録', [], ['class' => 'nav-link']) !!}</li>

					

				</ul>
			</div>
		</nav>

		<div class="container">
			
		</div>
		

		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
		<script defer src="https://use.fontawesome.com/releases/v5.7.2/js/all.js"></script>
		<script type="text/javascript" src="main.js"></script>
</body>

</html>