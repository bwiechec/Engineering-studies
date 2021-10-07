<?php
session_start();
require_once('php/dataCzas.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Dodaj trofeum</title>
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
    
    <div class="panel-body col-md-6 col-md-offset-3">
        <form role="form" action="php/dodajTrofeum.php?str=trofeaDodajPilkarz.php" method="POST">
            <div id="komunikat">
            <?php
                if(isset($_SESSION['komunikat'])){
                    echo "$_SESSION[komunikat]";
                    unset($_SESSION['komunikat']);
                }    
            ?>
            </div>
            <div class="form-group">
            <label for="Nazwa">Podaj nazwę trofeum:</label>         
            <input type="text" class="form-control" id="Nazwa" name="Nazwa">
            </div>
            
            
            <div class="form-group">
            <label for="Pilkarz">Wybierz zdobywcę trofeum:</label>
            <select name="Pilkarz" id="Pilkarz" class="form-control">
                <?php
                
                    $polaczenie = new mysqli('localhost','root','','projekt');
                    if(!$polaczenie->connect_errno){
                        $sql = "select id_pilkarza, Imie, Nazwisko from Pilkarz;";
        
                        if($rezultat=$polaczenie->query($sql)){
                            
                                while($res = $rezultat->fetch_assoc()){ 
                                    echo "<option value = '$res[id_pilkarza]'>$res[Imie] $res[Nazwisko]</option>";
                                }
                            
                        }else{
                            echo "Błąd w zapytaniu";
                        }
                        $polaczenie->close(); 
                    }else{
                        echo "Błąd w połączeniu z bazą danych";
                    }
                
                ?>
            </select>
            </div> 
            
            <button type="submit" id="add" class="btn btn-primary">Dodaj trofeum</button>

        </form>
        
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