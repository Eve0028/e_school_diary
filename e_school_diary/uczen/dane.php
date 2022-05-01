<?php
session_start();

if(!isset($_SESSION['loggedU_id']) && !isset($_SESSION['loggedR_id']))
{
	header('Location: ../index.php');
	exit();
}
else
{
	$id_ucznia = $_SESSION['loggedU_id'];
	$id_rodzica = $_SESSION['id_rodzica'];
	
	require_once '../database.php';
	
	$PDetailsQuery = $db -> prepare("SELECT * FROM rodzice WHERE id_rodzica = '$id_rodzica'");
	$PDetailsQuery -> execute();
	
	$PDetails = $PDetailsQuery -> fetch();
	
	$_SESSION['imie_r'] = $PDetails['imie'];
	$_SESSION['nazwisko_r'] = $PDetails['nazwisko'];
	$_SESSION['pesel_r'] = $PDetails['PESEL'];
	$_SESSION['data_ur_r'] = $PDetails['data_ur'];
	$_SESSION['miejsce_ur_r'] = $PDetails['miejsce_ur'];
	$_SESSION['miejsce_zam_r'] = $PDetails['miejsce_zam'];
	$_SESSION['telefon_r'] = $PDetails['telefon'];
	$_SESSION['email_r'] = $PDetails['email'];
	$_SESSION['plec_r'] = $PDetails['plec'];
				
	$imie_r = $_SESSION['imie_r'];
	$nazwisko_r = $_SESSION['nazwisko_r'];
	$pesel_r = $_SESSION['pesel_r'];
	$data_ur_r = $_SESSION['data_ur_r'];
	$miejsce_ur_r = $_SESSION['miejsce_ur_r'];
	$miejsce_zam_r = $_SESSION['miejsce_zam_r'];
	$telefon_r = $_SESSION['telefon_r'];
	$email_r = $_SESSION['email_r'];
	$plec_r = $_SESSION['plec_r'];
	
	
	if(!isset($_SESSION['loggedR_id']))
	{
		$imie = $_SESSION['imie'];
		$nazwisko = $_SESSION['nazwisko'];
		$pesel = $_SESSION['pesel'];
		$data_ur = $_SESSION['data_ur'];
		$miejsce_ur = $_SESSION['miejsce_ur'];
		$miejsce_zam = $_SESSION['miejsce_zam'];
		$telefon = $_SESSION['telefon'];
		$email = $_SESSION['email'];
		$plec = $_SESSION['plec'];
	}
	else
	{
		if(!isset($_POST['uczen']))
		{
			$imie = $_SESSION['imie'][0];
			$nazwisko = $_SESSION['nazwisko'][0];
			$pesel = $_SESSION['pesel'][0];
			$data_ur = $_SESSION['data_ur'][0];
			$miejsce_ur = $_SESSION['miejsce_ur'][0];
			$miejsce_zam = $_SESSION['miejsce_zam'][0];
			$telefon = $_SESSION['telefon'][0];
			$email = $_SESSION['email'][0];
			$plec = $_SESSION['plec'][0];
			$klasa = $_SESSION['klasa'][0];
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
					$pesel = $_SESSION['pesel'][$i];
					$data_ur = $_SESSION['data_ur'][$i];
					$miejsce_ur = $_SESSION['miejsce_ur'][$i];
					$miejsce_zam = $_SESSION['miejsce_zam'][$i];
					$telefon = $_SESSION['telefon'][$i];
					$email = $_SESSION['email'][$i];
					$plec = $_SESSION['plec'][$i];
					$klasa = $_SESSION['klasa'][$i];
					
					break;
				}
			}
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
	<link href="https://fonts.googleapis.com/css?family=Lato&amp;subset=latin-ext" rel="stylesheet"> 
	<link href='http://fonts.googleapis.com/css?family=Amita&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

</head>

<body>
	<a href="../dziennik_u.php"><h1 class="powrot" style="">eDziennik</h1></a><div id="logout"><a href="logout.php">Wyloguj się</a></div>
	<div style="clear: both;"></div>

    <div class="container" style="width: 650px; text-align: left;">

        <header class="kafelekH">
			<h2 style="border: none; float:left;">Dane osobowe</h2>
				
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
			<select name="dane" id="dane" style="font-size: 16px;">
				<option value=1><?= isset($_SESSION['loggedR_id']) ? "Dane ucznia" : "Twoje dane" ?></option>
				<option value=2>Dane rodzica</option>
			</select>
		</form>
		<div style="clear: both;"></div>
		
		<script type="text/javascript">
			document.getElementById('dane').value = "<?= $_POST['dane'];?>";
		</script>	
		
		<main>
            <article>
			<?php
				$data_ur_r = date("d.m.Y", strtotime($data_ur_r));
				$data_ur = date("d.m.Y", strtotime($data_ur));
			
				if(isset($_POST['dane']) && $_POST['dane'] == 2)
				{
					echo '<div class="dane">';
						echo '<h3 style="border:none; padding-bottom:15px; padding-top:20px;"><div class='.'"data" style="color: #82b74b; font-size: 20px;">Dane rodzica</div></h3>';
						echo '<div class="rek1b"><div class='.'"rek2b"'.'style="float:left">Imie i nazwisko</div><div class="rek3b" style="float:left">'.$imie_r.' '.$nazwisko_r.'</div> <div style="clear: both;"></div> </div>';
						if($plec_r == 'k')
							echo '<div class="rek1b"><div class='.'"rek2b"'.'style="float:left">Stopień pokrewieństwa</div><div class="rek3b" style="float:left">Matka</div> <div style="clear: both;"></div> </div>';
						else
							echo '<div class="rek1b"><div class='.'"rek2b"'.'style="float:left">Stopień pokrewieństwa</div><div class="rek3b" style="float:left">Ojciec</div> <div style="clear: both;"></div> </div>';
						echo '<div class="rek1b"><div class='.'"rek2b"'.'style="float:left">Data i miejsce urodzenia</div><div class="rek3b" style="float:left">'.$data_ur_r.', '.$miejsce_ur_r.'</div> <div style="clear: both;"></div> </div>';
						echo '<div class="rek1b"><div class='.'"rek2b"'.'style="float:left">PESEL</div><div class="rek3b" style="float:left">'.$pesel_r.'</div> <div style="clear: both;"></div> </div>';
						echo '<div class="rek1b"><div class='.'"rek2b"'.'style="float:left">Miejsce zamieszkania</div><div class="rek3b" style="float:left">'.$miejsce_zam_r.'</div> <div style="clear: both;"></div> </div>';
						echo '<div class="rek1b"><div class='.'"rek2b"'.'style="float:left">Telefon</div><div class="rek3b" style="float:left">'.$telefon_r.'</div> <div style="clear: both;"></div> </div>';
						echo '<div class="rek1b" style="border-bottom:1px solid grey; padding-bottom:25px;"><div class='.'"rek2b"'.'style="float:left">E-mail</div><div class="rek3b" style="float:left">'.$email_r.'</div> <div style="clear: both;"></div> </div>';
					echo '</div><br>';
				}
				else
				{
					echo '<div class="dane">';
						if(isset($_SESSION['loggedR_id']))
							echo '<h3 style="border:none; padding-bottom:15px; padding-top:20px;"><div class='.'"data" style="color: #82b74b; font-size: 20px;">Dane ucznia</div></h3>';
						else
							echo '<h3 style="border:none; padding-bottom:15px; padding-top:20px;"><div class='.'"data" style="color: #82b74b; font-size: 20px;">Twoje dane</div></h3>';
						echo '<div class="rek1b"><div class='.'"rek2b"'.'style="float:left">Imie i nazwisko</div><div class="rek3b" style="float:left">'.$imie.' '.$nazwisko.'</div> <div style="clear: both;"></div> </div>';
						echo '<div class="rek1b"><div class='.'"rek2b"'.'style="float:left">Data i miejsce urodzenia</div><div class="rek3b" style="float:left">'.$data_ur.', '.$miejsce_ur.'</div> <div style="clear: both;"></div> </div>';
						echo '<div class="rek1b"><div class='.'"rek2b"'.'style="float:left">PESEL</div><div class="rek3b" style="float:left">'.$pesel.'</div> <div style="clear: both;"></div> </div>';
						if($plec == 'k')
							echo '<div class="rek1b"><div class='.'"rek2b"'.'style="float:left">Płeć</div><div class="rek3b" style="float:left">Kobieta</div> <div style="clear: both;"></div> </div>';
						else
							echo '<div class="rek1b"><div class='.'"rek2b"'.'style="float:left">Płeć</div><div class="rek3b" style="float:left">Mężczyzna</div> <div style="clear: both;"></div> </div>';
						echo '<div class="rek1b"><div class='.'"rek2b"'.'style="float:left">Miejsce zamieszkania</div><div class="rek3b" style="float:left">'.$miejsce_zam.'</div> <div style="clear: both;"></div> </div>';
						echo '<div class="rek1b"><div class='.'"rek2b"'.'style="float:left">Imię rodzica</div><div class="rek3b" style="float:left">'.$imie_r.'</div> <div style="clear: both;"></div> </div>';
						echo '<div class="rek1b"><div class='.'"rek2b"'.'style="float:left">Telefon</div><div class="rek3b" style="float:left">'.$telefon.'</div> <div style="clear: both;"></div> </div>';
						echo '<div class="rek1b" style="border-bottom:1px solid grey; padding-bottom:25px;"><div class='.'"rek2b"'.'style="float:left">E-mail</div><div class="rek3b" style="float:left">'.$email.'</div> <div style="clear: both;"></div> </div>';
					echo '</div><br>';
				}

			?>

			</article>
        </main>
	</div>
</body>
</html>