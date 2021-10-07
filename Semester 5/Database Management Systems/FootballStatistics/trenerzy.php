<?php
session_start();
require_once('php/dataCzas.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Trenerzy</title>
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

            <div id="komunikat">
            <?php
                if(isset($_SESSION['komunikat'])){
                    echo "$_SESSION[komunikat]";
                    unset($_SESSION['komunikat']);
                }    
            ?>
            </div>
     <form action="trenerzy.php" method="post">
        Imie: <input type="text" name="Imie">
        Nazwisko: <input type="text" name="Nazwisko">
        Wiek: <input type="text" name="Wiek">
        Narodowosc: <input type="text" name="Narodowosc"> <br>
        Nazwa klubu: <input type="text" name="Nazwa">
        Mecze jako trener: <input type="text" name="Mecze">
        Wygrane: <input type="text" name="Wygrane">
        Przegrane: <input type="text" name="Przegrane"><br>
        Ilosc Trofeów: <input type="text" name="IloscTrofeum">
        <input type="submit" name="zatwierdz" value="Szukaj" class="btn btn-primary mb-2">
    </form>  
        <br>
        <?php
        
        
        
        if(!empty($_POST['Imie'])){
            $imie = $_POST['Imie'];
        }else {
            $imie = '%';
        }
        if(!empty($_POST['Nazwisko'])){
            $nazwisko = $_POST['Nazwisko'];
        }else{
            $nazwisko =  '%';
        }if(!empty($_POST['Wiek'])){
            $wiek = $_POST['Wiek'];
        }else{
            $wiek =  '%';
        }
        if(!empty($_POST['Narodowosc'])){
            $narodowosc = $_POST['Narodowosc'];
        }else{
            $narodowosc =  '%';
        }
        if(!empty($_POST['Nazwa'])){
            $nazwa = $_POST['Nazwa'];
        }else{
            $nazwa =  '%';
        }
        if(!empty($_POST['Mecze'])){
            $mecze = $_POST['Mecze'];
        }else{
            $mecze =  '%';
        }
        if(!empty($_POST['Wygrane'])){
            $wygrane = $_POST['Wygrane'];
        }else{
            $wygrane =  '%';
        }
        if(!empty($_POST['Przegrane'])){
            $przegrane = $_POST['Przegrane'];
        }else{
            $przegrane =  '%';
        }
        if(!empty($_POST['IloscTrofeum'])){
            $iloscTrofeum = $_POST['IloscTrofeum'];
        }else{
            $iloscTrofeum =  '%';
        }
        $sql = "SELECT id_trenera, Imie, Nazwisko, YEAR(CURRENT_DATE()) - YEAR(dataurodzenia) - (DATE_FORMAT(CURRENT_DATE(), '%m%d') < DATE_FORMAT(dataurodzenia, '%m%d')) as 'Wiek', Narodowosc,
        NazwaKlubu, MeczeJakoTrener, Wygrane, Przegrane, count(id_trofeum) as 'IloscTrofeum'
        FROM `trener` as tr left join trofea as t on tr.id_trenera = t.trener_id_trenera left join trenerstatystyki as ts on tr.id_trenera = ts.trener_id_trenera
        left join klub as k on tr.klub_id_klubu = k.id_klubu
        Group by id_trenera
        having Imie like '$imie' and Nazwisko like '$nazwisko' and Wiek like '$wiek' and Narodowosc like '$narodowosc' and NazwaKlubu like '$nazwa' and MeczeJakoTrener like '$mecze' and Wygrane like '$wygrane' and Przegrane like '$przegrane' and IloscTrofeum like '$iloscTrofeum'";
        $polaczenie = new mysqli('localhost','root','','projekt');
        if(!$polaczenie->connect_errno){
            if(!empty($_GET['id'])){
                $sqlDel = "Delete from `klub` where id_klubu = '$_GET[id]'";
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
                        <th scope="col"><center>Imie</center></th>
                        <th scope="col"><center>Nazwisko</center></th>
                        <th scope="col"><center>Wiek</center></th>
                        <th scope="col"><center>Narodowosc</center></th>
                        <th scope="col"><center>Nazwa klubu</center></th>
                        <th scope="col"><center>Mecze jako trener</center></th>
                        <th scope="col"><center>Wygrane</center></th>
                        <th scope="col"><center>Przegrane</center></th>
                        <th scope="col"><center>Ilosc Trofeów</center></th>
                    </tr>
                    </thead>
                    <tbody>
                
TABELA;
                while($res = $result->fetch_assoc()){ 
                    echo <<<TABELA
                    <tr>
                    <td><center>$res[Imie] </center></td>
                    <td><center>$res[Nazwisko] </center></td>
                    <td><center>$res[Wiek] </center></td>
                    <td><center>$res[Narodowosc] </center></td>
                    <td><center>$res[NazwaKlubu] </center></td>
                    <td><center>$res[MeczeJakoTrener] </center></td>
                    <td><center>$res[Wygrane] </center></td>
                    <td><center>$res[Przegrane] </center></td>
                    <td><center>$res[IloscTrofeum] </center></td>
                    <td><a href='trenerzy.php?id=$res[id_trenera]'>Usuń</a></td>
                    <td><a href='trenerzyEdytuj.php?id=$res[id_trenera]'>Edytuj</a></td>
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
        <div class="col-md-3 col-md-offset-10">
        
        <a href = "trenerzyDodaj.php"><button class = "btn btn-primary mb-2">Dodaj nowego trenera</button></a>
            
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