<!DOCTYPE html>
<html>
<head>
  <title>PHP CRUDs</title>

</head>
<body>
<?php

/*	$db = mysqli_connect(
		"localhost",
		"username",
		"password",
		"database"
	);*/
  $name ='';
  $password = '';
  $gender ='';
  $color = '';

	if (isset($_POST['submit']))
	{
		$ok =true;
		if (!isset($_POST['name']) || $_POST['name'] === '' ){
			$ok = false;
		} else {
      $name = $_POST['name'];
    }

    if (!isset($_POST['password']) || $_POST['password'] === '' ){
      $ok = false;
    } else {
      $password = $_POST['password'];
    }

		if (!isset($_POST['gender']) || $_POST['gender'] === '' ){
			$ok = false;
		}else {
      $gender = $_POST['gender'];
    }

		if (!isset($_POST['color']) || $_POST['color'] === '' ){
			$ok = false;
		}else {
      $color = $_POST['color'];
    }


		if ($ok){
		/* LAGRE I VARIABLER
    printf('User name: %s
			  <br>Gender: %s
			  <br>Color: %s',
			 htmlspecialchars($_POST['name']),
			 htmlspecialchars($_POST['gender']),
			 htmlspecialchars($_POST['color']));*/

       //SEND TIL DB//
      $hash = password_hash($password, PASSWORD_DEFAULT);
       //$db = mysqli_connect('localhost', 'root', ' ', 'php');
      $db = mysqli_connect('localhost', 'root', '', 'php', 3307, null);

       $sql = sprintf("INSERT INTO users (name, password, gender, color) VALUES (
         '%s', '%s','%s', '%s')"
          ,mysqli_real_escape_string($db, $name),
           mysqli_real_escape_string($db, $hash),
           mysqli_real_escape_string($db, $gender),
           mysqli_real_escape_string($db, $color));
           mysqli_query($db, $sql);
           mysqli_close($db);
           echo '<p> User added. </p>';

    }
	}

?>


<form method="post" action=""> <hr>
  User name: <input type="text" name="name"> <br>

  Password: <input type="password" name="password"> <br>

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
    <?php readfile('navigation.tmpl.html');?>
  </body>
  </html>
