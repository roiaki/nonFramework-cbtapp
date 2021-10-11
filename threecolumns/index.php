<?php
session_start();

require '../common/database.php';
require '../common/auth.php'; // ここでsession_start

// ログインしていなかったらログイン画面へリダイレクト
if ( !isLogin() ) {
  header('Location: ../login/');
  exit;
}

$htmltitle = 'CBT APP';
$description = '';

include('../common/head.php');

$user_id = getLoginUserId();
$user_name = getLoginUserName();

//var_dump($user_id, $user_name);

$database_handler = getDatabaseConnection();
$sql = $database_handler->prepare("SELECT * FROM threecolumns WHERE user_id = :user_id ORDER BY updated_at DESC");
$sql->bindParam(':user_id', $user_id);
$sql->execute();

$events = [];

while ($result = $sql->fetch(PDO::FETCH_ASSOC)) {
  array_push($events, $result);
  //var_dump($result);
}
//var_dump($events);


?>

<body>
  <?php include('../common/global_menu.php'); ?>
  <?php if (isset($_SESSION['flash_message'])) {
        $message = $_SESSION['flash_message'];
      unset($_SESSION['flash_message']);
          echo $message;
      }		  
  ?>
  <div class="container">
    <h3>3カラム一覧</h3>

    <table class="table table-striped table-bordered">
      <thead>
        <tr class="table-primary">
          <th>3カラムid</th>
          <th>感情</th>
          <th>強さ</th>
          <th>更新日</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($events as $event) { ?>
        <tr>
          <td><?php echo $event['id']; ?></td>
          <td><?php echo $event['title']; ?></td>
          <td><?php echo $event['content']; ?></td>
          <td><?php echo $event['updated_at']; ?>
          <p><a href="show.php?event_id=<?php echo $event['id']; ?> ">詳細</a></p>
          </td>
        </tr>
      <?php  } ?>
      </tbody>
    </table>
    
  </div>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
  <script defer src="https://use.fontawesome.com/releases/v5.7.2/js/all.js"></script>
  <script type="text/javascript" src="main.js"></script>
</body>

</html>