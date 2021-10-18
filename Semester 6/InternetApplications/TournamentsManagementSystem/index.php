<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Turnieje</title>
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
    
    <div class="container" style="margin-top: 70px;margin-left: auto; margin-right: auto;"> 

        <?php if(isset($_SESSION['komunikat'])){
            echo $_SESSION['komunikat'];
            unset($_SESSION['komunikat']);
        } ?>
        
    <form action="index.php" method="post">
        Nazwa turnieju: <input type="text" name="Nazwa">
        Liczba uczestników <input type = "text" name="Uczestników">
        Status turnieju: <select name="status" id="status">
                            <option value="Otwarty">Otwarty</option>
                            <option value="Po zapisach">Po zapisach</option>
                            <option value="W trakcie">W trakcie</option>
                        </select>
        <input type="submit" name="zatwierdz" value="Szukaj" class="btn btn-primary mb-2">
    </form>  
        <?php
            if(!empty($_POST['Nazwa'])){
                $nazwa = $_POST['Nazwa'];
            }else {
                $nazwa = '%';
            }
            if(!empty($_POST['Uczestników'])){
                $uczestnikow = $_POST['Uczestników'];
            }else {
                $uczestnikow = '%';
            }
            if(!empty($_POST['status'])){
                $status = $_POST['status'];
                if($status == "W trakcie"){
                    $znakDeadline = "<";
                    $znakTime = "<";
                }else if($status == "Po zapisach"){
                    $znakDeadline = "<";
                    $znakTime = ">";                    
                }else{
                    $znakDeadline = ">";
                    $znakTime = ">";                    
                }
                $curDate = strtotime(date("Y-m-d"));
            }else {
                $znakDeadline = ">";
                $znakTime = ">"; 
                $curDate = strtotime(date("Y-m-d"));
            }
            if(!empty($_GET['site'])){
                $siteA = ($_GET['site'] - 1) * 10 ;
                $siteB = $_GET['site'] * 10;
            }else {
                $siteA = 0;
                $siteB = 10;
            }
        
            $polaczenie = @new mysqli('127.0.0.1','root','','turnieje');
            $sql = "SELECT * FROM `tournament` WHERE name like '$nazwa' and limitation like '$uczestnikow' and deadline $znakDeadline $curDate and time $znakTime $curDate LIMIT $siteA,$siteB";
        
            if(!$polaczenie->connect_error){
                if($rezultat = $polaczenie->query($sql)){
                    $polaczenie->close();
                   echo <<<TEXT
                   <table class="table">
                   <thead>
                   <tr>
                   <th scope="col"><center>Nazwa</center></th>
                   <th scope="col"><center>Data rozpoczęcia</center></th>
                   <th scope="col"><center>Limit uczestników</center></th>
                   <th scope="col"><center>Status</center></th>
                   </tr>
                    </thead>
                    <tbody>
TEXT;   
                    foreach($rezultat as $i){
                    if(strtotime(date("Y-m-d")) > strtotime($i['time'])){ 
                        $status = "<p style = 'color:red'>W trakcie</p>";
                    }else if(strtotime(date("Y-m-d")) > strtotime($i['deadline'])){ 
                        $status = "<p style = 'color:orange'>Po zapisach</p>";                        
                    }else{
                        $status = "<p style = 'color:green'>Otwarty</p>";
                    }
                   echo <<<TEXT
                   <tr>
                   <td><center><a href = "siteTournament.php?name=$i[name]">$i[name]</a></center></td>
                   <td><center>$i[time]</center></td>
                   <td><center>$i[limitation]</center></td>
                   <td><center>$status</center></td>
                   </tr>
TEXT;                       
                    
                    }
                    echo "</tbody></table>";
                }else {
                    echo "<span style='color: red; font-size: 20px;'>Błąd w zapytaniu</span>";
                }
            }else{
                    echo "<span style='color: red; font-size: 20px;'>Błąd połączenia.</span>";
            }
        ?>
        <div class="col-md-9 col-sm-9 col-md-offset-2">
            <?php
            
            if(!empty($_GET['site'])){
                $site = $_GET['site'];
            }else {
                $site = 1;
            }
            
            $polaczenie = @new mysqli('127.0.0.1','root','','turnieje');
            $sql = "SELECT * FROM `tournament`";
        
            if(!$polaczenie->connect_error){
                if($rezultat = $polaczenie->query($sql)){
                    $polaczenie->close();
                    $nr = $rezultat->num_rows;
                    //$iloscStron = ceil($nr/10);
                    $iloscStron = ceil($nr/10);
                   echo <<<TEXT
                   <table class="table">
                   <tr>
TEXT;  
                    if($site == $iloscStron){
                        if($iloscStron >= 3){
                            if($iloscStron >= 10){
                                $i = $site - 9;
                                if($iloscStron > 10){
                                    echo "<th><a href='index.php?site=1'>Pierwsza</a></th>";
                                }
                                while($i < $site){
                                    echo "<th><a href='index.php?site=$i'>$i</a></th>";    
                                    $i++;                                
                                }
                                echo "<th>$site</th>";
                            }else{
                                $i = 1;
                                while($i < $site){
                                    echo "<th><a href='index.php?site=$i'>$i</a></th>";    
                                    $i++;                                
                                }
                                echo "<th>$site</th>";
                            }
                        }else if($iloscStron == 2){
                            echo "<th><a href='index.php?site=1'>1</a></th>";
                            echo "<th>2</th>";                            
                        }
                    }else if($site == 1){
                        if($iloscStron >= 3){
                            if($iloscStron >= 10){
                                $i = 2;
                                echo "<th>$site</th>";
                                while($i <= 10){
                                    echo "<th><a href='index.php?site=$i'>$i</a></th>"; 
                                    $i++;       
                                }
                                if($iloscStron > 10){
                                    echo "<th><a href='index.php?site=$iloscStron'>Ostatnia</a></th>";
                                }
                            }else{
                                $i = 2;
                                echo "<th>$site</th>";
                                while($i <= $iloscStron){
                                    echo "<th><a href='index.php?site=$i'>$i</a></th>"; 
                                    $i++;
                                }
                            }
                        }else if($iloscStron == 2){
                            echo "<th>1</th>";
                            echo "<th><a href='index.php?site=2'>2</a></th>";                            
                        }                        
                    }else{ //tu musi być więcej lub równo 3 stron
                        if($iloscStron >= 10){
                            if($site > 10){
                                echo "<th><a href='index.php?site=1'>Pierwsza</a></th>";
                            }
                            if($site < 10){
                                $i = $site + 1  - $site%10;                                
                            }else if($site%10 == 0){
                                $i = $site - 1;
                            }else{
                                $i = $site  - $site%10;
                            }
                            $done = 0;
                            while($i < $site){
                                echo "<th><a href='index.php?site=$i'>$i</a></th>";    
                                $i++;   
                                $done++;
                            }
                            echo "<th>$site</th>";
                            $j = $site+1;
                            $end = $site + (10 - $done);
                            while($j <= $end){
                                if($j > $iloscStron) break;
                                echo "<th><a href='index.php?site=$j'>$j</a></th>";    
                                $j++;                                
                            }
                            if($site + (10 - $done) < $iloscStron){
                                echo "<th><a href='index.php?site=$iloscStron'>Ostatnia</a></th>";
                            }
                        }else{
                            $i = 1;
                            while($i < $site){
                                echo "<th><a href='index.php?site=$i'>$i</a></th>";    
                                $i++;                                
                            }
                            echo "<th>$site</th>";
                            $j = $site+1;
                            while($j <= $iloscStron){
                                echo "<th><a href='index.php?site=$j'>$j</a></th>";    
                                $j++;                                
                            }
                        }
                    }
                    
                   echo <<<TEXT
                   </tr>
                    </table>
TEXT;  
                }else {
                    echo "<span style='color: red; font-size: 20px;'>Błąd w zapytaniu</span>";
                }
            }else{
                    echo "<span style='color: red; font-size: 20px;'>Błąd połączenia.</span>";
            }
            
            ?> </div>
    </div>
    
	<nav class="navbar navbar-inverse navbar-fixed-bottom">
		<div class="container-fluid">
            <p class="navbar-text pull-right">Projekt z Podstaw Aplikacji Internetowych Bartosz Wiecheć 141334</p>
		</div>
	</nav>
</body>
</html>