#include <SFML/Graphics.hpp>
#include "pionekB.h"

using namespace sf;

void PionekB::rysuj(RenderWindow& window)
{
	//--------------------NANIESIENIE PIONKA NA PLANSZE---------------------
	if (deleted == false) {
		pionek.loadFromFile("Images/pionekB.png");
		Sprite p(pionek);
		pionek.setSmooth(true);
		p.setPosition(pozX, pozY);
		//p.move(0, 5);
		window.draw(p);
	}
}