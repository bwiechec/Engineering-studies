<?php
session_start();
require_once('php/dataCzas.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Trofea</title>
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
    
	<div class="container" style="margin-top: 70px;">
    <form action="kluby.php" method="post">
        Nazwa klubu: <input type="text" name="Nazwa">
        Rok założenia <input type="text" name="Rok">
        Kraj pochodzenia: <input type="text" name="Kraj">
        Ilosc Trofeów: <input type="text" name="IloscTrofeum">
        <input type="submit" name="zatwierdz" value="Szukaj" class="btn btn-primary mb-2">
    </form>  
        <br>
        <?php
        
        if(!empty($_POST['Nazwa'])){
            $nazwa = $_POST['Nazwa'];
        }else {
            $nazwa = '%';
        }
        if(!empty($_POST['Kraj'])){
            $kraj = $_POST['Kraj'];
        }else{
            $kraj =  '%';
        }if(!empty($_POST['Rok'])){
            $rok = $_POST['Rok'];
        }else{
            $rok =  '%';
        }
        if(!empty($_POST['IloscTrofeum'])){
            $iloscTrofeum = $_POST['IloscTrofeum'];
        }else{
            $iloscTrofeum =  '%';
        }
        $sql = "SELECT id_trofeum, Nazwa, pilkarz_id_pilkarza as 'p', klub_id_klubu as 'k', trener_id_trenera as 't' FROM `trofea`";
        $polaczenie = new mysqli('localhost','root','','projekt');
        if(!$polaczenie->connect_errno){
            if(!empty($_GET['id'])){
                $sqlDel = "Delete from `klub` where id_klubu = '$_GET[id]'";
                echo "$sqlDel";
                if(!($rezultat=$polaczenie->query($sqlDel))){
                    echo "Błąd przy usuwaniu";
                }
            }
            if($rezultat=$polaczenie->query($sql)){
                $result = $rezultat;
                echo <<<TABELA
                    <table class="table">
                    <thead>
                    <tr>
                        <th scope="col"><center>Nazwa trofeum</center></th>
                        <th scope="col"><center>Typ (dla kogo)</center></th>
                    </tr>
                    </thead>
                    <tbody>
                
TABELA;
                while($res = $result->fetch_assoc()){ 
                    echo <<<TABELA
                    <tr>
                    <td><center>$res[Nazwa] </center></td>
                    <td><center>
TABELA;
                    
                    if(!is_null($res['p'])){
                        echo "Piłkarz";
                    }else if(!is_null($res['k'])){
                        echo "Klub";                        
                    }else if(!is_null($res['t'])){
                        echo "Trener";                        
                    }
                    
                    
                    echo <<<TABELA
                    </center></td>
                    <td><a href='kluby.php?id=$res[id_trofeum]'>Usuń</a></td>
                   </tr>
TABELA;
                }
                echo "</tbody></table>";
            }
            else{
                echo "Błąd w zapytaniu!";
            }
        }
        
        $polaczenie->close(); 
        ?>  
        
        <div class="row justify-content-end">
        <div class="col-md-9 col-md-offset-6">
        
        <a href = "trofeaDodajKlub.php"><button class = "btn btn-primary mb-2">Dodaj nowe trofeum klubowe</button></a>
        
        <a href = "trofeaDodajTrener.php"><button class = "btn btn-primary mb-2">Dodaj nowe trofeum trenerskie</button></a>
            
        <a href = "trofeaDodajPilkarz.php"><button class = "btn btn-primary mb-2">Dodaj nowe trofeum piłkarskie</button></a>            
            
        </div>
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