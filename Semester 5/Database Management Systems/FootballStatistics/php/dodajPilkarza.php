<?php
session_start();

    if(!empty($_POST['Imie']) && !empty($_POST['Nazwisko']) && !empty($_POST['Numer']) && !empty($_POST['Data']) && !empty($_POST['Kraj']) && !empty($_POST['Mecze']) && !empty($_POST['Bramki']) && !empty($_POST['Asysty']) && !empty($_POST['Zolte']) && !empty($_POST['Czerwone'])){

        $imie = $_POST['Imie'];
        $nazwisko = $_POST['Nazwisko'];
        $numer = intval($_POST['Numer']);
        $data = $_POST['Data'];
        $kraj = $_POST['Kraj'];
        $klub = $_POST['Klub'];
        $mecze = intval($_POST['Mecze']);
        $bramki = intval($_POST['Bramki']);
        $asysty = intval($_POST['Asysty']);
        $zolte = intval($_POST['Zolte']);
        $czerwone = intval($_POST['Czerwone']);
        
        $expChechImie_Nazwisko_kraj = "/^[a-zA-Z]+$/";
        $expCheckKlub = "/^\w+\s*\w*$/";
        $expCheckData = "/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/";
        $expCheckLiczba = "/^[0-9]+$/";
        
        if(!preg_match($expChechImie_Nazwisko_kraj, $imie)){
            $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>Podano błędne imie</span>";  
            header("Location: ../pilkarzeDodaj.php");
        }
        if(!preg_match($expChechImie_Nazwisko_kraj, $nazwisko)){
            $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>Podano błędne nazwisko</span>";  
            header("Location: ../pilkarzeDodaj.php");
        }
        if(!preg_match($expChechImie_Nazwisko_kraj, $kraj)){
            $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>Podano błędny kraj</span>";  
            header("Location: ../pilkarzeDodaj.php");
        }
        if(!preg_match($expCheckKlub, $klub)){
            $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>Podano błędny klub</span>";  
            header("Location: ../pilkarzeDodaj.php");
        }
        if(!preg_match($expCheckData, $data)){
            $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>Podano błędną datę</span>";  
            header("Location: ../pilkarzeDodaj.php");
        }
        if(!preg_match($expCheckLiczba, $numer) || !preg_match($expCheckLiczba, $mecze) || !preg_match($expCheckLiczba, $bramki) || !preg_match($expCheckLiczba, $asysty) || !preg_match($expCheckLiczba, $zolte) || !preg_match($expCheckLiczba, $czerwone)){
            $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>Podano błędną liczbę (numer/mecze/bramki/asysyty/żółte kartki/czerwone kartki)</span>";  
            header("Location: ../pilkarzeDodaj.php");
        }
        
        
        $polaczenie = new mysqli('localhost','root','','projekt');
        if(!$polaczenie->connect_errno){
            $sqlNumberCheck = "select * from klub as k join pilkarz as p on k.id_klubu = p.klub_id_klubu where nazwaklubu like '$klub' and NumerNaKoszulce like '$numer'";
        
            if($rezultat=$polaczenie->query($sqlNumberCheck)){
                $ilosc=$rezultat->num_rows;
                if($ilosc===1){
                    $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>Podany numer na koszulce jest zajęty w klubie, musisz wybrac inny, lub porozmawiać z jego posiadaczem i poprosić o zmianę :)</span>";  
                    header('Location: ../pilkarzeDodaj.php');  
                }else{
                    $sqlNameCheck = "select * from pilkarz where imie like '$imie' and nazwisko like '$nazwisko'";
                    if($rezultat=$polaczenie->query($sqlNameCheck)){
                        $ilosc=$rezultat->num_rows;
                        if($ilosc===1){
                            $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>Podany piłkarz istnieje już w bazie</span>";  
                            header('Location: ../pilkarzeDodaj.php'); 
                            
                        }else{
                            
                            echo "Nie ma w bazie";
                            $sqlInsert = "INSERT INTO `pilkarz`(`imie`, `nazwisko`, `numernakoszulce`, `dataurodzenia`, `narodowosc`, `klub_id_klubu`) VALUES ('$imie', '$nazwisko', $numer, '$data', '$kraj', (Select id_klubu from klub where nazwaklubu like '$klub'))";
                            if($rezultat=$polaczenie->query($sqlInsert)){
                                $sqlInsert2 = "
                                INSERT INTO `pilkarzstatystyki`(`bramki`, `rozegranemecze`, `asysty`, `zoltekartki`, `czerwonekartki`, `pilkarz_id_pilkarza`) VALUES ($bramki, $mecze, $asysty, $zolte, $czerwone, (Select id_pilkarza from pilkarz where imie like '$imie' and Nazwisko like '$nazwisko' and dataurodzenia like '$data'))";
                                
                                if($rezultat=$polaczenie->query($sqlInsert2)){
                                    $_SESSION['komunikat'] = "<span style='color: green; font-size: 20px;'>Pomyślnie Dodano piłkarza $imie $nazwisko!</span>";
                                    header('Location: ../pilkarzeDodaj.php'); 
                                }
                                else{
                                    echo "Błąd w zapytaniu";                                    
                                }
                            }else{
                                echo "$sqlInsert";
                                echo "Błąd w zapytaniu";
                            }
                            
                        }
                    }  
                }
            }
            else{
                echo "Błąd w zapytaniu";
            }
           $polaczenie->close(); 
        }else{
            echo "Błąd w połączeniu z bazą danych";
        }
    }else{
        echo "Błądfds";
        $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>Nie podano wszystkich danych</span>";  
        header('Location: ../pilkarzeDodaj.php');
    }
?>