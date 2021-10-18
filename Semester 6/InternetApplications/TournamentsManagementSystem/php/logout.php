<?php
    
    session_start();

    if(isset($_SESSION['zalogowany'])){
        
        session_destroy();
        session_start();
        $_SESSION['komunikat'] = "<span style='color: green; font-size:20px;'>Pomyślnie wylogowano</span>";
        header('Location: ../index.php');
        
    }else{
        header('Location: ../index.php');
    }

?>