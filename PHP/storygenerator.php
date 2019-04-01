<!DOCTYPE html>
<html>
<head>
  <title>Fyll-inn-Story</title>
</head>
<body>

<form method="post" action="">
  Et navn: <input type="text" name="name"><br>
  Tre Verb: <input type="text" name="verb"> <input type="text" name="verb2"><input type="text" name="verb3"> <br>
  To steder: <input type="text" name="place"><input type="text" name="place2"><br>
  To Substantiv : <input type="text" name="noun"> <input type="text" name="noun2"><br>
<input type="submit" name="submit" value="submit">
<hr>
</form>


<?php

$navn = $_POST['name'];
$verb = $_POST['verb'];
$sted = $_POST['place'];
$substantiv = $_POST['noun'];
$verb2 = $_POST['verb2'];
$verb3 = $_POST['verb3'];
$sted2 = $_POST['place2'];
$substantiv2 = $_POST['noun2'];




$text ="Det var en dag da {$navn} fant ut at det hadde vært lurt å {$verb} en tur til {$sted}.
Vel framme så ble det oppdaget at {$sted} allerede var {$verb3} av {$substantiv}, så {$navn} ble nødt til å {$verb2} til {$sted2} med {$substantiv2}";

if(!$navn == '')

{echo $text;}


 ?>


</body>
</html>
