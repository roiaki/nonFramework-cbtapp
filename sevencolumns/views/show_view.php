<body>
  <?php include '../common/global_menu.php'; ?>
  <div class="container">
    <h3>7コラム 詳細ページ</h3>
    <table class="table table-striped table-bordered">
      <thead>
        <tr class="table-primary">
          <th>id</th>
          <th>出来事id</th>
          <th>3コラムID</th>
          <th>更新日</th>
        </tr>
      </thead>

      <tbody>
        <tr>
          <td><?php echo $sevencolumn['id']; ?></td>
          <td><?php echo $sevencolumn['event_id']; ?></td>
          <td><?php echo $sevencolumn['threecol_id'] ?></td>
          <td><?php echo $sevencolumn['updated_at']; ?></td>
        </tr>
      </tbody>
    </table>

    <table class="table table-striped table-bordered">
      <thead>
        <tr class="table-primary">
          <th>タイトル</th>
          <th>内容</th>
          <th>感情</th>
          <th>感情の強さ</th>
          <th>考えたこと</th>
          <th>考え方の癖</th>
        </tr>
      </thead>

      <tbody>
        <tr>
          <td><?php echo $sevencolumn['title']; ?></td>
          <td><?php echo $sevencolumn['content']; ?></td>
          <td><?php echo $sevencolumn['emotion_name']; ?></td>
          <td><?php echo $sevencolumn['emotion_strength']; ?></td>
          <td><?php echo $sevencolumn['thinking']; ?></td>
          <td><?php
              foreach ($names as $name) {
                echo $name['habit_name'] . "<br>";
              }
              ?>
          </td>
        </tr>
      </tbody>
    </table>

    <table class="table table-striped table-bordered">
      <thead>
        <tr class="table-primary">
          <th>その考えの根拠</th>
          <th>逆の事実</th>
          <th>新しい考え</th>
          <th>新しい感情</th>
        </tr>
      </thead>

      <tbody>
        <tr>
          <td><?php echo $sevencolumn['basis_thinking']; ?></td>
          <td><?php echo $sevencolumn['opposite_fact']; ?></td>
          <td><?php echo $sevencolumn['new_thinking']; ?></td>
          <td><?php echo $sevencolumn['new_emotion']; ?></td>
        </tr>
      </tbody>
    </table>

    <a href="edit.php?sevencolumn_id=<?php echo $sevencolumn['id']; ?>" class="btn btn-primary btn-lg" role="button" aria-pressed="true">
      編集
    </a>
    <a href="delete.php?sevencolumn_id=<?php echo $sevencolumn['id']; ?>" class="btn btn-danger btn-lg" role="button" onclick="confirmDelete();return false;" aria-pressed="true">
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