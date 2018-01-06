<?php
include_once 'config/database.php';
include_once 'config/session.php';
include_once 'config/utilities.php';



if (isset($_POST['save']) && isset($_SESSION['username'])){
        
    $form_errors = array();
    $required_fields = array('firstname', 'lastname', 'email', 'username', 'password', 'country');
    $form_errors = array_merge($form_errors, check_empty_fields($required_fields));
    $fields_to_check_length = array('username' => 4, 'password' => 6);
    $form_errors = array_merge($form_errors, check_min_length($fields_to_check_length));
    $form_errors = array_merge($form_errors, check_email($_POST));

    if (empty($form_errors)){
        
        $id = $_SESSION['id'];
        $firstname = htmlEntities($_POST['fisrtname']);
        $lastname = htmlEntities($_POST['lastname']);
        $username = htmlEntities($_POST['username']);
        $email = htmlEntities($_POST['email']);
        $password = htmlEntities($_POST['password']);
        $country = htmlEntities($_POST['country']);
        $email_pref = "true";
        if (isset($_POST['email_pref'])){
            $email_pref = "false";
        }
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        try{
    
            $stmt = $conn->prepare('UPDATE users SET firstname = :firstname, lastname = :lastname, username = :username, email = :email, email_pref = :email_pref,  password = :hashed_password ,country = :country WHERE id = :id');
            $stmt->bindParam(':firstname',$firstname);
            $stmt->bindParam(':lastname',$lastname);
            $stmt->bindParam(':username',$username);
            $stmt->bindParam(':email',$email);
            $stmt->bindParam(':email_pref', $email_pref);
            $stmt->bindParam(':hashed_password',$hashed_password);
            $stmt->bindParam(':country',$country);
            $stmt->bindParam(':id',$id);
            $stmt->execute();
            
            $mailbody = '
            Changes were Made to your account!
            
            Your account has been updated, you can login with the following new credentials.
            ------------------------
            Username: '.$username.'
            Password: '.$password.'   
            ------------------------

            Thank you!';

            mail("$email", "www.noreply@camagru.com - Account updated", $mailbody);

            $result = "<p style='padding: 20px; color: green;'>Account was successfully updated!</p>";
        
        }catch (PDOException $ex){
            $result = "<p style='padding: 20px; color: red'>An error occurred: ".$ex->getMessage()." </p>";
        }
    }
    else{
        if(count($form_errors) == 1){
            $result = "<p style='color: red;'> There was 1 error in the form<br>";
        }else{
            $result = "<p style='color: red;'> There were " .count($form_errors). " error in the form <br>";
        }
    }
}
?>
<!DOCTYPE html>

<HTML>
    <HEAD>
        <TITLE>my account</TITLE>
        <link rel="stylesheet" type="text/css" href="myaccount.css"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
  <!-- <div class="phoneimg">
    <img src="https://ting.com/wp-content/uploads/Android-Guest-Mode-GIF04.gif"></div>
  -->

<div class="container1">
<div class="head1"><h1>EDIT ACCOUNT</h1></div>

<center><form method="POST" enctype="multipart/form-data" class="form-horizontal" action"">

     
 <table class="table table-bordered table-responsive">
 
    <tr>
    <P>If you wish to make any changes on your account,<br>please fill in the necessary information below</p>
     <td><label class="control-label">firstname:</label></td>
        <td><input class="form-control" type="text" name="firstname" placeholder="firstname" value="" /></td>
    </tr>

    <tr>
     <td><label class="control-label">lastname:</label></td>
        <td><input class="form-control" type="text" name="lastname" placeholder="lastname" value="" /></td>
    </tr>
    
    <tr>
     <td><label class="control-label">username:</label></td>
        <td><input class="form-control" type="text" name="username" placeholder="username" value="" /></td>
    </tr>

    <tr>
     <td><label class="control-label">email:</label></td>
        <td><input class="form-control" type="text" name="email" placeholder="email" value="" /></td>
    </tr>

    <tr>
     <td><label class="control-label">password:</label></td>
        <td><input class="form-control" type="Password" name="password" placeholder="password" value="" /></td>
    </tr>
    
    <tr>
     <td><label class="control-label">country:</label></td>
        <td><input class="form-control" type="text" name="country" placeholder="country" value="" /></td>
</tr><br></br>
   <tr>
    <td><input type="checkbox" name="email_pref" value="Notify" style="height: 1.5vh; width: 1.5vw;">Do not send me emails</br></br></td>
    </tr>
    <tr>
            

</tr>
    </table>
    
    <button type="submit" name="save" value="save">Save</button>
</form></center>
<center><p>deactivate my account <a style='color: pink; font-size:30px;'  value="deactivate" name="deactivate" onclick="window.location.href='index.php'" class="  fa fa-close" href='#'></i></a></center>
</div>  


<div class="profile">
<div class="head1"><h1>PERSONAL DETAILS</h1></div>
<?php if(isset($result)) echo "<b>$result <b>" ?>
<?php if(!empty($form_errors)) echo show_errors($form_errors); ?>
<?php
    $query = "SELECT firstname, lastname, username, email, country FROM users WHERE username = '".$_SESSION['username']."' ";

    try
    {
        $stmt = $conn->prepare($query);
        $stmt->execute();
    }
    catch(PDOException $ex)
    {
        die("Failed to run query: " . $ex->getMessage());
    }
    $rows = $stmt->fetchAll();
?>
</tr>
<?php foreach($rows as $row): ?>
<tr>
    <td><?php echo "First Name:" ?></td></br>
    <td><?php echo htmlentities($row['firstname'], ENT_QUOTES, 'UTF-8'); ?></td></br></br>
    <td><?php echo "Last Name:" ?></td></br>
    <td><?php echo htmlentities($row['lastname'], ENT_QUOTES, 'UTF-8'); ?></td></br></br>
    <td><?php echo "Username:" ?></td></br>
    <td><?php echo htmlentities($row['username'], ENT_QUOTES, 'UTF-8'); ?></td></br></br>
    <td><?php echo "Email:" ?></td></br>
    <td><?php echo htmlentities($row['email'], ENT_QUOTES, 'UTF-8'); ?></td></br></br>
    <td><?php echo "Country:" ?></td></br>
    <td><?php echo htmlentities($row['country'], ENT_QUOTES, 'UTF-8'); ?></td></br></br>
</tr></br>
<?php endforeach; ?>
</div></br>



</div>

</BODY>
</HTML>

