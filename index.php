<?php
//header("Access-Control-Allow-Origin:*");
//session_start(); 

$host = getenv('IP');
$username = 'roshawn';
$password = 'roshawn_123';
$dbname = 'Bugdb';
$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);




function sanitizer($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


$fname = sanitizer($_POST["firstname"]);
$lname = sanitizer($_POST["lastname"]);
$email = sanitizer($_POST["email"]);
$salt = mt_rand(1,99999);
$pass = md5($_POST['password'] . $salt);
$date = date("Y-m-d");

##############################################
$title=$_GET["title"];
$text=$_GET["text"];
$user=$_GET["user"];
$type=$_GET["type"];
$priority=$_GET["priority"];












   
if($_POST["add"] == "all")
{
   $sql = "INSERT INTO Users (firstname, lastname, hash, email, date, Salt) VALUES('$fname', '$lname', '$pass', '$email', '$date', '$salt')";    
    $conn -> query($sql);
}


if($_GET["get"]=="list")
{
    $sql = $conn ->query("SELECT * FROM Users");    
    $result = $sql->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($result as $user)
    {
        ?> <option><?php echo $user["firstname"]; ?> </option><?php
    }
}

if($_GET["hidden"]=="addissue")
{
  echo "here1";
     $conn -> query("INSERT INTO Issues (title, description, type, priority, status, assigned_to,created_by,created,updated) 
       VALUES('$title', '$text', '$type', '$priority', 'Open', '$user','Admin','$date','$date')");    
      echo "here2";
}



if($_GET["get"]=="all")
{
    $sql = $conn ->query("SELECT * FROM Issues");    
    $results = $sql->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($results as $result)
    {
      
      
      {
        ?>
        <table>
        <tr><th><b>Title</b> </th><th><b>Type</b></th><th><b>Status</b></th><th><b>Assign To</b></th><th><b>Created</b> </th> </tr>
        <?php
        foreach($results as $result)
        {
       ?>
         <td><?php echo $result['id'].$result['title'];?></td>
         <td><?php echo $result['type'];?></td>
          <td><?php echo $result['status'];?></td>
         <td><?php echo $result['assigned_to'];?></td>
          <td><?php echo $result['created'];?></td>
         </tr>
        <?php
        }
        ?>
        </table>
        <br>
        <br>
        
        <?php
        }
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
    }
}









?>