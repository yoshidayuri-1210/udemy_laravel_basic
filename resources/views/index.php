<?php
echo 'thii is mmy test yuri';
// ssh -i ~/Desktop/id_xserver_rsa -p 10022 xs050415@xs050415.xsrv.jp

$host     = 'sv13265.xserver.jp'; // 接続先ホスト
$username = 'xs050415_sample';   // データベースユーザ名
$password = 'dbsecret';       // データベースのパスワード
$dbname   = 'message';   // データベース名
$charset  = 'utf8';   // データベースの文字コード
 
$messages = [];
$errors = [];
 
// MySQL用のDSN文字列
$dsn = 'mysql:dbname='.$dbname.';host='.$host.';charset='.$charset;
 
 
 
if($_SERVER['REQUEST_METHOD'] === 'POST'){
 
  $name = '';
  if(isset($_POST['name']) === true){
    $name = $_POST['name'];
  }
 
  $comment = '';
  if(isset($_POST['comment']) === true){
    $comment = $_POST['comment'];
  }
 
  if($name === ''){
    $errors[] = '名前を入力してください';
  }
  if(mb_strlen($name) > 20){
    $errors[] = '名前は20文字以内で入力してください';
  }
 
  if($comment === ''){
    $errors[] = 'コメントを入力してください';
  }
  if(mb_strlen($comment) > 100){
    $errors[] = 'コメントは100文字以内で入力してください';
  }
}
 
try {
  // データベースに接続
  $dbh = new PDO($dsn, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
 
  if($_SERVER['REQUEST_METHOD'] === 'POST' && count($errors) === 0){
    try {
      $sql = 'INSERT INTO messages(name, comment) VALUES(?, ?)';
      // SQL文を実行する準備
      $stmt = $dbh->prepare($sql);
      $stmt->bindValue(1, $name, PDO::PARAM_STR);
      $stmt->bindValue(2, $comment, PDO::PARAM_STR);
      // SQLを実行
      $stmt->execute();
    } catch (PDOException $e) {
      echo '書き込みできませんでした。理由：'.$e->getMessage();
    }
 
  }
 
  // SQL文を作成
  $sql = 'SELECT name, comment, created from messages';
  // SQL文を実行する準備
  $stmt = $dbh->prepare($sql);
  // SQLを実行
  $stmt->execute();
  // レコードの取得
  $messages = $stmt->fetchAll();
 
} catch (PDOException $e) {
  echo '接続できませんでした。理由：'.$e->getMessage();
}
 
function h($string){
  return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>一言掲示板</title>
  </head>
  <body>
    <?php foreach($errors as $error){ ?>
      <p><?php print h($error); ?></p>
    <?php } ?>
    <form method="POST">
      <label for="name">名前: </label>
      <input type="text" id="name" name="name">
      <label for="comment">コメント: </label>
      <input type="text" id="comment" name="comment">
      <input type="submit" value="投稿する"> 
    </form>
    <ul>
      <?php foreach($messages as $message){ ?>
        <li>
          <?php print h($message['name']); ?>:
          <?php print h($message['comment']); ?>:
          <?php print h($message['created']); ?>
        </li>
      <?php } ?>
  </body>
</html>