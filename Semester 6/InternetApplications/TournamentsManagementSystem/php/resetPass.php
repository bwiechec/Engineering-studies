<?php
    session_start();
    if(isset($_SESSION['zalogowany'])){
        header("Location: index.php");
    }
    if(!empty($_POST['email']) && !empty($_POST['passInput']) && !empty($_POST['passInput2'])){
        $email = $_POST['email'];
        $pass = $_POST['passInput'];
        $pass2 = $_POST['passInput2'];
    }else{
        header('location: ../zaloguj.php'); 
    }
    

    $polaczenie = new mysqli('localhost','root','','turnieje');
    if(!$polaczenie->connect_error){
        if($pass === $pass2) {
            $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `user` (`id_user`, `name`, `nazwisko`, `email`, `password`) VALUES (NULL, '$name', '$surname', '$email', '$hashed_password');";
        } else{
            header('location: ../zaloguj.php');  
        }
        $sql = "UPDATE `user` SET `password` = '$hashed_password' WHERE email like '$email'";
            if($rezultat = $polaczenie->query($sql)){
            
                $_SESSION['komunikat'] = "<span style='color: green; font-size: 20px;'>Pomyślnie zmieniono hasło</span>";
                header('location: ../zaloguj.php');  
            }else{
                echo "Błąd w zapytaniu";
            }
    }else{
        echo "błąd w połączeniu";
    }
?>