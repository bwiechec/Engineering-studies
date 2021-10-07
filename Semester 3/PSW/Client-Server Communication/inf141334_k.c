#include <stdio.h>
#include <unistd.h>
#include <sys/types.h>
#include <sys/ipc.h>
#include <sys/msg.h>
#include <string.h>
#include <stdbool.h>

int main(){
    int kolejka = msgget(123,0644); 
	bool zalogowany = false;
    struct msgbuf{
        long mtype;
        char pole1[1024];
		char pole2[1024];
        int pidWysylajacego;
        int typWiadomosci;
        bool potwierdzenie; //tylko serwer z tego korzysta;
    } msg;
    printf("WITAJ W APLIKACJI KLIENT SERWER\nZNAJDUJESZ SIE NA KOMPUTERZE KLIENTA\nPODAJ LOGIN I HASLO KONTA DO KTOREGO CHCESZ UZYSKAC DOSTEP");
    printf("LOGIN:\n");
    scanf("%s",msg.pole1);
    printf("HASLO:\n");
    scanf("%s",msg.pole2);
    msg.typWiadomosci = 123;
    msg.pidWysylajacego = getpid();
    msgsnd(kolejka,&msg,sizeof(msg)+1,0);
    msgrcv(kolejka,&msg,sizeof(msg)+1,999,0);
    if(msg.potwierdzenie == true){
		printf("ZALOGOWANO\n");
		zalogowany=true;
		int wybor;
		while(zalogowany){
            msg.mtype = 1;
            msg.pidWysylajacego = getpid();
			printf("WYBIERZ GRUPE DZIALAN KTORE CHCESZ WYKONAC\n");
			printf("1. OBSLUGA KONTA\n");
			printf("2. OBSLUGA GRUP\n");
			printf("3. OBSLUGA WIADOMOSCI\n");
			scanf("%d",&wybor);
			switch(wybor){
				case 1:
					printf("WYBIERZ CO CHCESZ ZROBIC\n");
					printf("1. WYLOGUJ SIE\n");
					printf("2. PODGLAD LISTY\n");
					scanf("%d",&wybor);
					switch(wybor){
						case 1:
                            msg.typWiadomosci = 321;
                            msgsnd(kolejka,&msg,sizeof(msg)+1,0);
                            msgrcv(kolejka,&msg,sizeof(msg)+1,999,0);
                            if(msg.potwierdzenie){
                                printf("WYLOGOWANO\n");
                                zalogowany = false;
                            }else{
                                printf("WYSTAPIL BLAD\n");
                            }
							break;
						case 2:
							printf("WYBIERZ CO CHCESZ ZROBIC\n");
							printf("1. ZALOGOWANI UZYTKOWNICY\n");
							printf("2. ZAPISANYCH DO GRUPY TEMATYCZNEJ\n");
							scanf("%d",&wybor);
							switch(wybor){
								case 1:
                                    msg.typWiadomosci = 2311;
                                    msgsnd(kolejka,&msg,sizeof(msg)+1,0);
                                    msgrcv(kolejka,&msg,sizeof(msg)+1,999,0);
                                    if(msg.potwierdzenie){
                                        printf("%s\n",msg.pole1);
                                    }else{
                                        printf("WYSTAPIL BLAD\n");
                                    }
									break;
								case 2:
                                    msg.typWiadomosci = 2312;
                                    msgsnd(kolejka,&msg,sizeof(msg)+1,0);
                                    msgrcv(kolejka,&msg,sizeof(msg)+1,999,0);
                                    if(msg.potwierdzenie){
                                        printf("%s\n",msg.pole1);
                                    }else{
                                        printf("WYSTAPIL BLAD\n");
                                    }
									break;
								default:
									printf("ZLY WYBOR\n");
							}
							break;
						default:
							printf("ZLY WYBOR\n");
					}
					break;
				case 2:
					printf("WYBIERZ CO CHCESZ ZROBIC\n");
					printf("1. ZAPISANIE DO GRUPY\n");
					printf("2. WYPISANIE SIE Z GRUPY\n");
					printf("3. PODGLAD DOSTEPNYCH GRUP\n");
					scanf("%d",&wybor);
					switch(wybor){
						case 1:
                            msg.typWiadomosci = 111;
                            printf("Wybierz grupe do ktorej chcesz sie zapisac (1,2,3)\n");
                            scanf("%s",msg.pole1);
                            msgsnd(kolejka,&msg,sizeof(msg)+1,0);
                            msgrcv(kolejka,&msg,sizeof(msg)+1,999,0);
                            if(msg.potwierdzenie){
                                printf("POMYSLNIE ZAPISANO DO GRUPY\n");
                            }else{
                                printf("WYSTAPIL BLAD\n");
                            }
							break;
						case 2:
                            msg.typWiadomosci = 222;
                            printf("Wybierz grupe z ktorej chcesz sie wypisac (1,2,3)\n");
                            scanf("%s",msg.pole1);
                            msgsnd(kolejka,&msg,sizeof(msg)+1,0);
                            msgrcv(kolejka,&msg,sizeof(msg)+1,999,0);
                            if(msg.potwierdzenie){
                                printf("POMYSLNIE WYPISANO Z GRUPY\n");
                            }else{
                                printf("WYSTAPIL BLAD\n");
                            }
							break;
						case 3:
                            msg.typWiadomosci = 333;
                            msgsnd(kolejka,&msg,sizeof(msg)+1,0);
                            msgrcv(kolejka,&msg,sizeof(msg)+1,999,0);
                            if(msg.potwierdzenie){
                                printf("%s\n",msg.pole1);
                            }else{
                                printf("WYSTAPIL BLAD\n");
                            }
							break;
						default:
                            printf("ZLY WYBOR\n");
					}
					break;
				case 3:
					printf("WYBIERZ CO CHCESZ ZROBIC\n");
					printf("1. WYSLANIE WIADOMOSCI DO GRUPY\n");
					printf("2. WYSLANIE WIADOMOSCI DO UZYTKOWNIKA\n");
					printf("3. ODBIOR WIADOMOSCI\n");
					scanf("%d",&wybor);
					switch(wybor){
						case 1:
                            msg.typWiadomosci = 654;
                            printf("Wybierz do ktorej grupy chcesz wyslac wiadomosc (1,2,3)\n");
                            scanf("%s",msg.pole1);
                            printf("Podaj tekst wiadomosci ktora chcesz wyslac\n");
                            scanf("%s",msg.pole2);
                            msgsnd(kolejka,&msg,sizeof(msg)+1,0);
                            msgrcv(kolejka,&msg,sizeof(msg)+1,999,0);
                            if(msg.potwierdzenie){
                                printf("WIADMOSC WYSLANA POMYSLNIE\n");
                            }else{
                                printf("WYSTAPIL BLAD\n");
                            }
							break;
						case 2:
                            msg.typWiadomosci = 564;
                            printf("Wybierz do ktorego uzytkownika chcesz wyslac wiadomosc (1,2,3...9)\n");
                            scanf("%s",msg.pole1);
                            printf("Podaj tekst wiadomosci ktora chcesz wyslac\n");
                            scanf("%s",msg.pole2);
                            msgsnd(kolejka,&msg,sizeof(msg)+1,0);
                            msgrcv(kolejka,&msg,sizeof(msg)+1,999,0);
                            if(msg.potwierdzenie){
                                printf("WIADMOSC WYSLANA POMYSLNIE\n");
                            }else{
                                printf("WYSTAPIL BLAD\n");
                            }
							break;
						case 3:
                            msg.typWiadomosci = 456;
                            msgsnd(kolejka,&msg,sizeof(msg)+1,0);
                            msgrcv(kolejka,&msg,sizeof(msg)+1,999,0);
                            if(msg.potwierdzenie == true){
                                printf("Twoje wiadmosci: %s\n",msg.pole1);
                            }else{
                                printf("WYSTAPIL BLAD\n");
                            }
							break;
						default:
                            printf("ZLY WYBOR\n");
					}
					break;
				default:
					printf("ZLY WYBOR\n");
			}
		}
    }else printf("WYSTAPIL BLAD\n");
    return 0;
}
