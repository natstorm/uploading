<?php

//connecting the database to our script

session_start();
if( isset($_SESSION['user_id']) ){
	header("location: secret.php");
}

require 'database.php';

//If the email and the password box aren't empty, we want to enter the new user to the database

if(!empty($_POST['email']) && !empty($_POST['password'])):

$records = $conn->prepare('SELECT id,email,password FROM users WHERE email = :email');
$records->bindParam(':email', $_POST['email']);
$records->execute();
$results = $records->fetch(PDO::FETCH_ASSOC);

$message = '';

if(count($results) > 0 && password_verify($_POST['password'], $results['password']) ) {

$_SESSION['user_id'] = $results['id'];
header("Location: secret.php");
}

 else {
    $message = 'looks like something is missing';
}


endif;
?>

<!DOCTYPE html>
<html>
<head>
    
<title>Login Below</title>
<link rel="stylesheet" type="text/css" href="style.css">
<link href="https://fonts.googleapis.com/css?family=Roboto+Mono" rel="stylesheet">
</head>
    
<body>
    
 <div class="header">
<a href="index.php">Natalie Way Storm</a>  
         
</div>
   
  <?php if(!empty($message)): ?>
	<p><?= $message ?></p>
  <?php endif;?>
   
   
    <h1>Login</h1>
    
   
    <form action="login.php" method="POST">
    
        <input type="text" placeholder="Enter your email" name="email">
        <input type="password" placeholder="...and password" name="password">
        <input type="submit">
    
    </form>
    <span>Don't have a login? <a href="register.php">Go register</a></span>
    
  
    
</body>




</html>