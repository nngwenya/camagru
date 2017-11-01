
<?php

include_once 'config/database.php';
include_once 'config/utilities.php';
//include_once 'config/session.php';
    
   
    //Proccess the form

    if (isset($_POST['submit'])){

        //initialise an array to store any error message from the form
        $form_errors = array();
        
        //form validation
        $required_fields = array('email', 'newpassword', 'confirm_password');

       
        //using our function to check for empty fileds

        $form_errors = array_merge($form_errors, check_empty_fields($required_fields));
       
        //fields that requires for minimun length
        $fields_to_check_length = array('newpassword' => 10, 'confirm_password' => 10);

        //call the function to check mininum required length and merge the return data into the error array
        $form_errors = array_merge($form_errors, check_min_length($fields_to_check_length));

        //email validation
        $form_errors = array_merge($form_errors, check_email($_POST));

        //check if no error was generated, then proceed to process the form

        if (empty($form_errors)){
            //Collect form data and store in variables
            $email = $_POST['email'];
            $npassword = $_POST['newpassword'];
            $cpassword = $_POST['confirm_password'];
            //echo $npassword . "npassword     " .  $cpassword . " cpassword     ";
            //hashing password
            if ($npassword != $cpassword)
            {
                /*$result =*/ echo "<p style='padding:20px color: red;'> new password and confirm password does not match</p>";
                
            }
            else
            {
                
                try {
                   
                $sqlQuery = "SELECT email FROM users WHERE email =:email";

                //Use PDO prepare to sanitize data
                 $stmt = $conn->prepare($sqlQuery);

                //Add the data into the database
                 $stmt->execute(array(':email' => $email));
                 
               // echo $stmt->rowCount() . "row count";
               
                 if ($stmt->rowCount() == 1)
                 {
                    $hashedPassword = password_hash($npassword, PASSWORD_DEFAULT);
                
                     $sqlUpdate = "UPDATE users SET password =:password WHERE email=:email";

                     $stmt = $conn->preprare($sqlUpdate);
                     echo "did it work?";

                     $stmt->execute(array(':password' => $hashed_password, ':email' => $email));

                     $result = "<p style='padding:20px; color:green;'> Password Reset Succes</p>";
                 }
                 else
                 {
                    $result = "<p style='padding:20px; color:red;'> The email address you have provided does not exist</p>";
                 }
                }catch (PDOExeption $ex)
                {
                    $result = "<p style='padding:20px; color:red;'> An error occurred: ".$ex->getmessage()."</p>";
                }
            }
        }else
    {
        if (Count($form_errors) == 1)
        {
            $result = "<p style='padding:20px; color:red;'> There was one error in the form</p>";
        }else{
            $result = "<p style='padding:20px; color:red;'> There where ".Count($form_errors). " errors in the form<br>";
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

            <center><div class="forgot">
            <div class="head1"><h1>Oops !!</h1></div>
            <img src="https://i.pinimg.com/originals/ca/54/e0/ca54e0a12f6bd7dfd467ce59648c17eb.gif"/>
           
               <form method="post" action="">
                <input type="text" name="Email*" placeholder="Email Address" required><br>
                <input type="password" name="newpassword" value="newpassword" placeholder="new password" required><br>
                <input type="password" name="confirm_password"  value="confirm_password"placeholder="confirm password" required><br><br>
                <button type="submit" value="Submit" name="submit" >Submit</button><br>
                <p>RESET PASSWORD</p>
               
            </BODY>

</HTML>