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
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<?php 
$uzytkownik = $_SESSION['user'];
$_SERVER['DOCUMENT_ROOT'] = "$uzytkownik/";
// dodaje nam nowy  plik
if (is_uploaded_file($_FILES['plik']['tmp_name'])) 
{ echo 'Dodano nowy plik: '.$_FILES['plik']['name'].'<br/>';
move_uploaded_file($_FILES['plik']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].$_FILES['plik']['name']); 
} 
else {echo 'Błąd przy przesyłaniu danych!';} ?>