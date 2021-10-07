#include <SFML/Graphics.hpp>
#include "gameStart.h"
#include <fstream>
#include <iostream>
#include <cstdlib>

using namespace sf;

void GameStart::start(RenderWindow& window, Ruch& ruch, Pole& pole, WindowManage& manage, PionekB pB[], PionekC pC[],bool odNowa) {
	if (odNowa) startNowy(window, ruch, pole, manage, pB, pC);
	else wczytaj(window, ruch, pole, manage, pB, pC);
}

void GameStart::startNowy(RenderWindow& window, Ruch& ruch, Pole& pole, WindowManage& manage, PionekB pB[], PionekC pC[]) {
	pole.setPossition();
	for (int i = 0; i < 32; i++) {
		pole.setUse(false, i,false, false);
	}
	for (int i = 0; i < 12; i++) {
		pC[i].setDeleted(false);
		pB[i].setDeleted(false);
		pole.setUse(true, i,true,false);
		pole.setUse(true, (20 + i),false, true);
		pB[i].setPos(pozBiale[i][0], pozBiale[i][1]);
		pB[i].setPole(i);
		pC[i].setPos(pozCzarne[i][0], pozCzarne[i][1]);
		pC[i].setPole(20 + i);
	}
	int tab[2] = { -1,-1 };
	ruch.setRuch(true);
	ruch.setZbityWTurze(-1);
	ruch.setZbijany(tab);
	ruch.setZbijanyNa(tab);
}

void GameStart::wczytaj(RenderWindow& window, Ruch& ruch, Pole& pole, WindowManage& manage, PionekB pB[], PionekC pC[]) {
	std::cout << "TU BEDZIE WCZYTYWANIE" << std::endl;
	pole.setPossition(); 
	std::fstream plik;
	bool otwarty = false;
	try {
		plik.open("save.txt", std::ios::in);
		if (plik.good() == false) {
			std::string wyjatek = "save.txt";
			otwarty = false;
			throw wyjatek;
		}
		else {
			otwarty = true;
		}
	}
	catch(std::string err){
		std::cout << "BRAK PLIKU "<<err<< " DO WCZYTANIA" << std::endl;
	}

	//----Wczytanie DANYCH PIONKOW BIALYCH----}
	if(otwarty){
	int a,x,y,nrPole;
	bool deleted;
	std::string str;
	for (int i = 0; i < 32; i++) {
		pole.setUse(false, i, false, false);
	}
	for (int i = 0; i < 12; i++) {
		std::getline(plik,str);
		a = atoi(str.c_str());
		std::cout << "A1: " << a << std::endl;
		std::getline(plik, str);
		deleted = atoi(str.c_str());
		if (deleted == 0 || deleted == 204) deleted = false;
		else deleted = true;
		pB[a].setDeleted(deleted);
		std::getline(plik, str);
		x = atoi(str.c_str());
		std::getline(plik, str);
		y = atoi(str.c_str());
		pB[a].setPos(x,y);
		std::getline(plik, str);
		nrPole = atoi(str.c_str());
		pB[i].setPole(nrPole);
	}
	//----Wczytanie DANYCH PIONKOW CZARNYCH----
	for (int i = 0; i < 12; i++) {
		std::getline(plik, str);
		a = atoi(str.c_str());
		std::cout << "A2: " << a << std::endl;
		std::getline(plik, str);
		deleted = atoi(str.c_str());
		if (deleted == 0 || deleted == 204) deleted = false;
		else deleted = true;
		pC[a].setDeleted(deleted);;
		std::getline(plik, str);
		x = atoi(str.c_str());
		std::getline(plik, str);
		y = atoi(str.c_str());
		pC[a].setPos(x, y);
		std::getline(plik, str);
		nrPole = atoi(str.c_str());
		pC[i].setPole(nrPole);
	}

	//----Wczytanie DANYCH KLASY RUCH---
	bool czyjRuch;
	std::cout << "RUCH3: " << a << std::endl;
	std::getline(plik, str);
	czyjRuch = atoi(str.c_str());
	ruch.setRuch(czyjRuch);

	//-----Wczytanie DANYCH O POLACH----
	bool getUse;
	bool poleColorX, poleColorY;
	for (int i = 0; i < 32; i++) {
		std::getline(plik, str);
		a = atoi(str.c_str());
		std::cout << "A3: " << a << std::endl;
		//pole.getUse(i);
		std::getline(plik, str);
		getUse = atoi(str.c_str());
		if (getUse == 0 || getUse == 204) getUse = false;
		else getUse = true;
		std::cout << "CZY MOZNA POSTAWIC NA POLU " << a << " : " << getUse<< std::endl;
		std::getline(plik, str);
		poleColorX = atoi(str.c_str());
		if (poleColorX == 0 || poleColorX == 204) poleColorY = false;
		else poleColorX = true;
		std::getline(plik, str);
		poleColorY = atoi(str.c_str());
		if (poleColorY == 0 || poleColorY == 204) poleColorY = false;
		else poleColorY = true;
		pole.setUse(getUse,i,poleColorX, poleColorY);
		std::cout << "CZY MOZNA POSTAWIC NA POLU " << i << " : " << pole.getUse(i) << std::endl;
	}

	int tab[2] = { -1,-1 };
	ruch.setZbityWTurze(-1);
	ruch.setZbijany(tab);
	ruch.setZbijanyNa(tab);
	plik.close();
	/*for (int i = 0; i < 32; i++) {
		std::cout << "CZY MOZNA POSTAWIC NA POLU " << i << " : " << pole.getUse(i) << std::endl;
	}*/
	}
}


void GameStart::save(RenderWindow& window, Ruch& ruch, Pole& pole, WindowManage& manage, PionekB pB[], PionekC pC[]) {
	std::cout << "TU BEDZIE ZAPIS" << std::endl;
	std::fstream plik("save.txt", std::ios::out);
	//----ZAPIS DANYCH PIONKOW BIALYCH----
	for (int i = 0; i < 12; i++) {
		plik << i << std::endl;
		plik << pB[i].getDeleted() << std::endl;
		if (pB[i].getDeleted() == true) {
			plik << -1 << std::endl;
			plik << -1 << std::endl;
			plik << -1 << std::endl;
		}else{
			plik << pB[i].getXY().x << std::endl;
			plik << pB[i].getXY().y << std::endl;
			plik << pB[i].getPole() << std::endl;
		}
	}
	//----ZAPIS DANYCH PIONKOW CZARNYCH----
	for (int i = 0; i < 12; i++) {
		plik << i << std::endl;
		plik << pC[i].getDeleted() << std::endl;
		if (pC[i].getDeleted() == true) {
			plik << -1 << std::endl;
			plik << -1 << std::endl;
			plik << -1 << std::endl;
		}
		else {
			plik << pC[i].getXY().x << std::endl;
			plik << pC[i].getXY().y << std::endl;
			plik << pC[i].getPole() << std::endl;
		}
	}
	//----ZAPIS DANYCH KLASY RUCH---
	plik << ruch.czyjRuch()<< std::endl;

	//-----ZAPIS DANYCH O POLACH----
	for(int i =0;i<32;i++){
		plik << i << std::endl;
		//pole.getUse(i);
		plik << pole.getUse(i) << std::endl;
		plik << pole.getColor(i).x << std::endl;
		plik << pole.getColor(i).y << std::endl;
	}
	plik.close();
}