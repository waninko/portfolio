<?php
    require 'auth.php';

   if(isset($_GET['id']) && ctype_digit($_GET['id'])){
      $id = $_GET['id'];
   }  else{
     //om det feiler redirecter den oss til select sida.
     header('Location: formselect.php');
   }
?>
<!DOCTYPE html>
<html>
<head>
  <title>PHP UPDATE DB</title>

<body>

<?php


$name ='';
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

    $db = mysqli_connect('localhost', 'root', '', 'php', 3307, null);
    $sql = sprintf("UPDATE users SET name='%s', gender='%s', color='%s'
    WHERE id=%s",
    mysqli_real_escape_string($db, $name),  //realescape ungår behandlig av spesialtegn
    mysqli_real_escape_string($db, $gender),
    mysqli_real_escape_string($db, $color),
    $id); //id er et tall, så den trenger ikke "renskes"
  mysqli_query($db, $sql);
  echo '<p> User Updated. </p>';
  mysqli_close($db);
    }
  } else{
    $db = mysqli_connect('localhost', 'root', '', 'php', 3307, null);
    $sql = sprintf("SELECT * FROM users WHERE id='%s'", $id);
    $result = mysqli_query($db, $sql);
    foreach ($result as $row) {
      $name = $row['name'];
      $gender = $row['gender'];
      $color = $row['color'];
    }
    mysqli_close($db);
  }

?>
<form method="post" action="">

  <hr>
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
<?php   readfile('navigation.tmpl.html'); ?>
</body>
</html>
