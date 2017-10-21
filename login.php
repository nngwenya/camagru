<?php
include_once 'database/connection.php';
include_once 'database/utilities.php';
include_once 'database/session.php';

if(isset($_POST['login'])) {

    $form_errors = array();
    
    $required_fields = array('email', 'password');
    
    $form_errors = array_merge($form_errors, check_empty_fields($required_fields));
     
    if(empty($form_errors)){

       $email = $_POST['email'];
        $password = $_POST['password'];
        
        $sqlQuery = "SELECT * FROM users WHERE email = :email";
        $stmt = $conn->prepare($sqlQuery);
       // echo "error";
       // header("location: home.php?sig=error");
        $stmt->execute(array(':email' => $email));
        while($row = $stmt->fetch()){
            $id = $row['id'];
            $hashed_password = $row['password'];
            $email = $row['email'];

            if(password_verify($password, $hashed_password)){
                $_SESSION['id'] = $id;
                $_SESSION['email'] = $email;
                header("location: home.php");

            }else{
                $result = "<p style='padding: 20px; color: red'>Invelid email or password</p>";
            }
        }
        
    }else{
        if(count($form_errors) == 1){
            $result = "<p style='color: red;'>There was one error in the form </p>";
    
        }else{
            $result = "<p style='color: red;'>There were".count($form_errors).  "error in the form </p>";
        }
    }
}
?>
<!DOCTYPE html>

<HTML>
    <HEAD>
        <TITLE>login</TITLE>
        <link rel="stylesheet" type="text/css" href="camagru.css"/>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    </HEAD>
    <BODY class="bgi">

    <i class="material-icons" style="font-size:50px">camera</i>
            <div class="material-icons header"><h1>CAMAGRU</h1></div>
           <?php if(isset($result)) echo $results; ?>
            <?php if (!empty($form_errors)) echo show_errors($form_errors); ?>
         
            <center><div class="container">
            
                <div class="head1"><h1>LOGIN</h1></div>
                <div class="head2"><p>with Email</p></div>
            <form method="post" action="home.php">
                <input type="text" name="email" value="" placeholder="Email Address" required><br>
                <input type="password" name="password" value="" placeholder="Password" required><br><br>
                <button type="submit" name="login"  value="Submit" >Submit</button><br>
                <button type="signup" value="Submit"  onclick="window.location.href='signup.php'">SignUp</button>
                <div class="footer"><a href="http://localhost:8080/camagru/forgot_password.php">forgot my password ?</a></div>
            </form>
            </div>
                
    </BODY>

</HTML>