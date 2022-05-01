<?php

session_start();

if(isset($_POST['email_log']))
{
	// Sprawdzanie poprawności adresu e-mail
	$email = filter_input(INPUT_POST, 'email_log', FILTER_VALIDATE_EMAIL);
	
	if (empty($email)) {  // Niepoprawny email
		
		// Zapamiętanie danych
		$_SESSION['e_email'] = $_POST['email_log'];
		
		$_SESSION['err_email'] = "Niepoprawny email lub hasło";
		header('Location: index.php');
		exit();
		
	} else {  // Poprawny składniowo email
		
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
			
			if(!$emailRep)
			{
				// Sprawdzenie czy wprowadzony email jest w bazie rodziców
				$emailQuery = $db -> prepare('SELECT id_rodzica FROM rodzice WHERE email = :emailR');
				$emailQuery -> bindValue(':emailR', $email, PDO::PARAM_STR);
				$emailQuery -> execute();
				
				$emailRep = $emailQuery -> fetch();
				
				if (!$emailRep)  // email nie jest zarejestrowany w żadnej bazie
				{
					$_SESSION['e_email'] = $_POST['email_log'];
					$_SESSION['err_email'] = "Niepoprawny email lub hasło";
					header('Location: index.php');
					exit();
				}
				else   // email jest w bazie rodziców
				{
					// czy konto posiada hasło - rodzic
					$idRodzica = $emailRep['id_rodzica'];
					$passQuery = $db -> prepare("SELECT haslo FROM hasla WHERE id_usera = '$idRodzica' and typ_usera = 'r'");
					$passQuery -> execute();
					
					$passRep = $passQuery -> fetch();
					
					if($passRep)  // konto jest zarejestrowane
					{
						if(password_verify($_POST['haslo'], $passRep['haslo']))  // poprawne hasło - UDANE LOGOWANIE
						{
							$_SESSION['loggedR_id'] = $idRodzica;
							header('Location: dziennik_u.php');
							exit();
						}
						else  // Niepoprawne hasło
						{
							$_SESSION['e_email'] = $_POST['email_log'];
							$_SESSION['err_email'] = "Niepoprawny email lub hasło";
							header('Location: index.php');
							exit();
						}
					}
					else  // Konto nie jest zarejestrowane
					{
						$_SESSION['e_email'] = $_POST['email_log'];
						$_SESSION['email_reg'] = "Konto nie jest zarejestowane";
						header('Location: index.php');
						exit();					
					}
				}
			}
			else  // email jest w bazie nauczycieli
			{
				// czy konto posiada hasło - nauczyciel
				$idNauczyciela = $emailRep['id_nauczyciela'];
				$passQuery = $db -> prepare("SELECT haslo FROM hasla WHERE id_usera = '$idNauczyciela' and typ_usera = 'n'");
				$passQuery -> execute();
				
				$passRep = $passQuery -> fetch();
				
				if($passRep)  // konto jest zarejestrowane
				{
					if(password_verify($_POST['haslo'], $passRep['haslo']))  // poprawne hasło - UDANE LOGOWANIE
					{
						$_SESSION['loggedN_id'] = $idNauczyciela;
						header('Location: dziennik_n.php');
						exit();
					}
					else  // Niepoprawne hasło
					{
						$_SESSION['e_email'] = $_POST['email_log'];
						$_SESSION['err_email'] = "Niepoprawny email lub hasło";
						header('Location: index.php');
						exit();
					}
				}
				else  // Konto nie jest zarejestrowane
				{
					$_SESSION['e_email'] = $_POST['email_log'];
					$_SESSION['email_reg'] = "Konto nie jest zarejestowane";
					header('Location: index.php');
					exit();					
				}
			}
		}
		
		else // email jest w bazie uczniow
		{
			// czy konto posiada hasło - uczen
			$idUcznia = $emailRep['id_ucznia'];
			$passQuery = $db -> prepare("SELECT haslo FROM hasla WHERE id_usera = '$idUcznia' and typ_usera = 'u'");
			$passQuery -> execute();
			
			$passRep = $passQuery -> fetch();
			
			if($passRep)  // konto jest zarejestrowane
			{
				if(password_verify($_POST['haslo'], $passRep['haslo']))  // poprawne hasło - UDANE LOGOWANIE
					{
						$_SESSION['loggedU_id'] = $idUcznia;
						header('Location: dziennik_u.php');
						exit();
					}
					else  // Niepoprawne hasło
					{
						$_SESSION['e_email'] = $_POST['email_log'];
						$_SESSION['err_email'] = "Niepoprawny email lub hasło";
						header('Location: index.php');
						exit();
					}
			}
			else  // Konto nie jest zarejestrowane
			{
				$_SESSION['e_email'] = $_POST['email_log'];
				$_SESSION['email_reg'] = "Konto nie jest zarejestowane";
				header('Location: index.php');
				exit();
			}
		}
	}
}
else
{
	header ('Location: index.php');
}