<?php
    session_start();
if(isset($_SESSION['zalogowany'])){
    header("Location: index.php");
}
    if(!empty($_POST['email'])){
        $email = $_POST['email'];
    }else{
        header('location: ../zaloguj.php'); 
    }


    $polaczenie = new mysqli('localhost','root','','turnieje');
    if(!$polaczenie->connect_error){
        $sql = "Select * from user where email like '$email'";
            if($rezultat = $polaczenie->query($sql)){
            $message = "<html><a href='localhost/pai/reset.php?mail=$email'>Zresetuj swoje hasło</a></html>";
                
                $headers[] = 'MIME-Version: 1.0';
                $headers[] = 'Content-type: text/html; charset=iso-8859-1';
                $headers[] = "To: $name <$email>";
                $headers[] = 'From: Tournament Mailing <mailingtournaments@gmail.com>';
                $polaczenie->close();
                if(mail($email, "Nowe haslo", $message, implode("\r\n", $headers))){
                    $_SESSION['komunikat'] = "<span style='color: green; font-size: 20px;'>Pomyślnie wysłano mail z linkiem resetującym hasło</span>";
                    header('location: ../zaloguj.php');
                }else{
                    $_SESSION['komunikat'] = "<span style='color: red; font-size: 20px;'>Problem z wysłaniem linku resetującego hasło</span>";
                    header('location: ../zaloguj.php');                    
                }
            }else{
                echo "Błąd w zapytaniu";
            }
    }else{
        echo "błąd w połączeniu";
    }
?>