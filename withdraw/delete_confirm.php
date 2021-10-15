<?php
session_start();
var_dump($_SESSION['user']);
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <title>CBT APPs</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../public/css/main.css">

</head>

<body>
<?php include('../common/global_menu.php'); ?>

  
<div class="container">
  <div class="card border-dark mb-3">
    <div class="card-header">
      <h3>退会の確認</h3>
    </div>
    <div class="card-body">
      <p class="card-text">退会をすると作成したデータも全て削除されます。</p>
      <p class="card-text">それでも退会をしますか？</p>
    </div>
  </div>

  <div class="btn-group">
    <form method="post" action="../withdraw/action/user_delete.php">
        <button type="submit" class="btn btn-danger">退会する</button>
    </form>
        
    <div class="ml-3">
      <a href="../events" class="btn btn-primary">キャンセルする</a>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
  <script defer src="https://use.fontawesome.com/releases/v5.7.2/js/all.js"></script>
  <script type="text/javascript"src="../public/js/main.js"></script>
</body>

</html>
