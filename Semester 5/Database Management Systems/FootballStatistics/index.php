<?php
session_start();
require_once('php/dataCzas.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Strona główna</title>
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
		<a class="navbar-brand"><span id="ProjHeader">Projekt zaliczeniowy</span></a>
		</div>
		<ul class="nav navbar-nav">
		<li><a href="index.php">Strona główna</a></li>
		<li><a href="kluby.php">Kluby</a></li>
		<li><a href="pilkarze.php">Piłkarze</a></li>
		<li><a href="mecze.php">Mecze</a></li>
		<li><a href="trenerzy.php">Trenerzy</a></li>
		<li><a href="trofea.php">Trofea</a></li>
        </ul>
		</div>
	</nav>
    
	<div class="container"> 
    
    <div class="col-md-9 col-sm-9 col-md-offset-2">
        <p> 
        <fieldset>
        <center><legend>Projekt z przedmiotu Zarządzanie bazami SQL i NoSQL. Rok akademicki 2020/2021 semestr zimowy.</legend>
            <p>Bartosz Wiecheć 141334 I3.2</p></center>
        </fieldset> 
    </div>
        
    </div>
    
	<div class="container" style="margin-top: 70px;margin-left: auto; margin-right: auto;"> 
    
    <div class="col-md-9 col-sm-9 col-md-offset-2">
        <p> 
        <fieldset>
        <center><legend>Krótki opis:</legend></center>
            <ul >
                <li>Zakładka kluby: Możemy tam przeglądać dostępne w bazie kluby, trofea zdobyte przez klub.</li>
                <li>Zakładka piłkarze: możemy tam przeglądać statystyki piłkarzy, klub w którym grają (jeśli nie grają w żadnym klubie nie zobaczymy ich tam), zdobyte trofea</li>
                <li>Zakładka mecze: Możemy tam przeglądać dostępne w bazie mecze, oraz informacje o nich.</li>
                <li>Zakładka trenerzy: Możemy tam przeglądać trenerów ich statystyki oraz klub (jeśli żadnego nie trenują nie zobaczymy ich tam), w którym pracują</li>
                <li>Zakładka trofea: Możemy tam zobaczyc dostępne trofea oraz kto może je dostać (Piłkarz, Klub, Trener)</li>
            </ul>
        </fieldset> 
    </div>
        
    </div>
	<nav class="navbar navbar-inverse navbar-fixed-bottom">
		<div class="container-fluid">
            <p class="navbar-text pull-right">Barosz Wiecheć 141334</p>
            <p class="navbar-text pull-left">
            <?php
            echo "Jest: ".date("d-m-Y");       
            ?>
            </p>
		</div>
	</nav>
</body>
</html>