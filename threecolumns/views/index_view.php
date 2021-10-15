<body>
  <?php include '../common/global_menu.php'; ?>
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
          <th>出来事</th>
          <th>感情</th>
          <th>強さ</th>
          <th>更新日</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($threecolumns as $threecolumn) { ?>
        <tr>
          <td><?php echo $threecolumn['id']; ?></td>
          <td><?php echo $threecolumn['title'] ?></td>
          <td><?php echo $threecolumn['emotion_name']; ?></td>
          <td><?php echo $threecolumn['emotion_strength']; ?></td>
          <td><?php echo $threecolumn['updated_at']; ?>
          <p><a href="show.php?threecol_id=<?php echo $threecolumn['id']; ?> ">詳細</a></p>
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