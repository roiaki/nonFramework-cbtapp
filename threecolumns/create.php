<?php
session_start();

require '../common/database.php';
require '../common/auth.php';
//var_dump($_SESSION);
//exit();

// ログインしていないならログイン画面へ
if (!isLogin()) {
  header('Location: ../../login/');
}

$htmltitle = "3コラム新規作成";

$user_id = getLoginUserId();
$user_name = getLoginUserName();

$event_id = $_GET['event_id'];
var_dump($_GET);
//exit;
$database_handler = getDatabaseConnection();
$stmt = $database_handler->prepare("SELECT * FROM events WHERE user_id = :user_id AND id = :event_id");

$stmt->bindParam(':event_id', $event_id);
$stmt->bindParam(':user_id', $user_id);

$stmt->execute();

$event = $stmt->fetch(PDO::FETCH_ASSOC);
$event_title = $event['title'];
$event_content = $event['content'];

// 作成ボタンを押した段階でテーブルに一旦データを仮格納する
$stmt = $database_handler
    ->prepare(
      "INSERT INTO 
        threecolumns 
        (user_id, event_id, title, content) 
      VALUES 
        (:user_id, :event_id, :title, :content)"
    );
//var_dump($stmt);
$stmt->bindParam(':user_id', $user_id);
$stmt->bindParam(':event_id', $event_id);
$stmt->bindParam(':title', $event_title);
$stmt->bindParam(':content', $event_content);
//var_dump($stmt);

$stmt->execute();
//var_dump($stmt);
//exit;
$threecol_id = $database_handler->lastInsertId();

include('../common/head.php');
?>

<body>
  <?php include('../common/global_menu.php'); ?>

  <div class="container">
    <div class="row">
      <div class="col-5">
        <h3>3コラム　新規作成</h3>

        <form method="post" action="action/store.php">
          <div class="form-group">

            <input type="hidden" name="threecol_id" value="<?php echo $threecol_id; ?>">
            
          <label>出来事タイトル</label>
            <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>" >
            <input type="text" class="form-control" id="title" name="title" 
                   value="<?php echo $event['title']; ?> " readonly>

            <?php if (isset($_SESSION['error_title'])) {
                echo '<div class="text-danger">';
                //var_dump($_SESSION);
                foreach ($_SESSION['error_title'] as $error) {
                  echo "<div>* $error </div>";
                }
                echo '</div>';
                unset($_SESSION['error_title']);
            }
            ?>
          </div>
          <div class="form-group">
            <!-- 内容 -->
            <label for="content">①出来事 の 内容</label>
            <textarea class="form-control" id="content" name="content" cols="90" rows="7" readonly><?php echo $event['content']; ?></textarea>

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
          </div>

          <div class="form-group">
            <label for="emotion_name">②-1  感情名</label>
            <input type="text" class="form-control" id="emotion_name" name="emotion_name">

            <!-- 感情名必須バリデーション表示-->

          </div>

          <div class="form-group">
            <label for="emotion_strength">②-2  強さ</label>
            <input type="number" class="form-control" id="emotion_strength" name="emotion_strength">

            <!-- 感情名必須バリデーション表示-->

          </div>

          <div class="form-group">
            <label for="thinking">③その時考えたこと（自動思考）</label><br>
            <textarea class="form-control" id="thinking" name="thinking" cols="90" rows="7"></textarea>

            <!-- 感情名必須バリデーション表示-->

          </div>

          <lavel>・その考えに当てはまる考え方の癖</lavel>
          <div class="form-group">					
            
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" name="habit[0]" id="1">
              <label class="form-check-label" for="1">
                一般化のし過ぎ
              </label>
            </div>

            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" name="habit[1]" id="2">
              <label class="form-check-label" for="2">
                自分への関連付け
              </label>
            </div>

            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" name="habit[2]" id="3">
              <label class="form-check-label" for="3">
                根拠のない推論
              </label>
            </div>

            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" name="habit[3]" id="4">
              <label class="form-check-label" for="4">
                白か黒か思考
              </label>
            </div>

            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" name="habit[4]" id="5">
              <label class="form-check-label" for="5">
                すべき思考
              </label>
            </div>

            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" name="habit[5]" id="6">
              <label class="form-check-label" for="6">
                過大評価と過少評価
              </label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" name="habit[6]" id="7">
              <label class="form-check-label" for="7">
                感情による決めつけ
              </label>
            </div>
          </div>
          <button class="btn btn-primary" type="submit">作成</button>
        </form>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
  <script defer src="https://use.fontawesome.com/releases/v5.7.2/js/all.js"></script>
  <script type="text/javascript" src="main.js"></script>
</body>