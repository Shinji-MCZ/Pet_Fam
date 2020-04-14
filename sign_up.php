<?php
require_once('categories.php');
require_once('config.php');
require_once('functions.php');

$categories = getAllCategories();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = $_POST['email'];
  $username = $_POST['username'];
  $petname = $_POST['petname'];
  $categories_id = $_POST['categpries_id'];
  $typename = $_POST['typename'];
  $password = $_POST['password'];

  $errors = [];

  if ($email == '') {
    $errors[] = 'メールアドレスが未入力です';
  }

  if ($username == '') {
    $errors[] = 'ユーザー名が未入力です';
  }

  if ($petname == '') {
    $errors[] = 'ペットの名前が未入力です';
  }

  if ($categories_id == '') {
    $errors[] = 'カテゴリーが未選択です';
  }
  if ($type_name == '') {
    $errors[] = 'ペットの種類が未入力です';
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
    $sql = "insert into users " . "(email, username, profile, password, created_at, updated_at) values " .
      "(:email, :username, now(), now())";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->bindParam(":username", $username, PDO::PARAM_STR);
    $stmt->bindParam(":profile", $profile, PDO::PARAM_STR);
    $pw_hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt->bindParam(":password", $pw_hash, PDO::PARAM_STR);
    $stmt->execute();

    $username_id = $dbh->lastInsertId();

    $sql2 = "insert into pets " . "(petname, categories_id, type_name,created_at, updated_at) values " .
      "(:petname, :categories_id, :type_name, now(), now())";
    $stmt->bindParam(":petname", $petname, PDO::PARAM_STR);
    $stmt->bindParam(":categories_id", $categories_id, PDO::PARAM_INT);
    $stmt->bindParam(":type_name", $type_name, PDO::PARAM_STR);
    $stmt->execute();


    header('Location:index.php');
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
        <li><a href="sign_out.php" class="">ログアウト</a></li>
        <li><a href="new.php" class="">写真を投稿</a></li>
      <?php else : ?>
        <li><a href="sign_in.php" class="">ログイン</a></li>
        <li><a href="index.php" class="">TOPへ戻る</a></li>
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
    <label for="email">メールアドレス</label><br>
    <input type="email" name="email" id="" class="" autofocus required><br>

    <label for="username">ユーザー名</label><br>
    <input type="text" name="username" id="" class="" required><br>

    <label for="petname">ペットの名前</label><br>
    <input type="text" name="petname" id="" class="" required><br>

    <label for="type_id">ペットカテゴリー</label><br>
    <select name="categpries_id" class="" require><br>
      <option value="" disabled selected>選択してください</option><br>
      <?php foreach ($categories as $c) : ?>
        <option value="<?php echo h($c['id']); ?>"><?php echo h($c['type']); ?></option>
      <?php endforeach; ?>
    </select><br>

    <label for="type_name">ペットの種類</label><br>
    <input type="text" name="type_name" id="" class="" required><br>

    <label for="profile">紹介文･コメント</label><br>
    <textarea cols="30" rows="5" name="profile" class="textaread" required></textarea><br>

    <input type="file" name="image" size="35"><br>

    <label for="password">パスワ-ド</label><br>
    <input type="password" name="password" id="" class="" required><br>
    <a href="thanks.php"><input type="submit" value="新規登録" class=""></a><br>
  </form>

  <footer class="">
    <div>&copy; 2020 OriginalApp</div>
  </footer>
</body>

</html>