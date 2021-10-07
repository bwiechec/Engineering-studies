#pragma once
#include <SFML/Graphics.hpp>
#include "pionki.h"

using namespace sf;

///Klasa pionek bia³y
class PionekB : public Pionki{
	//img = "Images/pionekB.png";

	///Jakiego koloru jest pionek
	bool czyKolorBialy = true;

	///Jakiego koloru jest pionek
	bool czyKolorCzarny = false;
public:
	//void rysuj(RenderWindow& window) { Pionki::rysuj(window); }
	//PionekB(std::string image = "Images/pionekB.png") : Pionki(image) {}
	//void wypiszXY() { Pionki::wypiszXY(); }
	//Vector2i getXY() { return Pionki::getXY(); }
	//void setPos(int a, int b) { Pionki::setPos(a, b); }
	///Rysowanie pionka
	void rysuj(RenderWindow& window);
};