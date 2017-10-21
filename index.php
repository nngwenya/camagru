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

    <p>You are currently not registered <a href="login.php">login</a> Not yet a member? <a href="signup.php">Signup</a> </p>
    

    <p You are logged in as  <?php if(!isset($_SESSION['email'])) echo $_SESSION['email']; ?> <a href="logout"</a></p>

        <br>
    <div class="booth">
        <video id="video" width="600" height="450"></video><br/>
        <center><div class="material-icons capturebutton" style="font-size:40px" href="#" id="capture">camera_alt</button></center>
    </div><br>
                
</BODY>
</HTML>