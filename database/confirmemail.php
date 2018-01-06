<?php
include_once "database/connection.php";
include_once "database/session.php";
include_once "database/utilities.php";
include_once "database/signup.php";


if(connect())
{
    function insert()
    {
        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
          }

        $firstname = test_input($_POST["firstname"]);
        $lastname = test_input($_POST["lastname"]);
        $username = test_input($_POST["username"]);
        $email = test_input($_POST["email"]);
        $password = test_input($_POST["password"]);
        $country = test_input($_POST["country"]);

        $encry = md5('camagru');
        $phash = crypt($password,$encry);

        $activationcode = hash('whirlpool', rand(0, 10000));

        $checkreg = "SELECT email, password FROM register WHERE email LIKE('%$email%')";
        $see = mysqli_query(connect(), $checkreg);
        if(mysqli_num_rows($see) > 0)
        {
            while($row = mysqli_fetch_assoc($see))
            {
                $nemail = $row['email'];
            }
        }
        if($email == $nemail)
        {
            echo "User with same user details already registered<br>";   
        }
        else
        {
            if(!empty($nam) && !empty($surname) && !empty($email) && !empty($phash) && !empty($question) && !empty($answer))
            {
                $result = "INSERT INTO register (firstname, lastname, username, email, password, country, code) VALUES('$nam','$surname','$email','$phash','$question','$answer','$activationcode')";
                $check = mysqli_query(connect(), $result);
                
                if($check)
                {
                    //Email Part

                    $to=$email;
                    $msg= "Thanks for new Registration.";   
                    $subject="Email Verification";
                    $headers .= "MIME-Version: 1.0"."\r\n";
                    $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
                    $headers .= 'From:Camagru <mngubane26@gmail.com>'."\r\n";
                                    
                    $ms.="<html></body><div><div>Dear $nam,</div></br></br>";
                    $ms.="<div style='padding-top:8px;'>Your account information is successfully updated in our server, Please click the following link For verifying and activate your account.</div>
                        <div style='padding-top:10px;'><a href='http://localhost:8080/CamagruProject/login.php?code=$activationcode'>Click Here</a></div>
                        </div>
                        </body></html>";
                    mail($to,$subject,$ms,$headers);


                    ////end Emaill
                    
                }
                echo "Your Have Uccessfuly Registerd Check Your Email<br> For Confirmation Link";
                mysqli_close(connect());
            }
            else
                echo "Null Fields";
        }
    }
   
}

?>
