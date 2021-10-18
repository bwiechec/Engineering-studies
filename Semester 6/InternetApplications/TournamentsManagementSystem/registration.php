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
	<title>Rejestracja</title>
	<link rel="icon" href="fav.png">
	<link href="stylesheets/rejestracja.css" type="text/css" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
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
        <ul class="nav navbar-nav navbar-right">    
		<li><?php if(!isset($_SESSION['zalogowany'])) echo "<li><a href='zaloguj.php'>Zaloguj się</a></li>"; ?>
		</ul>
		</div>
	</nav>
	<div class="container">
    <div class="col-md-6 col-sm-6">
        <br>
        <br>
    <fieldset>
        <legend>Panel rejestracji</legend>
    <div class="panel-body">
        
        
        <?php if(isset($_SESSION['komunikat'])){
            echo $_SESSION['komunikat'];
            unset($_SESSION['komunikat']);
        } ?>
        
        <form role="form" action="php/regVal.php" method="POST">
            <div id="komunikat"></div>
            <div class="form-group">
            <label for="emailInput">Adres e-mail</label>
            <input type="email" class="form-control" id="emailInput" name="email">
            </div>
            
            <div class="form-group">
            <label for="nameInput">Imię</label>         
            <input type="text" class="form-control" id="nameInput" name="name">
            </div>
            
            <div class="form-group">
            <label for="surnameInput">Nazwisko</label>         
            <input type="text" class="form-control" id="surnameInput" name="surname">
            </div>
            
            <div class="form-group">
            <label for="passInput">Hasło</label>         
            <input type="password" class="form-control" id="passInput" name="pass1">
            </div>
            
            <div class="form-group">
            <label for="passInput2">Potwierdź hasło</label>         
            <input type="password" class="form-control" id="passInput2" name="pass2">
            </div>
            
            <label><input type="checkbox" value="checked" name="regulations">&nbsp;Akceptuję&nbsp;<a href="regulamin/regulamin.pdf">regulamin</a></label><br><br>
            
            <br>
            <button type="submit" id="registration" class="btn btn-primary">Zarejestruj się</button>

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