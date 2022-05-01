<?php
session_start();

if(!isset($_SESSION['loggedU_id']) && !isset($_SESSION['loggedR_id']))
{
	header('Location: ../index.php');
	exit();
}
else
{
	require_once '../database.php';
	
	if(!isset($_SESSION['loggedR_id']))
	{
		$imie = $_SESSION['imie'];
		$nazwisko = $_SESSION['nazwisko'];
		$klasa = $_SESSION['klasa'];
		$id_klasy = $_SESSION['id_klasy'];
		$id_ucznia = $_SESSION['loggedU_id'];
		
		$FTeacherQuery = $db -> prepare("SELECT n.imie, n.nazwisko FROM nauczyciele as n, klasy as k WHERE id_klasy = '$id_klasy' and n.id_nauczyciela = k.id_wychowawcy");
		$FTeacherQuery -> execute();
		$FTeacher = $FTeacherQuery -> fetch();
		
		$_SESSION['imie_wych'] = $FTeacher['imie'];
		$_SESSION['nazwisko_wych'] = $FTeacher['nazwisko'];
	}
	else
	{
		if(isset($_POST['uczen']))
			$_SESSION['ktoryNow'] = $_POST['uczen'];
		
		for($i = 0; $i<=$_SESSION['ktory']; $i++)
		{
			if($_SESSION['ktoryNow']==$i)
			{	
				$imie = $_SESSION['imie'][$i];
				$nazwisko = $_SESSION['nazwisko'][$i];
				$klasa = $_SESSION['klasa'][$i];
				$id_klasy = $_SESSION['id_klasy'][$i];
				$id_ucznia = $_SESSION['loggedU_id'][$i];
			
				$FTeacherQuery = $db -> prepare("SELECT n.imie, n.nazwisko FROM nauczyciele as n, klasy as k WHERE id_klasy = '$id_klasy' and n.id_nauczyciela = k.id_wychowawcy");
				$FTeacherQuery -> execute();
				$FTeacher = $FTeacherQuery -> fetch();
				
				$_SESSION['imie_wych'] = $FTeacher['imie'];
				$_SESSION['nazwisko_wych'] = $FTeacher['nazwisko'];
				
				break;
			}
		}
	}
	
	$SchoolQuery = $db -> prepare("SELECT * FROM szkola");
	$SchoolQuery -> execute();
	$School = $SchoolQuery -> fetch();
	
	$_SESSION['nazwa_sz'] = $School['nazwa'];
	$_SESSION['adres_sz'] = $School['adres'];
	$_SESSION['tel_sz'] = $School['telefon'];
	$_SESSION['imie_dyr'] = $School['imie_dyr'];
	$_SESSION['nazwisko_dyr'] = $School['nazwisko_dyr'];
	
	$subjectsQuery = $db -> prepare("SELECT p.nazwa_cala, n.imie, n.nazwisko FROM nauczyciele as n, przedmioty as p WHERE n.id_przedmiotu = p.id_przedmiotu");
	$subjectsQuery -> execute();
	$subjects = $subjectsQuery -> fetchAll();

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

    <link rel="stylesheet" href="../style.css">
	<link href="https://fonts.googleapis.com/css?family=Lato&amp;subset=latin-ext" rel="stylesheet"> 
	<link href='http://fonts.googleapis.com/css?family=Amita&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

</head>

<body>
	<a href="../dziennik_u.php"><h1 class="powrot" style="">eDziennik</h1></a><div id="logout"><a href="logout.php">Wyloguj się</a></div>
	<div style="clear: both;"></div>

    <div class="container" style="width: 650px; text-align: left;">

        <header class="kafelekH">
			<h2 style="border: none; float:left;">Szkoła i nauczyciele</h2>
				
			<?php
			if(!isset($_SESSION['loggedR_id']))
			{
				echo '<div id="osoba" style="float:right; font-size: 16px; padding-top:28px;">'. $_SESSION['klasa'] . ' - ' . $_SESSION['imie'] . ' ' . $_SESSION['nazwisko'].'</div>';
			}
			else
			{
				echo '<form method="post" action="" style="float:right;" onchange="this.submit()">';
					echo '<select name="uczen" id="ucz" style="font-size: 16px; margin-top: 25px;">';

						for($i = 0; $i<=$_SESSION['ktory']; $i++)
						{
							echo '<option value='.$i.'>'.$_SESSION['klasa'][$i].' - '.$_SESSION['imie'][$i].' '.$_SESSION['nazwisko'][$i].'</option>';
						}

					echo '</select>';
				echo '</form>';
		
				echo '<script type="text/javascript">';
					echo 'document.getElementById("ucz").value = "'. $_SESSION["ktoryNow"].'"';
				echo '</script>';	
			}
			?>
				
			<div style="clear: both;"></div>
        </header>
		
		<main>
            <article>
				<?php
				echo '<div class="dane">';
					echo '<h3 style="border:none; padding-bottom:15px; padding-top:20px;"><div class='.'"data" style="color: #82b74b; font-size: 20px;">Szkoła</div></h3>';
					echo '<div class="rek1b"><div class='.'"rek2b"'.'style="float:left">Nazwa szkoły</div><div class="rek3b" style="float:left">'.$_SESSION['nazwa_sz'].'</div> <div style="clear: both;"></div> </div>';
					echo '<div class="rek1b"><div class='.'"rek2b"'.'style="float:left">Adres szkoły</div><div class="rek3b" style="float:left">'.$_SESSION['adres_sz'].'</div> <div style="clear: both;"></div> </div>';
					echo '<div class="rek1b"><div class='.'"rek2b"'.'style="float:left">Telefon</div><div class="rek3b" style="float:left">'.$_SESSION['tel_sz'].'</div> <div style="clear: both;"></div> </div>';
					echo '<div class="rek1b" style="border-bottom:1px solid grey; padding-bottom:25px;"><div class='.'"rek2b"'.'style="float:left">Imię i nazwisko dyrektora</div><div class="rek3b" style="float:left">'.$_SESSION['imie_dyr'].' '.$_SESSION['nazwisko_dyr'].'</div> <div style="clear: both;"></div> </div>';
				echo '</div><br>';
				
				echo '<div class="dane">';
					echo '<h3 style="border:none; padding-bottom:15px; padding-top:20px;"><div class='.'"data" style="color: #82b74b; font-size: 20px;">Nauczyciele</div></h3>';
					echo '<div class="rek1b"><div class='.'"rek2b"'.'style="float:left">Wychowawca</div><div class="rek3b" style="float:left">'.$_SESSION['imie_wych'].' '.$_SESSION['nazwisko_wych'].'</div> <div style="clear: both;"></div> </div>';
					foreach($subjects as $subject)
					{
						echo '<div class="rek1b"><div class='.'"rek2b"'.'style="float:left">'.$subject["nazwa_cala"].'</div><div class="rek3b" style="float:left">'.$subject["imie"].' '.$subject["nazwisko"].'</div> <div style="clear: both;"></div> </div>';
					}
				echo '</div><br>';
			?>

			</article>
        </main>
	</div>
</body>
</html>