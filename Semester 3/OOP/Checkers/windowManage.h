#pragma once
#include <SFML/Graphics.hpp>
#include "ruch.h"
#include <iostream>


using namespace sf;
///Zarz¹dzanie oknem
class WindowManage {
	///Nowa gra
	std::string reload = "Images/button_reload.png";
	///Nowa gra
	Vector2i relPos=Vector2i(825, 85);
	///Wczytanie z pliku
	std::string wczytaj = "Images/button_wczytaj.png";
	///Wczytanie z pliku
	Vector2i wczytajPos = Vector2i(825, 160);
	///Zapis do pliku
	std::string save = "Images/button_zapisz.png";
	///Zapis do pliku
	Vector2i savePos = Vector2i(825, 235);
	///Wyjscie
	std::string quit = "Images/button_wyjdz.png";
	///Wyjscie
	Vector2i quitPos = Vector2i(825, 310);
	///Czyja tura
	std::string tura[2] = {"Images/button_ruch-bialy.png","Images/button_ruch-czarny.png"};
	///Czyja tura
	Vector2i turaPos = Vector2i(825, 10);
public:
	///rysowanie opcji 
	void rysuj(RenderWindow& window, Ruch& ruch);
	///Nowa gra
	Vector2i getRel();
	///Czyja tura
	Vector2i getTura();
	///Wczytanie
	Vector2i getWczytaj();
	///Zapis
	Vector2i getZapisz();
	///Wyjscie
	Vector2i getWyjdz();
};