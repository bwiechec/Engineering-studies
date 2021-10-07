#pragma once
#include <SFML/Graphics.hpp>
using namespace sf;

///Klasa odpowiedzialna za pola br¹zowe
class PoleBraz {
	///Po³o¿enie pola brazowego
	int x, y;
	///Odpowiedzialne za rysowanie pola
	Sprite poleBrazowe;
	///Odpowiedzialne za rysowanie pola
	Texture poleBrazo;
	///Czy w u¿yciu
	bool inUse=false;
	///Jaki kolor pionka po³o¿onego na polu
	bool czyKolorBialy;
	///Jaki kolor pionka po³o¿onego na polu
	bool czyKolorCzarny;
public:
	///obraz pola
	std::string img;
public:
	///ustawienie pozycji
	void setPosition(int posX, int posY);
	///Ustawienei obrazu
	void setTextur(std::string text);
	///Rysowanie pola
	void rysuj(RenderWindow& window);
	///Zwraca pozycje pola
	Vector2i getPosition();
	///Ustawienei u¿ytkowania
	void setUsage(bool use);
	///Czy w u¿yciu
	bool isUsed();
	/// ustawienie koloru pionka
	void setColor(bool Bialy, bool Czarny);
	///zwrócenie koloru pionka 
	Vector2i getColor();
};