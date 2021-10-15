<?php
session_start();

require '../common/database.php';
require '../common/auth.php';
//var_dump($_SESSION);
//exit();

// ログインしてないならログイン画面へ
if (!isLogin()) {
  header('Location: ../login/');
  exit;
}

$htmltitle = "出来事編集";

$user_id = getLoginUserId();
$user_name = getLoginUserName();

if ( isset($_GET['event_id']) ) {
  $event_id = $_GET['event_id'];
}

//var_dump($_POST);
//var_dump($_GET);
var_dump("SESSION");
var_dump($_SESSION);

//var_dump($user_id);
$database_handler = getDatabaseConnection();
$stmt = $database_handler->prepare("SELECT * FROM events WHERE id = :event_id");
$stmt->bindParam(':event_id', $event_id);
$stmt->execute();

$event = [];

while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $event = $result;
}
//var_dump("session_event_id". $_SESSION['event_id']);

// バリデーションエラーリダイレクト時の値の受け渡し
if ( isset($_SESSION['event_id']) ) {
  $event['id'] = $_SESSION['event_id'];
  unset($_SESSION['event_id']);
}

if ( isset($_SESSION['title']) ) {
  $event['title'] = $_SESSION['title'];
  unset($_SESSION['title']);
}

if ( isset($_SESSION['content']) ) {
  $event['content'] = $_SESSION['content'];
  unset($_SESSION['content']);
}

// バリデーションエラータイトル


include('../common/head.php');
?>

<body>
  <?php include('../common/global_menu.php'); ?>

  <div class="container">

    <div class="col-5">
      <h3>id = <?php echo $event['id']; ?> 番　出来事　編集ページ</h3>

      <form method="post" action="action/update.php">
        <input type="hidden" name="event_id" 
               value="<?php if (isset($event['id']) ) {
                          echo $event['id']; 
                      } ?>"
               >
        <div class="form-group">
          <label>出来事タイトル</label>
          <input type="text" class="form-control" id="title" name="title" 
                 value="<?php if (isset($event['title']) ) { 
                          echo $event['title']; }
                        ?>"
                 >
        </div>
        <?php
        if (isset($_SESSION['error_title'])) {
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
          <textarea class="form-control" id="content" name="content" cols="90" rows="7"><?php if ( isset($event['content']) ) {echo $event['content']; }
          unset($_SESSION['content']); ?></textarea>
        </div>
        <?php
        if (isset($_SESSION['error_content'])) {
          echo '<div class="text-danger">';
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