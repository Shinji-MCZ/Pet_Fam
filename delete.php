<?php
require_once('config.php');
require_once('functions.php');

$id = $_GET['id'];

$dbh = connectDb();

$sql = "select * from photos where id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(":id", $id, PDO::PARAM_INT);
$stmt->execute();

$photo = $stmt->fetch(PDO::FETCH_ASSOC);

// 存在しないidを渡された場合はindex.phpへ
if (!$photo) {
  header('Location: index.php');
  exit;
}

//sqlのデリート文
$sql_delete = "delete from photos where id = :id";
$stmt = $dbh->prepare($sql_delete);
$stmt->bindParam(":id", $id, PDO::PARAM_INT);
$stmt->execute();

$photo = $stmt->fetch(PDO::FETCH_ASSOC);

header('Location: index.php');
exit;
