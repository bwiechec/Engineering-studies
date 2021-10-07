#include <SFML/Graphics.hpp>
#include "plansza.h"

using namespace sf;


void Board::rysuj(RenderWindow &window)
{
	plansza.loadFromFile(img);
	Sprite background(plansza);
	window.draw(background);
}
