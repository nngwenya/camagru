<?php

    include_once 'database/connection.php';
    include_once 'database/utilities.php';
//include_once 'database/session.php';
//include_once "database/confirmemail";
    
   
    //Proccess the form

    if (isset($_POST['signup'])){

        //initialise an array to store any error message from the form
        $form_errors = array();
        
        //form validation
        $required_fields = array('firstname', 'lastname', 'username', 'email', 'password', 'country');

       
        //using our function to check for empty fileds

        $form_errors = array_merge($form_errors, check_empty_fields($required_fields));
       
        //fields that requires for minimun length
        $fields_to_check_length = array('username' => 10, 'password' => 10);

        //call the function to check mininum required length and merge the return data into the error array
        $form_errors = array_merge($form_errors, check_min_length($fields_to_check_length));

        //email validation
        $form_errors = array_merge($form_errors, check_email($_POST));

        //check if no error was generated, then proceed to process the form

        if (empty($form_errors)){
            //Collect form data and store in variables
            $firstname= $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $country = $_POST['country'];

            //hashing password

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            try{

                //Create SQL insert stament

                $sqlInsert = "INSERT INTO users (firstname, lastname, username, email, password, country, join_time)
                      VALUES (:firstname, :lastname, :username, :email, :password, :country ,now())";
                

                //Use PDO prepare to sanitize data
                 $stmt = $conn->prepare($sqlInsert);

                //Add the data into the database
                 $stmt->execute(array(
                    ':firstname' => $firstname,
                    ':lastname' => $lastname,
                    ':username' => $username,
                    ':email' => $email,
                    ':password' => $hashedPassword,
                    ':country' => $country
                 ));

                //check if one new was created
                if ($stmt->rowCount() == 1){
                    $result = "<p style='padding: 20px; color: green;'> Registration Successful </p>";
                }
                
            }catch (PDOException $ex){
                $result = "<p style='padding: 20px; color: red'>An error occurred: ".$ex->getMessage()."</p>";
            }

         }
}

?>

<!DOCTYPE html>

<HTML>
    <HEAD>
        
        <TITLE>Sign Up</TITLE>
        <link rel="stylesheet" type="text/css" href="camagru.css"/>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    </HEAD>
    <BODY class="bgi">
    
   
            <i class="material-icons" style="font-size:50px">camera</i>
            <div class="material-icons header"><h1>CAMAGRU</h1></div>

    
            <center><div class="container">
            <?php if(isset($result)) echo "$result" ?>

                <div class="head1"><h1>Sign In</h1></div>
                 <div class="head2"><p>with Email</p></div>
                 <form method="post" action="signup.php">
                  First name:<br>
                  <input type="text" name="firstname"  value="" placeholder="firstname" required><br>
                  Last name:<br>
                  <input type="text" name="lastname"  value="" placeholder="lastname" required><br>
                  Username<br>
                  <input type="text" name="username" value="" placeholder="username" required><br>
                  Email:<br>
                  <input type="text" name="email"  placeholder="Email" required><br>
                  Password:<br>
                  <input type="password" name="password"  placeholder="*********" required><br>
                  <!--<div class="head"><p>Gender:</p></div>
                  <div class="head"><input style="width: 25px" type="radio" name="gender" value="male"  checked required>Female<br>
                  <div class="head"><input style="width: 25px"  type="radio" name="gender" value="female"required>Male<br> -->
                    Your Country:<br> 
                    <input type="text" name="country"  placeholder="country" required><br><br>
                  <button type="submit" name="signup" value="signup">Register</button>
                  <div class="footer"><a href="http://localhost:8080/camagru/forgot_password.php">forgot my password ?</a></div></center>
              </form>
       
              </div>
</BODY>
</HTML>