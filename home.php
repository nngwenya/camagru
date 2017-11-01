<?php include_once 'config/session.php';?>
<!DOCTYPE html>

<HTML>
    <HEAD>
    <TITLE>camagru.com</TITLE>
    <link rel="stylesheet" type="text/css" href="camagru.css"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
       <!--`<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
 
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
            <li><a class="footer1" href="gallary">MY GALLARY</a></li>
            <li><a class="footer1" href="signup.php">FRAMES</a></li>
            <div class="icons"> 
            <li><a class="material-icons icons"  onclick="window.location.href='myaccount.php'" style="font-size:30px">person</a></div>
        </ul>
    </div>
    
        <br>
    <div class="booth">
        <video id="video" width="800" height="600"></video><br/>
        <center><div class="material-icons capturebutton" style="font-size:40px" href="#" id="capture">camera_alt</button></center>
    </div><br>

        <div class="myimage">
            <center><canvas id="canvas" width="400" height="300"></canvas></div>

        <div class="myimage">
            <canvas id="myCanvas2" width="400" height="300">
            </canvas></center>
        
           
            <button type="submit" name="save"  onclick="window.location.href='mygallary.php'" class="btn btn-default">
         <span class="glyphicon glyphicon-save"></span> &nbsp; save 
        </button></center>
</div>
            
        
		<script src="photo.js"></script>
    <script>

    (function(){
	var video = document.getElementById('video'),
		canvas = document.getElementById('canvas'),
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

var c = document.getElementById('canvas');
var ctx = c.getContext("2d");
/*var source = {
    ember : "981122-1509019360.jpg",
    tux : "https://cdn.shopify.com/s/files/1/1061/1924/files/Hugging_Emoji_Icon.png?11214052019865124406";
}
*/
function print() {
    window.alert("here");
    var imgData = ctx.getImageData(10, 10, 50, 50);
     window.alert("here");
     
}

</script>
 
</BODY>
</HTML>