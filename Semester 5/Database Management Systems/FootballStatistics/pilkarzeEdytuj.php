<?php
session_start();
require_once('php/dataCzas.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Edytuj piłkarza</title>
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
            <?php
                if(isset($_SESSION['komunikat'])){
                    echo "<div id='komunikat'>$_SESSION[komunikat]</div>";
                    unset($_SESSION['komunikat']);
                }    
                
                $polaczenie = new mysqli('localhost','root','','projekt');
            if(!$polaczenie->connect_errno){
                
                $sql = "SELECT id_pilkarza, Imie, Nazwisko, NumerNaKoszulce, dataurodzenia, Narodowosc, RozegraneMecze, Bramki, Asysty, ZolteKartki, CzerwoneKartki from pilkarz as p left join pilkarzstatystyki as ps on p.id_pilkarza = ps.pilkarz_id_pilkarza where p.id_pilkarza = '$_GET[id]'";
                
                if($rezultat=$polaczenie->query($sql)){
                $result = $rezultat;
                while($res = $result->fetch_assoc()){ 
                    $mecze = intval($res['RozegraneMecze']);
                    $bramki = intval($res['Bramki']);
                    $asysty = intval($res['Asysty']);
                    $zolte = intval($res['ZolteKartki']);
                    $czerwone = intval($res['CzerwoneKartki']);
                    echo <<<TABELA
                    
            <form role="form" action="php/edytujPilkarza.php?id=$_GET[id]" method="POST">
            <div class="form-group">
            <label for="Imie">Imie:</label>         
            <input type="text" class="form-control" id="disabledInput" name="Imie" value='$res[Imie]' disabled>
            </div>
            <div class="form-group">
            <label for="Nazwisko">Nazwisko:</label>         
            <input type="text" class="form-control" id="disabledInput" name="Nazwisko" value='$res[Nazwisko]' disabled>
            </div>            
            
            <div class="form-group">
            <label for="Numer">Podaj numer na koszulce: </label><br>      
            <input type="number" class="form-control" min="1" max="99" step="1" value='$res[NumerNaKoszulce]' id="Numer" name="Numer"/>
            </div>
            
            
            <div class="form-group">
            <label for="Klub">Klub piłkarza:</label>
            <select name="Klub" id="Klub" class="form-control">
TABELA;
                        $sql2 = "select NazwaKlubu from klub";
        
                        if($rezultat=$polaczenie->query($sql2)){
                            
                                while($res = $rezultat->fetch_assoc()){ 
                                    echo "<option>$res[NazwaKlubu]</option>";
                                }
                            
                        }else{
                            echo "Błąd w zapytaniu2";
                        }
                    echo <<<TABELA
                    </select>
            </div>       
            
            <div class="form-group">
            <label for="Mecze">Podaj ilość rozegranych meczy: </label><br>      
            <input type="number" class="form-control" min="1" max="1999" step="1" value='$mecze' id="Mecze" name="Mecze"/>
            </div>
                
            <div class="form-group">
            <label for="Bramki">Podaj ilość zdobytych bramek: </label><br>      
            <input type="number" class="form-control" min="0" max="999" step="1" value='$bramki' id="Bramki" name="Bramki"/>
            </div>
            
            <div class="form-group">
            <label for="Asysty">Podaj ilość zdobytych asyst: </label><br>      
            <input type="number" class="form-control" min="0" max="1999" step="1" value='$asysty' id="Asysty" name="Asysty"/>
            </div>
                
            
            <div class="form-group">
            <label for="Zolte">Podaj ilość otrzymanych żółtych kartek: </label><br>      
            <input type="number" class="form-control" min="0" max="299" step="1" value='$zolte' id="Zolte" name="Zolte"/>
            </div>
            
            <div class="form-group">
            <label for="Czerwone">Podaj ilość otrzymanych czerwonych kartek: </label><br>      
            <input type="number" class="form-control" min="0" max="199" step="1" value='$czerwone' id="Czerwone" name="Czerwone"/>
            </div>
            <button type="submit" id="add" class="btn btn-primary">Zatwierdź edycję</button>

        </form>
TABELA;                   
                }
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