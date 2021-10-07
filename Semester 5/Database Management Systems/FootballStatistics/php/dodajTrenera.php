<?php
session_start();

    if(!empty($_POST['Imie']) && !empty($_POST['Nazwisko']) && !empty($_POST['Data']) && !empty($_POST['Kraj']) && !empty($_POST['Mecze']) && !empty($_POST['Wygrane']) && !empty($_POST['Przegrane'])){

        $imie = $_POST['Imie'];
        $nazwisko = $_POST['Nazwisko'];
        $data = $_POST['Data'];
        $kraj = $_POST['Kraj'];
        $klub = $_POST['Klub'];
        $mecze = intval($_POST['Mecze']);
        $wygrane = intval($_POST['Wygrane']);
        $przegrane = intval($_POST['Przegrane']);
        $expCheckKlub = "/^\w+\s*\w*$/";
        $expCheckData = "/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/";
        $expCheckImie_Nazwisko_Kraj = "/^[a-zA-Z]+$/";
        $expCheckNumber = "/^[0-9]+$/";
        
        if(!preg_match($expCheckKlub, $klub)){
            $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>Podano błędny klub</span>";  
            header("Location: ../trenerzyDodaj.php");
        }if(!preg_match($expCheckData, $data)){
            $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>Podano błędną datę</span>";  
            header("Location: ../trenerzyDodaj.php");
        }if(!preg_match($expCheckImie_Nazwisko_Kraj, $imie)){
            $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>Podano błędne imie</span>";  
            header("Location: ../trenerzyDodaj.php");
        }if(!preg_match($expCheckImie_Nazwisko_Kraj, $nazwisko)){
            $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>Podano błędne nazwisko</span>";  
            header("Location: ../trenerzyDodaj.php");
        }if(!preg_match($expCheckImie_Nazwisko_Kraj, $kraj)){
            $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>Podano błędny kraj</span>";  
            header("Location: ../trenerzyDodaj.php");
        }if(!preg_match($expCheckNumber, $mecze)){
            $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>Podano błędną liczbę meczy</span>";  
            header("Location: ../trenerzyDodaj.php");
        }if(!preg_match($expCheckNumber, $wygrane)){
            $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>Podano błędną liczbę wygranych</span>";  
            header("Location: ../trenerzyDodaj.php");
        }if(!preg_match($expCheckNumber, $przegrane)){
            $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>Podano błędną liczbę przegranych</span>";  
            header("Location: ../trenerzyDodaj.php");
        }
        
        $polaczenie = new mysqli('localhost','root','','projekt');
        if(!$polaczenie->connect_errno){
            $sqlNameCheck = "select * from trener where imie like '$imie' and nazwisko like '$nazwisko'";
            if($rezultat=$polaczenie->query($sqlNameCheck)){
                $ilosc=$rezultat->num_rows;
                if($ilosc===1){
                    $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>Podany trener istnieje już w bazie</span>";  
                    header('Location: ../trenerzyDodaj.php'); 
                    }else{ 
                        echo "Nie ma w bazie";
                        $sqlInsert = "INSERT INTO `trener`(`imie`, `nazwisko`, `dataurodzenia`, `narodowosc`, `klub_id_klubu`) VALUES ('$imie', '$nazwisko', '$data', '$kraj', (Select id_klubu from klub where nazwaklubu like '$klub'))";
                        if($rezultat=$polaczenie->query($sqlInsert)){
                            $sqlInsert2 = "
                            INSERT INTO `trenerstatystyki`(`meczejakotrener`, `wygrane`, `przegrane`, `trener_id_trenera`) VALUES ($mecze, $wygrane, $przegrane, (Select id_trenera from trener where imie like '$imie' and Nazwisko like '$nazwisko' and dataurodzenia like '$data'))";
                            if($rezultat=$polaczenie->query($sqlInsert2)){
                                $_SESSION['komunikat'] = "<span style='color: green; font-size: 20px;'>Pomyślnie dodano trenera $imie $nazwisko!</span>";
                                header('Location: ../trenerzyDodaj.php'); 
                            }
                            else{
                                echo "Błąd w zapytaniu";                                    
                            }
                        }else{
                            echo "Błąd w zapytaniu";
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
        header('Location: ../trenerzyDodaj.php');
    }
?>