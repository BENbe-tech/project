<?php
session_start();

require('../config.php');

$messageError = "";
//validating inputs

$regnumber = $_SESSION['registrationnumbera'];


if($regnumber != ""){
    $sq = "SELECT regnumberclient FROM relational WHERE regnumberadvisor='$regnumber' ";
    $result = $conn->query($sq);
  
    if($result->num_rows > 0){
    
     
  }

  $sql = "SELECT firstname FROM advisor WHERE idnumber = '$regnumber' ";
  $output = $conn->query($sql);

  if($output->num_rows>0){
    $output1 =  $output->fetch_assoc();
  
  }
  
}

if(!empty($_POST['send'])){

  if(!empty($_GET['user'])){
    $user = $_GET['user'];}


//validating message
if (empty($_POST["message"])) {
  $messageError = "please write a message";
  } 
  else {

  $message = test_input($_POST['message']);

  
}


if($messageError ==""){
  //2 - all message from advisor
  $sortadvisor = 2;
  $sql = "INSERT INTO messages(regnumberclient,regnumberadvisor, message,sort) VALUES('$user','$regnumber','$message','$sortadvisor')";

  $connect =   $conn->query($sql);
}


// $conn ->close();
}

//testing the inputs entered by the user

function test_input($data){
  $data = trim($data);
  $data = stripslashes($data);
  
return $data; 
}

?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <script>
      function setActive(){
        var online = document.getElementsByClassName('onlineDiv');
        var input = document.getElementsByClassName('inputDiv');

        online[0].style.display = "block";
        input[0].style.display = "block";

      }
    </script>
    <style>
    body{
      margin: 0;
      background-color: #E0E0E0;
    }

    ul {
      list-style-type: none;
      margin: 0;
      padding: 0;
      width: 20%;
      background-color: #f1f1f1;
       position: fixed;
      height: 100%;
      overflow: auto;
    }

    li a {
       display: block; 
      color: #000;
      float: left;
      padding: 8px 16px;
      text-decoration: none;
    }

    li a.active {
      background-color: #448AFF;
      color: white;
    }

    li a:hover:not(.active) {
      background-color: #555;
      color: white;
    }

    .container {
  border: 2px solid #dedede;
  background-color: #f1f1f1;
  border-radius: 5px;
  padding: 10px;
  margin: 10px 0;
}

.darker {
  border-color: #ccc;
  background-color: #ddd;
}

.container::after {
  content: "";
  clear: both;
  display: table;
}

.container img {
  float: left;
  max-width: 60px;
  width: 100%;
  margin-right: 20px;
  border-radius: 50%;
}

.right {
  float: right;
  margin-left: 20px;
  margin-right:0;
}

.time-right {
  float: right;
  color: #aaa;
}

.time-left {
  float: left;
  color: #999;
}
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>
  </head>

  <body>
    <ul>
    <li style="text-align:center;font-family: 'Poppins', sans-serif"><img src="https://img.icons8.com/cute-clipart/48/000000/chat.png"/><h3>My Clients</h3></li>
  
    <?php while(  $fetch =  $result->fetch_array(MYSQLI_ASSOC)){?>
      
    <li style="text-align:center;font-family: 'Poppins', sans-serif"><a href="advisor.php?user=<?php echo $fetch["regnumberclient"];
   if(!empty($_GET['user'])){
    $reg = $_GET['user'];}
    ?>" ><?php echo $fetch["regnumberclient"];} ?></a></li><br>
        

    <li style="text-align:center;font-family: 'Poppins', sans-serif;margin-top:150%"><a href = "../logout.php">Log Out</a></li>
  </ul>

  <div
  class="onlineDiv"
  style="position:fixed;top:0;margin-left:500px;margin-left:300px;padding:1px 16px;width:100%;background-color:black;"
  >
    <p  style="text-align:center;font-family: 'Poppins', sans-serif;color:white">Welcome <?php echo $output1["firstname"];?></p>
  </div>


  <div style="margin-left:280px;margin-right:20px;margin-top:80px;margin-bottom:200px;">

  

<!--code to loop through message sent by the client-->
 <?php

 if(!empty($_GET['user'])){
   $user = $_GET['user'];

  //1- all message from client
  //2 - all message from advisor
  //advisor light 
  //client darker
  $sortclient= 1; 
  $sortadvisor= 2;

  $sq = "SELECT message,time,sort FROM messages WHERE regnumberclient='$user' AND regnumberadvisor='$regnumber'";
  $data = $conn->query($sq);
  if($data->num_rows > 0){

while($fetch = $data->fetch_array(MYSQLI_ASSOC)){


  if($fetch["sort"]==$sortadvisor){
    ?>
  <div class="container">
  <i class="fas fa-user" ></i>
  <p><?php  echo $fetch["message"];?></p>

  <span class="time-right"><?php echo $fetch["time"]; ?></span>
  </div>
  <?php }
    elseif($fetch["sort"]==$sortclient){  ?>
  
  <div class = "container darker">
  <i class="fas fa-user right" style="color:white;"></i>
    <p><?php echo $fetch["message"]; ?></p>
   
  <span class="time-left"><?php echo $fetch["time"]; ?></span>
  </div>

<?php
}}}
else{?>


<h3><?php echo "no message available";} }?></h3>

</div>
 
  <div
  style="position:fixed;left:0;bottom:0;width:100%;background:black;color:white;text-align:center;
  margin-left:100px;padding:1px 16px;"
  class="inputDiv"
  >
  <form method = "post" action = "advisor.php?user=<?php echo $reg;?>">
    <input type="text" name="message"  autocomplete="off"   placeholder="Enter Message"
    style="width: 40%;
  padding: 12px 20px;
  margin-top: 20px;
  border: 3px solid #555;
  color: black;"
    >
    

      <input type = "submit" name = "send" value = "send"   style="background-color: #448AFF;
      border: none;
      color: white;
      margin-left: 150px;
      margin-top: 10px;
      padding: 16px 32px;
      text-decoration: none;
      cursor: pointer;">
 </form>
  </div>
  

  </body>
</html>
