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
		
		$rekQuery = $db -> prepare("SELECT o.id_przedmiotu, o.ocena_int, o.id_oceny, o.data, n.imie, n.nazwisko FROM oceny as o, nauczyciele as n WHERE id_ucznia = '$id_ucznia' and o.id_nauczyciela = n.id_nauczyciela ORDER BY id_przedmiotu");
	
		$rekQuery -> execute();
			
		$rekords = $rekQuery -> fetchAll();
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
			
				$rekQuery = $db -> prepare("SELECT o.id_przedmiotu, o.ocena_int, o.id_oceny, o.data, n.imie, n.nazwisko FROM oceny as o, nauczyciele as n WHERE id_ucznia = '$id_ucznia' and o.id_nauczyciela = n.id_nauczyciela ORDER BY id_przedmiotu");
	
				$rekQuery -> execute();
			
				$rekords = $rekQuery -> fetchAll();
				
				break;
			}
		}
	}
	
	$subjQuery = $db -> prepare("SELECT id_przedmiotu, nazwa_cala FROM przedmioty");
	$subjQuery -> execute();
	
	$subjects = $subjQuery -> fetchAll();
	
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
	
	<script src="../script.min.js"></script>
	<script src="script_oceny.js"></script>
    <link rel="stylesheet" href="../style.css">
	<link href="https://fonts.googleapis.com/css?family=Lato&amp;subset=latin-ext" rel="stylesheet"> 
	<link href='http://fonts.googleapis.com/css?family=Amita&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	
</head>

<body>

	<a href="../dziennik_u.php"><h1 class="powrot" style="">eDziennik</h1></a><div id="logout"><a href="logout.php">Wyloguj się</a></div>
	<div style="clear: both;"></div>
	
    <div class="container" style="width: 530px; text-align: left;">

        <header class="kafelekH">
			<h2 style="border: none; float:left;">Oceny</h2>
				
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
		
		<!--<p style="float:right; margin: 0px; margin-bottom: 10px;"><a href="" class="green">Szczegóły ocen</a></p>
		<div style="clear: both;"></div>-->
		
		<main>
            <article>
				<?php
					foreach ($subjects as $subj)
					{
						$ktora = true;   // Zmienna stworzona do wstawienia przecinka w odpowiednie miejsce
						echo "<h3><div class=".'"przedmiot"'.'style="float:left">'.$subj['nazwa_cala'].'</div><div class="oceny" style="float:left">';
						foreach ($rekords as $rek) 
						{
							if($rek['id_przedmiotu'] == $subj['id_przedmiotu'])
							{
								$id_oceny = $rek['id_oceny'];
								$markQuery = $db -> prepare("SELECT opis FROM opisy_ocen WHERE id_oceny = $id_oceny");
								$markQuery -> execute();
								$mark = $markQuery -> fetch();
								
								$data = date("d.m.Y", strtotime($rek['data']));

								if(isset($mark['opis']))
								{
									if($ktora)
									{
										if($mark['opis'])
											echo '<div style="float: left; cursor: default;" class="chmurka">'.$rek["ocena_int"].'<span>Opis: '.$mark['opis'].'<br>Data: '.$data.'<br>Nauczyciel: '.$rek['nazwisko'].' '.$rek['imie'].'</span></div>';
										else
											echo '<div style="float: left; cursor: default;" class="chmurka">'.$rek["ocena_int"].'<span>Data: '.$data.'<br>Nauczyciel: '.$rek['nazwisko'].' '.$rek['imie'].'</span></div>';
									}
									else
									{
										if($mark['opis'])
											echo '<div style="float: left; cursor: default;" class="chmurka">, '.$rek["ocena_int"].'<span>Opis: '.$mark['opis'].'<br>Data: '.$data.'<br>Nauczyciel: '.$rek['nazwisko'].' '.$rek['imie'].'</span></div>';
										else
											echo '<div style="float: left; cursor: default;" class="chmurka">, '.$rek["ocena_int"].'<span>Data: '.$data.'<br>Nauczyciel: '.$rek['nazwisko'].' '.$rek['imie'].'</span></div>';
									}
									$ktora = false;
								}
							}
						}
						echo "</div></h3>";
						echo '<div style="clear: both;"></div>';
					}
				?>

			</article>
        </main>
	</div>
</body>
</html>