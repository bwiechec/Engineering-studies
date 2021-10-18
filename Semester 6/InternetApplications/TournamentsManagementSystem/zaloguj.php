<?php
session_start();
if(isset($_SESSION['zalogowany'])){
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Zaloguj się</title>
	<link rel="icon" href="fav.png">
	<link href="stylesheets/index.css" type="text/css" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
	<nav class="navbar navbar-inverse navbar-fixed-top" id="navbar">
		<div class="container-fluid">
		<div class="navbar-header">
		<a class="navbar-brand"><span id="IEheader">Turnieje</span></a>
		</div>
		<ul class="nav navbar-nav">
		<li><a href="index.php">Strona główna</a></li>
		<li><a href="createTournament.php">Utwórz turniej</a></li>
		<li><?php if(isset($_SESSION['zalogowany'])) echo "<li><a href='myTournaments.php'>Moje Turnieje</a></li>"; ?></li>
        </ul>
		</div>
	</nav>
    
	<div class="container">
    <div class="col-md-5 col-sm-5">
    <fieldset>
        <legend>Panel logowania</legend>
        <?php if(isset($_SESSION['komunikat'])){
            echo $_SESSION['komunikat'];
            unset($_SESSION['komunikat']);
}       ?>
    <div class="panel-body">
        <form role="form" action="php/login.php" method="post">
            <div class="form-group">
            <label for="emailInput">Adres e-mail</label>
            <input type="email" class="form-control" id="emailInput" name="emailInput">
            </div>
            
            <div class="form-group">
            <label for="passInput">Hasło</label>         
            <input type="password" class="form-control" id="passInput" name="passInput">
            </div>
            <input type="submit" class="btn btn-primary" value="Zaloguj się">
            <br>
            <br>
            <p>Nie masz konta? <a href="registration.php">Zarejestruj się</a></p>
            
            <p>Zapomniałeś hasła? <a href="remindPassword.php">Przypomnij hasło</a></p>
        </form>
    </div>
    </fieldset>
    </div>

        
    </div>
    
	<nav class="navbar navbar-inverse navbar-fixed-bottom">
		<div class="container-fluid">
            <p class="navbar-text pull-right">Projekt z Podstaw Aplikacji Internetowych Bartosz Wiecheć 141334</p>
		</div>
	</nav>
</body>
</html>