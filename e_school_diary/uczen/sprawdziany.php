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
		
		$testsQuery = $db -> prepare("SELECT p.id_przedmiotu, s.id_spr, s.data_spr, dayofweek(s.data_spr) as dzien, p.nazwa_cala, s.rodzaj, n.imie, n.nazwisko, s.data_wpisu FROM sprawdziany as s, przedmioty as p, nauczyciele as n, klasy as k WHERE s.id_klasy = $id_klasy and s.data_spr > date(date_sub(now(), interval 7 day)) and s.id_klasy = k.id_klasy and s.id_przedmiotu = p.id_przedmiotu and s.id_nauczyciela = n.id_nauczyciela ORDER BY s.data_spr");
		$testsQuery -> execute();
				
		$tests = $testsQuery -> fetchAll();
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
			
				$testsQuery = $db -> prepare("SELECT p.id_przedmiotu, s.id_spr, s.data_spr, dayofweek(s.data_spr) as dzien, p.nazwa_cala, s.rodzaj, n.imie, n.nazwisko, s.data_wpisu FROM sprawdziany as s, przedmioty as p, nauczyciele as n, klasy as k WHERE s.id_klasy = $id_klasy and s.data_spr > date(date_sub(now(), interval 7 day)) and s.id_klasy = k.id_klasy and s.id_przedmiotu = p.id_przedmiotu and s.id_nauczyciela = n.id_nauczyciela ORDER BY s.data_spr");
				$testsQuery -> execute();
				
				$tests = $testsQuery -> fetchAll();
				
				break;
			}
		}
	}

	$subjectsQuery = $db -> prepare("SELECT nazwa_cala, id_przedmiotu FROM przedmioty");
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
	<script src="../script.min.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Lato&amp;subset=latin-ext" rel="stylesheet"> 
	<link href='http://fonts.googleapis.com/css?family=Amita&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

</head>

<body>
	<a href="../dziennik_u.php"><h1 class="powrot" style="">eDziennik</h1></a><div id="logout"><a href="logout.php">Wyloguj się</a></div>
	<div style="clear: both;"></div>

    <div class="container" style="width: 650px; text-align: left;">

        <header class="kafelekH">
			<h2 style="border: none; float:left;">Sprawdziany</h2>
				
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
		
		<form method="post" action="" style="float:right;" onchange="this.submit()">
			<select name="przedmiot" id="przedm" style="font-size: 16px;">
				<option value=0>Wszystkie przedmioty</option>
				<?php
				foreach($subjects as $subject)
				{
					echo '<option value='.$subject['id_przedmiotu'].'>'.$subject['nazwa_cala'].'</option>';
				}
				?>
			</select>
		</form>
		<div style="clear: both;"></div>
		
		<script type="text/javascript">
		<?php
			if(isset($_SESSION['przedmiot']))
				echo 'document.getElementById("przedm").value = "'. $_SESSION['przedmiot'].'"';
			else
				echo 'document.getElementById("przedm").value = "'. $_POST['przedmiot'].'"';
		?>
		</script>	
		
		<main>
            <article>
			<?php
				foreach($tests as $test)
				{
					if($test['dzien'] == 1)
						$dzien = 'Niedziela';
					else if($test['dzien'] == 2)
						$dzien = 'Poniedziałek';
					else if($test['dzien'] == 3)
						$dzien = 'Wtorek';
					else if($test['dzien'] == 4)
						$dzien = 'Środa';
					else if($test['dzien'] == 5)
						$dzien = 'Czwartek';
					else if($test['dzien'] == 6)
						$dzien = 'Piątek';
					else
						$dzien = 'Sobota';		
					
					if(isset($_POST['przedmiot']))
					{
						$przedmiot = $_POST['przedmiot'];
						$_SESSION['przedmiot'] = $przedmiot;
					}
					else
						$przedmiot = 0;
					if(($przedmiot == 0) || ($przedmiot == $test['id_przedmiotu']))
					{
						$data_spr = date("d.m.Y", strtotime($test['data_spr']));
						$data_wpisu = date("d.m.Y", strtotime($test['data_wpisu']));
						
						echo '<div class="dane">';
							echo '<h3 style="border:none; padding-bottom:15px; padding-top:20px;"><div class='.'"data" style="color: #82b74b; font-size: 20px;">'.$dzien.', '.$data_spr.'</div></h3>';
							echo '<div class="rek1b"><div class='.'"rek2b"'.'style="float:left">Przedmiot</div><div class="rek3b" style="float:left">'.$test['nazwa_cala'].'</div> <div style="clear: both;"></div> </div>';
							echo '<div class="rek1b"><div class='.'"rek2b"'.'style="float:left">Rodzaj sprawdzianu</div><div class="rek3b" style="float:left">'.$test['rodzaj'].'</div> <div style="clear: both;"></div> </div>';
							
							$id_spr = $test['id_spr'];
							$noteQuery = $db -> prepare("SELECT opis FROM opisy_spr WHERE id_spr = $id_spr");
							$noteQuery -> execute();
							$note = $noteQuery -> fetch();
							
							if($note['opis'])
								echo '<div class="rek1b"><div class='.'"rek2b"'.'style="float:left">Opis</div><div class="rek3b" style="float:left">'.$note['opis'].'</div> <div style="clear: both;"></div> </div>';
							echo '<div class="rek1b" style="border-bottom:1px solid grey; padding-bottom:25px;"><div class='.'"rek2b"'.'style="float:left">Nauczyciel i data wpisu</div><div class="rek3b" style="float:left">'.$test['imie'].' '.$test['nazwisko'].', '.$data_wpisu.'</div> <div style="clear: both;"></div> </div>';
						echo '</div><br>';
					}
				}
			?>
			</article>
        </main>
	</div>
</body>
</html>