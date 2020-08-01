 <?php

require('config.php');

$emailError = "";
$fnameError = "";
$lnameError = "";
$Error2 = "";
$Error1 = "";
$regnoError = "";
$checkError = "";


//validating the inputs
if(!empty($_POST['SignUp'])){


//validating email
if(empty($_POST['email'])){
$emailError = "email required";
}
else{
$email = test_input($_POST['email']);

if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
    $emailError = "Invalid email format";
}

}

//$checkbox validation
if(empty($_POST['checkclient']) && empty($_POST['checkadvisor']) ){
$checkError = "tick one box";
}


if(!empty($_POST['checkclient']) && !empty($_POST['checkadvisor']) ){
    $checkError = "tick one box";
    }



//validating firstname
if (empty($_POST["first_name"])) {
    $fnameError = "firstname is required";
  } else {
    $firstname = test_input($_POST['first_name']);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$firstname)) {
      $fnameError = "Only letters and white space allowed";
    }
  }


//validating lastname
if (empty($_POST["last_name"])) {
    $lnameError = "lastname is required";
    
  } else {
    $lastname = test_input($_POST['last_name']);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$lastname)) {
      $lnameError = "Only letters and white space allowed";
    }
  }


  //validating regnumber
  if (empty($_POST["regno"])) {
    $regnoError = "registration number is required";
    
  }
  else {
    $regnumber = test_input($_POST['regno']);

  }



  //validating password
 
   $pass =test_input($_POST['password']);
  $password = password_hash($pass,PASSWORD_DEFAULT);
 
  

  //insert into the table student
   if(!empty($_POST['checkclient']) && empty($_POST['checkadvisor']) ){
       

 if($emailError =="" && $fnameError =="" && $lnameError ==""&& $regnoError==""){
 $sql = "INSERT INTO client(firstname, lastname,idnumber, email, password)
 VALUES('$firstname', '$lastname','$regnumber', '$email', '$password')";

$connect =   $conn->query($sql);
  }
  if($connect===true){
    header("Location: login.php");
    }
    
    else{
        $Error2 = "Signup failed";
    }

 }



if(!empty($_POST['checkadvisor']) &&  empty($_POST['checkclient'])){

    if($emailError =="" && $fnameError =="" && $lnameError ==""&& $regnoError=="" ){
        $sql = "INSERT INTO advisor(firstname, lastname,idnumber, email, password)
        VALUES('$firstname', '$lastname','$regnumber', '$email', '$password')";
       
       $connect =   $conn->query($sql);
         }

         if($connect===true){
            header("Location: login.php");
            }
            
            else{
                $Error2 = "Signup failed";
            }

}




$conn -> close();

}

else{

  $Error1 = "failed to Signup";
}


// testing the  inputs entered by the user
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
	<title>SignUp</title>
	<link rel="stylesheet" type="text/css" href="./css/signup-style1.css">
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
	<img class="Signup-image" src="img/forms.svg">
	<div class="container">
		<div class="signup-content">
			<!-- <form name="signup-form" onsubmit="return validateForm()"  action="SignUp.html"> -->
            
                <form   onsubmit=" return validateForm()" autocomplete = "on" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
              

                <div class="input-div one">
                    <div class="i">
                        <i class="fas fa-user"></i>    
                    </div>
                    <div class="div">
                        <h5>First Name</h5>
                        <input type="text" class="input" name="first_name" >
                    </div>
                 </div>
                 <span class = "error"><?php echo $fnameError;?></span>
              

                 <div class="input-div one">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="div">
                        <h5>Last Name</h5>
                        <input type="text" class="input" name="last_name">
                    </div>
                  </div>
                  <span class = "error"><?php echo $lnameError;?></span>


                  <div class="input-div one">
                    <div class="i">
                        <i class="fa fa-id-card"></i>
                    </div>
                    <div class="div">
                        <h5>ID_Number</h5>
                        <input type="tel" class="input" name="regno">
                    </div>
                </div>
                <span class = "error"><?php echo $regnoError;?></span>
                


                 <div class="input-div one">
                    <div class="i">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="div">
                        <h5>Email</h5>
                        <input type="text" class="input" name="email">
                    </div> 
                 </div>
                 <span class = "error"><?php echo $emailError;?></span>



                 <div class="input-div pass">
                    <div class="i"> 
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="div">
                        <h5>Password</h5>
                        <input type="password" class="input"name="password" id="password" autocomplete="off">
                    </div>
                    </div>
                    <span class = "error"><?php echo $passError;?></span>



                <div class="input-div pass">
                    <div class="i">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="div">
                        <h5>Confrim Password</h5>
                        <input type="password" class="input" id="cpassword" name="confrim_password">
                    </div>
                 </div>


                 <h4>You are: </h4>
                 <div class="checkbox">
                    <div class="l_advisor">
                        <input type="checkbox" name= "checkadvisor" >
                        <label><b>Advisor</b></label>
                    </div>
                    <div class="l">
                        <input type="checkbox"  name="checkclient" >
                        <label><b>Client</b></label>
                    </div>
                </div>
                <span class = "error"><?php echo $checkError;?></span>

              <a href="HelpMe.html">Help Me?</a>


              <input type="submit" class="btn" value="SignUp" name="SignUp">
                </form>
        </div>
    </div>
     <script type="text/javascript" src="js/signUp2.js"></script> 
</body>
</html>