<?php

	session_start();
	
	if ((!isset($_POST['login'])) || (!isset($_POST['haslo'])))
	{
		header('Location: index.php');
		exit();
	}

	require_once "polaczenie.php";

	$polaczenie = @new mysqli($dbhost, $dbuser, $dbpassword, $dbname);
	
	if ($polaczenie->connect_errno!=0)
	{
		echo "Error: ".$polaczenie->connect_errno;
	}
	else
	{
		$login = $_POST['login'];
		$haslo = $_POST['haslo'];
		$login = htmlentities($login, ENT_QUOTES, "UTF-8");
	
		if ($rezultat = @$polaczenie->query(
		sprintf("SELECT * FROM uzytkownicy WHERE uzytkownik='%s'",
		mysqli_real_escape_string($polaczenie,$login))))
		{
			$ilu_userow = $rezultat->num_rows;
			if($ilu_userow>0)
			{
				$wiersz = $rezultat->fetch_assoc();
                    $ip = $_SERVER["REMOTE_ADDR"];
                    function ip_details($ip) 
                    {
                     $json = file_get_contents ("https://ipinfo.io/{$ip}/geo");
                    $details = json_decode ($json);
                    return $details;
                    }
                    $data = date("Y-m-d H:i:s");
                    $dataerr == 0;
                    $iperr == 0;
                    $l_prob = 0;
                    $login = $_POST['login'];
				if (password_verify($haslo, $wiersz['pass']))
				{
                     $result = mysqli_query ($polaczenie, "SELECT * FROM uzytkownicy");
					$_SESSION['zalogowany1'] = true;
					$_SESSION['id'] = $wiersz['id'];
					$_SESSION['user'] = $wiersz['uzytkownik'];	
                    $_SESSION['imie1'] = $wiersz['imie'];
					$_SESSION['nazwisko1'] = $wiersz['nazwisko'];
                    mysqli_query($polaczenie, "UPDATE logowanie SET datagodz = '$data', ip = '$ip', proby = '$l_prob' WHERE nazwa = '$login' AND iperror = ''"); 
                    mysqli_query($polaczenie, "DELETE FROM logowanie WHERE nazwa = '$login' AND iperror != ''"); 
                        $rezultat->free_result();
					header('Location: chmura.php');
				}
		    	else 
				{
                    $polaczenie->query("INSERT INTO logowanie VALUES (NULL, '$login', '$dataerr', '$iperr', '$l_prob', CURRENT_TIMESTAMP, '$ip', 0)");  
                    $rezulta2 = mysqli_query($polaczenie, "SELECT count(`proby`) as wszystkie_proby FROM `logowanie`  WHERE `ip` ='' AND nazwa = '$login' ");
                    $wiersz1=mysqli_fetch_assoc($rezulta2);
                    $w_p = $wiersz1['wszystkie_proby'];
                    mysqli_query($polaczenie, "UPDATE logowanie SET proby = '$w_p', ostatnia_proba = NOW() WHERE nazwa = '$login' AND iperror = '' "); 
                    $rezulta2->free_result();               
                    $pozost = 3 - $w_p;
					
					
					$rezultat3=mysqli_query($polaczenie, "SELECT COUNT( * ) AS ban FROM logowanie WHERE nazwa LIKE '$login' AND (datagodz - ostatnia_proba) <120");
					$wiersz2=mysqli_fetch_assoc($rezultat3);
					$blad = $wiersz2['ban'];
					if ($blad>=4)
					{
						echo 'Ban na 2min!';
					}
					else{
					$_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło! || Pozostało ci '.$pozost.' prób</span>';
                    header('Location: index.php');
					}
                }
			}
		    else {
				$_SESSION['blad'] = '<span style="color:red">Nie ma tatakiego użytkownika!</span>';
				header('Location: index.php');
			}	
		}	
		$polaczenie->close();
	}
	
?>