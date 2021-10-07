#pragma once
#include <SFML/Graphics.hpp>

using namespace sf;

class Board {
	std::string img;
	Texture plansza;
public:
	void rysuj(RenderWindow &window);
	Board(std::string image) {
		img = image;
	}
};
