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
$pullup=$_GET["pullup"];






$title  = preg_replace('/[^a-zA-Z0-9_ -]/s','',$title);
$text  = preg_replace('/[^a-zA-Z0-9_ -]/s','',$text);











   
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
 
     $conn -> query("INSERT INTO Issues (title, description, type, priority, status, assigned_to,created_by,created,updated) 
       VALUES('$title', '$text', '$type', '$priority', 'OPEN', '$user','Admin','$date','$date')");   
       
       header('Location: NewIssue.html');
    
}



if($_GET["get"]=="all")
{
    $sql = $conn ->query("SELECT * FROM Issues");    
    $results = $sql->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <table class="table-border">
        <tr><th><b>Title</b> </th><th><b>Type</b></th><th class="center"><b>Status</b></th><th><b>Assign To</b></th><th><b>Created</b> </th> </tr>
        
        <?php
        foreach($results as $result)
        {
       ?>
           <td> <?php echo"#".$result['id']?> <a href="index.php?pullup=<?php echo $result['id'];?>" class="link"> <?php echo $result['title'];?> </a> </td>
         <td><?php echo $result['type'];?></td>
         <?php
        if($result['status']=="OPEN")
          {
              ?>
              <td class="center"><label class="open"><?php echo $result['status'];?></label></td>
              <?php
          }
         
          else if($result['status']=="CLOSED")
          {
              ?>
              <td class="center"><label class="closed"><?php echo $result['status'];?></label></td>
              <?php
          }
          
        else if($result['status']=="IN PROGRESS")
          {
              ?>
              <td class="center"><label class="inprogress"><?php echo $result['status'];?></label></td>
              <?php
          }
         ?>
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
    










if($_GET["get"]=="open")
{
    $sql = $conn ->query("SELECT * FROM Issues where status='open'");    
    $results = $sql->fetchAll(PDO::FETCH_ASSOC);
    
        ?>
        <table>
        <tr><th><b>Title</b> </th><th><b>Type</b></th><th class="center"><b>Status</b></th><th><b>Assign To</b></th><th><b>Created</b> </th> </tr>
        <?php
        foreach($results as $result)
        {
       ?>
 <td> <?php echo"#".$result['id']?> <a href="DisplayIssue.html" class="link"> <?php echo $result['title'];?> </a> </td>
         <td><?php echo $result['type'];?></td>
 <td class="center"><label class="open"><?php echo $result['status'];?></label></td>
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
if($_GET["get"]=="listmyticket")
{
    $sql = $conn ->query("SELECT * FROM Issues where created_by='Admin'");    
    $results = $sql->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <table>
        <tr><th><b>Title</b> </th><th><b>Type</b></th><th class="center"><b>Status</b></th><th><b>Assign To</b></th><th><b>Created</b> </th> </tr>
        <?php
        foreach($results as $result)
        {
       ?>
                 <td> <?php echo"#".$result['id']?> <a href="DisplayIssue.html" class="link"> <?php echo $result['title'];?> </a> </td>
         <td><?php echo $result['type'];?></td>
         
         
         
         
         
                  <?php
         
         
        if($result['status']=="OPEN")
          {
              ?>
              <td class="center"><label class="open"><?php echo $result['status'];?></label></td>
              <?php
          }
         
          else if($result['status']=="CLOSED")
          {
              ?>
              <td class="center"><label class="closed"><?php echo $result['status'];?></label></td>
              <?php
          }
          
        else if($result['status']=="IN PROGRESS")
          {
              ?>
              <td class="center"><label class="inprogress"><?php echo $result['status'];?></label></td>
              <?php
          }
         ?>
         
         
         
         
         
         
         
         
         

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



################################################################################################




$login=$_POST["hide"];
    if($login== "123AC")
    {
      
      $loginpassword = $_POST['password']; 
      $loginusername =$_POST['email'];
      
      $stmt22 = $conn->query("SELECT * FROM Users WHERE email = '$loginusername'");
      $passwordresult = $stmt22->fetchAll(PDO::FETCH_ASSOC);
      foreach ($passwordresult as $rows)
      {
         
          if($rows['hash'] ==  md5( $rows['salt'].$loginpassword ))
          {
                return header('Location: Home.html');
          }
      }
             header('Location: index.html');    
        
      
      
    }


##################################################################################################
############################# Pullling up the information     ####################################


if($pullup>0)
{
  $sql = $conn ->query("SELECT * FROM Issues where id='$pullup'");    
  $results = $sql->fetchAll(PDO::FETCH_ASSOC);   
  
  ?>
  
  
  
  
  <?php
}


?>

