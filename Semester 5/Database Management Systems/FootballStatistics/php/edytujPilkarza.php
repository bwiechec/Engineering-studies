<?php
session_start();

    if(!empty($_POST['Numer'])&& !empty($_POST['Mecze']) && !empty($_POST['Bramki']) && !empty($_POST['Asysty']) && !empty($_POST['Zolte']) && !empty($_POST['Czerwone'])){
        
        
        if(isset($_GET['id'])){
           $id = $_GET['id']; 
        }else{
            $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>Wystąpił błąd przy edycji piłkarza</span>";  
            header('Location: ../pilkarze.php'); 
        }
        $numer = intval($_POST['Numer']);
        $klub = $_POST['Klub'];
        $mecze = intval($_POST['Mecze']);
        $bramki = intval($_POST['Bramki']);
        $asysty = intval($_POST['Asysty']);
        $zolte = intval($_POST['Zolte']);
        $czerwone = intval($_POST['Czerwone']);
        
        $expCheckKlub = "/^\w+\s*\w*$/";
        $expCheckData = "/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/";
        $expCheckLiczba = "/^[0-9]+$/";
        
        if(!preg_match($expCheckKlub, $klub1)){
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
            $sqlNumberCheck = "select * from klub as k join pilkarz as p on k.id_klubu = p.klub_id_klubu where nazwaklubu like '$klub' and NumerNaKoszulce like '$numer' and p.id_pilkarza not like '$id'";
        
            if($rezultat=$polaczenie->query($sqlNumberCheck)){
                $ilosc=$rezultat->num_rows;
                if($ilosc===1){
                    $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>Podany numer na koszulce jest zajęty w klubie, musisz wybrac inny, lub porozmawiać z jego posiadaczem i poprosić o zmianę :)</span>";  
                    header("Location: ../pilkarzeEdytuj.php?id=$id");  
                }else{                            
                    echo "Nie ma w bazie";
                    $sqlUpdate = "UPDATE pilkarz SET NumerNaKoszulce = $numer,
                    klub_id_klubu = (Select id_klubu from klub where nazwaklubu like '$klub')
                    where id_pilkarza = $id";
                    if($rezultat=$polaczenie->query($sqlUpdate)){
                        $sqlUpdate2 = "UPDATE pilkarzstatystyki
                        SET Bramki = $bramki, RozegraneMecze = $mecze, Asysty = $asysty,
                        ZolteKartki = $zolte, CzerwoneKartki = $czerwone
                        where pilkarz_id_pilkarza = $id";
                                
                        if($rezultat=$polaczenie->query($sqlUpdate2)){
                            $_SESSION['komunikat'] = "<span style='color: green; font-size: 20px;'>Pomyślnie Edytowano piłkarza $imie $nazwisko!</span>";
                            header('Location: ../pilkarze.php'); 
                        }
                        else{
                            echo "Błąd w zapytaniu";                                    
                        }
                    }else{
                        echo "$sqlUpdate";
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
        header("Location: ../pilkarzeEdytuj?id=$id.php"); 
    }
?>