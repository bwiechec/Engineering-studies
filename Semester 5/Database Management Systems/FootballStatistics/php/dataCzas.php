<?php
    $dzienTygodnia = date('w');
        switch ($dzienTygodnia) {
            case 0: 
                $dzienTygodnia = "Niedziela";
                break;
            case 1: 
                $dzienTygodnia = "Poniedziałek";
                break;
            case 2: 
                $dzienTygodnia = "Wtorek";
                break;
            case 3: 
                $dzienTygodnia = "Środa";
                break;
            case 4: 
                $dzienTygodnia = "Czwartek";
                break;
            case 5: 
                $dzienTygodnia = "Piątek";
                break;
            case 6: 
                $dzienTygodnia = "Sobota";
                break;
        }
?>