<?php
    session_start();


    $polaczenie = @new mysqli('127.0.0.1','root','','turnieje');
    if(!$polaczenie->connect_error){
        
            $email = $_POST['email'];
            $name = $_POST['name'];
            $surname = $_POST['surname'];
            $password1 = $_POST['pass1'];
            $password2 = $_POST['pass2'];
            $regulations = $_POST['regulations'];
        
        if(!empty($_POST['email']) && !empty($_POST['name']) && !empty($_POST['surname']) && !empty($_POST['pass1']) && !empty($_POST['pass2']) && ($regulations == 'checked')) {
            

            $name = $polaczenie->real_escape_string(htmlentities($name));
            $surname = $polaczenie->real_escape_string(htmlentities($surname));
            $email = $polaczenie->real_escape_string(htmlentities($email));
            $password1 = $polaczenie->real_escape_string(htmlentities($password1));
            $password2 = $polaczenie->real_escape_string(htmlentities($password2));
            
            if($password1 === $password2) {
                $hashed_password = password_hash($password1, PASSWORD_DEFAULT);
                $sql = "INSERT INTO `user` (`id_user`, `name`, `nazwisko`, `email`, `password`) VALUES (NULL, '$name', '$surname', '$email', '$hashed_password');";
            } 
            if($rezultat = $polaczenie->query($sql)){
                $message = "<html><a href='localhost/pai/verify.php?mail=$email'>Zweryfikuj swoje konto</a></html>";
                
                $headers[] = 'MIME-Version: 1.0';
                $headers[] = 'Content-type: text/html; charset=iso-8859-1';
                $headers[] = "To: $name <$email>";
                $headers[] = 'From: Tournament Mailing <mailingtournaments@gmail.com>';
                $polaczenie->close();
                if(mail($email, "Weryfikacja konta", $message, implode("\r\n", $headers))){
                    $_SESSION['komunikat'] = "<span style='color: green; font-size: 20px;'>Pomyślnie utworzono konto!</span>";
                    header('location: ../zaloguj.php');
                }else{
                    $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>Problem z mailem weryfikacyjnym</span>";
                    header('location: ../registration.php');                    
                }
        }else {
            $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>Błędne dane. Nie zarejestrowano konta.</span>";
                header('location: ../registration.php');
        }
        } else {
            $_SESSION['komunikat'] = "<span style='color: green; font-size: 20px;'>Nie podano wszystkich danych!</span>";
            header('location: ../registration.php');
        }
        $polaczenie->close(); 
    } else {
        echo "Błędna połączenie z bazą";
    }
?>