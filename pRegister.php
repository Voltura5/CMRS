<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

session_start();

$error=0;
$name=$_POST['userName'];
$pass1=$_POST["password"];
$pass=password_hash($pass1,PASSWORD_BCRYPT);
$email=$_POST['email'];
$dob=$_POST['dob'];
$servername = "localhost";
$username = "root";// Enter mysql username
$password = "AthlonY2";// Enter mysql password
$dbname = "hospital";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT name,mail FROM USERS";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $exist_name=$row["name"];
      $exist_email=$row["mail"];
    if($name==$exist_name)
    {
      $error=1;
      echo "This name is already taken";
    }
  else if($email==$exist_email)
    {
      $error=1;
      echo "This email is already taken";
    }
}
}
// prepare and bind
if($error==0)
{
  echo "Success";
  $_SESSION['patient'] = $name;
$stmt = $conn->prepare("INSERT INTO USERS (name, pass, mail, dob ,type) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $new_name, $new_pass, $new_email, $new_dob, $new_type);
// set parameters and execute
$new_name = $name;
$new_pass = $pass;
$new_email = $email;
$new_dob = $dob;
$new_type="patient";
$stmt->execute();
//$_SESSION['username']=$name;
$stmt->close();
$conn->close();
}
}
?>
