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
	<title>Rejestracja w turnieju</title>
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
        } ?>
        <form role="form" action="php/addUsrTournament.php" method="post">
            <?php
             echo "<input type='hidden' class='form-control' id='idInput'  name='idInput' value='$_GET[id]' >";               
            ?>
            <div class="form-group">
            <label for="numberInput">Numer licencji:</label>
            <input type="text" class="form-control" id="numberInput" name="numberInput">
            </div>
            <div class="form-group">
            <label for="numberInput">Obecny ranking:</label>
            <input type="text" class="form-control" id="rankInput" name="rankInput">
            </div>
            <input type="submit" name="zatwierdz" value="Dodaj" class="btn btn-primary mb-2"> 
        </form>  
        
        <?php
        
        if(!empty($_GET['id'])){
            $id = $_GET['id'];
        }else{
            header("Location: index.php");
        }
            
        echo <<<TEXT
            <p>Użytkownik $_SESSION[name] chce zarejestrować się na turniej o identyfikatorze: $id</p>
TEXT;
        
        $polaczenie = @new mysqli('127.0.0.1','root','','turnieje');
        $sql = "SELECT count(*) as 'liczba' FROM `user_tournament` WHERE id_tournament like '$id'";
        $sql2 = "SELECT *  FROM `tournament` WHERE id_tournament like '$id'";
        
        if(!$polaczenie->connect_error){
            if($rezultat = $polaczenie->query($sql)){
                if($rezultat2 = $polaczenie->query($sql2)){
                    $polaczenie->close();
                    $res = $rezultat->fetch_assoc();
                    $res2 = $rezultat2->fetch_assoc();
                    if($res['liczba'] < $res2['limitation']){
                        echo "<span style='color: green; font-size: 20px;'>SĄ MIEJSCA obecnie zapisanych: $res[liczba], a limit to: $res2[limitation]</span>";                        
                    }else{
                        //$_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>NIE MA MIEJSC NA TURNIEJ $res2[name]</span>";   
                        //header("Location: index.php");                     
                    }
                }else{
                    echo "<span style='color: red; font-size: 20px;'>Błąd w zapytaniu2</span>";                    
                }
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