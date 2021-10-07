#include <SFML/Graphics.hpp>
#include "ruch.h"

using namespace sf;

bool Ruch::czyjRuch() {
	return ruch;
}

void Ruch::setRuch(bool nowy) {
	ruch = nowy;
}

void Ruch::setKolejneBicice(bool bicie) {
	kolejneBicie = bicie;
}

bool Ruch::getKolejneBicice() {
	return kolejneBicie;
}

void Ruch::setZbijany(int zbij[]) {
	zbijaneWTurze[0] = zbij[0];
	zbijaneWTurze[1] = zbij[1];
	std::cout << "zbijaneWTurze[0] to: " << zbij[0] << " LUB: " << zbijaneWTurze[0] << " a [1] to: " << zbij[1] << " LUB: " << zbijaneWTurze[1] << std::endl;
}
void Ruch::setZbityWTurze(int zbity) {
	zbityWTurze = zbity;
}
void Ruch::setZbijanyNa(int zbijNa[]) {
	zbijaneNaPole[0] = zbijNa[0];
	zbijaneNaPole[1] = zbijNa[1];
	std::cout << "zbijaneNaPole[0] to: " << zbijNa[0] << " LUB: " << zbijaneNaPole[0] << " a [1] to: " << zbijNa[1] << " LUB: " << zbijaneNaPole[1] << std::endl;
}

Vector2i Ruch::getZbijanyNa() {
	return Vector2i(zbijaneNaPole[0], zbijaneNaPole[1]);
}
Vector2i Ruch::getZbijany() {
	return Vector2i(zbijaneWTurze[0], zbijaneWTurze[1]);
}
int Ruch::getZbity() {
	return zbityWTurze;
}