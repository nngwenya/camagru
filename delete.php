<?php
include_once 'config/database.php';
include_once 'config/session.php';


if(isset($_GET['delete_id'])){
    $stmt = $conn->prepare("SELECT * FROM usersimgage WHERE image_name:image_name");
    $stmt->execute(array(":image_name"=>$_GET['delete_id']));
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    unlike($row["image_name"]);
    $delete = $conn->prepare("DELETE FROM usersimgage WHERE image_name:image_name");
    $delete->bindParam(":image_name", $_GET['delete_id']);
    if($delete->execute())
    {
        ?>
        <script>alert("You have delete on image");
        windo.location.href=('mygallary.php');</script>

        <?php
    }else

    ?>
     <script>alert("image was not deleted");
        windo.location.href=('mygallary.php');</script>

    <?php
}

?>
