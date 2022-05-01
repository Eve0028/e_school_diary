<?php
	session_start();
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
    <div class="container" style="margin-top: 80px;">

        <header>
            <h1>eDziennik</h1>
        </header>
		
		<main>
            <article>
				<form method="post" action="logowanie.php">
                    <label>Podaj adres e-mail
                        <input type="email" name="email_log" <?=
						isset($_SESSION['e_email']) ? 'value="'.$_SESSION['e_email']. '"' : ""
						?>>
                    </label>
					<label>Podaj hasło
                        <input type="password" name="haslo" >
                    </label>
                    <input type="submit" value="Zaloguj się!">
					
					<?php
						
						if (isset($_SESSION['e_email'])) {
							if (isset($_SESSION['err_email'])) {
								echo "<p>{$_SESSION['err_email']}</p>";
								unset($_SESSION['err_email']);
							}
							
							else if (isset($_SESSION['email_reg'])) {
								echo "<p>{$_SESSION['email_reg']}</p>";
								unset($_SESSION['email_reg']);
							}
						}
						
					?>
					
                </form>
				<p><a href="rejestracja.php" class="green">Zarejestruj się</a></p>
			</article>
        </main>
	</div>
</body>
</html>