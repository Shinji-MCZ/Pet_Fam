<?php

require_once('config.php');
require_once('functions.php');
require_once('categories.php');

session_start();

$dbh = connectDb();

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pet Fam</title>
  <link rel="stylesheet" href="style.css">
  <!-- Google font -->
  <link href="https://fonts.googleapis.com/css?family=Dancing+Script" rel="stylesheet">
  <!-- Font Awesome-->
  <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
</head>

<body>
  <header class="page-header wrapper">
    <div>
      <h1 class="top">PetFam</h1>
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
        <ul class="main-nav">
          <li><a href="about.php" class="nav-link">About</a></li>
          <li><a href=" photo.php" class="nav-link">Photo</a></li>
          <li><a href=" search.php" class="nav-link">Search</a></li>
        </ul>
      </nav>
      <div>
        <img class="top-img" src="images/よつ.png" alt="">
      </div>
      <hr>
  </header>
  </div>
</body>

</html>