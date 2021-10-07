#pragma once
#include <SFML/Graphics.hpp>
#include "poleBraz.h"
#include "ruch.h"

using namespace sf;
///Klasa pole, odpowiedzialna za pola
class Pole{
	///Pola bia�e
	Sprite biale[32];
	///Klasa odpowiedzialna za pola br�zowe
	PoleBraz brazowe[32];
	///Po�o�enie p�l
	int x[64], y[64];
	///Licznik p�l na kt�rych mo�na po�o�y� pionki
	int playableCounter[32];
public:
	///Ustawienie pozycji p�l
	void setPossition();
	///Rysowanie p�l
	void rysuj(RenderWindow& window);
	///Sprawdzenie kt�re pola s� puste
	Vector2i findPossi(RenderWindow& window, Event& e, Ruch& ruch);
	//void genPlansza();
	///Ustawienie u�ytkowania pola
	void setUse(bool use, int number, bool biale, bool czarne);
	///Zwraca polo�enie p�l
	Vector2i getXY(int number);
	///M�wi jaki kolor pionka jest na polu
	Vector2i getColor(int number);
	///Czy pole jest u�ywane
	bool getUse(int number);
};

