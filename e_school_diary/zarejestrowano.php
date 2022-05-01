<?php
session_start();

if(!isset($_SESSION['haslo']))
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
    <div class="container" style="width: 530px; margin-top: 80px;">

        <header>
            <h1>eDziennik</h1>
			<h2>Rejestracja się powiodła!</h2>
        </header>
		
		<main>
            <article>
				Twoje hasło to: <br>
				<h3>
					<?php if(isset($_SESSION['haslo']))
					{
						echo $_SESSION['haslo'];
						unset($_SESSION['haslo']);
					}  ?>
				</h3>
				<p><a href="index.php" class="green">Zaloguj się</a></p>
			</article>
        </main>
	</div>
</body>
</html>