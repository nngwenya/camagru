<?php 

include_once 'config/database.php';
include_once 'config/session.php';
if (isset($_SESSION['username']))
header('location : home.php');

try {
    if (isset($_POST['image-url']))
    {
        $overlay = $_POST['watermark'];
        $img = $_POST['image-url'];
        $rand = rand(0, 9999);
        $file_dir = "images/";
        $file_name = $_SESSION['username'].$rand.".jpg";
        $img = explode(',', $img);
        $decoded = base64_decode($img[1]);
        file_put_contents($file_dir.$file_name, $decoded);      

        $watermark = imagecreatefrompng($overlay);
        $watermark_width = imagesx($watermark);
        $watermark_height = imagesy($watermark);
        $image = imagecreatefromjpeg($file_dir.$file_name);
        imagecopy($image, $watermark, -5, 0, 40, 40, $watermark_width, $watermark_height); 
        imagejpeg($image, $file_dir.$file_name);
        imagedestroy($image);
        imagedestroy($watermark);

        $filepath = $file_dir.$file_name;
        $username = $_SESSION['username'];

        $insert = "INSERT usersimage (id, image_name, username, edit_time)
            VALUE (null, '$filepath', '$username', now())";
    
        $stmt = $conn->prepare($insert);
        $stmt->execute();
        $result = "<p style='padding: 20px; color: green;'>Image is saved!</p>";
    }
}
catch(PDOException $ex){
    echo $insert ."<br>". $ex->getMessage();
}

if(isset($_POST['submit'])) {
    $username = $_SESSION['username'];
    $file = $_FILES['file'];
      
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];
    
    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));
    
    $allowed = array('jpg', 'jpeg', 'png');
    
    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            if($fileSize < 1000000) {
                $fileNameNew = uniqid('', true).".".$fileActualExt; 
                $fileDestination = 'images/'.$fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);
                var_dump($fileDestination);
                $insert_query="INSERT INTO usersimage (image_name, username) VALUES('$fileDestination', '$username')";
                $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
                $stmt = $conn->prepare($insert_query);
                $stmt->execute();
                $result = "<p style='padding: 20px; color: green;'>Upload was successful!</p>";
            }else {
                $result = "<p style='padding: 20px; color: red;'>You have chosen a file of large size!</p>";
            }  
        }else {
          $result =  "<p style='padding: 20px; color: red;'>There was an error while uploading your file!</p>"; 
        }
    }else {
        $result =  "<p style='padding: 20px; color: red;'>You have choosen an invaild file type!</p>";
    }
    
} 

?>

<!DOCTYPE html>

<HTML>
    <HEAD>
    <TITLE>camagru.com</TITLE>
    <link rel="stylesheet" type="text/css" href="camagru.css"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

     
    </HEAD>
    <BODY  class="bgi">

    <header>
            <i class="material-icons" style="font-size:50px">camera</i>
            <div class="material-icons header"><h1>CAMAGRU</h1></div>   
            <button class="logout" onclick="window.location.href='index.php'" >LogOut</button>   
          
    </header>
 
    <div class="content">
        <ul>
            <li><a class="footer1" href="home.php">HOME</a></li>
            <li><a class="footer1" href="mygallary.php">MY GALLARY</a></li>
            <div class="icons"> 
            <li><a class="material-icons icons"  href='myaccount.php' style="font-size:30px">person</a></div>
        </ul>
    </div>
    
        <br>
    <div class="booth">
    
        <video id="video" width="800" height="600"></video><br/>
        <center><div class="material-icons capturebutton" style="font-size:40px" href="#" name="btnsave" id="capture">camera_alt</button></center>
    </div><br>
  
        <div class="myimage">
            <center><canvas id="canvas" width="400" height="300"></canvas>
        </div>
    <div class="myimage">
    <img src='<?php echo $filepath;?>' class="pictures" width="250px" height="300px"/></div>
            
             <form method="post" action="" id="image-form">
                <input type="hidden"  id="image-url" name="image-url" value="" />
                <input type="hidden" name="watermark" id="watermark" value="" />
                <button class="btn btn-default" id="save_image">Save to Gallery</button><br> 
            </form>
              
            <form action="" method="POST" enctype="multipart/form-data">
                    <input type="file" name="file" style = "display: inline-block;" accept="images/*" >
                    <input type='hidden' name='username' value="$username">
                    <button type="submit" name="submit" id="save-image" class = "dropbtn" style = "display: inline-block;">Upload</button>
            </form>
            <form method="post" id="image-form">
                <input type="hidden" name="image-url" id="image-url" value="" />
                <input type="hidden" name="watermark" id="watermark" value="" />
            </form>

              

                <div class="dropdown">
                        <button class="dropbtn">frames</button>
                        <div class="dropdown-content">
                        <a href="#" id="hearts">hearts</a>
                        <a href="#" id="bird">bird</a>
                        <a href="#" id="kitty">kitty</a>
                        <a href="#" id="umbrella">umbrella</a>
                        <a href="#" id="flower">flower</a>
                        </div>

            </form>
            
        
<script>
var curr_object = [];
    (function(){
	var video = document.getElementById('video'),
		canvas = document.getElementById('canvas'), q
		context = canvas.getContext('2d'),
		vendorUrl = window.URL || window.webkitURL;
	
	navigator.getMedia = 	navigator.getUserMedia ||
							navigator.webkitGetUserMedia ||
							navigator.mozGetUserMedia ||
							navigator.msGetUserMedia;
	navigator.getMedia({
		video: true,
		audio: false
	}, function(stream) {
		video.src = vendorUrl.createObjectURL(stream);
		video.play();
	}, function(error) {
		//error code
	});
	document.getElementById('capture').addEventListener('click', function(){
	context.drawImage(video, 0, 0, 400, 300);
    
	});
})();
document.getElementById('save_image').addEventListener('click', function(){
var img = canvas.toDataURL('image/jpeg');
var field = document.getElementById('image-url');
var overlay = document.getElementById('watermark');
field.value = img;
overlay.value = curr_object[0];
document.getElementById('image-form').submit();
});
document.getElementById('hearts').addEventListener("click", function(){
    alert('Hearts Selected');
    curr_object[0] = "hearts.png";
});
 document.getElementById('kitty').addEventListener("click", function(){
    alert('kitty Selected');
    curr_object[0] = "kitty.png";
});
document.getElementById('umbrella').addEventListener("click", function(){
    alert('umbrella Selected');
    curr_object[0] = "umbrella.png";
});
document.getElementById('bird').addEventListener("click", function(){
    alert('bird Selected');
    curr_object[0] = "bird.png";
});
document.getElementById('flower').addEventListener("click", function(){
    alert('flower Selected');
    curr_object[0] = "flower.png";
});
window.onload = function() {
var c = document.getElementById('canvas');
var ctx = c.getContext("2d");
}
</script>


</BODY>
</HTML>