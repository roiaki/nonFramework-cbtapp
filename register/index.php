<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset=UTF-8>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">

	<title>会員登録</title>
</head>

<body>



	<div class="">
		<form action="../action/register.php" method="post">
			<div class="d-flex flex-column align-items-center justify-content-center shadow-lg p-3 mb-5 bg-white rounded">
				<h3>会員登録</h3>
				<div class="form-group">
					<label for="name">お名前</label>
					<input type="text" name="user_name" id="name" class="form-control" placeholder="お名前" required>
				</div>

				<div class="form-group">
					<label for="email">メールアドレス</label>
					<input type="email" name="user_email" id="email" class="form-control" placeholder="メールアドレス" required>
				</div>

				<div class="form-group">
					<label for="password">パスワード</label>
					<input type="password" name="user_password" id="password" class="form-control" placeholder="パスワード" required>
				</div>

				<button type="submit" class="form-control btn btn-success">
					登録する
				</button>
			</div>
		</form>
	
	</div>


</body>


</html>