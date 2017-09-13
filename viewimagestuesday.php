<!DOCTYPE html>
<html>
<head>
    
<title>Login Below</title>
<link rel="stylesheet" type="text/css" href="style.css">
<link href="https://fonts.googleapis.com/css?family=Roboto+Mono" rel="stylesheet">
</head>

<body>
	<h1>Images uploaded to the system</h1>
	<a href="secret.php">Go back</a>
	
<?php
	require_once('dbcontuesday.php');
	$sql = 'SELECT id, title, text, imageurl FROM images ORDER BY last_update DESC';
	$stmt = $link->prepare($sql);
	$stmt->execute();
	$stmt->bind_result($id, $title, $text, $url);
	
	while($stmt->fetch()){ ?>
		
	<h2><?=$title?></h2>
	<img src="<?=$url?>" width="650px" />
<?php } ?>
</body>
</html>