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

        
            
    <div class="col-md-6 col-sm-6 col-md-offset-2">
        
        <form role="form" action="php/resetPass.php" method="POST">
        <?php
        if(!empty($_GET['mail'])){
            $mail = $_GET['mail'];
            echo "<input type='hidden' class='form-control' id='email'  name='email' value='$mail' >"; 
        }else{
            header("location: zaloguj.php");
        }
        ?>
        
            <div class="form-group">
            <label for="passInput">Podaj hasło</label>
            <input type="password" class="form-control" id="passInput" name="passInput">
            </div>  
            <div class="form-group">
            <label for="passInput2">Powtórz hasło</label>
            <input type="password" class="form-control" id="passInput2" name="passInput2">
            </div>  
            <button type="submit" id="reset" class="btn btn-primary">Zresetuj hasło</button>

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