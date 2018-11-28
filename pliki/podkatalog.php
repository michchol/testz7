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
	<br><br><a href='katalog.php'> Cofnij</a>
    <?php
        $uzytkownik = $_SESSION['user'];
        $podkatalog = $_GET['podkatalog'];
	
        echo "<p><div style='text-align: left;'>/".$uzytkownik."/".$podkatalog."</div></p>";?></p><br>
       
        Wgraj plik:<br><br>
        <form action="dodajplik2.php" method="POST" ENCTYPE="multipart/form-data">
        <input type="file" name="plik"/><br><br>
        <input type="hidden" name="podkatalog" value="<?php echo $_GET['podkatalog']; ?>" />
        <input type="submit" value="Wyślij plik"/></form>
  
       Twoje pliki:<br>
        <? 
         // zwraca jakie pliki ma uzytkownik
         $pliki = array_diff(scandir($uzytkownik . DIRECTORY_SEPARATOR . $podkatalog), array('.', '..'));
        foreach($pliki as $file)
        {		// jeżeli plik jest katalogiem to
            if(is_dir($uzytkownik . DIRECTORY_SEPARATOR . $podkatalog . DIRECTORY_SEPARATOR . $file)){
                echo "<a href='$uzytkownik/podkatalog.php?podkatalog=$file'><img class='obrazki' src='katalog.png'>$file</a>";
            }
            else{// w przeciwnym razie
                echo "<a href='$uzytkownik/$podkatalog/$file' download='$file'><img class='obrazki' src='pobierz.png'>$file</a>";
            }
            }
            
        ?>
</center>
    </body>
</html>