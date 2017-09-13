<html>

<?php




require 'database.php';

if( isset($_SESSION['user_id']) ){

	$records = $conn->prepare('SELECT id,email,password FROM users WHERE id = :id');
	$records->bindParam(':id', $_SESSION['user_id']);
	$records->execute();
	$results = $records->fetch(PDO::FETCH_ASSOC);

	$user = NULL;

	if( count($results) > 0){
		$user = $results;
	}

}

?>


<!doctype html>


<?php if( !empty($user) ): ?>



<br><br><br>
		<br />Hi <?= $user['email'];?> 
		<br /><br />AWESOME, you're logged in! Go upload a photo or go through the <a href="viewimagestuesday.php">gallery!</a>
		<br /><br />
       <br /><br />
		

	<?php else: ?>

		<h1>Please Login or Register</h1>
		<a href="login.php">Login</a> or
		<a href="register.php">Register</a>

	<?php endif; ?>



    
<link rel="stylesheet" type="text/css" href="style.css">
<link href="https://fonts.googleapis.com/css?family=Roboto+Mono" rel="stylesheet">

<body>

	<a href="logout.php">Log out?</a>

	<h2>Upload a new picture</h2>
	<form action="secret.php" method="post" enctype="multipart/form-data">
    Select image to upload:<br>
    	<input type="text" name="title" placeholder="Image title" required />
    	<input type="text" name="text" placeholder="text comment" required />
    	<input type="file" name="fileToUpload" id="fileToUpload"><br>
    	<input type="submit" value="Upload Image" name="submit">
	</form>	

<a href="viewimagestuesday.php">see all photos</a> <br><br>
<?php
$title = filter_input(INPUT_POST, 'title')
	or die;
	
$target_dir = "img/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// If you need unique names:
//$target_file = $target_dir . uniqid().'.'.$imageFileType;	
	
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
		
		
		require_once('dbcontuesday.php');
		
		$sql = 'INSERT INTO images (imageurl, title) VALUES (?, ?)';
		$stmt = $link->prepare($sql);
		$stmt->bind_param('ss', $target_file, $title);
		$stmt->execute();
		if ($stmt->affected_rows > 0) {
			echo 'PERFECT';
		}
		else {
			echo 'Could not add the file to the database :-(';
		}
		
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>
<hr>
	
	
	
</body>
</html>

