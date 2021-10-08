<?php
session_start();

require '../common/database.php';
require '../common/auth.php';

// ログインしてないならログイン画面へ
if ( !isLogin() ) {
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

var_dump(
    "event_id = " . $event_id,
    "get['event_id'] = " . $_GET['event_id'],
    "user_id = " . $user_id,
    'user_name = ' . $user_name
);

$database_handler = getDatabaseConnection();
$sql = $database_handler->prepare("SELECT * FROM events WHERE user_id = :user_id AND id = :event_id ORDER BY updated_at DESC");

$sql->bindParam(':user_id', $user_id);
$sql->bindParam(':event_id', $event_id);

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

    <div class="container">
        <h3>出来事 詳細ページ</h3>

        <table class="table table-striped table-bordered">
            <thead>
                <tr class="table-primary">

                    <th>出来事id</th>
                    <th>タイトル</th>
                    <th>内容</th>
                    <th>更新日</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($events as $event) { ?>
                    <tr>
                        <td><?php echo $event['id']; ?></td>
                        <td><?php echo $event['title']; ?></td>
                        <td><?php echo $event['content']; ?></td>
                        <td><?php echo $event['updated_at']; ?></td>
                    </tr>
                <?php  } ?>
            </tbody>
        </table>
        <a href="edit.php?event_id=<?php echo $event['id']; ?>" class="btn btn-success btn-lg" role="button" aria-pressed="true">この出来事を元に3コラムを作成</a>
        <a href="edit.php?event_id=<?php echo $event['id']; ?>" class="btn btn-primary btn-lg" role="button" aria-pressed="true">編集</a>
        <a href="delete.php?event_id=<?php echo $event['id']; ?>" class="btn btn-danger btn-lg" role="button" aria-pressed="true">削除</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.7.2/js/all.js"></script>
    <script type="text/javascript" src="main.js"></script>
</body>

</html>