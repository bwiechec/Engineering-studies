#include "poleBraz.h"
#include <SFML/Graphics.hpp>
using namespace sf;

void PoleBraz::setPosition(int posX, int posY) {
	x = posX;
	y = posY;
}
void PoleBraz::setTextur(std::string text) {
	img = text;
}
void PoleBraz::rysuj(RenderWindow& window) {
	poleBrazo.loadFromFile(img);
	poleBrazowe.setPosition(x, y);
	poleBrazowe.setTexture(poleBrazo);
	window.draw(poleBrazowe);
}
Vector2i PoleBraz::getPosition() {
	return Vector2i(x, y);
}

void PoleBraz::setUsage(bool use) {
	inUse = use;
}

bool PoleBraz::isUsed() {
	return inUse;
}

void PoleBraz::setColor(bool Bialy, bool Czarny) {
	czyKolorBialy = Bialy;
	czyKolorCzarny = Czarny;
}

Vector2i PoleBraz::getColor() {
	return Vector2i(czyKolorBialy, czyKolorCzarny);
}