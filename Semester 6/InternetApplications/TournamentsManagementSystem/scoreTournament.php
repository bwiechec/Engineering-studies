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
	<title>Mecze w turnieju</title>
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

        
            
    <div class="col-md-9 col-sm-9 col-md-offset-2">
        <?php 
            if(isset($_SESSION['komunikat'])){
                echo $_SESSION['komunikat'];
                unset($_SESSION['komunikat']);
            }       
        ?> 
        <?php
            if(isset($_GET['id'])){
                $id = $_GET['id'];
            }  
            $polaczenie = new mysqli('localhost','root','','turnieje');
            if(!$polaczenie->connect_errno){
                //Mecze gdzie jest gospodarzem
                $sql = "SELECT m.id_user1 as id_user1, m.id_user2 as id_user2, u1.name as name1, u1.nazwisko as nazwisko1, u2.name as name2, u2.nazwisko as nazwisko2, m.round as round, m.winner as winner, m.winner1 as winner1, m.deadline as deadline, m.matchNr as matchNr FROM `matches` as m join user as u1 on m.id_user1 = u1.id_user join user as u2 on m.id_user2 = u2.id_user WHERE id_tournament like $id and m.id_user1 like '$_SESSION[id]' order by matchNr";
                if($rezultat = $polaczenie->query($sql)){
                    $rez = array();
                    while($row = mysqli_fetch_array($rezultat)){                        
                        array_push($rez, $row);
                    }
                }else{
                    echo "błąd w zapytaniu";
                }
                
                //Mecze gdzie jest gościem
                $sql2 = "SELECT m.id_user1 as id_user1, m.id_user2 as id_user2, u1.name as name1, u1.nazwisko as nazwisko1, u2.name as name2, u2.nazwisko as nazwisko2, m.round as round, m.winner as winner, m.winner2 as winner2, m.deadline as deadline, m.matchNr as matchNr FROM `matches` as m join user as u1 on m.id_user1 = u1.id_user join user as u2 on m.id_user2 = u2.id_user WHERE id_tournament like $id and m.id_user2 like '$_SESSION[id]' order by matchNr";
                if($rezultat2 = $polaczenie->query($sql2)){
                    $rez2 = array();
                    while($row = mysqli_fetch_array($rezultat2)){                        
                        array_push($rez2, $row);
                    }
                }else{
                    echo "błąd w zapytaniu2";
                }
                
                $sql3 = "Select * from tournament where id_tournament like $id";
                if($rezultat3 = $polaczenie->query($sql3)){
                    $rez3 = mysqli_fetch_assoc($rezultat3);
                }else{
                    echo "błąd w zapytaniu3";
                }
                foreach($rez as $r){
                    if(!is_null($r['winner'])){
                        if($r['winner'] == $_SESSION['id']){
                            echo <<<TEXT
                            <b>Turniej: $rez3[name]</b><br>
                            <span style='color: green;'><b>$r[name1] $r[nazwisko1] (WYGRANY)</b></span> vs $r[name2] $r[nazwisko2]<br>   <br>  
TEXT;                                              
                        }else{
                            echo <<<TEXT
                            <b>Turniej: $rez3[name]</b><br>
                            <b>$r[name1] $r[nazwisko1]</b> vs <span style='color: green;'>$r[name2] $r[nazwisko2] (WYGRANY)</span><br>  <br>   
TEXT;                          
                        }
                    }else{
                        if(!is_null($r['winner1'])){
                            echo <<<TEXT
                            <b>Turniej: $rez3[name]</b><br>
                            <b>$r2[name1] $r[nazwisko1]</b> vs $r[name2] $r[nazwisko2]<br>  <br>   
TEXT;                                                  
                        }else{
                            echo <<<TEXT
                            <b>Turniej: $rez3[name]</b><br>
                            <b>$r[name1] $r[nazwisko1]</b> vs $r[name2] $r[nazwisko2] <br> <form action=php/updateBracket.php method=post>Kto wygrał?
                            <input type='hidden' class='form-control' id='idInput'  name='idInput' value='$_GET[id]' >
                            <input type='hidden' class='form-control' id='winnerInput'  name='winnerInput' value='winner1' >
                            <input type='hidden' class='form-control' id='round'  name='round' value='$r[round]' >
                            <input type='hidden' class='form-control' id='matchNr'  name='matchNr' value='$r[matchNr]' >
                            <select name="winner" id="winner">
                            <option value="$r[id_user1]">Ty</option>
                            <option value="$r[id_user2]">$r[name2] $r[nazwisko2]</option> 
                            </select>
                            <input type="submit" name="zatwierdz" value="Zatwierdź" class="btn btn-primary mb-2">
                            </form><br>    <br> 
TEXT;                              
                        }
                        
                    }
                }
                
                foreach($rez2 as $r2){
                    if(!is_null($r2['winner'])){
                        if($r2['winner'] == $_SESSION['id']){
                            echo <<<TEXT
                            <b>Turniej: $rez3[name]</b><br>
                            $r2[name1] $r2[nazwisko1] vs <span style='color: green;'><b>$r2[name2] $r2[nazwisko2] (WYGRANY)</b></span><br> <br>    
TEXT;                                              
                        }else{
                            echo <<<TEXT
                            <b>Turniej: $rez3[name]</b><br>
                            <span style='color: green;'>$r2[name1] $r2[nazwisko1] (WYGRANY)</span> vs <b>$r2[name2] $r2[nazwisko2]</b><br>  <br>   
TEXT;                          
                        }
                    }else{
                        if(!is_null($r2['winner2'])){   
                            echo <<<TEXT
                            <b>Turniej: $rez3[name]</b><br>
                            $r2[name1] $r2[nazwisko1] vs <b>$r2[name2] $r2[nazwisko2]</b><br>  <br>   
TEXT;                        
                        }else{
                            echo <<<TEXT
                            <b>Turniej: $rez3[name]</b><br>
                            $r2[name1] $r2[nazwisko1] vs <b>$r2[name2] $r2[nazwisko2]</b><br> <form action=php/updateBracket.php method=post>Kto wygrał?
                            <input type='hidden' class='form-control' id='idInput'  name='idInput' value='$_GET[id]' >
                            <input type='hidden' class='form-control' id='idInput'  name='winnerInput' value='winner2' >
                            <input type='hidden' class='form-control' id='round'  name='round' value='$r2[round]' >
                            <input type='hidden' class='form-control' id='matchNr'  name='matchNr' value='$r2[matchNr]' >
                            <select name="winner" id="winner">
                            <option value="$r2[id_user1]">$r2[name1] $r2[nazwisko1]</option>
                            <option value="$r2[id_user2]">Ty</option> 
                            </select>
                            <input type="submit" name="zatwierdz" value="Zatwierdź" class="btn btn-primary mb-2">
                            </form><br>    <br> 
TEXT;
                        }
                        
                    }
                }
            }else{
                echo "błąd w połączeniu";
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