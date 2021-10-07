#pragma once
#include <SFML/Graphics.hpp>
#include <iostream>

using namespace sf;
///Klasa 
class Ruch {
	///Czyj ruch
	bool ruch = true;//True - ruch bia�y; False - ruch czarny
	///Ktore mozna pionki zbic w tej turze
	int zbijaneWTurze[2];
	///Na kt�re pole po zbiciu idzie pionek
	int zbijaneNaPole[2];
	///Pionek ju� zbity w turze
	int zbityWTurze;
	///Czy jest kolejne bicie
	bool kolejneBicie;
public:
	///Czyj ruch
	bool czyjRuch();
	///Zmiana ruchu
	void setRuch(bool nowy);
	///Ustawienie kolejnego bicia
	void setKolejneBicice(bool bicie);
	///Ustawienie zbijanych w turze
	void setZbijany(int zbij[]);
	///Ustawienei na kt�r� pozycje po zbiciu idzie pionek
	void setZbijanyNa(int zbijNa[]);
	///Ustawienie zbitego w turze pionka
	void setZbityWTurze(int zbity);
	///Wypisanie na kt�r� pozycje po zbiciu idzie pionek
	Vector2i getZbijanyNa();
	///Wypisanie kt�re mog� by�zbite
	Vector2i getZbijany();
	///Wypisanie zbitych
	int getZbity();
	///Informacja czy jest kolejne bicie
	bool getKolejneBicice();
};