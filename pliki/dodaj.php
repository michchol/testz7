<?php

    session_start(); 
    if (!isset($_SESSION['zalogowany1']))
    {
        header('Location: index.php');
		exit();
	}
    ?>
<html>
<head>
<title>Cholewinski</title>
<link rel="stylesheet" href="style1111.css" type="text/css" />
</head>
<body>
<?php
$katalog = $_POST['katalog']; 
$uzytkownik = $_SESSION['user'];
if ($katalog){
	// tworzy nam nowy katalog
mkdir("$uzytkownik/$katalog", 0777, true);
}
echo "Dodano katalog.";
?>
</body>
</html>