<?php
session_start();
require_once('php/dataCzas.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Dodaj piłkarza</title>
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
        <form role="form" action="php/dodajPilkarza.php" method="POST">
            <div id="komunikat">
            <?php
                if(isset($_SESSION['komunikat'])){
                    echo "$_SESSION[komunikat]";
                    unset($_SESSION['komunikat']);
                }    
            ?>
            </div>
            <div class="form-group">
            <label for="Imie">Imie:</label>         
            <input type="text" class="form-control" id="Imie" name="Imie">
            </div>
            <div class="form-group">
            <label for="Nazwisko">Nazwisko:</label>         
            <input type="text" class="form-control" id="Nazwisko" name="Nazwisko">
            </div>            
            
            <div class="form-group">
            <label for="Numer">Podaj numer na koszulce: </label><br>      
            <input type="number" class="form-control" min="1" max="99" step="1" value="1" id="Numer" name="Numer"/>
            </div>
            
            <div class="form-group">
            <label for="Data">Podaj date urodzenia: </label><br>      
            <input type="date" class="form-control" id="Data" name="Data"/>
            </div>
            
            <div class="form-group">
            <label for="Kraj">Podaj kraj pochodzenia piłkarza:</label>         
            <input type="text" class="form-control" id="Kraj" name="Kraj">
            </div>
            
            <div class="form-group">
            <label for="Klub">Klub piłkarza:</label>
            <select name="Klub" id="Klub" class="form-control">
                <?php
                
                    $polaczenie = new mysqli('localhost','root','','projekt');
                    if(!$polaczenie->connect_errno){
                        $sql = "select NazwaKlubu from klub";
        
                        if($rezultat=$polaczenie->query($sql)){
                            
                                while($res = $rezultat->fetch_assoc()){ 
                                    echo "<option>$res[NazwaKlubu]</option>";
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
            
            <div class="form-group">
            <label for="Mecze">Podaj ilość rozegranych meczy: </label><br>      
            <input type="number" class="form-control" min="1" max="1999" step="1" value="1" id="Mecze" name="Mecze"/>
            </div>
                
            <div class="form-group">
            <label for="Bramki">Podaj ilość zdobytych bramek: </label><br>      
            <input type="number" class="form-control" min="0" max="999" step="1" value="0" id="Bramki" name="Bramki"/>
            </div>
            
            <div class="form-group">
            <label for="Asysty">Podaj ilość zdobytych asyst: </label><br>      
            <input type="number" class="form-control" min="0" max="1999" step="1" value="0" id="Asysty" name="Asysty"/>
            <label for="Zolte">Podaj ilość otrzymanych żółtych kartek: </label><br>      
            <input type="number" class="form-control" min="0" max="299" step="1" value="0" id="Zolte" name="Zolte"/>
            <label for="Czerwone">Podaj ilość otrzymanych czerwonych kartek: </label><br>      
            <input type="number" class="form-control" min="0" max="199" step="1" value="0" id="Czerwone" name="Czerwone"/>
            </div>
            
            <button type="submit" id="add" class="btn btn-primary">Dodaj piłkarza</button>

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