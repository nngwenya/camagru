<?php 
session_start();
include_once 'config/database.php';
if (isset($_SESSION['username']))
header('location : home.php');

$overlay = isset($_POST['watermark']) ? $_POST['watermark'] : '';
$decoded = isset($img[1]) ? $img[1] : null;
$img_file = isset($_FILES['user_image']["name"]) ? $_FILES['user_image']["name"] : null;
try{
if (isset($_POST['image-url']))
{
 
    $img = $_POST['image-url'];
    $rand = rand(0, 9999);
    $file_dir = "images/";
    $file_name = $_SESSION['username'].$rand.".jpg";
    $img = explode(',', $img);
    $decoded = base64_decode($img[1]);
    file_put_contents($file_dir.$file_name, $decoded);
    $filepath = $file_dir.$file_name;
    $username = $_SESSION['username'];

   // $overlay = isset($_POST['watermark']) ? $_POST['watermark'] : '';
    $overlay = $_POST['watermark'];
    $watermark = imagecreatefrompng($overlay);
    $watermark_width = imagesx($watermark);
    $watermark_height = imagesy($watermark);
    $image = imagecreatefromjpeg($file_dir.$file_name);
    $size = getimagesize($file_dir.$file_name );
    imagecopy($image, $watermark, -5, 0, 40, 40, $watermark_width, $watermark_height);
    imagejpeg($image, $file_dir.$file_name);
    imagedestroy($image);
    imagedestroy($watermark);

    $sqlInsert = "INSERT INTO usersimage (id, image_name, username, edit_time)
    VALUES ( null, '$filepath', '$username', now())";
    
     $stmt = $conn->prepare($sqlInsert);
     //$stmt->bindParam(':username', $username);
     $stmt->execute();
  
   echo "image saved succssfully";
    }
    else
    {
    echo "the image is not saved";
    }
}

catch(PDOException $ex)
{
    echo $sqlInsert . "<br>" . $ex->getMessage();
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
            
             <form method="post" id="image-form">
                <input type="hidden"  id="image-url" name="image-url" value="" />
                <input type="hidden" name="watermark" id="watermark" value="" />
                <button class="btn btn-default" id="save_image">Save to Gallery</button>
            </form>
                    
                <label class="control-label">Profile Img.</label></td>
                <input class="input-group" type="file" name="user_image" accept="image/*" />
            
               
                <button type="submit" name="btnsave" value="" class="btn btn-default">
                <span class="glyphicon glyphicon-save"></span> &nbsp; save
                   </button>
            
           
           <div class="dropdown">
                        <button class="dropbtn">frames</button>
                        <div class="dropdown-content">
                        <a href="#" id="hearts">hearts</a>
                        <a href="#" id="blue">blue</a>
                        <a href="#" id="goofy">goofy</a>
                        <a href="#" id="painter">painter</a>
                        <a href="#" id="no_women">no_women</a>
                    </div>
</form>


<div class="profile">
<img src='<?php echo $filepath;?>' class="img-rounded" width="250px" height="300px"/></div>


</div>
            
        
		<script src="photo.js"></script>
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

 document.getElementById('goofy').addEventListener("click", function(){
    alert('Goofy Selected');
    curr_object[0] = "goofy.png";
});

document.getElementById('painter').addEventListener("click", function(){
    alert('painter Selected');
    curr_object[0] = "painter.png";
});

document.getElementById('blue').addEventListener("click", function(){
    alert('blue Selected');
    curr_object[0] = "blue.png";
});

document.getElementById('no_women').addEventListener("click", function(){
    alert('no_women Selected');
    curr_object[0] = "no_women.png";
});

window.onload = function() {
var c = document.getElementById('canvas');
var ctx = c.getContext("2d");
}

</script>

</BODY>
</HTML>



