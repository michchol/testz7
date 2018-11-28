<?php

	session_start();
	
	if (isset($_POST['nick']))
	{
		//Udana walidacja? Załóżmy, że tak!
		$wszystko_OK=true;
		
		//Sprawdź poprawność nickname'a
		$nick = $_POST['nick'];
		
		//Sprawdzenie długości nicka
		if ((strlen($nick)<3) || (strlen($nick)>20))
		{
			$wszystko_OK=false;
			$_SESSION['e_nick']="Nick musi posiadać od 3 do 20 znaków!";
		}
		
		if (ctype_alnum($nick)==false)
		{
			$wszystko_OK=false;
			$_SESSION['e_nick']="Nick może składać się tylko z liter i cyfr (bez polskich znaków)";
		}
		
		//Sprawdź poprawność hasła
		$haslo1 = $_POST['haslo1'];
		$haslo2 = $_POST['haslo2'];
		
		if ((strlen($haslo1)<3) || (strlen($haslo1)>10))
		{
			$wszystko_OK=false;
			$_SESSION['e_haslo']="Hasło musi posiadać od 3 do 10 znaków!";
		}
		
		if ($haslo1!=$haslo2)
		{
			$wszystko_OK=false;
			$_SESSION['e_haslo']="Podane hasła nie są identyczne!";
		}	

		$haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);
						
		$imie = $_POST['imie']; 
        $nazwisko = $_POST['nazwisko']; 
         $ip = $_SERVER["REMOTE_ADDR"];
                    function ip_details($ip) 
                    {
                     $json = file_get_contents ("https://ipinfo.io/{$ip}/geo");
                    $details = json_decode ($json);
                    return $details;
                    }
                    $data = date("Y-m-d H:i:s");
                    $proby == 0;
                    $dataerror == 0;
                    $iperror == 0;
		//Zapamiętaj wprowadzone dane
		$_SESSION['fr_nick'] = $nick;
		$_SESSION['fr_haslo1'] = $haslo1;
		$_SESSION['fr_haslo2'] = $haslo2;
        $_SESSION['fr_imie'] = $imie;
        $_SESSION['fr_nazwisko'] = $nazwisko;
        $_SESSION['fr_data'] = $data;
        $_SESSION['ip'] = $ip;	
		
		require_once "polaczenie.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try 
		{
			$polaczenie = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
			if ($polaczenie->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{	

				//Czy nick jest już zarezerwowany?
				$rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE uzytkownik='$nick'");
				
				if (!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_nickow = $rezultat->num_rows;
				if($ile_takich_nickow>0)
				{
					$wszystko_OK=false;
					$_SESSION['e_nick']="Istnieje już gracz o takim nicku! Wybierz inny.";
				}
				
				if ($wszystko_OK==true)
				{

					if ($polaczenie->query("INSERT INTO uzytkownicy VALUES (NULL, '$nick', '$haslo_hash', '$imie', '$nazwisko')") and $polaczenie->query("INSERT INTO logowanie VALUES (NULL, '$nick', '$data', '$ip', '$proby', '$dataerror', '$iperror', 0)"))
					{
						// tworzy katalog "pliki" o nazwie zarejestrowanego uzytkownika
						// 0777 określa uprawnienia (najszerszy dostęp) 
						// is_dir sprawdza czy plik jest katalogiem
                        $path = 'pliki' . DIRECTORY_SEPARATOR . $_POST['nick'];
    								if(!is_dir($path)) {
										mkdir($path, 0777, true);}

						$_SESSION['udanarejestracja']=true;
						header('Location: witamy.php');
					}
					else
					{
						throw new Exception($polaczenie->error);
					}				
				}			
				$polaczenie->close();
			}		
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
			echo '<br />Informacja developerska: '.$e;
		}	
	}	
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Cholewinski</title>
    <link rel="stylesheet" href="style11.css" type="text/css" />
	
	<style>
		.error
		{
			color:red;
			margin-top: 10px;
			margin-bottom: 10px;
		}
	</style>
</head>

<body>
<center>	
	<form method="post">
	<div id="rejestracja">
		Nazwa: <br /> <input type="text" value="<?php
			if (isset($_SESSION['fr_nick']))
			{
				echo $_SESSION['fr_nick'];
				unset($_SESSION['fr_nick']);
			}
		?>" name="nick" />
		
		<?php
			if (isset($_SESSION['e_nick']))
			{
				echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
				unset($_SESSION['e_nick']);
			}
		?><br /><br />
		Imię: <br /> <input type="text" value"" name="imie"/><br /> <br />
        Nazwisko: <br /> <input type="text" value"" name="nazwisko"/><br /> <br />
		
		Twoje hasło: <br /> <input type="password"  value="<?php
			if (isset($_SESSION['fr_haslo1']))
			{
				echo $_SESSION['fr_haslo1'];
				unset($_SESSION['fr_haslo1']);
			}
		?>" name="haslo1" />
		
		<?php
			if (isset($_SESSION['e_haslo']))
			{
				echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
				unset($_SESSION['e_haslo']);
			}
		?>		<br /><br />
		
		Powtórz hasło: <br /> <input type="password" value="<?php
			if (isset($_SESSION['fr_haslo2']))
			{
				echo $_SESSION['fr_haslo2'];
				unset($_SESSION['fr_haslo2']);
			}
		?>" name="haslo2" /><br /><br />	

		<br />
		
		<input type="submit" value="Zarejestruj się" />
		
	</form>
        <br><br>
    <a href='index.php'>Cofnij</a>
<br><br>
</center>
</body>
</html>