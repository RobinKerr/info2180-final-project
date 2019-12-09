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
$udate=date("Y/m/d")." at ".date("h:i");

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
       VALUES('$title', '$text', '$type', '$priority', 'OPEN', '$user','Admin','$date','$udate')");   
       
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
   foreach($results as $result)
  {
  ?>
  
  	<head>

		<meta charset="UTF-8" />

		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<meta http-equiv="X-UA-Compatible" content="ie=edge" />

		<title>Home</title>

		<link rel="stylesheet" href="style.css" />

		<script src="home.js"></script>

	</head>

	<body>
		<div class="bod">
            
            <!--green header-->
			<header>
			
                <img src="bug.png" class="bugcon"/>
				<h2>BugMe Issue Tracker</h2>
				
			</header>

            <!--side bar navigation-->
			<div class="sidebar">
                
				<a href="Home.html">
                    <div class="Home pageColor">
                        <p>
					       <img src="house.png" class="sidecon"/>Home
                        </p>
				    </div>
                </a>
				
                <a href="AddUser.html">
                    <div class="AddUser hover">
                        <p>
					       <img src="adduser.png" class="sidecon"/>Add User
                        </p>
				    </div>
                </a>
				
                <a href="NewIssue.html">
                    <div class="NewIssue hover">
                        <p>
					       <img src="newIssue.png" class="sidecon"/>New Issue
                        </p>
				    </div>
                </a>
                
				<a href="index.html">
                    <div class="Logout hover">
                        <p>
					       <img src="logout.png" class="sidecon"/>Logout
                        </p>
				    </div>
                </a>
                
			</div>

            <!--main content area-->
			<div class="mainContent">
                
                <!--title div for the issue-->
                <div class="title">
                    <h1 id="issueTitle"><?php echo $result['title'];?></h1>
                    <h5 id="issueNum"><?php echo "Issue #".$result['id'];?></h5>
                </div>
                
                <!--description div for the issue-->
                <div class="descArea">
                    
                    <!--paragraph for description-->
                    <p id="issueDesc">
                       <?php echo $result['description'];?>
                    </p>
                    <br/>
                    
                    <!--unordered list for updates-->
                    <ul id="updateList">
                        <li><p class="fontOpacity">Issue was created on <?php echo $result['created'];?> by <?php echo $result['created_by'];?></p></li>
                        
                        <li><p class="fontOpacity">Last updated on <?php echo $result['updated'];?></p></li>
                    </ul>
                    
                </div>
                
                
                <!--Right side panel with Issue Specs-->
                <div class="rightPanel">
                    
                    <!--content area-->
                    <div class="specsArea">
                        
                        <label>Assigned To:</label>
                        <br/>
                        <label id="assigned" class="info"><?php echo $result['assigned_to'];?></label>
                        <br/><br/>
                        
                        <label>Type:</label>
                        <br/>
                        <label id="type" class="info"><?php echo $result['type'];?></label>
                        <br/><br/>
                        
                        <label>Priority:</label>
                        <br/>
                        <label id="priority" class="info"><?php echo $result['priority'];?></label>
                        <br/><br/>
                        
                        <label>Status:</label>
                        <br/>
                        <label id="status" class="info"><?php echo $result['status'];?></label>
                        <br/><br/>
                        
                    </div>
                    
               <a href="index.php?closed=<?php echo $result['id'];?>">     <button type="button" id="closed" class="issueButton">Mark as Closed</button></a>
                    
             <a href="index.php?inprogress=<?php echo $result['id'];?>">       <button type="button" id="progress" class="issueButton">Mark in Progress</button></a>
                    
                </div>
                
			</div>
		</div>
	</body>
  
  
  <?php
}
}

 $closed=$_GET["closed"];
$inprog3=$_GET["inprogress"];
if(strlen($closed)>0)
{
    $update = "UPDATE Issues SET status = 'CLOSED' where id='$closed' ";
    $conn->query($update);
        $update2 = "UPDATE Issues SET updated = '$udate' where id='$closed' ";
    $conn->query($update2);
     return header('Location: Home.html');
}



if(strlen($inprog3)>0)
{

    $update = "UPDATE Issues SET status = 'IN PROGRESS' where id='$inprog3' ";
    $conn->query($update);
    $update2 = "UPDATE Issues SET updated = '$udate' where id='$inprog3' ";
    $conn->query($update2);
    
     return header('Location: Home.html');
}
?>




    