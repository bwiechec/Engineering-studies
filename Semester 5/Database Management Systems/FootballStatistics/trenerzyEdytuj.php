<?php
session_start();
require_once('php/dataCzas.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Edytuj trenera</title>
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
                
                $sql = "SELECT id_trenera, Imie, Nazwisko, dataurodzenia, Narodowosc, MeczeJakoTrener, Wygrane, Przegrane from trener as t left join trenerstatystyki as ts on t.id_trenera = ts.trener_id_trenera where t.id_trenera = '$_GET[id]'";
                
                if($rezultat=$polaczenie->query($sql)){
                $result = $rezultat;
                while($res = $result->fetch_assoc()){ 
                    $mecze = intval($res['MeczeJakoTrener']);
                    $wygrane = intval($res['Wygrane']);
                    $przegrane = intval($res['Przegrane']);
                    echo <<<TABELA
                    
            <form role="form" action="php/edytujTrenera.php?id=$_GET[id]" method="POST">
            <div class="form-group">
            <label for="Imie">Imie:</label>         
            <input type="text" class="form-control" id="disabledInput" name="Imie" value='$res[Imie]' disabled>
            </div>
            <div class="form-group">
            <label for="Nazwisko">Nazwisko:</label>         
            <input type="text" class="form-control" id="disabledInput" name="Nazwisko" value='$res[Nazwisko]' disabled>
            </div>            
            
            
            
            <div class="form-group">
            <label for="Klub">Klub trenera:</label>
            <select name="Klub" id="Klub" class="form-control">
TABELA;  
                    $sql = "select NazwaKlubu from klub as k left join trener as t on k.id_klubu = t.klub_id_klubu where id_trenera is NULL or id_trenera like $_GET[id]";
        
                        if($rezultat=$polaczenie->query($sql)){
                            
                                while($res = $rezultat->fetch_assoc()){ 
                                    echo "<option>$res[NazwaKlubu]</option>";
                                }
                            
                        }else{
                            echo "Błąd w zapytaniu";
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
            <input type="number" class="form-control" min="0" max="1999" step="1" value='$wygrane' id="Wygrane" name="Wygrane"/>
            </div>
            
            <div class="form-group">
            <label for="Asysty">Podaj ilość zdobytych asyst: </label><br>      
            <input type="number" class="form-control" min="0" max="1999" step="1" value='$przegrane' id="Przegrane" name="Przegrane"/>
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