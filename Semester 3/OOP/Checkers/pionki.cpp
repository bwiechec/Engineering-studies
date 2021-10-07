#include <SFML/Graphics.hpp>
#include "pionki.h"
#include <iostream>

using namespace sf;

void Pionki::rysuj(RenderWindow& window)
{
//--------------------NANIESIENIE PIONKA NA PLANSZE---------------------
	if (deleted == false) {
		pionek.loadFromFile(img);
		Sprite p(pionek);
		pionek.setSmooth(true);
		p.setPosition(pozX, pozY);
		//p.move(0, 5);
		window.draw(p);
	}
}
void Pionki::wypiszXY() {
//--------WYPISANIE POZYCJI PIONKA--------------
	if (deleted == false) {
		std::cout << "X: " << pozX << " Y: " << pozY << std::endl;
	}
}

Vector2i Pionki::getXY() {
//------------------POBRANIE POZYCJI PIONKA-----------------
	if (deleted == false) {
		return Vector2i(pozX, pozY);
	}
}

void Pionki::setPos(int a, int b) {
//-------------USTAWIENIE POZYCJI PIONKA--------------
	if (deleted == false) {
		pozX = a;
		pozY = b;
	}
}

void Pionki::setMove(RenderWindow& window, Event& e, Pole& pole, Ruch& ruch) {
//---------------------------funkcja ktora sprawdza mozliwe ruchy gracza------------------------------------
	if (deleted == false) {
		//if(e.type == Event::MouseButtonPressed){
			//if(e.key.code == Mouse::Left){
				//Vector2i pos = Mouse::getPosition(window);
				//p.setPosition(pos.x - 50, pos.y - 50);
				//Sprite p(pionek);
			//}
		//}
		setMoving(true);
		//Vector2i opt;
		possibleMv = showOpt(window, e, pole, ruch);
		if (possibleMv.x == -1) setMoving(false);
	}
}



Vector2i Pionki::showOpt(RenderWindow& window, Event& e, Pole& pole, Ruch& ruch) {
//---------------------FUNKCJA ODPOWIEDZIALNA ZA POKAZANIE MOZLIWYCH RUCHOW----------------------
	if (deleted == false) {
		//pole.podajPlayable();
		Vector2i wynik;
		wynik = pole.findPossi(window, e, ruch);
		return wynik;
	}
}

void Pionki::setMoving(bool mv) {
//-----------------USTAWIENIE ZMIENNEJ MOWIACEJ CZY PIONEK JEST WYBRANY PRZEZ GRACZA---------------
	if (deleted == false) {
		moving = mv;
	}
}

bool Pionki::isMoving() {
//------------------SPRAWDZENIE CZY PIONEK JEST WYBRANY--------------------
	if (deleted == false) {
		return moving;
	}
}

void Pionki::move(RenderWindow& window, Event& e, Pole& pole, Vector2i pos, Ruch& ruch) {
//---------------------RUCH PIONKA----------------------
	if (deleted == false) {
		Vector2i XY[2];
		Vector2i zbijNa = ruch.getZbijanyNa();
		Vector2i zbijane = ruch.getZbijany();
		if (possibleMv.x != -1) {
			XY[0] = pole.getXY(possibleMv.x);
			std::cout << "NR MOZLIWEGO RUCHU: " << possibleMv.x << std::endl;
			std::cout << "POLE LEWE X: " << XY[0].x << "POLE LEWE Y: " << XY[0].y << std::endl;
		}
		if (possibleMv.y != -1) {
			XY[1] = pole.getXY(possibleMv.y);
			std::cout << "NR MOZLIWEGO RUCHU: " << possibleMv.y << std::endl;
			std::cout << "POLE LEWE X: " << XY[1].x << "POLE LEWE Y: " << XY[1].y << std::endl;
		}
		if (pos.x >= XY[0].x && pos.x <= (XY[0].x + 100))
			if (pos.y >= XY[0].y && pos.y <= (XY[0].y + 100)) {
				std::cout << "PossMv.x: " << possibleMv.x << "PossMv.y: " << possibleMv.y << "zbijNa.x: " << zbijNa.x << "zbijNa.y: " << zbijNa.y << std::endl;
				if (possibleMv.x == zbijNa.x) {
					ruch.setZbityWTurze(zbijane.x);
					std::cout << "Zbijany: " << zbijane.x << std::endl;
				}
				else if (possibleMv.x == zbijNa.y) {
					ruch.setZbityWTurze(zbijane.y);
					std::cout << "Zbijany: " << zbijane.y << std::endl;
				}
				std::cout << nrPole << std::endl;
				pole.setUse(false, nrPole, czyKolorBialy, czyKolorCzarny);
				pozX = XY[0].x;
				pozY = XY[0].y;
				setMoving(false);
				if (ruch.czyjRuch())
					pole.setUse(true, possibleMv.x, true, false);
				else
					pole.setUse(true, possibleMv.x, false, true);
				setPole(possibleMv.x);
				pole.setPossition();

				if (ruch.czyjRuch()) ruch.setRuch(false);
				else ruch.setRuch(true);
				std::cout << nrPole << std::endl;
			}
		if (pos.x >= XY[1].x && pos.x <= (XY[1].x + 100))
			if (pos.y >= XY[1].y && pos.y <= (XY[1].y + 100)) {
				std::cout << "PossMv.x: " << possibleMv.x << "PossMv.y: " << possibleMv.y << "zbijNa.x: " << zbijNa.x << "zbijNa.y: " << zbijNa.y << std::endl;
				if (possibleMv.y == zbijNa.x) {
					std::cout << "Zbijany: " << zbijane.x << std::endl;
					ruch.setZbityWTurze(zbijane.x);
				}
				else if (possibleMv.y == zbijNa.y) {
					ruch.setZbityWTurze(zbijane.y);
					std::cout << "Zbijany: " << zbijane.y << std::endl;
				}
				std::cout << nrPole << std::endl;
				pole.setUse(false, nrPole, false, false);
				pozX = XY[1].x;
				pozY = XY[1].y;
				setMoving(false);
				if (ruch.czyjRuch())
					pole.setUse(true, possibleMv.y, true, false);
				else
					pole.setUse(true, possibleMv.y, false, true);
				setPole(possibleMv.y);

				if (ruch.czyjRuch()) ruch.setRuch(false);
				else ruch.setRuch(true);
				pole.setPossition();
				std::cout << nrPole << std::endl;
			}
	}
}

void Pionki::setPole(int nr) {
//-------------------USTAWIENIE NA KTORYM POLU ZNAJDUJE SIE PIONEK-----------------
	if (deleted == false) {
		nrPole = nr;
	}
}


void Pionki::zbity(Pole& pole) {
//----------------USTAWIENIE INFORMACJI O ZBICIU PIONKA------------------------------
	if (deleted == false) {
		deleted = true;
		pole.setUse(false, nrPole, false, false);
	}
}

int Pionki::getPole() {
	if (deleted == false) {
		return nrPole;
	}
}

void Pionki::setDeleted(bool del) {
	deleted = del;
}
bool Pionki::getDeleted() {
	return deleted;
}