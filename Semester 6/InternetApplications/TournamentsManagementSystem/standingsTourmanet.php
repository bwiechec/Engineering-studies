<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Drabinka Turnieju</title>
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
        
            function getInitBracket($players){
                $count = count($players);
                $numberOfRounds = log($count / 2, 2);
                for ($i = 0; $i < $numberOfRounds; $i++) {
                    
                    $out = array();
                    $splice = pow(2, $i); 
                    
                    while (count($players) > 0) {

                        $out = array_merge($out, array_splice($players, 0, $splice));
                        $out = array_merge($out, array_splice($players, -$splice));

                    }            

                    $players = $out;
                }
                
                $outMatch = array();
                // Set matches
                $match = $outMatch;
                return $players;
            }
        
            function getSeparation($nrOfRounds){
                $separation = array();
                array_push($separation, 0);
                for($i = 1; $i <= $nrOfRounds; $i++){
                    if($i == 1){
                        array_push($separation, 2);
                    }else if($i == 2){
                        array_push($separation, 4);                        
                    }else if($i >= 3){
                        array_push($separation, 2 * $separation[$i-1]);
                    }
                }
                return $separation;
            }
        
            function drawBracket($count, $id){
                $numberOfRounds = ceil(log($count, 2));
                $separation = getSeparation($numberOfRounds);
                
                
                $polaczenie = @new mysqli('127.0.0.1','root','','turnieje');
                $sql = "SELECT u1.name as name1, u1.nazwisko as nazwisko1, u2.name as name2, u2.nazwisko as nazwisko2 FROM `matches` as m join user as u1 on m.id_user1 = u1.id_user join user as u2 on m.id_user2 = u2.id_user WHERE id_tournament like $id order by matchNr";
                if(!$polaczenie->connect_error){
                    if($rezultat = $polaczenie->query($sql)){
                        $rez = array();
                        $polaczenie->close();
                        while($row = mysqli_fetch_array($rezultat)){                            
                            array_push($rez, $row);
                        }
                    }else{
                        $polaczenie->close();
                        echo "blad w zapytaniu draw";
                    }
                }else{
                        $polaczenie->close();
                    echo "blad w polaczaniu draw";
                }
                
                echo <<<TEXT
                    <table class = "table">
                    <thead>
                    <tr>
TEXT;   
                $matchNumber = array();
                for($i = 1; $i <= $numberOfRounds; $i++){
                    if($i == 1){
                        array_push($matchNumber, 0);
                    }else if($i == 2){
                        array_push($matchNumber, $count/2 + 1);                        
                    }else{
                        array_push($matchNumber, $matchNumber[$i-1]/2 + 1);                          
                    }
                }
                for($i = 1; $i <= $numberOfRounds; $i++){
                    echo "<th>Runda $i</th>";
                }
                echo <<<TEXT
                    </tr>
                    </thead>
                    <tbody>
TEXT;
                for($i = 1; $i <= $count; $i++){
                    echo "<tr>";
                    if($i%2 != 0){
                        $curMatch = $rez[$matchNumber[0]]['name1'].' '.$rez[$matchNumber[0]]['nazwisko1'].' vs '.$rez[$matchNumber[0]]['name2'].' '.$rez[$matchNumber[0]]['nazwisko2'];
                        echo "<td>$curMatch</td>";
                        $matchNumber[0]++;
                    }else{
                        echo "<td></td>";
                    }
                    for($j = 1; $j < $numberOfRounds; $j++){
                        if($i >= $separation[$j]){
                            if(($i-$separation[$j]) % $separation[$j+1] == 0){
                                if(isset($rez[$matchNumber[$j]]) && !empty($rez[$matchNumber[$j]])){
                                    $curMatch = $rez[$matchNumber[$j]]['name1'].' '.$rez[$matchNumber[$j]]['nazwisko1'].' vs '.$rez[$matchNumber[$j]]['name2'].' '.$rez[$matchNumber[$j]]['nazwisko2'];
                                    echo "<td>$curMatch</td>";
                                    $matchNumber[$j]++;                                    
                                }else{
                                    echo "<td>TBA</td>";                                     
                                }
                            }else{
                                echo "<td></td>";                                
                            }
                        }
                    }
                    echo "</tr>";
                }
                
                echo <<<TEXT
                    </tbody>
                    </table>
                    <br>
TEXT;
            }
                
            if(!empty($_GET['id'])){
                $id = $_GET['id'];
            }else{
                header("Location: index.php");
            }
        
            $polaczenie = @new mysqli('127.0.0.1','root','','turnieje');
            $sql = "SELECT * FROM `tournament` WHERE id_tournament like $id";
            $sql2 = "SELECT * FROM `user_tournament` WHERE id_tournament like $id order by rank";
        
            if(!$polaczenie->connect_error){
                if($rezultat = $polaczenie->query($sql)){
                    $rez = $rezultat->fetch_assoc();
                    //$count = $rezultat->num_rows;
                    if($rez['ladder']){ 
                        if($rezultat2 = $polaczenie->query($sql2)){
                            $count = $rezultat2->num_rows;
                            drawBracket($count, $id);
                        }else{                            
                            $polaczenie->close();
                            echo "błąd w zapytaniu 2";                            
                        }
                    }else{
                        if(strtotime(date("Y-m-d")) > strtotime($rez['time'])){
                            if($rezultat2 = $polaczenie->query($sql2)){
                                $count = $rezultat2->num_rows;
                            //$count = 32;
                                $rez2 = array();
                                while($row = mysqli_fetch_array($rezultat2)){
                                
                                    array_push($rez2, $row);

                                }
                                $players = range(0, $count-1);
                                $ret = array();
                                $ret = getInitBracket($players);
                                for ($i = 0; $i < $count-1; $i+=2) {
                                    $id_user1 = $rez2[$players[$i]]['id_user'];
                                    $id_user2 = $rez2[$players[$i+1]]['id_user'];
                                    $matchNr = ceil(($i+1)/2);
                                    $datetime = new DateTime();
                                    $interval = new DateInterval('P1D');
                                    $datetime->sub($interval);
                                    $datetime = $datetime->format('Y-m-d');
                                    $sql3 = "INSERT INTO `matches` (`id_match`, `id_tournament`, `id_user1`, `id_user2`, `round`, `deadline`, `matchNr`) VALUES (NULL, '$id', '$id_user1', '$id_user2', '1', '$datetime', '$matchNr')";
                                    if($rezultat3 = $polaczenie->query($sql3)){
                                    }else{
                                        echo "Błąd w zapytaniu 3";
                                    }
                                }
                                $sql4 = "UPDATE `tournament` SET `ladder` = '1' WHERE `tournament`.`id_tournament` = $id";
                                if($rezultat4 = $polaczenie->query($sql4)){
                                }else{
                                    echo "blad w zapytaniu 4";
                                }
                                $polaczenie->close();
                                drawBracket($count, $id);
                            }else{
                                $polaczenie->close();
                                echo "błąd w zapytaniu 2";
                            }
                        }
                    }
                }else{
                    $polaczenie->close();
                    echo "błąd w zapytaniu";
                }
            }else{
                $polaczenie->close();
                echo "Błąd w połączeniu";
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