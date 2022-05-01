<?php
session_start();


if((isset($_SESSION['registerU_id'])) || (isset($_SESSION['registerN_id'])) || (isset($_SESSION['registerR_id'])))
{
	if(isset($_POST['imie']))
	{
		$imie = filter_input(INPUT_POST, 'imie');
		$nazwisko = filter_input(INPUT_POST, 'nazwisko');
		$pesel = filter_input(INPUT_POST, 'pesel');
		$data_ur = filter_input(INPUT_POST, 'data_ur');
		$miejsce_ur = filter_input(INPUT_POST, 'miejsce_ur');
		$miejsce_zam = filter_input(INPUT_POST, 'miejsce_zam');
		$telefon = filter_input(INPUT_POST, 'telefon');
		
		require_once 'database.php';
		
		//$OK = false;
		
		//  Formularz ucznia
		if(isset($_SESSION['registerU_id']))
		{
			$uczen_id = $_SESSION['registerU_id'];
			unset($_SESSION['registerU_id']);
			$dataQuery = $db -> prepare("SELECT * FROM uczniowie WHERE id_ucznia = '$uczen_id'");
			$dataQuery -> execute();
			
			$dataUczen = $dataQuery -> fetch();
			
			if($dataUczen['imie'] == $imie && $dataUczen['nazwisko'] == $nazwisko &&
				$dataUczen['PESEL'] == $pesel && $dataUczen['data_ur'] == $data_ur &&
				$dataUczen['miejsce_ur'] == $miejsce_ur && $dataUczen['miejsce_zam'] == $miejsce_zam &&
				$dataUczen['telefon'] == $telefon)
			{
				$haslo = uniqid();
				$_SESSION['haslo'] = $haslo;
				$haslo_hash = password_hash($haslo, PASSWORD_DEFAULT);
				$id_ucznia = $dataUczen['id_ucznia'];
				$db -> exec("INSERT INTO hasla VALUES (NULL, '$id_ucznia', '$haslo_hash', '$haslo', 'u')");
				
				// W tym miejscu zostałby wysłany e-mail z hasłem dla użytkownika (ja podam go bezpośrednio po przejściu do innej podstrony)
				
				header ('Location: zarejestrowano.php');
				exit();
			}
			else
			{
				$_SESSION['err_data'] = "Niepoprawne dane!";
			}
		}
		
		//  Formularz nauczyciela
		else if(isset($_SESSION['registerN_id']))
		{
			$nauczyciel_id = $_SESSION['registerN_id'];
			unset($_SESSION['registerN_id']);
			$dataQuery = $db -> prepare("SELECT * FROM nauczyciele WHERE id_nauczyciela = '$nauczyciel_id'");
			$dataQuery -> execute();
			
			$dataNauczyciel = $dataQuery -> fetch();
			
			if($dataNauczyciel['imie'] == $imie && $dataNauczyciel['nazwisko'] == $nazwisko &&
				$dataNauczyciel['PESEL'] == $pesel && $dataNauczyciel['data_ur'] == $data_ur &&
				$dataNauczyciel['miejsce_ur'] == $miejsce_ur && $dataNauczyciel['miejsce_zam'] == $miejsce_zam &&
				$dataNauczyciel['telefon'] == $telefon)
			{
				unset($_SESSION['err_data']);
				$haslo = uniqid();
				$_SESSION['haslo'] = $haslo;
				$haslo_hash = password_hash($haslo, PASSWORD_DEFAULT);
				$id_nauczyciela = $dataNauczyciel['id_nauczyciela'];
				$db -> exec("INSERT INTO hasla VALUES (NULL, '$id_nauczyciela', '$haslo_hash', '$haslo', 'n')");
				
				// W tym miejscu zostałby wysłany e-mail z hasłem dla użytkownika (ja podam go bezpośrednio po przejściu do innej podstrony)
				
				header ('Location: zarejestrowano.php');
				exit();
			}
			else
			{
				$_SESSION['err_data'] = "Niepoprawne dane!";
			}
		}
		
		//  Formularz rodzica
		else if(isset($_SESSION['registerR_id']))
		{
			$rodzic_id = $_SESSION['registerR_id'];
			unset($_SESSION['registerR_id']);
			$dataQuery = $db -> prepare("SELECT * FROM rodzice WHERE id_rodzica = '$rodzic_id'");
			$dataQuery -> execute();
			
			$dataRodzic = $dataQuery -> fetch();
			
			if($dataRodzic['imie'] == $imie && $dataRodzic['nazwisko'] == $nazwisko &&
				$dataRodzic['PESEL'] == $pesel && $dataRodzic['data_ur'] == $data_ur &&
				$dataRodzic['miejsce_ur'] == $miejsce_ur && $dataRodzic['miejsce_zam'] == $miejsce_zam &&
				$dataRodzic['telefon'] == $telefon)
			{
				unset($_SESSION['err_data']);
				$haslo = uniqid();
				$_SESSION['haslo'] = $haslo;
				$haslo_hash = password_hash($haslo, PASSWORD_DEFAULT);
				$id_rodzica = $dataRodzic['id_rodzica'];
				$db -> exec("INSERT INTO hasla VALUES (NULL, '$id_rodzica', '$haslo_hash', '$haslo', 'r')");
				
				// W tym miejscu zostałby wysłany e-mail z hasłem dla użytkownika (ja podam go bezpośrednio po przejściu do innej podstrony)
				
				header ('Location: zarejestrowano.php');
				exit();
			}
			else
			{
				$_SESSION['err_data'] = "Niepoprawne dane!";
			}
		}
	
	}
}
else
{
	header ('Location: rejestracja.php');
	exit();
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

</head>

<body>
    <div class="container" style="width: 530px; text-align: left;">

        <header>
            <h1>eDziennik</h1>
			<h2>Rejestracja</h2> <h3>Potwierdź swoje dane</h3>
        </header>
		
		<main>
            <article>
			<br>
			<p> <?= isset($_SESSION['err_data']) ? $_SESSION['err_data'] : ""  ?> </p>
				<form method="post" >
                    <label>Imię<br>
                        <input type="text" name="imie" >
                    </label> <br>
					<label>Nazwisko<br>
                        <input type="text" name="nazwisko" >
                    </label> <br>
					<label>PESEL<br>
                        <input type="text" name="pesel" >
                    </label> <br>
					<label>Data urodzenia<br>
                        <input type="date" name="data_ur" >
                    </label> <br>
					<label>Miejsce urodzenia<br>
                        <input type="text" name="miejsce_ur" >
                    </label> <br>
					<label>Miejsce zamieszkania<br>
                        <input type="text" name="miejsce_zam" >
                    </label><br>
					<label>Telefon<br>
                        <input type="tel" name="telefon" >
                    </label> 
                    <p><input type="submit" value="Zarejestruj się!" style="margin-top: 20px;"></p>
					
                </form>
			</article>
        </main>
	</div>
</body>
</html>