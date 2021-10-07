#pragma once
#include <SFML/Graphics.hpp>
#include "pole.h"
#include "ruch.h"

using namespace sf;

///Klasa g³ówna od pionków
class Pionki {
protected:
	///Obraz
	std::string img;
	///Tekstura pionka
	Texture pionek;
	///Czy w ruchu
	bool moving = false;
	///Pozycja X
	int pozX;
	///Pozycja Y
	int pozY;
	///mo¿liwe ruchy
	Vector2i possibleMv;
	///Na jakim polu
	int nrPole;
	///Jaki kolor pionka
	bool czyKolorBialy;
	///Jaki kolor pionka
	bool czyKolorCzarny;
	///Czy zbity
	bool deleted = false;
public:
	///rysowanie
	virtual void rysuj(RenderWindow& window);
	///Wypisanie X i Y
	void wypiszXY();
	///Zwrócenie X i Y
	Vector2i getXY();
	///Ustawienie ruchu
	void setMove(RenderWindow& window, Event& e, Pole& pole, Ruch& ruch);
	///Ustawienie pozycji
	void setPos(int a, int b);
	///Pokazanie opcji ruchu
	Vector2i showOpt(RenderWindow& window, Event& e, Pole& pole, Ruch& ruch);
	///Ustawienie czy sie rusza pionek
	void setMoving(bool mv);
	///Sprawdzenie czy rusza siê
	bool isMoving();
	//void findPossi()
	///Funkcja ruchu
	void move(RenderWindow& window, Event& e, Pole& pole, Vector2i pos, Ruch& ruch);
	///Ustawienie na którym polu jest pionek
	void setPole(int number);
	///Zbicie pionka
	void zbity(Pole& pole);
	///Ustawienie zbicia
	void setDeleted(bool del);
	///Sprawdzenei czy zbity
	bool getDeleted();
	///Zwraza na jakim polu jest pionek 
	int getPole();
};
