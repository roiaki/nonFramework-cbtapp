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

$threecol_id = $_GET['threecol_id'];
$database_handler = getDatabaseConnection();

$stmt = $database_handler
    ->prepare(
        "SELECT
          * 
        FROM
          threecolumns
        WHERE
          id = :threecol_id"
    );
$stmt->bindParam(':threecol_id', $threecol_id);  
$stmt->execute();

$threecolumn = [];

while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $threecolumn = $result;
}

$threecolumn_id = $threecolumn['id'];
$event_id = $threecolumn['event_id'];
$title = $threecolumn['title'];
$content = $threecolumn['content'];
$emotion_name = $threecolumn['emotion_name'];
$emotion_strength = $threecolumn['emotion_strength'];
$thinking = $threecolumn['thinking'];
var_dump($event_id, $title, $content, $emotion_name, $emotion_strength, $thinking);
//var_dump($threecolumn);

// 作成ボタンを押した段階でテーブルに一旦データを仮格納する
$stmt2 = $database_handler
    ->prepare(
      "INSERT INTO 
        sevencolumns 
        (user_id, 
         event_id,
         threecol_id,
         title,
         content,
         emotion_name,
         emotion_strength,
         thinking
         ) 
       VALUES 
        (:user_id, 
         :event_id,
         :threecolumn_id,
         :title,
         :content,
         :emotion_name,
         :emotion_strength,
         :thinking)"
    );

$stmt2->bindParam(':user_id', $user_id);
$stmt2->bindParam(':event_id', $event_id);
$stmt2->bindParam(':threecolumn_id', $threecolumn_id);
$stmt2->bindParam(':title', $title);
$stmt2->bindParam(':content', $content);
$stmt2->bindParam(':emotion_name', $emotion_name);
$stmt2->bindParam(':emotion_strength', $emotion_strength);
$stmt2->bindParam(':thinking', $thinking);
//var_dump($stmt2);

$stmt2->execute();

$sevencolumn_id = $database_handler->lastInsertId();

include '../common/head.php';
?>

<body>
  <?php include '../common/global_menu.php'; ?>

  <div class="container">
    <div class="row">
      <div class="col-5">
        <h3>7コラム　新規作成</h3>

        <form method="post" action="controller/store.php">
          <div class="form-group">
            <input type="hidden" name="sevencolumn_id" value="<?php echo $sevencolumn_id; ?>">
            <input type="hidden" name="threecolumn_id" value="<?php echo $threecol_id; ?>">
            <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">

          <label>出来事タイトル</label>
            
            <input type="text" class="form-control" id="title" name="title" 
                   value="<?php echo $title; ?> " readonly>

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
            <textarea class="form-control" id="content" name="content" cols="90" rows="3" readonly><?php echo $content; ?></textarea>

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
            <input readonly type="text" class="form-control" id="emotion_name" name="emotion_name"
                   value="<?php
                            if ( isset($emotion_name) ) {
                              echo $emotion_name;
                            }
                          ?>"
                   >

            <!-- 感情名必須バリデーション表示-->

          </div>

          <div class="form-group">
            <label for="emotion_strength">②-2  強さ</label>
            <input readonly type="number" class="form-control" id="emotion_strength" name="emotion_strength"
                   value="<?php
                            if (isset($emotion_strength) ) {
                              echo $emotion_strength;
                            }
                          ?>"
                   >

            <!-- 感情名必須バリデーション表示-->

          </div>

          <div class="form-group">
            <label for="thinking">③その時考えたこと（自動思考）</label><br>
            <textarea class="form-control" 
                      id="thinking" 
                      name="thinking" 
                      cols="90" 
                      rows="3"
                      readonly><?php if (isset($thinking) ) {
                                 echo $thinking;
                                }
                               ?></textarea>

            <!-- 感情名必須バリデーション表示-->
          </div>

          <div class="form-group">
            <label for="basis_thinking">④その考えの根拠</label>
            <textarea class="form-control"
                      id="basis_thinking"
                      name="basis_thinking"
                      cols="50"
                      rows="3"></textarea>
          </div>

          <div class="form-group">
            <label for="opposite_fact">⑤逆の事実</label>
            <textarea class="form-control"
                      id="opposite_fact"
                      name="opposite_fact"
                      cols="50"
                      rows="3"></textarea>
          </div>

          <div class="form-group">
            <label for="new_thinking">⑥新しい考え</label>
            <textarea class="form-control"
                      id="new_thinking"
                      name="new_thinking"
                      cols="50"
                      rows="3"></textarea>
          </div>

          <div class="form-group">
            <label for="new_emotion">⑦新しい感情</label>
            <textarea class="form-control"
                      id="new_emotion"
                      name="new_emotion"
                      cols="50"
                      rows="2"></textarea>
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