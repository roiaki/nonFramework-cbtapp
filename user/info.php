<?php 


?>
<!DOCTYPE html>
<html lang="ja">
    <head>
    <meta charset="utf-8">
	<title>CBT APP</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="../../public/css/main.css">

</head>

<body>

<?php include('../common/global_menu.php'); ?>
<?php var_dump($_SESSION['user']); ?>
<h3>このアプリの使い方</h3>
<br>
<p>出来事を元に考え方の癖について考えます。<br>
  落ち込んでしまった、などのネガティブな考え方を変えたいイベントを思い出し、<br>
  ３コラム新規作成をクリックして<br>
</p>
<p>１　感情<br>
   ２　考えたこと<br>
   ３　考え方の癖<br>
</p>
<p>をチェックしてみましょう。</p>

<p>
  次に７コラムの新規作成をクリックして<br>
  考え方を修正しましょう。<br>
  客観的事実に基づいて検証し、<br>
  自分にとって好ましい認知へ修正しましょう。
</p> 
</body>
</html>
