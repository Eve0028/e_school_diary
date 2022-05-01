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
				
				break;
			}
		}
	}
	
	$subjQuery = $db -> prepare("SELECT id_przedmiotu, nazwa_cala FROM przedmioty");
	$subjQuery -> execute();
	$subjects = $subjQuery -> fetchAll();
					
	$markQuery = $db -> prepare("SELECT ocena_pelna FROM oceny_nazwy");
	$markQuery -> execute();		
	$marks = $markQuery -> fetchAll();
	
	include_once("LabCharts/LabChartsPie.php");
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

    <div class="container" style="width: 870px; text-align: left;">

        <header class="kafelekH">
			<h2 style="border: none; float:left;">Na tle klasy</h2>
				
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
					foreach ($subjects as $subj)
					{
						echo '<div style="padding-bottom: 30px;"><h3 style="border:none; padding-bottom:20px;">'. $subj['nazwa_cala'] .'</h3>';
						
						$chartQuery = $db -> prepare("SELECT o_n.ocena_int, count(o.ocena_int) as ile FROM oceny_nazwy as o_n, oceny as o, uczniowie as u WHERE o.id_przedmiotu = '{$subj['id_przedmiotu']}' and o.id_ucznia in (SELECT id_ucznia FROM uczniowie WHERE id_klasy = $id_klasy) and o_n.ocena_int = o.ocena_int and u.id_ucznia = o.id_ucznia Group BY o_n.ocena_int");
						$chartQuery -> execute();
	
						$charts = $chartQuery -> fetchAll();
						
						$nie_ma = true;
						for($i = 1; $i<=6; $i++)
						{
							
							$jest = false;
							foreach($charts as $chart)
							{
								if($i == $chart['ocena_int'])
								{
									$jest = true;
									$nie_ma = false;
									$oceny[$i] = $chart['ile'];
								}
							}
							if($jest == false)
								$oceny[$i] = 0;
						}
						
						if($nie_ma)
							echo '<div style="width: 350px; text-align: center; margin-bottom: 30px; float:left;"><div style="font-size: 15px; margin-bottom: 20px;">Klasa</div><div style="color:grey;">Brak ocen</div></div>';
						else
						{
							$j=1;
							echo '<div class="kaf_o" style="width:135px; margin-right: 15px; float:left; font-size: 15px;">';
							foreach($marks as $mark)
							{
								echo '<div class="oceny_w"><div style="float:left; width:120px;">' . $mark['ocena_pelna'] . ': </div><div style="float:left;">' . $oceny[$j] . '</div><div style="clear: both;"></div></div>';
								$j++;
							}
							echo '</div>';
							
							$LabChartsPie = new LabChartsPie();
							$LabChartsPie->setData($oceny);
							$LabChartsPie->setSize('250x220');
							$LabChartsPie->setTitle('Klasa');
							$LabChartsPie->setColors('d65859|9172b5|d7b12a|489ef1|38c79c|92b53d');
							$LabChartsPie->setLabels('ndst|dop|dst|db|bdb|cel');
							
							echo '<div style="float:left; width:250px; padding-right: 70px;"><img src="' . $LabChartsPie->getChart() . '"></div>';
						}
						
						
						$chartQuery = $db -> prepare("SELECT ocena_int, count(ocena_int) as ile FROM oceny WHERE id_ucznia = $id_ucznia and id_przedmiotu = '{$subj['id_przedmiotu']}' GROUP BY ocena_int");
						$chartQuery -> execute();
	
						$charts = $chartQuery -> fetchAll();
						
						$nie_ma = true;
						for($i = 1; $i<=6; $i++)
						{
							
							$jest = false;
							foreach($charts as $chart)
							{
								if($i == $chart['ocena_int'])
								{
									$jest = true;
									$nie_ma = false;
									$oceny[$i] = $chart['ile'];
								}
							}
							if($jest == false)
								$oceny[$i] = 0;
						}
						
						if($nie_ma)
							echo '<div style="width: 350px; text-align: center; margin-bottom: 30px; float:left;"><div style="font-size: 15px; margin-bottom: 20px;">Ty</div><div style="color:grey;">Brak ocen</div></div>';
						else
						{
							$j=1;
							echo '<div class="kaf_o" style="width:135px; margin-right: 15px; float:left; font-size: 15px;">';
							foreach($marks as $mark)
							{
								echo '<div class="oceny_w"><div style="float:left; width:120px;">' . $mark['ocena_pelna'] . ': </div><div style="float:left;">' . $oceny[$j] . '</div><div style="clear: both;"></div></div>';
								$j++;
							}
							echo '</div>';
							
							$LabChartsPie = new LabChartsPie();
							$LabChartsPie->setData($oceny);
							$LabChartsPie->setSize('250x220');
							$LabChartsPie->setTitle('Ty');
							$LabChartsPie->setColors('d65859|9172b5|d7b12a|489ef1|38c79c|92b53d');
							$LabChartsPie->setLabels('ndst|dop|dst|db|bdb|cel');
							
							echo '<div style="float:left; width:250px;"><img src="' . $LabChartsPie->getChart() . '"></div><br><br>';
						}
						
						
						echo '<div style="clear: both;"></div></div>';
					}
				?>
			</article>
        </main>
	</div>
</body>
</html>