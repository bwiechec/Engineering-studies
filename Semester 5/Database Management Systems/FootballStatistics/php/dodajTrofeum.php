<?php
session_start();

    if(!empty($_POST['Nazwa']) && (!empty($_POST['Klub']) || (!empty($_POST['Trener']) || (!empty($_POST['Pilkarz']))))){
        if(empty($_POST['Klub'])){
            $klub = "NULL";
        }else{
            $klub = $_POST['Klub'];            
        }
        if(empty($_POST['Trener'])){
            $trener = "NULL";
        }else{
            $trener = $_POST['Trener'];
        }
        if(empty($_POST['Pilkarz'])){
            $pilkarz = "NULL";
        }else{
            $pilkarz = $_POST['Pilkarz'];
        }
        $nazwa = $_POST['Nazwa'];
        $expCheckNazwa = "/^(\w+\s*)+$/";
        
        if(!preg_match($expCheckNazwa, $nazwa)){
            $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>Podano błędną nazwę</span>";  
            header("Location: ../$od");
        }
                
        $od = $_GET['str'];
        
        $polaczenie = new mysqli('localhost','root','','projekt');
        if(!$polaczenie->connect_errno){
            $sqlNameCheck = "select * from trofea where nazwa like '$nazwa'";
        
            if($rezultat=$polaczenie->query($sqlNameCheck)){
                $ilosc=$rezultat->num_rows;
                if($ilosc===1){
                    $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>Podana nazwa trofeum już znajduje się w bazie danych</span>";  
                    header("Location: ../$od");
                }else{
                    echo "Nie ma w bazie";
                    $sqlInsert = "INSERT INTO `trofea`(`nazwa`, `pilkarz_id_pilkarza`, `klub_id_klubu`, `trener_id_trenera`) VALUES ('$nazwa', $pilkarz, $klub, $trener)";
                    if($rezultat=$polaczenie->query($sqlInsert)){
                        $_SESSION['komunikat'] = "<span style='color: green; font-size: 20px;'>Pomyślnie Dodano trofeum $nazwa!</span>";
                        header("Location: ../$od");
                    }else{
                        echo "Błąd w zapytaniu";
                        echo "$pilkarz $trener $klub";
                    }
                }  
            }else{
                echo "Błąd w zapytaniu";
            }
           $polaczenie->close(); 
        }else{
            echo "Błąd w połączeniu z bazą danych";
        }
    }else{
        echo "Błądfds";
        $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>Nie podano wszystkich danych</span>";  
        header("Location: ../$od");
    }
?>