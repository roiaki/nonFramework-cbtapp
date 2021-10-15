<?php
session_start();

require '../common/auth.php';

// ログインしていたらevents/index.phpへリダイレクト
if (isLogin()) {
  header('Location: ../events');
  exit;
}

// バリデーションエラーリダイレクトだったら前回入力した値を表示する
if ( isset($_SESSION['user_name']) ) {
  $user_name = $_SESSION['user_name'];
  unset( $_SESSION['user_name'] );
}

if ( isset($_SESSION['user_email']) ) {
  $user_email = $_SESSION['user_email'];
  unset( $_SESSION['user_email'] );
}

if ( isset($_SESSION['user_password']) ) {
  $user_password = $_SESSION['user_password'];
  unset( $_SESSION['user_password'] );
}

$htmltitle = '会員登録';
$description = '';

include('../common/head.php');

?>

<body>
  <?php include('../common/global_menu.php'); ?>

  <form action="action/register.php" method="post">
    <div class="d-flex flex-column align-items-center justify-content-center shadow-lg p-3 mb-5 bg-white rounded">
      <h3>会員登録</h3>

      <div class="form-group">
        <label for="name">お名前</label>
        <input type="text" name="user_name" id="name" class="form-control" placeholder="お名前" 
               value="<?php 
                        if ( isset($user_name) ) {
                          echo $user_name;
                        } 
                      ?>"
               >

        <?php if (isset($_SESSION['name_error'])) {
          echo '<div class="text-danger">';
          foreach ($_SESSION['name_error'] as $error) {
            echo "<div>* $error </div>";
          }
          echo '</div>';
          unset($_SESSION['name_error']);
        }
        ?>
      </div>

      <div class="form-group">
        <label for="email">メールアドレス</label>
        <input type="email" name="user_email" id="email" class="form-control"
               placeholder="メールアドレス"
               value="<?php
                        if ( isset($user_email) ) {
                          echo $user_email;
                        }
                      ?>"
                >
        <?php if (isset( $_SESSION['email_error']) ) {
          echo '<div class="text-danger">';
          foreach ($_SESSION['email_error'] as $error) {
            echo "<div>* $error </div>";
          }
          echo '</div>';
          unset($_SESSION['email_error']);
        }
        ?>
      </div>

      <div class="form-group">
        <label for="password">パスワード</label>
        <input type="password" name="user_password" id="password" class="form-control" 
               placeholder="パスワード"
               value="<?php
                        if ( isset($user_password) ) {
                          echo $user_password;
                        }
                      ?>"
               >
        <?php if (isset($_SESSION['password_error'])) {
          echo '<div class="text-danger">';
          foreach ($_SESSION['password_error'] as $error) {
            echo "<div>* $error </div>";
          }
          echo '</div>';
          unset($_SESSION['password_error']);
        }
        ?>
      </div>

      <button type="submit" class="col-1 form-control btn btn-success">
        登録する
      </button>
    </div>
  </form>
</body>

</html>