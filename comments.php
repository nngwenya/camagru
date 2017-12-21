<?php
include_once 'config/database.php';
include_once 'config/session.php';
include_once 'mygallary.php';


if (isset( $_POST['commentsave'])){
    var_dump($_POST);
$post_id = $_POST['image_id'];
$comment = $_POST['comment'];
$username = $_SESSION['username'];
$date = date('Y-m-d H:i:s');


    $sqlInsert = "INSERT INTO comments (username, commentimg ,post_id, date)
                VALUES ('$username', '$comment', '$post_id', now())";
    $stmt = $conn->prepare($sqlInsert);
    $stmt->bindParam(':post_id', $post_id);
    $stmt->execute();
    //var_dump("$sqlInsert"); 
  

   }

?>