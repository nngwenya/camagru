
<?php 

require_once ('comments.php');
require_once ('config/database.php');


?>
<!DOCTYPE html>

<HTML>
    <HEAD>
    <TITLE>camagru.com</TITLE>
    <link rel="stylesheet" type="text/css" href="camagru.css"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
       <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gallery</title>
 
    </HEAD>
    <BODY  class="bgi">

    <header>
            <i class="material-icons" style="font-size:50px">camera</i>
            <div class="material-icons header"><h1>CAMAGRU</h1></div>   
            <button class="logout" onclick="window.location.href='mygallary.php'" >LogOut</button>  
<div class="content" style="font-size:30px">
            <center><HEADER>WELCOME TO MY GALLARY</HEADER></center> </div>
          
    </header>
   
      
<?php 

$stmt = ('SELECT * FROM usersimage;');
$stmt = $conn->prepare($stmt);
$stmt->execute();


$images = $stmt->fetchAll(PDO::FETCH_ASSOC);


foreach($images as $image)
{

  
  ?>
  <?php
      $stmt = ('SELECT * FROM like_pictures WHERE post_id = '.$image['id'].';');
      $stmt = $conn->prepare($stmt);
      $stmt->execute();
      $likes = $stmt->rowCount();
      ?>
  <?php
      $sqlInsert = 'SELECT username FROM like_pictures WHERE post_id = :usersimage';
      $stmt = $conn->prepare($sqlInsert);
      $stmt->execute(array("usersimage" => $image['id']));
      $row = $stmt->fetchAll();
      $run_bool = 0;
      foreach ($row as $users){
          if (in_array($_SESSION['username'], $users))
              $run_bool = 1;
      }
    ?>
    
           <div class=image_border>
                    <?php echo "Post by-".$image['username']?>
                    <?php if ($_SESSION['username'] == $image['username']) {?>
                    <a class=del href="?delete_id=<?php echo $image['image_name']?>" action="delete.php" type='submit' name='delimg' style="float: right" onclick="return confirm('Are you sure you want to delete this image?')">Delect image</a>
                    <?php } ?>
                    <a   href="<?php echo  $image['image_name']; ?>"><img class = "pictures" src="<?php echo $image['image_name']; ?>"/>
                    </a>
                    <?php
                        if ($run_bool == 0){
                    ?>
                      <a href="likes.php?usersimage=<?php echo $image['id']?>"><img src="likes.png"  height="40vh" width="50vw"/></a>
                    <?php }else{ ?>
                    <a href="likes.php?usersimage=<?php echo $image['id']?>"><img src="likes.png" height="40vh" width="50vw" class="black"/></a>
                    <?php }?>
                    
                    <p class="lik" value='image' name='image'><?php echo $likes;?></p>
                    <?php if(isset($result)) echo $result; ?>
                    <?php
                    $sqlInsert = 'SELECT email FROM users WHERE username = :username';
                    $stmt = $conn->prepare($sqlInsert);
                    $stmt->execute(array(
                        "username" => $image['username']));
                    $row = $stmt->fetchAll();
                    $email = isset($row[0]) ? $row[0]['email'] : '[deleted]';
                    ?>

                    <?php 
                          echo "<form method='POST' action='comments.php'>
                          <textarea name='comment'></textarea>
                          <input type='hidden' name='image_id' value='{$image["id"]}'>
                          <input type='hidden' name='image_name' value='{$image["username"]}'>
                          <input type='hidden' name='username' value='$username'>
                          <input type='hidden' name='email' value='$email'>
                          <input type='hidden' name='date' value='".date('Y-m-d H:i:s')."'><br>
                          <button type='submit' name='commentsave' >Comment</button>
                        </form>"."<br>";


                            echo  "<div class='sepComments'>";  
                                $stmt = ("SELECT * FROM comments WHERE post_id = {$image['id']};");
                                $stmt = $conn->prepare($stmt);
                                $stmt->execute();
                                $com = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                foreach($com as $comment)
                                {
                                    echo "<div class='commentbox'>";
                                    echo $comment['username']." ";
                                    echo $image['id']." ";
                                    echo $comment['date']."<br>";
                                    echo htmlspecialchars($comment['commentimg']);
                                echo "</div>"."<br>";
                                }
                            echo "</div>";
                    ?>
            </div>

<?php
}
?>

            <script>
            function add1(element) {
                var xhtpp;
                var imgDiv = element.parentElement.parentElement;
                var output = imgDiv.querySelector("#output");
    
                output.value = parseInt(output.value,10) + 1;
                xhttp = new XMLHttpRequest();
                xhttp.open("POST", '/Camagru/like.php');
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                
                xhttp.onreadystatechange = function() {//Call a function when the state changes.
                    if(xhttp.readyState == XMLHttpRequest.DONE && xhttp.status == 200) {
                    // Request finished. Do processing here.
                    }
                }
                xhttp.send("POST=0&likes=2");
            }
            
            function myFunction(x) {
                x.classList.toggle("like.png");
            }
        </script>
     
</div>
</BODY>

</HTML>
<?php
echo "<a href=\"home.php\">Back to the homepage</a>"; 
?>