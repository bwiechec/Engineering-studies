#include <SFML/Graphics.hpp>
#include "windowManage.h"

using namespace sf;

void WindowManage::rysuj(RenderWindow& window, Ruch& ruch) {
	Texture relo, move, wczyt, zapisz,wyjdz;
	relo.loadFromFile(reload);
	wyjdz.loadFromFile(quit);
	wczyt.loadFromFile(wczytaj);
	zapisz.loadFromFile(save);
	Sprite rel(relo);
	Sprite wcz(wczyt);
	Sprite sv(zapisz);
	Sprite qt(wyjdz);
	//relo.setSmooth(true);
	rel.setPosition(relPos.x, relPos.y);
	wcz.setPosition(wczytajPos.x, wczytajPos.y);
	sv.setPosition(savePos.x, savePos.y);
	qt.setPosition(quitPos.x, quitPos.y);
	if (ruch.czyjRuch()) {
		move.loadFromFile(tura[0]);
	}
	else {
		move.loadFromFile(tura[1]);
	}
	Sprite mv(move);
	mv.setPosition(turaPos.x, turaPos.y);
	window.draw(rel);
	window.draw(mv);
	window.draw(wcz);
	window.draw(sv);
	window.draw(qt);
}

Vector2i WindowManage::getRel() {
	return relPos;
}


Vector2i WindowManage::getTura() {
	return turaPos;
}

Vector2i WindowManage::getWczytaj() {
	return wczytajPos;
}

Vector2i WindowManage::getZapisz() {
	return savePos;
}
Vector2i WindowManage::getWyjdz() {
	return quitPos;
}