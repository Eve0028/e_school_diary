<?php
session_start();

if(!isset($_SESSION['loggedU_id']) && !isset($_SESSION['loggedR_id']))
{
	header('Location: index.php');
	exit();
}
{
	require_once 'database.php';
	
	if(!isset($_SESSION['loggedR_id']))
	{
		$id_ucznia = $_SESSION['loggedU_id'];
		$uczenQuery = $db -> prepare("SELECT u.*, k.nazwa_klasy FROM uczniowie as u, klasy as k WHERE id_ucznia = '$id_ucznia' and k.id_klasy = u.id_klasy");
		$uczenQuery -> execute();
		
		$uczenRep = $uczenQuery -> fetch();
		
		$id_rodzica = $uczenRep['id_rodzica'];
		
		$_SESSION['imie'] = $uczenRep['imie'];
		$_SESSION['nazwisko'] = $uczenRep['nazwisko'];
		$_SESSION['pesel'] = $uczenRep['PESEL'];
		$_SESSION['data_ur'] = $uczenRep['data_ur'];
		$_SESSION['miejsce_ur'] = $uczenRep['miejsce_ur'];
		$_SESSION['miejsce_zam'] = $uczenRep['miejsce_zam'];
		$_SESSION['telefon'] = $uczenRep['telefon'];
		$_SESSION['email'] = $uczenRep['email'];
		$_SESSION['id_klasy'] = $uczenRep['id_klasy'];
		$_SESSION['id_rodzica'] = $uczenRep['id_rodzica'];
		$_SESSION['plec'] = $uczenRep['plec'];
		$_SESSION['klasa'] = $uczenRep['nazwa_klasy'];
	}
	else
	{
		$_SESSION['ktoryNow'] = 0;
		
		$_SESSION['id_rodzica'] = $_SESSION['loggedR_id'];
		$rodzicQuery = $db -> prepare("SELECT u.*, k.nazwa_klasy FROM uczniowie as u, rodzice as r, klasy as k WHERE u.id_rodzica = '{$_SESSION['id_rodzica']}' and u.id_rodzica = r.id_rodzica and k.id_klasy = u.id_klasy");
		$rodzicQuery -> execute();
		
		$uczniowie = $rodzicQuery -> fetchAll();
		
		$ktory=0;
		foreach($uczniowie as $uczen)
		{
			$_SESSION['loggedU_id'][$ktory] = $uczen['id_ucznia'];
			//echo $_SESSION['loggedU_id'][$ktory].' ';
			
			$_SESSION['imie'][$ktory] = $uczen['imie'];
			$_SESSION['nazwisko'][$ktory] = $uczen['nazwisko'];
			$_SESSION['pesel'][$ktory] = $uczen['PESEL'];
			$_SESSION['data_ur'][$ktory] = $uczen['data_ur'];
			$_SESSION['miejsce_ur'][$ktory] = $uczen['miejsce_ur'];
			$_SESSION['miejsce_zam'][$ktory] = $uczen['miejsce_zam'];
			$_SESSION['telefon'][$ktory] = $uczen['telefon'];
			$_SESSION['email'][$ktory] = $uczen['email'];
			$_SESSION['id_klasy'][$ktory] = $uczen['id_klasy'];
			$_SESSION['plec'][$ktory] = $uczen['plec'];
			$_SESSION['klasa'][$ktory] = $uczen['nazwa_klasy'];
			
			$ktory++;
		}
		$ktory--;
		$_SESSION['ktory'] = $ktory;
		
		$rodzicQuery = $db -> prepare("SELECT r.imie, r.nazwisko FROM uczniowie as u, rodzice as r WHERE u.id_rodzica = '{$_SESSION['id_rodzica']}' and u.id_rodzica = r.id_rodzica");
		$rodzicQuery -> execute();
		
		$uczniowie = $rodzicQuery -> fetch();
		
		$_SESSION['imie_r'] = $uczniowie['imie'];
		$_SESSION['nazwisko_r'] = $uczniowie['nazwisko'];
	}
	
}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <title>eDziennik</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	
    <meta name="description" content="Funkcjonowanie dziennika elektronicznego">
    <meta name="keywords" content="edziennik, dziennik elektroniczny, szkoła, uczen, nauczyciel,">
    <meta http-equiv="X-Ua-Compatible" content="IE=edge">

    <link rel="stylesheet" href="style_d.css">
	<link href="https://fonts.googleapis.com/css?family=Lato&amp;subset=latin-ext" rel="stylesheet"> 
	<link href='http://fonts.googleapis.com/css?family=Amita&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

</head>

<body>

	<div id="logout"><a href="logout.php">Wyloguj się</a></div>
	<div style="clear: both;"></div>
	
    <div class="container">
	
			<header>
				<h1>eDziennik</h1>
				<div id="osoba"><?php if(isset($_SESSION['loggedR_id'])) echo $_SESSION['imie_r'] . " " . $_SESSION['nazwisko_r'];
					else echo $_SESSION['klasa'] . " - " . $_SESSION['imie'] . " " . $_SESSION['nazwisko'];
				?></div>
			</header>
			
			<div class="mob2 mob3"></div>
			<a href="uczen/oceny.php"><div class="kafelek" style="background-color: #85bdb4"><div class="kaf">Oceny</div> <img src="img/scores.png" width="80px" heigth="80px" /></div></a>
			<div class="mob2_cb mob3"></div>
			<a href="uczen/frekwencja.php"><div class="kafelek" style="background-color: #82b74b"><div class="kaf" style="margin-bottom: 10px;">Frekwencja</div> <img src="img/survey.png" width="82px" heigth="80px" /></div></a>
			<div class="clearBoth mob2_fl mob3"></div>
			
			<a href="uczen/uwagi.php"><div class="kafelek" style="background-color: #ffcc5c;" ><div class="kaf" style="color: #444444; border-bottom: 1px dotted #444444;">Uwagi</div> <img src="img/warning.png" width="75px" heigth="80px" style="padding-top: 5px;"/></div></a>
			<div class="mob2_cb mob3"></div>
			<a href="uczen/wykres.php"><div class="kafelek" style="background-color: #ff6f69"><div class="kaf">Na tle klasy</div> <img src="img/bar-chart.png" width="77px" heigth="80px" style="padding-top: 3px;" /></div></a>
			<div class="mob2 mob3"></div>
			<a href="uczen/dane.php"><div class="kafelek " style="background-color: #ffcc5c"><div class="kaf" style="color: #444444; border-bottom: 1px dotted #444444;">Dane osobowe</div> <img src="img/resume.png" width="77px" heigth="80px" style="padding-left: 18px; padding-top: 3px;" /></div></a>
			<div class="clearBoth mob2_cb mob3" style="clear: both;"></div>
			
			<a href="uczen/plan.php"><div class="kafelek" style="background-color: #85bdb4;"><div class="kaf">Plan zajęć</div> <img src="img/small-calendar.png" width="77px" heigth="80px" style="padding-top: 3px;" /></div></a>
			<div class="mob2 mob3"></div>
			<a href="uczen/sprawdziany.php"><div class="kafelek" style="background-color: #82b74b"><div class="kaf">Sprawdziany</div> <img src="img/open-book.png" width="80px" heigth="80px" /></div></a>
			<div class="mob2_cb mob3"></div>
			<a href="uczen/szkola.php"><div class="kafelek" style="background-color: #ff6f69"><div class="kaf">Szkoła i nauczyciele</div> <img src="img/briefcase.png" width="82px" heigth="80px" /></div></a>
			<div style="clear: both;"></div>

	</div>
	<div>Icons made by <a href="https://www.flaticon.com/authors/those-icons" title="Those Icons">Those Icons</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a></div>
</body>
</html>