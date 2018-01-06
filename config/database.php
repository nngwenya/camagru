
<?php
//include_once 'setup.php';
//initialize variable to hold connection parameters.
$username = 'root';
$dsn = 'mysql:host=localhost;dbname=camagru;port=8080';
$password = "12345qwert";

try{
    //create an instance of the PDO class with the required parameters.
    $conn = new PDO($dsn, $username, $password);
    //set pdo error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch (PDOException $ex){
    //display success message
    echo "Connection failed".$ex->getMessage();
}
?>