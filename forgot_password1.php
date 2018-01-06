<?php
include_once 'config/database.php';


$hash = isset($_GET['q']) ? $_GET['q'] : '';
$confirmpassword= isset($_POST['confirmpassword']) ? $_POST['confirmpassword'] : '';

try {
// Was the form submitted?
if (isset($_POST["q"]))
{
  
    // Gather the post data
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmpassword = $_POST["confirmpassword"];
    $hash = $_POST["q"];


    // Does the new reset key match the old one?

        if ($password == $confirmpassword)
        {
            //has and secure the password
            $password = password_hash($password, PASSWORD_BCRYPT);

            // Update the user's password
                $query = $conn->prepare('UPDATE users SET password = :password WHERE email = :email');
                $query->bindParam(':password', $password);
                $query->bindParam(':email', $email);
                $query->execute();
                $conn = null;
            echo "Your password has been successfully reset.";
        }
        else
            echo "Your password's do not match.";
    }
}
catch(PDOException $ex)
{
    $msg = "Failed to connect to the database";
}

?>

<!DOCTYPE html>

<HTML>
    <HEAD>
        <TITLE>login</TITLE>
        <link rel="stylesheet" type="text/css" href="camagru.css"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    </HEAD>
    <BODY class="bgi">

    <i class="material-icons" style="font-size:50px">camera</i>
            <div class="material-icons header"><h1>CAMAGRU</h1></div>

            <center><div class="forgot">
            <div class="head1"><h1>Oops !!</h1></div>
            <img src="https://i.pinimg.com/originals/ca/54/e0/ca54e0a12f6bd7dfd467ce59648c17eb.gif"/>
        
               <form method="POST" action="">
                <input type="text" name="email" placeholder="Email Address" required><br>
                <input type="password" name="password" value="" placeholder="new password" required><br>
                <input type="password" name="confirmpassword"  value=""placeholder="confirm password" required><br><br>
                <button type="hidden" value="" name="q" >Submit</button><br>
            
                <p>RESET PASSWORD</p>
               
            </BODY>

</HTML>