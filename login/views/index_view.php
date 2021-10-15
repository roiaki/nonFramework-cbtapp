<body>
<?php include '../common/global_menu.php'; ?>
  <form action="action/login.php" method="post">
    <div class="d-flex flex-column align-items-center justify-content-center shadow-lg p-3 mb-5 bg-white rounded">
      <h3>ログイン</h3>
      <?php if ( isset($_SESSION['error_verify']) ) {
          echo '<div class="text-danger">';
          foreach ($_SESSION['error_verify'] as $error) {
            echo "<div>* $error </div>";
          }
          echo '</div>';
          unset($_SESSION['error_verify']);
        }
      ?>
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
        <?php if ( isset($_SESSION['email_error']) ) {
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
        <?php if ( isset($_SESSION['password_error']) ) {
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
        ログイン
      </button>
    </div>
  </form>
</body>
</html>