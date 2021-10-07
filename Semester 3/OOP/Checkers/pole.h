#pragma once
#include <SFML/Graphics.hpp>
#include "poleBraz.h"
#include "ruch.h"

using namespace sf;
///Klasa pole, odpowiedzialna za pola
class Pole{
	///Pola bia³e
	Sprite biale[32];
	///Klasa odpowiedzialna za pola br¹zowe
	PoleBraz brazowe[32];
	///Po³o¿enie pól
	int x[64], y[64];
	///Licznik pól na których mo¿na po³o¿yæ pionki
	int playableCounter[32];
public:
	///Ustawienie pozycji pól
	void setPossition();
	///Rysowanie pól
	void rysuj(RenderWindow& window);
	///Sprawdzenie które pola s¹ puste
	Vector2i findPossi(RenderWindow& window, Event& e, Ruch& ruch);
	//void genPlansza();
	///Ustawienie u¿ytkowania pola
	void setUse(bool use, int number, bool biale, bool czarne);
	///Zwraca polo¿enie pól
	Vector2i getXY(int number);
	///Mówi jaki kolor pionka jest na polu
	Vector2i getColor(int number);
	///Czy pole jest u¿ywane
	bool getUse(int number);
};

