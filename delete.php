<?php

include_once 'config/database.php';
include_once 'config/session.php';

if(isset($_GET['delete_id']))
{
    $stmt_select=$conn->prepare('SELECT * FROM usersimage WHERE image_name=:image_name');
    $stmt_select->execute(array(':image_name'=>$_GET['delete_id']));
    $imgRow=$stmt_select->fetch(PDO::FETCH_ASSOC);
    unlink($imgRow['image_name']);
    $stmt_delete=$conn->prepare('DELETE FROM usersimage WHERE image_name =:image_name');
    $stmt_delete->bindParam(':image_name', $_GET['delete_id']);
    if($stmt_delete->execute())
    {
        ?>
        <script>
        alert("You are deleted one item");
        window.location.href=('mygallary.php');
        </script>
        <?php 
    }else
 
    ?>
        <script>
        alert("Can not delete item");
        window.location.href=('mygallary.php');
        </script>
        <?php 
 
}
 
?>
