#include <SFML/Graphics.hpp>
#include "plansza.h"
#include "pionekC.h"
#include "pionekB.h"
#include "pole.h"
#include "ruch.h"
#include "gameStart.h"
#include "windowManage.h"
#include <iostream>


using namespace sf;

int main()
{
	RenderWindow window(VideoMode(1000, 800), "Warcaby v0.1.3");
	Ruch ruch;
	Pole pole;
	WindowManage manage;
	PionekB pB[12];
	PionekC pC[12];
	GameStart game;
	game.start(window, ruch, pole, manage, pB, pC, true);

	while (window.isOpen())
	{
		bool zbity = false;
		window.clear();
		window.clear(Color::White);
		manage.rysuj(window,ruch);
		Event e;
		while (window.pollEvent(e))
		{
			if (e.type == Event::Closed)
				window.close();


			if (e.type == Event::MouseButtonPressed){
				if (e.mouseButton.button == Mouse::Left) {
					Vector2i pos = Mouse::getPosition(window);
					std::cout << "X myszy: " << pos.x << " y myszy: " << pos.y << std::endl;
					for (int i = 0; i < 12; i++){
						if(ruch.czyjRuch()){
							Vector2i posPawn = pB[i].getXY();
							if(pB[i].isMoving()){
								std::cout << "rusza X: "<<pos.x<<" y: "<<pos.y << std::endl;
								pB[i].move(window, e, pole, pos, ruch);
								if(ruch.getZbity()!=-1){
									std::cout << "PIONEK ZBITY: " << ruch.getZbity() << std::endl;
									for(int i = 0; i<12; i++){
										if (ruch.getZbity() == pC[i].getPole()) {
											pC[i].zbity(pole);
											ruch.setZbityWTurze(-1);
											int tab[2] = { -1,-1 };
											ruch.setZbijany(tab);
											ruch.setZbijanyNa(tab);
											std::cout << "ZBITY W TURZE " << ruch.getZbity() << std::endl;
											zbity = true;
											break;
										}
									}
								}/*
								if (zbity) {
									std::cout << "OPCJE ZBICIA: " << ruch.getZbijany().x <<" ORAZ "<< ruch.getZbijany().y<< std::endl;
									pB[i].setMove(window, e, pole, ruch);
									std::cout << "OPCJE ZBICIA 2: " << ruch.getZbijany().x << " ORAZ " << ruch.getZbijany().y << std::endl;
									if (ruch.getZbijany().x != -1) {
										ruch.setKolejneBicice(true);
									}
									else {
										pole.setPossition();
										zbity = false;
										ruch.setKolejneBicice(false);
										if (ruch.czyjRuch()) ruch.setRuch(false);
										else ruch.setRuch(true);
										for (int i = 0; i < 12; i++) {
											pB[i].setMoving(false);
											pC[i].setMoving(false);
										}
									}
								}
								else {
									ruch.setKolejneBicice(false);
									pole.setPossition();
									ruch.setKolejneBicice(false);
									if(ruch.czyjRuch()) ruch.setRuch(false);
									else ruch.setRuch(true);
									for (int i = 0; i < 12; i++) {
										pB[i].setMoving(false);
										pC[i].setMoving(false);
									}
								}*/
							}
							else {
							//for (int i = 0; i < 12; i++)
								//pB[i].setMoving(false);
								if (pos.x >= posPawn.x && pos.x <= (posPawn.x + 100))
									if (pos.y >= posPawn.y && pos.y <= (posPawn.y + 100)) {
										//pB[i].showOpt(window, e, pole);
										for (int i = 0; i < 12; i++)
											pB[i].setMoving(false);
										pole.setPossition();
										pB[i].setMove(window, e, pole, ruch);
									}
							}
						}
						else {
							Vector2i posPawn = pC[i].getXY();
							if (pC[i].isMoving()) {
								std::cout << "rusza X: " << pos.x << " y: " << pos.y << std::endl;
								pC[i].move(window, e, pole, pos, ruch); 
								if (ruch.getZbity() != -1) {
									std::cout << "PIONEK ZBITY: " << ruch.getZbity() << std::endl;
									for (int i = 0; i < 12; i++) {
										if (ruch.getZbity() == pB[i].getPole()) {
											pB[i].zbity(pole);
											ruch.setZbityWTurze(-1);
											int tab[2] = { -1,-1 };
											ruch.setZbijany(tab);
											ruch.setZbijanyNa(tab);
											std::cout << "ZBITY W TURZE " << ruch.getZbity() << std::endl;
											zbity = true;
											break;
										}
									}
								}/*
								if (zbity) {
									std::cout << "OPCJE ZBICIA: " << ruch.getZbijany().x << " ORAZ " << ruch.getZbijany().y << std::endl;
									pC[i].setMove(window, e, pole, ruch);
									if (ruch.getZbijany().x != -1) {
										ruch.setKolejneBicice(true);
									}
									else {
										pole.setPossition();
										zbity = false;
										ruch.setKolejneBicice(false);
										if (ruch.czyjRuch()==false) ruch.setRuch(true);
										else ruch.setRuch(false);
										for (int i = 0; i < 12; i++) {
											pB[i].setMoving(false);
											pC[i].setMoving(false);
										}
									}
								}
								else {
									ruch.setKolejneBicice(false);
									pole.setPossition();
									ruch.setKolejneBicice(false);
									if (ruch.czyjRuch() == false) ruch.setRuch(true);
									else ruch.setRuch(false);
									pC[i].setMoving(false);
									for (int i = 0; i < 12; i++) {
										pB[i].setMoving(false);
										pC[i].setMoving(false);
									}
								}*/
							}
							else {
								//for (int i = 0; i < 12; i++)
									//pB[i].setMoving(false);
								if (pos.x >= posPawn.x && pos.x <= (posPawn.x + 100))
									if (pos.y >= posPawn.y && pos.y <= (posPawn.y + 100)) {
										//pB[i].showOpt(window, e, pole);
										for (int i = 0; i < 12; i++)
											pC[i].setMoving(false);
										pole.setPossition();
										pC[i].setMove(window, e, pole, ruch);
									}
							}
						}
					}
					if (pos.x > 800) {
						Vector2i posR = manage.getRel();
						Vector2i posW = manage.getWczytaj();
						Vector2i posZ = manage.getZapisz();
						Vector2i posQ = manage.getWyjdz();
						if (pos.x >= posR.x && pos.x <= posR.x+150) {
							if (pos.y >= posR.y && pos.y <= posR.y + 50) {
								std::cout << "RESTART GRY" << std::endl;
								game.start(window, ruch, pole, manage, pB, pC, true);
							}
							else if (pos.y >= posW.y && pos.y <= posW.y + 50) {
								std::cout << "WCZYTANIE GRY" << std::endl;
								game.start(window, ruch, pole, manage, pB, pC, false);
							}
							else if (pos.y >= posZ.y && pos.y <= posZ.y + 50) {
								std::cout << "Zapis gry" << std::endl;
								game.save(window, ruch, pole, manage, pB, pC);
							}
							else if (pos.y >= posQ.y && pos.y <= posQ.y + 50) {
								std::cout << "Wyjscie" << std::endl;
								window.close();
							}
						}
					}
				}
				if (e.mouseButton.button == Mouse::Right) {
					if(ruch.getKolejneBicice()==false){
						for (int i = 0; i < 12; i++){
							pB[i].setMoving(false);
							pC[i].setMoving(false);
						}
						pole.setPossition();
						std::cout << "odzanczanie ruchu" << std::endl;
					}
				}
			}
		}
		int czarneCounter=0, bialeCouter=0;
		for (int i = 0; i < 12; i++) {
			if (pB[i].getDeleted() == false) bialeCouter++;
			if (pC[i].getDeleted() == false) czarneCounter++;
		}
		if (bialeCouter == 0) {
			std::cout << "GRA SKONCZONA WYGRAL CZARNY" << std::endl;
			game.start(window, ruch, pole, manage, pB, pC, true);
		}
		if (czarneCounter == 0) {
			std::cout << "GRA SKONCZONA WYGRAL BIALY" << std::endl;
			game.start(window, ruch, pole, manage, pB, pC, true);
		}
		//window.clear();
		//window.clear(Color::White);
		//plansza.rysuj(window);
		pole.rysuj(window);
		for (int i = 0; i < 12; i++) {
			pB[i].rysuj(window);
			//pB[i].wypiszXY();
			pC[i].rysuj(window);
			//pC[i].wypiszXY();
		}
		window.display();
	}

	return 0;
}