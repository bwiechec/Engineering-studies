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
	<title>Strona Trunieju</title>
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

        
            
    <div class="col-md-9 col-sm-9 col-md-offset-2">
        <?php
        if(!empty($_GET['name'])){
            $nazwa = $_GET['name'];
        }else{
            header("Location: index.php");
        }
        $polaczenie = @new mysqli('127.0.0.1','root','','turnieje');
        $sql = "SELECT * FROM `tournament` WHERE name like '$nazwa'";
        
        if(!$polaczenie->connect_error){
            if($rezultat = $polaczenie->query($sql)){
                $polaczenie->close();
                $res = $rezultat->fetch_assoc();
                echo <<<TEXT
                Wybrany turniej: <br> Nazwa: $res[name] <br> Dyscyplina: $res[discipline]
                <br> Data rozpoczęcia: $res[time] <br> Lokalizacja: $res[location]
                <br> Limit uczestników: $res[limitation]<br> Data końca zapisów: $res[deadline]
                <br> <a href="registrationTournament.php?id=$res[id_tournament]">Zarejestruj się</a>
                <br> <a href="standingsTourmanet.php?id=$res[id_tournament]">Drabinka turnieju</a>
TEXT;
            }else {
                echo "<span style='color: red; font-size: 20px;'>Błąd w zapytaniu</span>";
            }
        }else{
            echo "<span style='color: red; font-size: 20px;'>Błąd połączenia.</span>";
        }
        ?>
    </div>
        
    </div>
    
	<nav class="navbar navbar-inverse navbar-fixed-bottom">
		<div class="container-fluid">
            <p class="navbar-text pull-right">Projekt z Podstaw Aplikacji Internetowych Bartosz Wiecheć 141334</p>
		</div>
	</nav>
</body>
</html>