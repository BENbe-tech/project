<?php

session_start();

require('config.php');
$fnameError = "";
$passwordError = "";
$Error1 = "";
$regnoError="";

//validating inputs
if(!empty($_POST['login'])){

	
	//validating firstname
	if (empty($_POST["regno"])) {
		$regnoError = "registration number is required";
	  } else {
		$regnumber = test_input($_POST['regno']);
	
	  }

	  
 //validating password

 if (empty($_POST["password"])) {
    $passwordError = "Password is required";
  }
  else{
   $loginpassword =test_input($_POST['password']);
 
  }

    

  if($regnoError=="" && $passwordError ==""){
  $sq = "SELECT * FROM client WHERE idnumber='$regnumber' ";
  $sql = "SELECT * FROM  advisor WHERE idnumber = '$regnumber' ";

  
  $resultadvisor = $conn->query($sql);
  $resultclient = $conn->query($sq);

  if($resultclient->num_rows > 0){
	  $fetch = $resultclient->fetch_assoc();
	  $registrationpassword = $fetch["password"];

	  $resultclient -> free_result(); 
//verify if the password entered by the user is the same as password entered during the registration
if(password_verify($loginpassword,$registrationpassword))
{

$_SESSION['password'] = $loginpassword;
$_SESSION['registrationnumberc'] = $regnumber;

	header("Location:./ChatUi/client.php"); 
}

else{

 $message = "invalid registration number or password";

}
  }


  elseif($resultadvisor->num_rows>0){
	$fetch = $resultadvisor->fetch_assoc();
	$registrationpassword = $fetch["password"];

	$resultadvisor -> free_result(); 
//verify if the password entered by the user is the same as password entered during the registration
if(password_verify($loginpassword,$registrationpassword))
{

$_SESSION['password'] = $loginpassword;
$_SESSION['registrationnumbera'] = $regnumber;

  header("Location:./ChatUi/advisor.php"); 
}

else{

$message = "invalid registration number or password";

}

	
  }

}



 $conn ->close();
  
}

else{
	
	$Error1 = "failed to login";
}

//testing the inputs entered by the user

function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data,ENT_QUOTES);
  return $data; 
}
?>



<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="css/login-style.css">
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
    .error{
        color:blue;
        
    }
    
</style> 
</head>
<body>
	<img class="img-ballon" src="img/img-ballon.svg">
	<div class="container">
		<div></div>
		<div class="login-content">
		<form  autocomplete = "on" method="post" onsubmit = "return validateForm()"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<h2 class="title">Welcome </h2>




           		<div class="input-div one">
           		   <div class="i">
           		   		<i class="fas fa-user"></i>
           		   </div>
           		   <div class="div">
           		   		<h5>ID_Number</h5>
           		   		<input type="tel" class="input" name="regno">
					  </div>	
				   </div>
				   <span class = "error"><?php echo $regnoError;?></span>
				   



           		<div class="input-div pass">
           		   <div class="i"> 
           		    	<i class="fas fa-lock"></i>
           		   </div>
           		   <div class="div">
           		    	<h5>Password</h5>
           		    	<input type="password" class="input" name="password" id="password" autocomplete="off">
				   </div>  	
				</div>
				<span class = "error"><?php echo $passwordError;?></span>



				<a href="Forgotpassword.html">Forgot Password?</a>
				<span class = "error"><?php echo $message;?></span><br> 


				
            	<input type="submit" class="btn" value="Login" name="login">
           
		    </form>
        </div>
    </div>
    <script type="text/javascript" src="js/login.js"></script>
</body>
</html>
