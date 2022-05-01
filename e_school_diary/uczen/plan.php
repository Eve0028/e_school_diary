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
		$id_ucznia = $_SESSION['loggedU_id'];
		$id_klasy = $_SESSION['id_klasy'];
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
				$id_ucznia = $_SESSION['loggedU_id'][$i];
				$id_klasy = $_SESSION['id_klasy'][$i];
				
				break;
			}
		}
	}
	
	$hoursQuery = $db -> prepare("SELECT nr_lekcji, left(godz_roz, 5) as godz_roz, left(godz_zak, 5) as godz_zak FROM godz_lekcyjne");
	$hoursQuery -> execute();
	$hours = $hoursQuery -> fetchAll();
	
	$daysQuery = $db -> prepare("SELECT nr_dnia, ucase(dzien) as dzien FROM nazwy_dni");
	$daysQuery -> execute();
	$days = $daysQuery -> fetchAll();
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

    <div class="container" style="width: 840px; text-align: left;">

        <header class="kafelekH">
			<h2 style="border: none; float:left;">Plan zajęć</h2>
				
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
			<br>
				<table>
					<thead style="color:#82b74b !important;">
						<tr class="naglowek">
							<th class="lekcja">LEKCJA</th>
							<?php foreach($days as $day){ echo '<th class="lekcja">'.$day['dzien'].'</th>'; }?>
						</tr>
					</thead>
					<tbody>
						<?php
							foreach($hours as $hour)
							{
								echo '<tr><td class="lekcja">' .$hour['nr_lekcji'] .'<br>'. $hour['godz_roz'] .'<br>' .$hour['godz_zak']. '</td>';
								$lessonNr = $hour['nr_lekcji'];
								
								foreach($days as $day)
								{
									$dayNr = $day['nr_dnia'];
								
									$lessonQuery = $db -> prepare("SELECT p.nazwa as nazwa_p, p.nazwa_cala, s.nazwa as nazwa_s FROM przedmioty as p, plan_lekcji as p_l, sale as s, klasy as k, nauczyciele as n WHERE p_l.id_klasy = $id_klasy and p_l.nr_dnia = $dayNr and p_l.nr_lekcji = $lessonNr and p_l.id_sali = s.id_sali and p_l.id_nauczyciela = n.id_nauczyciela and n.id_przedmiotu = p.id_przedmiotu");
									$lessonQuery -> execute();
									$lesson = $lessonQuery -> fetch();

									echo '<td>';
									if(isset($lesson['nazwa_cala']))
									{
										echo $lesson['nazwa_cala'].'<br>'.$lesson['nazwa_s'];
									}
									echo '</td>';
								}
								echo '</tr>';
							}
						?>
					</tbody>
				</table>
				
			</article>
        </main>
	</div>
</body>
</html>