<?php
session_start();
if(!isset($_SESSION['zalogowany'])){
    header("Location: zaloguj.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Utwórz turniej</title>
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
        <ul class="nav navbar-nav navbar-right">    
		<li><?php if(!isset($_SESSION['zalogowany'])) echo "<li><a href='zaloguj.php'>Zaloguj się</a></li>"; ?>
        <?php if(isset($_SESSION['zalogowany'])) echo "<li><a href='php/logout.php'>Witaj {$_SESSION['name']}! (Wyloguj się)</a></li>"; ?></li>
		</ul>
		</div>
	</nav>
    
	<div class="container" style="margin-top: 70px;">

        
            
    <div class="col-md-6 col-sm-6 col-md-offset-2">
        <?php if(isset($_SESSION['komunikat'])){
            echo $_SESSION['komunikat'];
            unset($_SESSION['komunikat']);
}       ?>
        
        <form role="form" action="php/addTournament.php" method="post">
            <div class="form-group">
            <label for="nameInput">Nazwa turnieju:</label>
            <input type="text" class="form-control" id="nameInput" name="nameInput">
            </div>
            <div class="form-group">
            <label for="dateInput">Data rozpoczęcia:</label>
            <input type="date" class="form-control" id="dateInput" name="dateInput">
            </div>
            <div class="form-group">
            <label for="locationInput">Lokalizacja:</label>
            <input type="text" class="form-control" id="locationInput" name="locationInput">
            </div>
            <div class="form-group">
            <label for="limitInput">Limit uczestników:</label>
            <select name="limitInput" id="limitInput">
                <option value="4">4</option>
                <option value="8">8</option>
                <option value="16">16</option>
                <option value="32">32</option>
                <option value="64">64</option>
                <option value="128">128</option>
                <option value="256">256</option>
            </select>
            </div>
            <div class="form-group">
            <label for="deadlineInput">Data zakończenia zapisów:</label>
            <input type="date" class="form-control" id="deadlineInput" name="deadlineInput">
            </div>
            <input type="submit" name="zatwierdz" value="Dodaj" class="btn btn-primary mb-2"> 
        </form>  
    </div>
        
    </div>
    
	<nav class="navbar navbar-inverse navbar-fixed-bottom">
		<div class="container-fluid">
            <p class="navbar-text pull-right">Projekt z Podstaw Aplikacji Internetowych Bartosz Wiecheć 141334</p>
		</div>
	</nav>
</body>
</html>