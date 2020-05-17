<?php

require_once('config.php');
require_once('functions.php');

session_start();
$dbh = connectDb();

if (!empty($_SESSION['id'])) {
  header('Location: index.php');
  exit;
}



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $errors = [];

  if ($email == '') {
    $errors[] = 'emailが未入力です';
  }
  if ($password == '') {
    $errors[] = 'passwordが未入力です';
  }

  // バリデーション突破後
  if (empty($errors)) {

    $sql = 'SELECT * FROM users WHERE email = :email';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (password_verify($password, $user['password'])) {
      $_SESSION['id'] = $user['id'];
      $url = $_SERVER['HTTP_REFERER'];
      header('Location: index.php');
      exit;
    } else {
      $errors[] = 'メールアドレスかパスワードが間違っています';
    }
  }
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="style.css">
  <title>ログイン画面</title>
</head>

<body>
  <h2>ログイン</h2>
  <ul class="sign-nav">
    <?php if ($_SESSION['id']) : ?>
      <li><a href="sign_out.php" class="nav-link">ログアウト</a></li>
      <li><a href="photo_new.php" class="nav-link">写真を投稿</a></li>
    <?php else : ?>
      <li><a href="sign_in.php" class="nav-link">ログイン</a></li>
      <li><a href="sign_up.php" class="nav-link">新規登録</a></li>
    <?php endif; ?>
  </ul>

  <?php if ($errors) : ?>
    <ul class="error">
      <?php foreach ($errors as $error) : ?>
        <li><?php echo $error; ?></li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>


  <form action="" method="post">
    <label for="email"> E-mail :
      <input type="email" name="email" value="<?php echo h($email); ?>">
    </label>
    <br>
    <label for="password"> Pass :
      <input type="password" name="password">
    </label>
    <br>
    <input type="submit" value="login">
  </form>
  <a href="index.php"></a>
</body>

</html>