#include <stdio.h>
#include <string.h>
#include <stdlib.h>
#include <unistd.h>
#include <fcntl.h>
#include <sys/types.h>
#include <sys/stat.h>
#include <sys/ipc.h>
#include <sys/msg.h>
#include <stdbool.h>

bool isIn(int pidWysy, int zalo[]){
    for(int i = 0; i < 9; i++){
        if(pidWysy == zalo[i]){
            return true;
        }
	}
    return false;
}

int ktoryUser(int pid, int zalogowany[]){
	for(int i = 0; i < 9; i++){
		if(pid == zalogowany[i]){
			return i;
		}
	}
	return -1;
}

int main(){
//#########ODCZYT Z PLIKU#############
	int fd = open("conf.txt",O_RDONLY);
	int size = lseek(fd,0,SEEK_END) - 1;
	lseek(fd,0,SEEK_SET);
	//printf("ROZMIAR: %d\n",size);
	char grupy[3][7];
	char loginy[9][6];
	char hasla[9][7];
	size_t len = sizeof(char)*size;
	char *wczytaj = malloc(len);
	read(fd,wczytaj,size);
	printf("%s\n",wczytaj);
	int i = 0;
	int userow = 0;
	int grup = 0;
	int j = 0;
    
	while(i<size){
		if(userow<9){
			for(j=0;j<5;j++){
				loginy[userow][j] = wczytaj[i];
				i++;
			}
			loginy[userow][5] = 0;
			i++;
			for(j=0;j<6;j++){
				hasla[userow][j] = wczytaj[i];
				i++;
			}
			hasla[userow][6] = 0;
			i++;
			userow++;
		}else{
			for(j=0;j<6;j++){
				grupy[grup][j] = wczytaj[i];
				i++;
			}
			i++;
			grup++;
		}
	}
	for(i = 0; i<9;i++){
		loginy[i][5] = '\0';
		printf("LOGIN %d : %s\n",i+1,loginy[i]);
		printf("HASLO %d : %s\n",i+1,hasla[i]);
		if(i<3) printf("GRUPA %d: %s \n",i+1,grupy[i]);
	}
//##########################################################	
	
	int kolejka = msgget(123,0644 | IPC_CREAT);
    
    struct msgbuf{
        long mtype;
        char pole1[1024];
		char pole2[1024];
        int pidWysylajacego;
        int typWiadomosci;
        bool potwierdzenie; //tylko serwer z tego korzysta;
    } msg;
    int zalogowany[9] = {0};
    bool czyZalogowany[9] = {false};
	int zalogowanych = 0;
	bool udaloSie;
	int wGrupach[3][9] = {0};
    char skrzynka[9][10][60]; // 9 userow po 10 wiad w skrzynce
    int doGrupyOd[9][10] = {0};
    int doUseraOd[9][10] = {0};
    int ktoryChce;
	int doKtorej;
	int zKtorej;
    for(int i = 0; i < 9; i++)
		for(int j = 0; j < 10; j++)
			strcpy(skrzynka[i][j],"");
    while(true){
        msgrcv(kolejka,&msg,sizeof(msg)+1,0,0);
        if(isIn(msg.pidWysylajacego,zalogowany)){
            switch(msg.typWiadomosci){
				case 321:
					//wylogowanie
                    for(int i = 0; i < 9; i++){
                        if(zalogowany[i] == msg.pidWysylajacego){
							czyZalogowany[i] = false;
							zalogowany[i] = 0;
							udaloSie = true;
                        }
                    }
					msg.mtype = 999;
					msg.potwierdzenie = udaloSie;
					msgsnd(kolejka,&msg,sizeof(msg)+1,0);
					break;
				case 2311:
					//podglad listy uzytkownikow
					strcpy(msg.pole1,"LISTA ZALOGOWANYCH UZYTKOWNIKOW:\n");
                    for(int i = 0; i < 9; i++){
                        if(czyZalogowany[i]){
							strcat(msg.pole1,loginy[i]);
							strcat(msg.pole1,"\n");
							udaloSie = true;
                        }
                    }
                    if(!udaloSie) 
						strcat(msg.pole1,"BRAK ZALOGOWANYCH\n");
					
					printf("%s\n",msg.pole1);
					
					msg.mtype = 999;
					msg.potwierdzenie = true;
					msgsnd(kolejka,&msg,sizeof(msg)+1,0);
					break;
				case 2312:
					//podglad listy uzytkownikow w grupach
					strcpy(msg.pole1,"LISTA UZYTKOWNIKOW W GRUPACH:\n");
					strcat(msg.pole1,"GRUPA 1:\n");
                    for(int i = 0; i < 9; i++){
                        if(wGrupach[0][i]>0){
							strcat(msg.pole1,loginy[ktoryUser(wGrupach[0][i],zalogowany)]);
							strcat(msg.pole1,"\n");
                        }
                    }
					strcat(msg.pole1,"GRUPA 2:\n");
                    for(int i = 0; i < 9; i++){
                        if(wGrupach[1][i]>0){
							strcat(msg.pole1,loginy[ktoryUser(wGrupach[1][i],zalogowany)]);
							strcat(msg.pole1,"\n");
                        }
                    }
					strcat(msg.pole1,"GRUPA 3:\n");
                    for(int i = 0; i < 9; i++){
                        if(wGrupach[2][i]>0){
							strcat(msg.pole1,loginy[ktoryUser(wGrupach[2][i],zalogowany)]);
							strcat(msg.pole1,"\n");
                        }
                    }
					
					printf("%s\n",msg.pole1);
					
					msg.mtype = 999;
					msg.potwierdzenie = true;
					msgsnd(kolejka,&msg,sizeof(msg)+1,0);
					break;
				case 111:
					//zapisanie sie do grupy
                    doKtorej = atoi(msg.pole1);
					if(doKtorej>=1 && doKtorej<=3){
						doKtorej-=1;
						wGrupach[doKtorej][ktoryUser(msg.pidWysylajacego,zalogowany)] = msg.pidWysylajacego;
						udaloSie = true;
					}else udaloSie = false;
					msg.mtype = 999;
					msg.potwierdzenie = udaloSie;
					msgsnd(kolejka,&msg,sizeof(msg)+1,0);
					break;
				case 222:
					//wypisanie sie z grupy
                    zKtorej = atoi(msg.pole1);
					if(zKtorej>=1 && zKtorej<=3){
						zKtorej-=1;
						wGrupach[zKtorej][ktoryUser(msg.pidWysylajacego,zalogowany)] = -1;
						udaloSie = true;
					}else udaloSie = false;
                    
					msg.mtype = 999;
					msg.potwierdzenie = udaloSie;
					msgsnd(kolejka,&msg,sizeof(msg)+1,0);
					break;
				case 333:
					//podglad dostepnych grup
                    strcpy(msg.pole1,"");
					strcat(msg.pole1, grupy[0]);
					strcat(msg.pole1, "\n");
					strcat(msg.pole1, grupy[1]);
					strcat(msg.pole1, "\n");
					strcat(msg.pole1, grupy[2]);
					strcat(msg.pole1, "\n");
					
					printf("%s\n",msg.pole1);
					
					msg.mtype = 999;
					msg.potwierdzenie = true;
					msgsnd(kolejka,&msg,sizeof(msg)+1,0);
					break;
				case 456:
					//odebranie wiadomosci
					ktoryChce= ktoryUser(msg.pidWysylajacego,zalogowany);
					strcpy(msg.pole1,"");
					for(int i = 0; i < 10; i++){
						if(strcmp(skrzynka[ktoryChce][i],"")){
							if(doGrupyOd[ktoryChce][i]>0){
								strcat(msg.pole1,"\n");
								strcat(msg.pole1,"WIADOMOSC WYSLANA DO GRUPY PRZEZ ");
								strcat(msg.pole1,loginy[ktoryUser(doGrupyOd[ktoryChce][i],zalogowany)]);
								strcat(msg.pole1,"\n");
								strcat(msg.pole1,skrzynka[ktoryChce][i]);
								strcat(msg.pole1,"\n");
							}else if(doUseraOd[ktoryChce][i]>0){
								strcat(msg.pole1,"\n");
								strcat(msg.pole1,"WIADOMOSC WYSLANA DO UZYTKOWNIKA PRZEZ ");
								strcat(msg.pole1,loginy[ktoryUser(doUseraOd[ktoryChce][i],zalogowany)]);
								strcat(msg.pole1,"\n");
								strcat(msg.pole1,skrzynka[ktoryChce][i]);
								strcat(msg.pole1,"\n");
							}
							strcpy(skrzynka[ktoryChce][i],"");
							doUseraOd[ktoryChce][i] = 0;
							doGrupyOd[ktoryChce][i] = 0;
						}
					}
					printf("%s\n",msg.pole1);
					msg.mtype = 999;
					msg.potwierdzenie = true;
					msgsnd(kolejka,&msg,sizeof(msg)+1,0);
					break;
				case 654:
					//wyslanie wiadomosci do grupy
					udaloSie = false;
                    int doKtorejGrp = atoi(msg.pole1);
					if(doKtorejGrp >= 1 && doKtorejGrp <= 3){
						doKtorejGrp-=1;
						udaloSie = true;
						for(int i = 0; i < 9; i++){
							if(wGrupach[doKtorejGrp][i] != -1){
								for(int j = 0; j < 10; j++){
									if(strcmp(skrzynka[ktoryUser(wGrupach[doKtorejGrp][i],zalogowany)][j],"") == 0){
										strcpy(skrzynka[ktoryUser(wGrupach[doKtorejGrp][i],zalogowany)][j],msg.pole2);
										doGrupyOd[ktoryUser(wGrupach[doKtorejGrp][i],zalogowany)][j] = msg.pidWysylajacego;
										break;
									}
								}
							}
						}
					}
					
					msg.mtype = 999;
					msg.potwierdzenie = udaloSie;
					msgsnd(kolejka,&msg,sizeof(msg)+1,0);
					break;
				case 564:
					//wyslanie wiadomosci do uzytkownika 
					udaloSie = false;
                    int doKogo = atoi(msg.pole1);
					if(doKogo >= 1 && doKogo <= 9){
						doKogo-=1;
						udaloSie = true;
						for(int j = 0; j < 10; j++){
							if(strcmp(skrzynka[doKogo][j],"") == 0){
								strcpy(skrzynka[doKogo][j],msg.pole2);
								doGrupyOd[doKogo][j] = 0;
								doUseraOd[doKogo][j] = msg.pidWysylajacego;
								break;
							}
						}
					}
					
					msg.mtype = 999;
					msg.potwierdzenie = udaloSie;
					msgsnd(kolejka,&msg,sizeof(msg)+1,0);
					break;
				
            }
        }else{
            if(msg.typWiadomosci==123){
				udaloSie = false;
                for(int i = 0; i < 9;i ++){
				printf("%s\n%s\n%s\n%s\n\n",msg.pole1,msg.pole2,loginy[i],hasla[i]);
                    if(strcmp(msg.pole1,loginy[i]) == 0 && strcmp(msg.pole2,hasla[i]) == 0){
							if(czyZalogowany[i] == false){
								zalogowanych++;
								zalogowany[i] = msg.pidWysylajacego;
								czyZalogowany[i] = true;
								udaloSie = true;
							}
						}
					}
				msg.mtype = 999;
				msg.potwierdzenie = udaloSie;
				msgsnd(kolejka,&msg,sizeof(msg)+1,0);
                }	
		
            else{
                msg.mtype = 999;
                msg.potwierdzenie = false;
                msgsnd(kolejka,&msg,sizeof(msg)+1,0);
            }
        }
    }
    return 0;
}
