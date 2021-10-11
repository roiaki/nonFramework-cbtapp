<?php
session_start();

require '../common/database.php';
require '../common/auth.php';

// ログインしてないならログイン画面へ
if (!isLogin()) {
    header('Location: ../login/');
    exit;
}

$htmltitle = '詳細ページ';
$description = '';

include('../common/head.php');

$user_id = getLoginUserId();
$user_name = getLoginUserName();

//var_dump('GET', $_GET);
$event_id = $_GET['event_id'];
/*
var_dump(
    "event_id = " . $event_id,
    "get['event_id'] = " . $_GET['event_id'],
    "user_id = " . $user_id,
    'user_name = ' . $user_name
);
*/

$database_handler = getDatabaseConnection();
$sql = $database_handler
    ->prepare(
        "SELECT * FROM 
          threecolumns
        WHERE 
          user_id = :user_id 
        AND 
          id = :event_id 
        ORDER BY updated_at DESC"
    );

$sql->bindParam(':user_id', $user_id);
$sql->bindParam(':event_id', $event_id);

$sql->execute();

$threecolumns = [];

while ($result = $sql->fetch(PDO::FETCH_ASSOC)) {
    $threecolumns = $result;
}

$sql = $database_handler->
    prepare(
        "SELECT 
          habit_id, 
          habit_name 
        FROM 
          habits 
        JOIN 
          habit_threecolumn 
        ON 
          habits.id = habit_threecolumn.habit_id 
        WHERE 
          habit_threecolumn.threecol_id = :threecol_id"
    );

$sql->bindParam(':threecol_id', $threecolumns['id']);

$sql->execute();

$names = [];

while ($result = $sql->fetch(PDO::FETCH_ASSOC)) {
    array_push($names, $result);
}

?>

<body>
  <?php include('../common/global_menu.php'); ?>
  <div class="container">
    <h3>3コラム 詳細ページ</h3>
    <table class="table table-striped table-bordered">
      <thead>
        <tr class="table-primary">
          <th>id</th>
          <th>出来事id</th>
          <th>タイトル</th>
          <th>内容</th>
          <th>感情</th>
          <th>考えたこと</th>
          <th>考え方の癖</th>
          <th>更新日</th>
        </tr>
      </thead>

      <tbody>
        <tr>
          <td><?php echo $threecolumns['id']; ?></td>
          <td><?php echo $threecolumns['event_id']; ?></td>
          <td><?php echo $threecolumns['title']; ?></td>
          <td><?php echo $threecolumns['content']; ?></td>
          <td><?php echo $threecolumns['emotion_name']; ?></td>
          <td><?php echo $threecolumns['thinking']; ?></td>
          <td><?php
              foreach ($names as $name) {
                echo $name['habit_name'] . "<br>";
              }
              ?>
          </td>
          <td><?php echo $threecolumns['updated_at']; ?></td>
        </tr>
      </tbody>
    </table>
    <a href="edit.php?threecol_id=<?php echo $threecolumns['id']; ?>" class="btn btn-primary btn-lg" role="button" aria-pressed="true">
      編集
    </a>
    <a href="delete.php?threecol_id=<?php echo $threecolumns['id']; ?>" class="btn btn-danger btn-lg" role="button" onclick="confirmDelete();return false;" aria-pressed="true">
      削除
    </a>
  </div>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
  <script defer src="https://use.fontawesome.com/releases/v5.7.2/js/all.js"></script>
  <script type="text/javascript" src="../public/js/main.js"></script>
</body>

</html>