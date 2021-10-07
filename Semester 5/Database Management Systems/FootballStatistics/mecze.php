<?php
session_start();
require_once('php/dataCzas.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Mecze</title>
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

    <form action="mecze.php" method="post">
        Data: <input type="text" name="Data">
        Gospodarze: <input type="text" name="Gospodarze">
        Goście: <input type="text" name="Goscie">
        Wynik: <input type="text" name="Wynik">
        <input type="submit" name="zatwierdz" value="Szukaj" class="btn btn-primary mb-2">
    </form>  
        <br>
        <?php
        
        if(!empty($_POST['Data'])){
            $data = $_POST['Data'];
        }else {
            $data = '%';
        }
        if(!empty($_POST['Gospodarze'])){
            $gospodarze = $_POST['Gospodarze'];
        }else{
            $gospodarze =  '%';
        }if(!empty($_POST['Goscie'])){
            $goscie = $_POST['Goscie'];
        }else{
            $goscie =  '%';
        }
        if(!empty($_POST['Wynik'])){
            $wynik = $_POST['Wynik'];
        }else{
            $wynik =  '%';
        }
        $sql = "SELECT DataMeczu, k2.NazwaKlubu as 'NazwaKlubu1', k1.NazwaKlubu  as 'NazwaKlubu2', Rezultat FROM `mecz` as m left join klub as k1 on k1.id_klubu = m.klub_id_klubu left join klub as k2 on k2.id_klubu = m.klub_id_klubu1
        having DataMeczu like '$data' and NazwaKlubu1 like '$gospodarze' and NazwaKlubu2 like '$goscie'
        and Rezultat like '$wynik'";
                
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
                        <th scope="col"><center>Data</center></th>
                        <th scope="col"><center>Gospodarze</center></th>
                        <th scope="col"><center>Goście</center></th>
                        <th scope="col"><center>Wynik</center></th>
                    </tr>
                    </thead>
                    <tbody>
                
TABELA;
                while($res = $result->fetch_assoc()){ 
                    echo <<<TABELA
                    <tr>
                    <td><center>$res[DataMeczu] </center></td>
                    <td><center>$res[NazwaKlubu1] </center></td>
                    <td><center>$res[NazwaKlubu2] </center></td>
                    <td><center>$res[Rezultat] </center></td>
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
        
        <a href = "meczeDodaj.php"><button class = "btn btn-primary mb-2">Dodaj nowy mecz</button></a>
            
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