<body>
  <?php include '../common/global_menu.php'; ?>
  <?php if (isset($_SESSION['flash_message'])) {
        $message = $_SESSION['flash_message'];
      unset($_SESSION['flash_message']);
          echo $message;
      }		  
  ?>
  <div class="container">
    <h3>7カラム一覧</h3>

    <table class="table table-striped table-bordered">
      <thead>
        <tr class="table-primary">
          <th>7カラムid</th>
          <th>出来事ID</th>
          <th>3コラムID</th>
          <th>タイトル</th>
          <th>内容</th></th>
          <th>更新日</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($sevencolumns as $sevencolumn) { ?>
        <tr>
          <td><?php echo $sevencolumn['id']; ?></td>
          <td><?php echo $sevencolumn['event_id'] ?></td>
          <td><?php echo $sevencolumn['threecol_id']; ?></td>
          <td><?php echo $sevencolumn['title']; ?></td>
          <td><?php echo $sevencolumn['content']; ?></td>
          <td><?php echo $sevencolumn['updated_at']; ?>
          <p><a href="show.php?sevencolumn_id=<?php echo $sevencolumn['id']; ?> ">詳細</a></p>
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