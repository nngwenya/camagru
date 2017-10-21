<!DOCTYPE html>

<HTML>
    <HEAD>
    <TITLE>camagru.com</TITLE>
    <link rel="stylesheet" type="text/css" href="camagru.css"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
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
            <li><a class="footer1" href="gallary">MY GALLARY</a></li>
            <li><a class="footer1" href="signup.php">FRAMES</a></li>
              
        </ul>
    </div>

        <br>
    <div class="booth">
        <video id="video" width="600" height="450"></video><br/>
        <center><div class="material-icons capturebutton" style="font-size:40px" href="#" id="capture">camera_alt</button></center>
    </div><br>

            <center><canvas id="canvas" width="400" height="300"></canvas><button type="button" onclick="print()">Snapchat</button></center>
            
        
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
ctx.fillStyle = "red";
ctx.fillRect(10, 10, 50, 50);

function print() {
    window.alert("here");
    var imgData = ctx.getImageData(10, 10, 50, 50);
    ctx.putImageData(imgData, 10, 70);
     ctx.putImageData(imgData, 10, 70);
     window.alert("here");
     
}

</script>
 
</BODY>
</HTML>