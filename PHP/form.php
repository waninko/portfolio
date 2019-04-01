<!DOCTYPE html>
<html>
<head>
  <title>PHP CRUDs</title>
</head>
<body>
<?php 
	
	$db = mysqli_connect(
		"localhost",
		"username",
		"password",
		"database"
	);
	

	if (isset($_POST['submit']))
	{
		$ok =true;
		if (!isset($_POST['name']) || $_POST['name'] === '' ){
			$ok = false;
		}

		if (!isset($_POST['gender']) || $_POST['gender'] === '' ){
			$ok = false;
		}

		if (!isset($_POST['color']) || $_POST['color'] === '' ){
			$ok = false;
		}


		if ($ok){
		printf('User name: %s
			  <br>Gender: %s
			  <br>Color: %s',
			 htmlspecialchars($_POST['name']),
			 htmlspecialchars($_POST['gender']),
			 htmlspecialchars($_POST['color']));
		}
	}
	mysqli_close($db);
?>


<form method="post" action=""> <hr>
  User name: <input type="text" name="name"> <br>
  
  Gender:
    <input type="radio" name="gender" value="f"> female
    <input type="radio" name="gender" value="m"> male
	<br>
  Favorite color:
      <select name="color">
		  <option value=" ">PLEASE SELECT</option>
          <option value="#f00">red</option>
          <option value="#0f0">green</option>
          <option value="#00f">blue</option>
      </select><br>
      <input type="submit" name="submit" value="submit">
  </form>
  </body>
  </html>
