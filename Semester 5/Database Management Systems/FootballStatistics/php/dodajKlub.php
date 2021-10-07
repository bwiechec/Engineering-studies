<?php
session_start();

    if(!empty($_POST['Nazwa']) && !empty($_POST['Kraj']) && !empty($_POST['Rok'])){

        $nazwa = $_POST['Nazwa'];
        $kraj = $_POST['Kraj'];
        $rok = intval($_POST['Rok']);
        $expCheckKraj_Nazwa = "/^[a-zA-Z]+$/";
        $expCheckRok = "/^[0-9]{4}$/";
        
        echo "nazwa: $_POST[Nazwa] Kraj: $_POST[Kraj]";
        
        if(!preg_match($expCheckKraj_Nazwa, $kraj)){
            $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>Podano błędny kraj</span>";  
            header("Location: ../klubyDodaj.php");
        }
        if(!preg_match($expCheckKraj_Nazwa, $nazwa)){
            $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>Podano błędną nazwę</span>";  
            header("Location: ../klubyDodaj.php");
        }
        if(!preg_match($expCheckRok, $rok)){
            $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>Podano błędny rok</span>";  
            header("Location: ../klubyDodaj.php");
        }
        $polaczenie = new mysqli('localhost','root','','projekt');
        if(!$polaczenie->connect_errno){
            $sqlNameCheck = "select * from klub where nazwaklubu like '$nazwa'";
        
            if($rezultat=$polaczenie->query($sqlNameCheck)){
                $ilosc=$rezultat->num_rows;
                if($ilosc===1){
                    $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>Podana nazwa klubu już znajduje się w bazie danych</span>";  
                    header('Location: ../klubyDodaj.php');  
                }else{
                    echo "Nie ma w bazie";
                    $sqlInsert = "INSERT INTO `klub`(`nazwaklubu`, `rokzalozenia`, `krajpochodzenia`) VALUES ('$nazwa', $rok, '$kraj')";
                    if($rezultat=$polaczenie->query($sqlInsert)){
                        $_SESSION['komunikat'] = "<span style='color: green; font-size: 20px;'>Pomyślnie Dodano klub $nazwa!</span>";
                        header('Location: ../klubyDodaj.php'); 
                    }else{
                        echo "Błąd w zapytaniu";
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
        header('Location: ../klubyDodaj.php');
    }
?>