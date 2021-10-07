<?php
session_start();
require_once('php/dataCzas.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Piłkarze</title>
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
    <form action="pilkarze.php" method="post" >
    <label>Wyszukaj</label><br>
        Imię: <input type="text" name="Imie">
        Nazwisko: <input type="text" name="Nazwisko">
        Nr na koszulce: <input type="text" name="Numer">
        Wiek: <input type="text" name="Wiek"><br>
        Narodowosc: <input type="text" name="Narodowosc">
        Klub: <input type="text" name="NazwaKlubu">
        Rozegrane Mecze: <input type="text" name="RozegraneMecze">
        Bramki: <input type="text" name="Bramki"><br>
        Asysty: <input type="text" name="Asysty">
        ZolteKartki: <input type="text" name="ZolteKartki">
        CzerwoneKartki: <input type="text" name="CzerwoneKartki"><br>
        Ilosc Trofeów: <input type="text" name="IloscTrofeum">
        <input type="submit" name="zatwierdz" value="Szukaj" class="btn btn-primary mb-2">
    </form>  
        <br>
        <?php
        
        
        if(!empty($_POST['Imie'])){
            $imie = $_POST['Imie'];
        }else{
            $imie = '%';
        }
        if(!empty($_POST['Nazwisko'])){
            $nazwisko = $_POST['Nazwisko'];
        }else{
            $nazwisko =  '%';
        }
        if(!empty($_POST['Numer'])){
            $numer = $_POST['Numer'];
        }else{
            $numer =  '%';
        }
        if(!empty($_POST['Wiek'])){
            $wiek = $_POST['Wiek'];
        }else{
            $wiek =  '%';
        }
        if(!empty($_POST['Narodowosc'])){
            $narodowosc = $_POST['Narodowosc'];
        }else{
            $narodowosc =  '%';
        }
        if(!empty($_POST['NazwaKlubu'])){
            $nazwaKlubu = $_POST['NazwaKlubu'];
        }else{
            $nazwaKlubu =  '%';
        }
        if(!empty($_POST['RozegraneMecze'])){
            $rozegraneMecze = $_POST['RozegraneMecze'];
        }else{
            $rozegraneMecze =  '%';
        }
        if(!empty($_POST['Bramki'])){
            $bramki = $_POST['Bramki'];
        }else{
            $bramki ='%';
        }
        if(!empty($_POST['Asysty'])){
            $asysty = $_POST['Asysty'];
        }else{
            $asysty =  '%';
        }
        if(!empty($_POST['ZolteKartki'])){
            $zolteKartki = $_POST['ZolteKartki'];
        }else{
            $zolteKartki =  '%';
        }
        if(!empty($_POST['CzerwoneKartki'])){
            $czerwoneKartki = $_POST['CzerwoneKartki'];
        }else{
            $czerwoneKartki =  '%';
        }
        if(!empty($_POST['IloscTrofeum'])){
            $iloscTrofeum = $_POST['IloscTrofeum'];
        }else{
            $iloscTrofeum =  '%';
        }
        $sql = "SELECT id_pilkarza, Imie, Nazwisko, NumerNaKoszulce, YEAR(CURRENT_DATE()) - YEAR(dataurodzenia) - (DATE_FORMAT(CURRENT_DATE(), '%m%d') < DATE_FORMAT(dataurodzenia, '%m%d')) as 'Wiek', Narodowosc, NazwaKlubu, RozegraneMecze, Bramki, Asysty, ZolteKartki, CzerwoneKartki, count(id_trofeum) as 'IloscTrofeum' from pilkarz as p left join klub as k on p.klub_id_klubu = k.id_klubu left join pilkarzstatystyki as ps on ps.pilkarz_id_pilkarza = p.id_pilkarza left join trofea as t on p.id_pilkarza = t.pilkarz_id_pilkarza group by id_pilkarza
        having Imie like '$imie' and Nazwisko like '$nazwisko' and NumerNaKoszulce like '$numer' and Wiek like '$wiek' and Narodowosc like '$narodowosc' and NazwaKlubu like '$nazwaKlubu' and RozegraneMecze like '$rozegraneMecze' and Bramki like '$bramki' and Asysty like '$asysty' and ZolteKartki like '$zolteKartki' and CzerwoneKartki like '$czerwoneKartki' and IloscTrofeum like '$iloscTrofeum'";
        
        #echo "$sql";
        
        $polaczenie = new mysqli('localhost','root','','projekt');
        if(!$polaczenie->connect_errno){
            if(!empty($_GET['id'])){
                $sqlDel = "Delete from `pilkarz` where id_pilkarza = '$_GET[id]'";
                if(!($rezultat=$polaczenie->query($sqlDel))){
                    echo "Błąd przy usuwaniu";
                }
            }
            if($rezultat=$polaczenie->query($sql)){
                $result = $rezultat;
                echo <<<TABELA
                    <table class="table">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col"><center>Imię</center></th>
                        <th scope="col"><center>Nawisko</center></th>
                        <th scope="col"><center>Numer</center></th>
                        <th scope="col"><center>Wiek</center></th>
                        <th scope="col"><center>Narodowość</center></th>
                        <th scope="col"><center>Klub</center></th>
                        <th scope="col"><center>Rozegrane mecze</center></th>
                        <th scope="col"><center>Bramki strzelone</center></th>
                        <th scope="col"><center>Asysty</center></th>
                        <th scope="col"><center>Żółte kartki</center></th>
                        <th scope="col"><center>Czerwone kartki</center></th>
                        <th scope="col"><center>Trofea</center></th>
                    </tr>
                    </thead>
                    <tbody>
                
TABELA;
                while($res = $result->fetch_assoc()){ 
                    echo <<<TABELA
                    <tr>
                    <td><center>$res[Imie] </center></td>
                    <td><center>$res[Nazwisko] </center></td>
                    <td><center>$res[NumerNaKoszulce] </center></td>
                    <td><center>$res[Wiek] </center></td>
                    <td><center>$res[Narodowosc] </center></td>
                    <td><center>$res[NazwaKlubu] </center></td>
                    <td><center>$res[RozegraneMecze] </center></td>
                    <td><center>$res[Bramki] </center></td>
                    <td><center>$res[Asysty] </center></td>
                    <td><center>$res[ZolteKartki] </center></td>
                    <td><center>$res[CzerwoneKartki] </center></td>
                    <td><center>$res[IloscTrofeum] </center></td>
                    <td><a href='pilkarze.php?id=$res[id_pilkarza]'>Usuń</a></td>
                    <td><a href='pilkarzeEdytuj.php?id=$res[id_pilkarza]'>Edytuj</a></td>
                   </tr>
TABELA;
                }
                echo "</tbody></table>";
            }
            else{
                echo "Błąd w zapytaniu!";
            }
        }
        else{
            echo "Błąd w łączeniu z bazą";
        }
        $polaczenie->close(); 
        ?>  
        
        <div class="row justify-content-end">
        <div class="col-md-3 col-md-offset-10">
        
        <a href = "pilkarzeDodaj.php"><button class = "btn btn-primary mb-2">Dodaj nowego piłkarza</button></a>
            
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