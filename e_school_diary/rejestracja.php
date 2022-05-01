<?php
session_start();

if(isset($_POST['email']))
{

	// Sprawdzanie poprawności adresu e-mail
	$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
	
	if (empty($email)) {
		
		// Zapamiętanie danych
		$_SESSION['e_email'] = $_POST['email'];
		
		$_SESSION['err_email'] = "Wprowadź poprawny adres e-mail";
		
	} else {
		
		require_once 'database.php';
		
		// Sprawdzenie czy wprowadzony email jest w bazie uczniow
		$emailQuery = $db -> prepare('SELECT id_ucznia FROM uczniowie WHERE email = :emailR');
		$emailQuery -> bindValue(':emailR', $email, PDO::PARAM_STR);
		$emailQuery -> execute();
		
		$emailRep = $emailQuery -> fetch();
		
		if (!$emailRep)
		{
			// Sprawdzenie czy wprowadzony email jest w bazie nauczycieli
			$emailQuery = $db -> prepare('SELECT id_nauczyciela FROM nauczyciele WHERE email = :emailR');
			$emailQuery -> bindValue(':emailR', $email, PDO::PARAM_STR);
			$emailQuery -> execute();
			
			$emailRep = $emailQuery -> fetch();
			
			if (!$emailRep)
			{
				// Sprawdzenie czy wprowadzony email jest w bazie rodziców
				$emailQuery = $db -> prepare('SELECT id_rodzica FROM rodzice WHERE email = :emailR');
				$emailQuery -> bindValue(':emailR', $email, PDO::PARAM_STR);
				$emailQuery -> execute();
				
				$emailRep = $emailQuery -> fetch();
				
				if (!$emailRep)  // email nie jest zarejestrowany w żadnej bazie
				{
					$_SESSION['e_email'] = $_POST['email'];
					$_SESSION['err_email'] = "Wprowadź poprawny adres e-mail";
				}
				else  // email jest w bazie rodziców
				{
					// czy konto posiada hasło - rodzic
					$idRodzica = $emailRep['id_rodzica'];
					$passQuery = $db -> prepare("SELECT id_usera FROM hasla WHERE id_usera = '$idRodzica' and typ_usera = 'r'");
					$passQuery -> execute();
					
					$passRep = $passQuery -> fetch();
					
					if($passRep)  // konto jest już zarejestrowane
					{
						$_SESSION['e_email'] = $_POST['email'];
						$_SESSION['email_empty'] = "Istnieje już konto z podanym adresem e-mail";		
					}
					else  // Udało się - Przejście do formularza potwierdzania danych (rodzic)
					{
						$_SESSION['registerR_id'] = $emailRep['id_rodzica'];
					}
				}
			}
			else  // email jest w bazie nauczycieli
			{
				// czy konto posiada hasło - nauczyciel
				$idNauczyciela = $emailRep['id_nauczyciela'];
				$passQuery = $db -> prepare("SELECT id_usera FROM hasla WHERE id_usera = '$idNauczyciela' and typ_usera = 'n'");
				$passQuery -> execute();
				
				$passRep = $passQuery -> fetch();
				
				if($passRep)  // konto jest już zarejestrowane
				{
					$_SESSION['e_email'] = $_POST['email'];
					$_SESSION['email_empty'] = "Istnieje już konto z podanym adresem e-mail";		
				}
				else  // Udało się - Przejście do formularza potwierdzania danych (nauczyciel)
				{
					$_SESSION['registerN_id'] = $emailRep['id_nauczyciela'];
				}
			}
		}
		else // email jest w bazie uczniow
		{
			// czy konto posiada hasło - uczen
			$idUcznia = $emailRep['id_ucznia'];
			$passQuery = $db -> prepare("SELECT id_usera FROM hasla WHERE id_usera = '$idUcznia' and typ_usera = 'u'");
			$passQuery -> execute();
			
			$passRep = $passQuery -> fetch();
			
			if($passRep)  // konto jest już zarejestrowane
			{
				$_SESSION['e_email'] = $_POST['email'];
				$_SESSION['email_empty'] = "Istnieje już konto z podanym adresem e-mail";		
			}
			else  // Udało się - Przejście do formularza potwierdzania danych (uczen)
			{
				$_SESSION['registerU_id'] = $emailRep['id_ucznia'];
			}
		}
		
		//Czy jest zaznaczona reCAPTCHA
		/*$sekret = "6LeF8ZwUAAAAAMLWk65sLKaA7uG1mI97xRFSzrRe";
			
		$sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);
			
		$odpowiedz = json_decode($sprawdz);
			
		if($odpowiedz->success==false)
		{
			$_SESSION['e_email'] = $_POST['email'];
			$_SESSION['err_bot'] = "Zaznacz, że nie jesteś botem";
		}
		else
		{*/
			
		//}
	}
	
	if(!isset($_SESSION['e_email']))  // Rejestracja powiodła się - przeniesienie do potwierdzenia danych
	{
		header('Location: formularz_r.php');
		exit();
	}
	
} 

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <title>eDziennik</title>
    <meta name="description" content="Funkcjonowanie dziennika elektronicznego">
    <meta name="keywords" content="edziennik, dziennik elektroniczny, szkoła, uczen, nauczyciel,">
    <meta http-equiv="X-Ua-Compatible" content="IE=edge">

    <link rel="stylesheet" href="style.css">
	<link href="https://fonts.googleapis.com/css?family=Lato&amp;subset=latin-ext" rel="stylesheet"> 
	<link href='http://fonts.googleapis.com/css?family=Amita&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>

</head>

<body>
    <div class="container" style="margin-top: 80px;">

        <header>
            <h1>eDziennik</h1>
        </header>
		
		<main>
            <article>
				<form method="post">
                    <label>Podaj adres e-mail
                        <input type="email" name="email" <?=
						isset($_SESSION['e_email']) ? 'value="'.$_SESSION['e_email']. '"' : ""
						?>>
                    </label>
					<div class="g-recaptcha" data-sitekey="6LeF8ZwUAAAAAKv3T1ojd5M_l13f_Ks6fL2Z_T23"></div>
                    <input type="submit" value="Zarejestruj się!">
					
					<?php
						
						if (isset($_SESSION['e_email'])) {
							if (isset($_SESSION['err_email'])) {
								echo "<p>{$_SESSION['err_email']}</p>";
								unset($_SESSION['err_email']);
							}
							
							else if (isset($_SESSION['email_empty'])) {
								echo "<p>{$_SESSION['email_empty']}</p>";
								unset($_SESSION['email_empty']);
							}
							
							else if (isset($_SESSION['err_bot'])) {
								echo "<p>{$_SESSION['err_bot']}</p>";
								unset($_SESSION['err_bot']);
							}
							unset($_SESSION['e_email']);
						}
						
					?>
					
                </form>
				<p><a class="green" href="index.php">Zaloguj się</a></p>
         </article>
        </main>
	</div>
</body>
</html>