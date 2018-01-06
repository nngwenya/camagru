<?php
include_once 'database.php';



try{
    $username = 'root';
    $dsn = 'mysql:host=localhost';
    $password = "12345qwert";
    //create an instance of the PDO class with the required parameters.
    $connt = new PDO($dsn, $username, $password);
    //set pdo error mode to exception
    $connt->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$create = "CREATE DATABASE IF NOT EXISTS `camagru`";
$create_dbs = $connt->prepare($create);

echo "Database was created successfully .<br>";

$create_dbs->execute();
$table = "CREATE TABLE IF NOT EXISTS `comments` (
    `id` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `username` varchar(100) NOT NULL,
    `commentimg` text NOT NULL,
    `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `post_id` int(11) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
  
";
echo "Table `comments` has been created successfully .<br>";
$stmt = $conn->prepare($table);
$stmt->execute();



$table = "CREATE TABLE IF NOT EXISTS `like_pictures` (
    `id` int(11) UNSIGNED NOT NULL,
    `username` varchar(100) NOT NULL,
    `post_id` int(11) NOT NULL,
    `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";
$stmt = $conn->prepare($table);
$stmt->execute();
echo "Table `like_picture` has been created successfully .<br>";

$table = "CREATE TABLE IF NOT EXISTS `users` (
    `id` int(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `firstname` varchar(30) DEFAULT NULL,
    `lastname` varchar(30) DEFAULT NULL,
    `username` varchar(30) DEFAULT NULL,
    `email` varchar(255) DEFAULT NULL,
    `password` varchar(255) DEFAULT NULL,
    `country` varchar(30) DEFAULT NULL,
    `join_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `email_pref` varchar(256) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";
$stmt = $conn->prepare($table);
$stmt->execute();
echo "Table `users` has been created successfully .<br>";

$table = " CREATE TABLE IF NOT EXISTS `usersimage` (
    `id` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `image_name` varchar(255) NOT NULL,
    `username` varchar(255) NOT NULL,
    `edit_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";
$stmt = $conn->prepare($table);
$stmt->execute();

echo "Table `usersimage` has been created successfully .<br>";


}catch (PDOException $ex){
  //display success message
  echo "Connection failed".$ex->getMessage();
}

$conn = null;
?>