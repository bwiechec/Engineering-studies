<?php
session_start();
if(!isset($_SESSION['zalogowany'])){
    header("Location: zaloguj.php");
}

    
    $polaczenie = new mysqli('localhost','root','','turnieje');
    if(!$polaczenie->connect_error){
        if(!empty($_POST['nameInput']) && !empty($_POST['dateInput']) && !empty($_POST['locationInput']) && !empty($_POST['limitInput']) && !empty($_POST['deadlineInput'])){
            $name = $_POST['nameInput'];
            $date = $_POST['dateInput'];
            $location = $_POST['locationInput'];
            $limitation = $_POST['limitInput'];
            $deadline = $_POST['deadlineInput'];
            if(strtotime(date("Y-m-d")) > strtotime($date)){
                $polaczenie->close();
                $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>Ta data już minęła, jak chcesz utworzyć turniej, który nie może się odbyć?!</span>";
                header('location: ../createTournament.php');                
            }else if(strtotime(date("Y-m-d")) > strtotime($deadline)){
                $polaczenie->close();
                $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>Ta data już minęła, jak chcesz utworzyć turniej, na który nie można się zapisać?!</span>";
                header('location: ../createTournament.php');                
            }
        
            $sql = "INSERT INTO `tournament` (`id_tournament`, `id_creator`, `name`, `discipline`, `time`, `location`, `limitation`, `deadline`, `ladder`) VALUES (NULL, '$_SESSION[id]', '$name', 'Matematyka', '$date', '$location', '$limitation', '$deadline', '0')";
        
            if($rezultat = $polaczenie->query($sql)){
                $polaczenie->close();
                $_SESSION['komunikat'] = "<span style='color: green; font-size: 20px;'>Pomyślnie dodano turniej!</span>";
                header('location: ../createTournament.php');
            }else {
                $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>Wystąpił błąd podczas dodawania turnieju.</span>";
                header('location: ../createTournament.php');
            }
        } else {
            $_SESSION['komunikat'] = "<span style='color: green; font-size: 20px;'>Nie podano wszystkich danych!</span>";
            header('location: ../createTournament.php');
        $polaczenie->close(); 
    } 
    }else{
        echo " błąd w połączeniu z bazą";
    }

?>