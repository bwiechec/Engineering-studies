#pragma once
#include "pionekC.h"
#include "pionekB.h"
#include "pole.h"
#include "ruch.h"
#include "windowManage.h"
#include <SFML/Graphics.hpp>

using namespace sf;
///rozpoczêcie gry
class GameStart {
	///Pozycje startowe bia³ych pionków
	int pozBiale[12][2] = {
	{100,0},{300,0},{500,0},{700,0},{0,100},{200,100},{400,100},{600,100},{100,200},{300,200},{500,200},{700,200}
	};
	///Pozycje startowe czarnych pionków
	int pozCzarne[12][2] = {
		{0,500},{200,500},{400,500},{600,500},{100,600},{300,600},{500,600},{700,600},{0,700},{200,700},{400,700},{600,700}
	};
public:
	///Uruchomienie gry
	void start(RenderWindow& window,Ruch& ruch,Pole& pole,WindowManage& manage,PionekB pB[], PionekC pC[],bool odNowa);
	///Uruchomienie gry od nowa
	void startNowy(RenderWindow& window, Ruch& ruch, Pole& pole, WindowManage& manage, PionekB pB[], PionekC pC[]);
	///Uruchomienie gry przez wczytanie
	void wczytaj(RenderWindow& window, Ruch& ruch, Pole& pole, WindowManage& manage, PionekB pB[], PionekC pC[]);
	///zapis
	void save(RenderWindow& window, Ruch& ruch, Pole& pole, WindowManage& manage, PionekB pB[], PionekC pC[]);
};