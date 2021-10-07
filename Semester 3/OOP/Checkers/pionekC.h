#pragma once
#include <SFML/Graphics.hpp>
#include "pionki.h"
using namespace sf;
///Pionek czarny 
class PionekC : public Pionki {
	//img = "Images/pionekC.png";
	///Jakiego koloru jest pionek
	bool czyKolorBialy = false;
	///Jakiego koloru jest pionek
	bool czyKolorCzarny = true;
public:
	//void rysuj(RenderWindow& window) { Pionki::rysuj(window); }
	//PionekC(std::string image = "Images/pionekC.png") : Pionki(image) {}
	//void wypiszXY() { Pionki::wypiszXY(); }
	//Vector2i getXY() { return Pionki::getXY(); }
	//void setPos(int a, int b) { Pionki::setPos(a, b); }
	///Rysowanie pionka
	void rysuj(RenderWindow& window);
};