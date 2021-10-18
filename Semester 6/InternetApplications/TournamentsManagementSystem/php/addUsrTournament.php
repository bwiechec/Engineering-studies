<?php
session_start();
if(!isset($_SESSION['zalogowany'])){
    header("Location: zaloguj.php");
}

    
    $polaczenie = new mysqli('localhost','root','','turnieje');
    if(!$polaczenie->connect_error){
        if(!empty($_POST['idInput']) && !empty($_POST['numberInput']) && !empty($_POST['rankInput'])){
            $id = $_POST['idInput'];
            $number = $_POST['numberInput'];
            $rank = $_POST['rankInput'];
            
            $sql = "SELECT * FROM `user_tournament` where player_license_number='$number' and rank='$rank'";
            $sql2 = "INSERT INTO `user_tournament` (`id_tournament`, `id_user`, `player_license_number`, `rank`) VALUES ('$id', '$_SESSION[id]', '$number', '$rank')";
        
            if($rezultat = $polaczenie->query($sql)){
                $nr = $rezultat->num_rows;
                if($nr===0){
                    if($rezultat2 = $polaczenie->query($sql2)){
                        $polaczenie->close();
                        $_SESSION['komunikat'] = "<span style='color: green; font-size: 20px;'>Pomyślnie zapisano na turniej!</span>";
                        header('location: ../index.php');                        
                    }else{
                        $polaczenie->close();
                        $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>Wystąpił błąd podczas zapisu na turniej. Użytkownik już zapisany na ten turniej.</span>";
                        header("location: ../index.php");                        
                    }
                }else{
                    $polaczenie->close();
                    $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>W bazie zapisanych użytkowników istnieje już taki o numerze licencji: $number oraz rankingu: $rank.</span>";
                    //echo "$nr";
                    header("location: ../index.php");                    
                }
            }else {
                $polaczenie->close();
                $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>Wystąpił błąd podczas zapisu na turniej.</span>";
                header("location: ../index.php");
            }
        } else {
            $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>Nie podano wszystkich danych!</span>";
            header("location: ../index.php");
            $polaczenie->close(); 
        } 
    }else{
        echo " błąd w połączeniu z bazą";
        $polaczenie->close(); 
    }

?>