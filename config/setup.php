<?php
include_once ('database.php');

$username = 'root';
$dsn = 'mysql:host=localhost';
$password = "12345qwert";

try{
    //create an instance of the PDO class with the required parameters.
    $connt = new PDO($dsn, $username, $password);
    //set pdo error mode to exception
    $connt->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}catch (PDOException $ex){
    //display success message
    echo "Connection failed".$ex->getMessage();
}


$create = "CREATE DATABASE IF NOT EXISTS `camagru`";
$create_dbs = $connt->prepare($create);

$create_dbs->execute();
$table = "CREATE TABLE IF NOT EXISTS `comments` (
    `id` int(11) UNSIGNED NOT NULL,
    `username` varchar(100) NOT NULL,
    `commentimg` text NOT NULL,
    `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `post_id` int(11) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";
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


$table = "CREATE TABLE IF NOT EXISTS `users` (
    `id` int(10) UNSIGNED NOT NULL,
    `firstname` varchar(30) DEFAULT NULL,
    `lastname` varchar(30) DEFAULT NULL,
    `username` varchar(30) DEFAULT NULL,
    `email` varchar(255) DEFAULT NULL,
    `password` varchar(255) DEFAULT NULL,
    `country` varchar(30) DEFAULT NULL,
    `join_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `profile_image` varchar(256) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";
$stmt = $conn->prepare($table);
$stmt->execute();

$table = " CREATE TABLE IF NOT EXISTS `usersimage` (
    `id` int(11) NOT NULL,
    `image_name` varchar(255) NOT NULL,
    `username` varchar(255) NOT NULL,
    `edit_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";
$stmt = $conn->prepare($table);
$stmt->execute();


?>