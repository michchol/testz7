<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany1']))
	{
		header('Location: index.php');
		exit();
	}
	
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title> Cholewinski</title>
	<link rel="stylesheet" href="pliki/style.css" type="text/css" />
</head>

<body class="chmura">
	
<?php

	echo "<p>Witaj ".$_SESSION['imie1'].'! [ <a href="logout.php">Wyloguj się!</a>]</p>';
    $uzytkownik = $_SESSION['user'];
 require_once "polaczenie.php";
$polaczenie = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
$rezultat2 = mysqli_query($polaczenie, "SELECT * FROM logowanie WHERE nazwa= '$uzytkownik' AND ip !=''");
 while ($w = mysqli_fetch_array($rezultat2)) {  
                    $ostatnia_pr = $w [7];
                     echo "Ostatnie nieudane logowanie było: <font color=red size=5>$ostatnia_pr</font> <br><br><br>";                     
;}

Echo "<center><a href='pliki/katalog.php?user=$uzytkownik'><img class='obrazki' src='katalog.png'><font color=blue size=15> Katalog</font> </a></center>";

?>
</body>
</html>