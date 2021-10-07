INSTRUKCJA KOMPILACJI: 
Do kompilacji plików .c wykorzystuję plik o nazwie kompilacja, który tworzy pliki s - odpowiedzialny za serwer oraz k - odpowiedzialny za klienta

INSTRUKCJA URUCHOMIENIA:
Pliki otwieramy ./s - dla serwera oraz ./k dla klienta

KRÓTKI OPIS ZAWAROŚCI PLIKÓW .c
inf141334_s.c:
    Plik który odpowiada za działanie serwera, jest w nim zrealizowane określone działania na polecenia od klienta, protokół komunikacji między klientem, a serverem opisany jest w pliku PROTOCOL.txt.
inf141334_k.c:
    Plik, który odpowiada za działanie klientów. Aby móc działać dalej musimy na początku urucomienia go podać login i hasło zgodnie z istniejącymi loginami i hasłami z pliku conf.txt. Potem komunikujemy się z serwerem wybierając opcje pojawiające się w konsoli.
