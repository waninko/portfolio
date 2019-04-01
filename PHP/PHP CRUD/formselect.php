<?php require 'auth.php' ?>
<!DOCTYPE>
<html>
<head>
  <title>PHP SELECT FROM DB</title>
</head>
<body>


<ul>
      <?php

        $db = mysqli_connect('localhost', 'root', '', 'php', 3307, null);
        $sql = 'SELECT * FROM users';
        $result = mysqli_query($db, $sql);

        foreach($result as $row){
          printf('<li><span style="color: %s;">%s (%s)</span>
          <a href="formupdate.php?id=%s">edit</a>
          <a href="formdelete.php?id=%s">delete</a></li>',
              htmlspecialchars($row['color']),
              htmlspecialchars($row['name']),
              htmlspecialchars($row['gender']),
              htmlspecialchars($row['id']),
              htmlspecialchars($row['id'])
        );
        }
        mysqli_close($db);
      ?>

</ul>
<?php
  readfile('navigation.tmpl.html');
?>
</body>
</html>
