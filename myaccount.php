<?php
include_once 'config/database.php';
session_start();
$password = '';
$firstname = '';
$lasttname = '';
$username = '';
$email = '';
if (isset($_POST["btnsave"]))
{
    $img_file = $_FILES['user_image']["name"];
    $validext = array("jpg", "png", "bmp", "gif");

    if($img_file == " ")
        echo "please attach an image";
    else if ($_FILES["user_image"]["size"] <= 0)
        echo "no image found";

    else if (!in_array("jpg", $validext))
        echo "invalid type";
    else
    { 
    
        $img_file = $_FILES["user_image"]["name"];
        $foldername = 'pictures/';
        $ext = pathinfo($img_file, PATHINFO_EXTENSION);
        $file_name = rand(10000, 990000). '-'. time() .'.'.$ext;
        $filepath = $foldername.$file_name;
        if (move_uploaded_file($_FILES["user_image"]["tmp_name"], $filepath))
       

        {
           // $conn->query( "INSERT INTO usersimage (ID, image_name, edit_time, image, username)
         //   VALUES (null, $file_name, 'CURRENT_DATE', ".($filepath).", 'username'");
         $sqlInsert = ("UPDATE users SET profile_image='$filepath' WHERE username=':username'");
         
         $stmt = $conn->prepare($sqlInsert);
         $stmt->bindParam(':username', $username);
         $stmt->execute();
      
        echo "image uploaded succssfully";
        }
else
        echo "could not upload the image";
}
}
?>
<!DOCTYPE html>

<HTML>
    <HEAD>
        <TITLE>my account</TITLE>
        <link rel="stylesheet" type="text/css" href="myaccount.css"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    </HEAD>
    <BODY>
<header>
    <i class="material-icons" style="font-size:50px">camera</i>
            <div class="material-icons header"><h1>CAMAGRU</h1></div>
            <button class="logout" onclick="window.location.href='index.php'" >LogOut</button>   
</header>

    <div class="content">
        <ul>
            <li><a class="footer1" href="home.php">HOME</a></li>
              
        </ul>
    </div>

</br>
<div class="phoneimg">
    <img src="https://ting.com/wp-content/uploads/Android-Guest-Mode-GIF04.gif"></div>


<div class="container1">
<div class="head1"><h1>MY ACCOUNT</h1></div>
<center><form method="post" enctype="multipart/form-data" class="form-horizontal">
     
 <table class="table table-bordered table-responsive">
 
    <tr>
     <td><label class="control-label">firstname:</label></td>
        <td><input class="form-control" type="text" name="firstname" placeholder="firstname" value="<?php echo $firstname; ?>" /></td>
    </tr>

    <tr>
     <td><label class="control-label">lastname:</label></td>
        <td><input class="form-control" type="text" name="lastname" placeholder="lastname" value="<?php echo $lasttname; ?>" /></td>
    </tr>
    
    <tr>
     <td><label class="control-label">username:</label></td>
        <td><input class="form-control" type="text" name="username" placeholder="username" value="<?php echo $username; ?>" /></td>
    </tr>

    <tr>
     <td><label class="control-label">email:</label></td>
        <td><input class="form-control" type="text" name="email" placeholder="email" value="<?php echo $email; ?>" /></td>
    </tr>

    <tr>
     <td><label class="control-label">password:</label></td>
        <td><input class="form-control" type="Password" name="password" placeholder="password" value="<?php echo $password; ?>" /></td>
    </tr>
    
    <tr>
     <td><label class="control-label">confirm_password:</label></td>
        <td><input class="form-control" type="password" name="password" placeholder="confirm_password" value="<?php echo $password; ?>" /></td>
    </tr>

    <tr>
     <td><label class="control-label">Profile Img.</label></td>
        <td><input class="input-group" type="file" name="user_image" accept="image/*" /></td>
    </tr> 
    
    <tr>
    <td colspan="2"><button type="submit" name="btnsave" value="btnsave" class="btn btn-default">
    <span class="glyphicon glyphicon-save"></span> &nbsp; save
        </button>
        </td>
    </tr>
    
    </table>
    
</form></center>
<center><p>deactivate my account <a style='color: pink; font-size:30px;'  value="deactivate" name="deactivate" onclick="window.location.href='index.php'" class="  fa fa-close" href='#'></i></a></center>
</div>

<?php
 

 $stmt = $conn->prepare("SELECT profile_image, username FROM users ");
 $stmt->execute();
 if($stmt->rowCount() > 0)
 {
  while($row=$stmt->fetch(PDO::FETCH_ASSOC))
  {
    
    extract($row);
   ?>
<div class="col-xs-3">
        <p class="page-header"><?php echo $username."&nbsp;/&nbsp;".$email; ?></p>
       
        <img src='<?php echo $filepath;?>' class="img-rounded" width="250px" height="250px"/>
        <p class="page-header">
        <span>
    <a class="btn btn-info" href="editform.php?edit_id=<?php echo $row['username']; ?>" title="click for edit" onclick="return confirm('sure to edit ?')"><span class="glyphicon glyphicon-edit"></span> Edit</a> 
    <a class="btn btn-danger" href="?delete_id=<?php echo $row['username']; ?>" title="click for delete" onclick="return confirm('sure to delete ?')"><span class="glyphicon glyphicon-remove-circle"></span> Delete</a>
    </span>
    </p>
    </div>
    <?php
  }
 }
 else
 {
  ?>
        <div class="col-xs-1">
         <div class="alert alert-warning">
             <span class="glyphicon glyphicon-info-sign"></span> &nbsp; No Data Found ...
            </div>
        </div>
        <?php
 }
 ?>
</div>
</BODY>
</HTML>
