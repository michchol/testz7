<?php

    session_start(); 
    if (!isset($_SESSION['zalogowany1']))
    {
    	header('Location: index.php');
		exit();
	}
    ?>
﻿<!DOCTYPE html>
<html>
    <head>
        <title>Cholewinski</title> 
        <link rel="stylesheet" href="style.css" type="text/css" />
    </head>
    <body>
    <center>
	<br><br><a href=".."> Cofnij</a>
    <?php
        $uzytkownik = $_SESSION['user'];

        echo "<p><div>Nazwa katalogu:".$uzytkownik."</div></p>";
      ?></p><br>

        Dodaj plik:<br><br>

        <form action="dodajplik.php" method="POST" ENCTYPE="multipart/form-data">
        <input type="file" name="plik"/><br><br>
        <input type="submit" value="Wyślij plik"/></form>
        
        <form method="post" action="dodaj.php"> <?php
        if (isset ($_SESSION['upload'])) echo $_SESSION['upload'];
        if (isset ($_SESSION['failedupload'])) echo $_SESSION['failedupload'];
        ?><br>
        Utwórz nowy katalog:<br>
        <br><input type="text" name="katalog" maxlength="40" required><br><br>
        <input type="submit" value="Stwórz"/>
        </form><br>
       Twoje pliki:<br>
<?php         // zwraca jakie pliki ma uzytkownik
         $pliki = array_diff(scandir($uzytkownik), array('.', '..'));
        foreach($pliki as $file)
        {
			// jeżeli plik jest katalogiem to
    if(is_dir($uzytkownik . DIRECTORY_SEPARATOR . $file)){
                echo "<a href='podkatalog.php?podkatalog=$file'><img class='obrazki' src='katalog.png'>$file</a>";
            }
            else{ // w przeciwnym razie
                echo "<a href='$uzytkownik/$file' download='$file'><img class='obrazki' src='pobierz.png'>$file</a>";
            }
            }
?>
        <br><br>
        
</center>
    </body>
</html>