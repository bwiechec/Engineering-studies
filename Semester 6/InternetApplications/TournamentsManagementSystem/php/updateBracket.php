<?php
session_start();
if(!isset($_SESSION['zalogowany'])){
    header("Location: zaloguj.php");
}

    $polaczenie = new mysqli('localhost','root','','turnieje');
    if(!$polaczenie->connect_error){
        if(!empty($_POST['idInput']) && !empty($_POST['winnerInput']) && !empty($_POST['winner']) && !empty($_POST['round']) && !empty($_POST['matchNr'])){ 
            $id = $_POST['idInput'];
            $winnerInput = $_POST['winnerInput'];
            $winner = $_POST['winner'];
            $round = $_POST['round'];
            $matchNr = $_POST['matchNr'];
            echo "Turniej nr: $_POST[idInput] Który gracz zgłasza wynik? $_POST[winnerInput] Kto wygrał? $_POST[winner]";
            $sql = "Select * from matches where round like $round AND id_tournament like $id AND matchNr like $matchNr";
            if($rezultat = $polaczenie->query($sql)){
                $rez = mysqli_fetch_assoc($rezultat);
                if($winnerInput == "winner1"){ //wprowadza user1
                    if(!is_null($rez['winner2'])){
                        if($rez['winner2'] == $winner){
                            //podali tego samego aktualizacja drabinki
                            $sql2 = "UPDATE `matches` SET `winner1` = $winner, `winner` = $winner WHERE id_user1 = $_SESSION[id] AND id_tournament like $id AND round like $round AND matchNr like $matchNr";
                            $sql3 = "SELECT MAX(matchNr) as maxNr FROM `matches` where round like $round AND id_tournament like $id AND matchNr like $matchNr";
                            if($rezultat2 = $polaczenie->query($sql2)){
                                if($rezultat3 = $polaczenie->query($sql3)){
                                    $rez3 = mysqli_fetch_assoc($rezultat3);
                                    $newMatchNr = $rez3['maxNr'] + ceil($matchNr/2);
                                    $newRound = $round+1;
                                    $datetime = new DateTime();
                                    $interval = new DateInterval('P1D');
                                    $datetime->sub($interval);
                                    $datetime = $datetime->format('Y-m-d');
                                    $sql4 = "SELECT id_user1, id_user2 from matches where matchNr like $newMatchNr AND id_tournament like $id";
                                    if($rezultat4 = $polaczenie->query($sql4)){
                                        $iloscc = $rezultat4->num_rows;
                                        $rez4 = mysqli_fetch_assoc($rezultat4);
                                        if($rezultat4->num_rows === 0){
                                            //nie ma jeszcze tego meczu
                                            $sql5 = "INSERT INTO `matches` (`id_match`, `id_tournament`, `id_user1`, `id_user2`, `round`, `winner1`, `winner2`, `winner`, `deadline`, `matchNr`) VALUES (NULL, '$id', $_SESSION[id], NULL, '$newRound', NULL, NULL, NULL, '$datetime', '$newMatchNr')";
                                            if($rezultat5 = $polaczenie->query($sql5)){
                                                $_SESSION['komunikat'] = "<span style='color: green; font-size: 20px;'>Pomyślnie dodano wynik i mecz $rez3[maxNr] $matchNr $newMatchNr $iloscc</span>";
                                                header("location: ../myTournaments.php");                                                 
                                            }else{
                                                $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>błąd w zapytaniu5 v1</span>";
                                                header("location: ../myTournaments.php");                                                
                                            }
                                        }else{
                                            //jest już ten mecz
                                            if(is_null($rez4['id_user1'])){
                                                $sql5 = "UPDATE `matches` SET id_user1 = $_SESSION[id] where matchNr like $newMatchNr AND id_tournament like $id";                                                
                                            }else{
                                                $sql5 = "UPDATE `matches` SET id_user2 = $_SESSION[id] where matchNr like $newMatchNr AND id_tournament like $id";
                                            }
                                            if($rezultat5 = $polaczenie->query($sql5)){
                                                $_SESSION['komunikat'] = "<span style='color: green; font-size: 20px;'>Pomyślnie dodano wynik gdy mecz byl $newMatchNr $iloscc</span>";
                                                header("location: ../myTournaments.php");                                                 
                                            }else{
                                                $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>błąd w zapytaniu5</span>";
                                                header("location: ../myTournaments.php");                                                
                                            }
                                        }
                                    }else{
                                        echo "błąd w zapytaniu4";
                                        $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>błąd w zapytaniu4</span>";
                                        header("location: ../myTournaments.php");
                                    }
                                }else{
                                    echo "błąd w zapytaniu3";
                                    $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>błąd w zapytaniu3</span>";
                                    header("location: ../myTournaments.php");
                                }
                            }else{
                                echo "błądw zapytaniu2";
                                $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>błąd w zapytaniu2</span>";
                                header("location: ../myTournaments.php");
                            }
                        }else{
                            //podali innego trzeba wymazać
                            $sql2 = "UPDATE `matches` SET `winner2` = NULL WHERE id_user2 = $_SESSION[id] AND id_tournament like $id AND round like $round AND matchNr like $matchNr";
                            if($rezultat2 = $polaczenie->query($sql2)){
                                $_SESSION['komunikat'] = "<span style='color: green; font-size: 20px;'>Pomyślnie dodano wynik przy róznych</span>";
                                header("location: ../myTournaments.php");                                 
                            }else{
                                $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>błąd w zapytaniu2</span>";
                                header("location: ../myTournaments.php");
                            }
                        }
                    }else{
                        //nikt nie podał po prostu wpisujemy
                            $sql2 = "UPDATE `matches` SET `winner1` = $winner WHERE id_user2 = $_SESSION[id] AND id_tournament like $id AND round like $round AND matchNr like $matchNr";
                            if($rezultat2 = $polaczenie->query($sql2)){
                                $_SESSION['komunikat'] = "<span style='color: green; font-size: 20px;'>Pomyślnie dodano wynik jeden $rez[winner2]</span>";
                                header("location: ../myTournaments.php"); 
                                
                            }else{
                                $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>błąd w zapytaniu2</span>";
                                header("location: ../myTournaments.php");
                            }
                    }
                }else{ //wprowadza user2
                    if(!is_null($rez['winner1'])){
                        if($rez['winner1'] == $winner){
                            //podali tego samego aktualizacja drabinki
                            $sql2 = "UPDATE `matches` SET `winner2` = $winner, `winner` = $winner WHERE id_user2 = $_SESSION[id] AND id_tournament like $id AND round like $round AND matchNr like $matchNr";
                            $sql3 = "SELECT MAX(matchNr) as maxNr FROM `matches` where round like $round AND id_tournament like $id";
                            if($rezultat2 = $polaczenie->query($sql2)){
                                if($rezultat3 = $polaczenie->query($sql3)){
                                    $rez3 = mysqli_fetch_assoc($rezultat3);
                                    $newMatchNr = $rez3['maxNr'] + ceil($matchNr/2) + 1;
                                    $newRound = $round+1;
                                    $datetime = new DateTime();
                                    $interval = new DateInterval('P1D');
                                    $datetime->sub($interval);
                                    $datetime = $datetime->format('Y-m-d');
                                    $sql4 = "SELECT * from matches where matchNr like $newMatchNr AND id_tournament like $id";
                                    if($rezultat4 = $polaczenie->query($sql4)){
                                        if($rezultat->num_rows === 0){
                                            //nie ma jeszcze tego meczu
                                            $sql5 = "INSERT INTO `matches` (`id_match`, `id_tournament`, `id_user1`, `id_user2`, `round`, `winner1`, `winner2`, `winner`, `deadline`, `matchNr`) VALUES (NULL, '$id', NULL, $_SESSION[id],  '$newRound', NULL, NULL, NULL, '$datetime', '$newMatchNr')";
                                            if($rezultat5 = $polaczenie->query($sql5)){
                                                $_SESSION['komunikat'] = "<span style='color: green; font-size: 20px;'>Pomyślnie dodano wynik i nowy mecz2</span>";
                                                header("location: ../myTournaments.php");                                                 
                                            }else{
                                                $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>błąd w zapytaniu5</span>";
                                                header("location: ../myTournaments.php");                                                
                                            }
                                        }else{
                                            //jest już ten mecz
                                            if(is_null($rez4['id_user1'])){
                                                $sql5 = "UPDATE `matches` SET id_user1 = $_SESSION[id] where matchNr like $newMatchNr AND id_tournament like $id";                                                
                                            }else{
                                                $sql5 = "UPDATE `matches` SET id_user2 = $_SESSION[id] where matchNr like $newMatchNr AND id_tournament like $id";
                                            }
                                            if($rezultat5 = $polaczenie->query($sql5)){
                                                $_SESSION['komunikat'] = "<span style='color: green; font-size: 20px;'>Pomyślnie dodano wynik gdy mecz byl2 $newMatchNr</span>";
                                                header("location: ../myTournaments.php"); 
                                                
                                            }else{
                                                $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>błąd w zapytaniu5</span>";
                                                header("location: ../myTournaments.php");                                                
                                            }
                                        }
                                    }else{
                                        $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>błąd w zapytaniu4</span>";
                                        header("location: ../myTournaments.php");
                                    }
                                }else{
                                    $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>błąd w zapytaniu3</span>";
                                    header("location: ../myTournaments.php");
                                }
                            }else{
                                $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>błąd w zapytaniu2</span>";
                                header("location: ../myTournaments.php");
                            }
                        }else{
                            //podali innego trzeba wymazać
                            $sql2 = "UPDATE `matches` SET `winner1` = NULL WHERE id_user2 = $_SESSION[id] AND id_tournament like $id AND round like $round AND matchNr like $matchNr";
                            if($rezultat2 = $polaczenie->query($sql2)){
                                $_SESSION['komunikat'] = "<span style='color: green; font-size: 20px;'>Pomyślnie dodano wynik gdy inny 2</span>";
                                header("location: ../myTournaments.php");                                 
                            }else{
                                $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>błąd w zapytaniu2</span>";
                                header("location: ../myTournaments.php");
                            }
                        }
                    }else{
                        //nikt nie podał po prostu wpisujemy
                            $sql2 = "UPDATE `matches` SET `winner2` = $winner WHERE id_user2 = $_SESSION[id] AND id_tournament like $id AND round like $round AND matchNr like $matchNr";
                            if($rezultat2 = $polaczenie->query($sql2)){
                                $_SESSION['komunikat'] = "<span style='color: green; font-size: 20px;'>Pomyślnie dodano wynik jeden2</span>";
                                header("location: ../myTournaments.php");                                 
                            }else{
                                $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>błąd w zapytaniu2</span>";
                                header("location: ../myTournaments.php");
                            }
                        }                    
                    }                    
            }else{
                $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>błąd w zapytaniu</span>";
                header("location: ../myTournaments.php");
            }  
        }else{
            $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>Coś poszło nie tak</span>";
            header("location: ../myTournaments.php");
        }
    }else{
        $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>Coś poszło nie tak</span>";
        header("location: ../myTournaments.php");
    }

?>