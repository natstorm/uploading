<?php

require 'database.php';
$message ='';


if(!empty($_POST['email']) && !empty($_POST['password'])):

//enter the new user in the database

//below is the query to insert data into the database
	
$sql = "INSERT INTO users (email, password) VALUES (:email, :password)";
$stmt = $conn->prepare($sql);

$stmt->bindParam(':email', $_POST['email']);
$stmt->bindParam(':password', password_hash($_POST['password'], PASSWORD_DEFAULT));

//the hash is a distortion of a password, so no one is able to see the original password in the database

if( $stmt->execute() ):
  $message = 'Successfully created new user!';
else:
  $message = 'So sorry, it did not work. User registration failed.';

endif;

endif;

?>


<!DOCTYPE html>
<html>
<head>
<title> Register Below</title>    
    
<link rel="stylesheet" type="text/css" href="style.css">
<link href="https://fonts.googleapis.com/css?family=Roboto+Mono" rel="stylesheet">
</head>

    <body>
  
 <div class="header">
<a href="index.php">Natalie Way Storm</a>  
         
</div>
    
        
<?php if(!empty($message)): ?>
        <p><?= $message ?></p>
        
 <?php endif; ?>
            
        <h1>Register</h1>
  
    <form action="register.php" method="POST">
    
        <input type="text" placeholder="Enter your email" name="email">
        <input type="password" placeholder="...and password" name="password">
        <input type="password" placeholder="confirm password" name="confirm_password">
        
        <input type="submit">
        
        <br>
        <span>Already registered? <a href="login.php">Sign in here!</a></span>
    
    </form>
    
    
    
    </body>





</html>