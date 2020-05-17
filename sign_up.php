<?php

require_once('config.php');
require_once('functions.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = $_POST['email'];
  $username = $_POST['username'];
  $profile = $_POST['profile'];
  $password = $_POST['password'];

  $errors = [];

  if ($email == '') {
    $errors[] = 'メールアドレスが未入力です';
  }

  if ($username == '') {
    $errors[] = 'ユーザー名が未入力です';
  }

  if ($profile == '') {
    $errors[] = 'プロフィールが未入力です';
  }

  if ($password == '') {
    $errors[] = 'パスワードが未入力です';
  }

  //アカウント登録済か確認
  $dbh = connectDb();
  $sql = "select * from users where email = :email";
  $stmt = $dbh->prepare($sql);
  $stmt->bindParam(":email", $email, PDO::PARAM_STR);
  $stmt->execute();
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($user) {
    $errors[] = '既にメールアドレスが登録されています。';
  }

  if (empty($errors)) {
    $sql = <<<SQL
    INSERT INTO
      users
    (
      email,
      username,
      profile,
      password
    )
    VALUES
    (
      :email,
      :username,
      :profile,
      :password
    )
    SQL;
    $stmt = $dbh->prepare($sql);

    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->bindParam(":username", $username, PDO::PARAM_STR);
    $stmt->bindParam(":profile", $profile, PDO::PARAM_STR);
    $pw_hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt->bindParam(":password", $pw_hash, PDO::PARAM_STR);

    $stmt->execute();

    header('Location: thanks.php');
    exit;
  }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PetFam新規登録</title>
  <link rel="stylesheet" href="style.css">
  <!-- Google font -->
  <link href="https://fonts.googleapis.com/css?family=Dancing+Script" rel="stylesheet">
</head>

<body>
  <nav>
    <ul class="sign-nav">
      <?php if ($_SESSION['id']) : ?>
        <li><a href="sign_out.php" class="nav-link">ログアウト</a></li>
        <li><a href="photo_new.php" class="nav-link">写真を投稿</a></li>
      <?php else : ?>
        <li><a href="sign_in.php" class="nav-link">ログイン</a></li>
        <li><a href="sign_up.php" class="nav-link">新規登録</a></li>
      <?php endif; ?>
    </ul>
    <hr>
  </nav>
  <h4>アカウント登録</h4>
  <?php if ($errors) : ?>
    <ul class="error">
      <?php foreach ($errors as $error) : ?>
        <li><?php echo $error; ?></li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
  <form action="sign_up.php" method="post">
    <label for="email">メールアドレス【必須】</label><br>
    <input type="email" name="email" value="<?php echo h($email); ?>" autofocus required><br>

    <label for="username">ユーザー名【必須】</label><br>
    <input type="text" name="username" value="<?php echo h($username); ?>" required><br>

    <label for="profile">ひとこと</label><br>
    <textarea cols="30" rows="5" name="profile" class="textaread" value="<?php echo h($profile); ?>" required></textarea><br>

    <label for="password">パスワ-ド</label><br>
    <input type="password" name="password" id="" class="" required><br>

<input type="submit" value="新規登録" class="">
  </form>

  <footer class="">
    <div>&copy; 2020 OriginalApp</div>
  </footer>
</body>

</html>