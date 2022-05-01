<?php
session_start();

if(!isset($_SESSION['loggedU_id']) && !isset($_SESSION['loggedR_id']))
{
	header('Location: ../index.php');
	exit();
}
else
{
	
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

	require_once '../database.php';
	
	$daysQuery = $db -> prepare("SELECT nr_dnia, ucase(dzien) as dzien FROM nazwy_dni");
	$daysQuery -> execute();
	$days = $daysQuery -> fetchAll();
	
	$hoursQuery = $db -> prepare("SELECT nr_lekcji, godz_zak FROM godz_lekcyjne");
	$hoursQuery -> execute();
	$hours = $hoursQuery -> fetchAll();

		date_default_timezone_set('GMT');
					
		$dzis = date('N', time());
		$dni[$dzis] = date('d.m.Y', time());
		$dniP[$dzis] = date(time());
		
		if($dzis==6 or $dzis==7)
		{
			for($i = 1; $i<=5; $i++)
			{
				$wstecz = $dzis - $i;
				$dni[$i] = date('d.m.Y', strtotime("-$wstecz day"));
				$dniP[$i] = date(strtotime("-$wstecz day"));
			}
		}
		else
		{
			for($i = 1; $i<$dzis; $i++)
			{
				$wstecz = $dzis - $i;
				$dni[$i] = date('d.m.Y', strtotime("-$wstecz day"));
				$dniP[$i] = date(strtotime("-$wstecz day"));
			}
			for($i = $dzis+1; $i<=5; $i++)
			{
				$wprzod = $i - $dzis;
				$dni[$i] = date('d.m.Y', strtotime("+$wprzod day"));
				$dniP[$i] = date(strtotime("+$wprzod day"));
			}
		}
		
		$tygodnie = 0;
		
		if(isset($_POST['tydz']))
		{
			$tygodnie = $_POST['tydz_ile'];
			
			if($_POST['tydz'] == -7)
				$tygodnie--;
			else
				$tygodnie++;
			
			$ile_dni = 7*$tygodnie;
			
			for($i = 1; $i<=5; $i++)
			{
				$dniP[$i] = date($dniP[$i]);
				$dni[$i] = date('d.m.Y', $dniP[$i]);
				
				$dniP2 = $dniP[$i];
				$dni[$i] = date('d.m.Y', strtotime("$ile_dni day", $dniP2));
				$dniP[$i] = date(strtotime("$ile_dni day", $dniP2));
			}
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

    <link rel="stylesheet" href="../style.css">
	<script src="../script.min.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Lato&amp;subset=latin-ext" rel="stylesheet"> 
	<link href='http://fonts.googleapis.com/css?family=Amita&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

		
	<script type="text/javascript">
		window.onscroll = scroll;

		function scroll() {
			document.getElementById("pozycja_na_stronie").value =
			$("html,body").scrollTop();
			document.getElementById("pozycja_na_stronie2").value =
			$("html,body").scrollTop();
		}
	</script>
</head>

<body>
	<a href="../dziennik_u.php"><h1 class="powrot" style="">eDziennik</h1></a><div id="logout"><a href="logout.php">Wyloguj się</a></div>
	<div style="clear: both;"></div>

    <div class="container" style="width: 840px; text-align: left;">

        <header class="kafelekH">
			<h2 style="border: none; float:left;">Frekwencja</h2>
				
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
				
				<div id="przewin">
					<form method="post">
						<input type="hidden" name="pozycja_na_stronie" id="pozycja_na_stronie" value="0" />
						<input type="hidden" name="tydz" value=-7>
						<input type="hidden" name="tydz_ile" value=<?= $tygodnie ?>>
						<input type="submit" class="innyT" value="&#60; POPRZEDNI TYDZIEŃ" style="float: left;">
					</form>
					<form method="post">
						<input type="hidden" name="pozycja_na_stronie" id="pozycja_na_stronie2" value="0" />
						<input type="hidden" name="tydz" value=7>
						<input type="hidden" name="tydz_ile" value=<?= $tygodnie ?>>
						<input type="submit" class="innyT" value="KOLEJNY TYDZIEŃ &#62;" style="float: right;">
					</form>
					<div style="clear: both;"></div>
				</div>
				
				
				
				<table>
					<thead style="color:#82b74b !important;">
						<tr class="naglowek">
							<th class="lekcja">LEKCJA</th>
							<?php foreach($days as $day){ echo '<th class="lekcja">'.$day['dzien'].'<br>'.$dni[$day['nr_dnia']].'</th>'; }?>
						</tr>
					</thead>
					<tbody>
						<?php
							foreach($hours as $hour)
							{
								echo '<tr><td class="lekcja" style="background-color: white; text-align: left;">' .$hour['nr_lekcji'] .'</td>';
								$lessonNr = $hour['nr_lekcji'];
								
								foreach($days as $day)
								{
									$data = date('Y-m-d', $dniP[$day['nr_dnia']]);
									
									if(($tygodnie==0 && (($dzis<$day['nr_dnia']) || (($dzis==$day['nr_dnia']) && ($hour['godz_zak']>date('H:i:s'))))) || ($tygodnie>0))
										echo '<td></td>';
									else
									{
										$dayNr = $day['nr_dnia'];
									
										$lessonQuery = $db -> prepare("SELECT count(*) as ile, p.nazwa as nazwa_p, p.nazwa_cala, p_l.id_lekcji FROM przedmioty as p, plan_lekcji as p_l, klasy as k, nauczyciele as n WHERE p_l.id_klasy = $id_klasy and p_l.nr_dnia = $dayNr and p_l.nr_lekcji = $lessonNr and p_l.id_nauczyciela = n.id_nauczyciela and n.id_przedmiotu = p.id_przedmiotu");
										$lessonQuery -> execute();
										$lesson = $lessonQuery -> fetch();
										
										$id_lekcji = $lesson['id_lekcji'];
										$frequencyQuery = $db -> prepare("SELECT o.typ, o_n.*, count(*) as ile FROM obecnosci as o, obecnosc_nazwa as o_n WHERE o.id_ucznia = $id_ucznia
										and o.id_lekcji = '$id_lekcji' and o.data = '$data' and o.typ = o_n.typ");
										$frequencyQuery -> execute();
										$frequ = $frequencyQuery -> fetch();
										
										if($frequ['ile']==0 && $lesson['ile']>0)
											echo '<td style="background-color: #eee;"><div class="chmurka">[?]<span>Nieuzupełniona frekwencja</span></div>'.$lesson['nazwa_cala'].'</td>';
										else
											echo '<td style="background-color: '.$frequ['kolor'].';"><div class="chmurka">'.$frequ['skrot'].'<span>'.$frequ['nazwa_cala'].'</span></div>'.$lesson['nazwa_cala'].'</td>';
									}
								}
								echo '</tr>';
							}
						?>
					</tbody>
				</table>
				
			</article>
        </main>
	</div>
	
	<?php
		if (isset($_POST['pozycja_na_stronie'])) {
			echo '<script type="text/javascript">';
			echo ' $("html,body").scrollTop('.$_POST['pozycja_na_stronie'].'); ';
			echo '</script>';
		}
	?>
	
</body>
</html>