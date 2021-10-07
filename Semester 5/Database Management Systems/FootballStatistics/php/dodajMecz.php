<?php
session_start();

    if(!empty($_POST['Data']) && !empty($_POST['Wynik']) && !empty($_POST['Klub1']) && (!empty($_POST['Klub2']))){
        
        $wynik = $_POST['Wynik'];
        $data = $_POST['Data'];
        $klub1 = $_POST['Klub1'];
        $klub2 = $_POST['Klub2'];
        $expCheckWynik = "/^[0-9]+:[0-9]+$/";
        $expCheckKlub = "/^\w+\s*\w*$/";
        $expCheckData = "/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/";
        
        if($klub1 === $klub2){
            $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>Podano dwa razy ten sam klub</span>";  
            header("Location: ../meczeDodaj.php");
        }
        
        if(!preg_match($expCheckWynik, $wynik)){
            $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>Podano błędny wynik</span>";  
            header("Location: ../meczeDodaj.php");
        }
        if(!preg_match($expCheckKlub, $klub1) || !preg_match($expCheckKlub, $klub2)){
            $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>Podano błędny klub</span>";  
            header("Location: ../meczeDodaj.php");
        }
        if(!preg_match($expCheckData, $data)){
            $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>Podano błędną datę</span>";  
            header("Location: ../meczeDodaj.php");
        }
        
        $polaczenie = new mysqli('localhost','root','','projekt');
        if(!$polaczenie->connect_errno){
            $sqlInsert = "INSERT INTO `mecz`(`dataMeczu`, `rezultat`, `klub_id_klubu1`, `klub_id_klubu`) VALUES ('$data','$wynik',$klub1, $klub2)";
            if($rezultat=$polaczenie->query($sqlInsert)){
                $_SESSION['komunikat'] = "<span style='color: green; font-size: 20px;'>Pomyślnie Dodano nowy mecz!</span>";
                header("Location: ../meczeDodaj.php");
            }else{
                echo "$sqlInsert";
                echo "Błąd w zapytaniu";
            }
           $polaczenie->close(); 
        }else{
            echo "Błąd w połączeniu z bazą danych";
        }
    }else{
        echo "Błądfds";
        $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>Nie podano wszystkich danych</span>";  
        header("Location: ../meczeDodaj.php");
    }
?>