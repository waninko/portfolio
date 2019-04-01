<?php
    require 'auth.php';

    if (isset($_GET['id']) && ctype_digit($_GET['id'])){
        $id = $_GET['id'];
    } else{
      header('Location: formselect.php');
    }

?>
<!DOCTYPE>
<html>
<head>
    <title>PHP DELETE FROM DB</title>

</head>
<body>
<?php

  $db = mysqli_connect('localhost', 'root', '', 'php', 3307, null);
  $sql = "DELETE FROM users WHERE id=$id";
  mysqli_query($db, $sql);
  echo '<p>User Deleted. </p>';
  mysqli_close($db);
?>
<hr>
  <?php   readfile('navigation.tmpl.html'); ?>
</body>
</html>
