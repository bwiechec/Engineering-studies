<?php
session_start();

    if(!empty($_POST['Mecze']) && !empty($_POST['Wygrane']) && !empty($_POST['Przegrane'])){
        
        
        if(isset($_GET['id'])){
           $id = $_GET['id']; 
        }else{
            $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>Wystąpił błąd przy edycji trenera</span>";  
            header('Location: ../trenerzy.php'); 
        }
        $klub = $_POST['Klub'];
        $mecze = $_POST['Mecze'];
        $wygrane = intval($_POST['Wygrane']);
        $przegrane = intval($_POST['Przegrane']);
        $expCheckKlub = "/^\w+\s*\w*$/";
        $expCheckData = "/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/";
        $expCheckNumber = "/^[0-9]+$/";
        
        if(!preg_match($expCheckKlub, $klub)){
            $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>Podano błędny klub</span>";  
            header("Location: ../trenerzyDodaj.php");
        }if(!preg_match($expCheckData, $data)){
            $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>Podano błędną datę</span>";  
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
            echo "Nie ma w bazie";
            $sqlUpdate = "UPDATE trener SET
            klub_id_klubu = (Select id_klubu from klub where nazwaklubu like '$klub')
            where id_trenera = $id";
            if($rezultat=$polaczenie->query($sqlUpdate)){
                $sqlUpdate2 = "UPDATE trenerstatystyki
                SET MeczeJakoTrener = $mecze, Wygrane = $wygrane, przegrane = $przegrane
                where trener_id_trenera = $id";
                                
                if($rezultat=$polaczenie->query($sqlUpdate2)){
                    $_SESSION['komunikat'] = "<span style='color: green; font-size: 20px;'>Pomyślnie Edytowano trenera $imie $nazwisko!</span>";
                    header('Location: ../trenerzy.php'); 
                }else{
                    echo "BŁĄD W ZAPYTANIU 2";
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
        header("Location: ../trenerzyEdytuj?id=$id.php"); 
    }
?>