<?php
session_start();

if(!isset($_SESSION['loggedN_id']))
{
	header('Location: index.php');
	exit();
}
{
	$id_ucznia = $_SESSION['loggedN_id'];

	echo "Witaj ".$_SESSION['loggedN_id']."!";
}