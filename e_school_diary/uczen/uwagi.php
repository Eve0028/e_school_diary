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
		
		$noteQuery = $db -> prepare("SELECT n.imie, n.nazwisko, u.id_ucznia, u.rodzaj, u.tresc, u.data FROM uwagi as u, nauczyciele as n WHERE id_ucznia = '$id_ucznia' and u.id_nauczyciela = n.id_nauczyciela ORDER BY u.data DESC");
		$noteQuery -> execute();
		$notes = $noteQuery -> fetchAll();
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
			
				$noteQuery = $db -> prepare("SELECT n.imie, n.nazwisko, u.id_ucznia, u.rodzaj, u.tresc, u.data FROM uwagi as u, nauczyciele as n WHERE id_ucznia = '$id_ucznia' and u.id_nauczyciela = n.id_nauczyciela ORDER BY u.data DESC");
				$noteQuery -> execute();
				$notes = $noteQuery -> fetchAll();
				
				break;
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
			<h2 style="border: none; float:left;">Uwagi</h2>
				
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
				foreach($notes as $note)
				{
					$data = date("d.m.Y", strtotime($note['data']));
					echo '<div class="uwaga">';
						echo '<h3 style="border:none; padding-bottom:15px; padding-top:20px;"><div class='.'"data" style="color: #82b74b; font-size: 20px;">'.$data.'</div></h3>';
						echo '<div class="rek1"><div class='.'"rek2"'.'style="float:left">Nauczyciel</div><div class="rek3" style="float:left">'.$note['imie']." ".$note['nazwisko'].'</div>'.'<div style="clear: both;"></div>'.'</div>';
						echo '<div class="rek1"><div class='.'"rek2"'.'style="float:left">Rodzaj</div><div class="rek3" style="float:left">'.$note['rodzaj'].'</div>'.'<div style="clear: both;"></div>'.'</div>';
						echo '<div class="rek1" style="border-bottom:1px solid grey; padding-bottom:25px;"><div class='.'"rek2"'.'style="float:left">Treść</div><div class="rek3" style="float:left">'.$note['tresc'].'</div>'.'<div style="clear: both;"></div>'.'</div>';
					echo '</div>';
				}
			?>
			</article>
        </main>
	</div>
</body>
</html>