<?php
include_once 'config/database.php';
include_once 'config/session.php';

$image_id = $_GET['usersimage'];
$username = $_SESSION['username'];
$date = date('Y-m-d H:i:s');
    
    $sqlInsert = 'SELECT username FROM like_pictures WHERE post_id = '.$image_id;
    $stmt = $conn->prepare($sqlInsert);
    $stmt->execute();

    $row = $stmt->fetchAll();
    $run_bool = 0;
    foreach ($row as $users){
        if (in_array($username, $users))
            $run_bool = 1;
    }
    if ($run_bool == 0){
    $sqlInsert = "INSERT INTO like_pictures (username, post_id, date) VALUES ('$username', '$image_id', now())" ;
    $stmt->bindParam(':post_id', $image_id);
    $stmt = $conn->prepare($sqlInsert);
    $stmt->execute();

    }else{
        $del = 'DELETE FROM like_pictures WHERE username = :username AND post_id = :post_id';
        $stmt = $conn->prepare($del);
        $stmt->execute(array(':username' => $username, ':post_id' => $image_id));
    }
    header('Location: http://localhost:8080/Camagru/mygallary.php');


?>
