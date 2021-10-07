#include <SFML/Graphics.hpp>
#include "pionekC.h"

using namespace sf;

void PionekC::rysuj(RenderWindow& window)
{
	//--------------------NANIESIENIE PIONKA NA PLANSZE---------------------
	if (deleted == false) {
		pionek.loadFromFile("Images/pionekC.png");
		Sprite p(pionek);
		pionek.setSmooth(true);
		p.setPosition(pozX, pozY);
		//p.move(0, 5);
		window.draw(p);
	}
}