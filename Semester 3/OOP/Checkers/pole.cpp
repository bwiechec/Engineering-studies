#include <SFML/Graphics.hpp>
#include "pole.h"
#include <iostream>

using namespace sf;

void Pole::setPossition() {
	int posX = 0, posY = 0, size = 100, counter = 0, pCounter = 0;;
	for (int i = 0; i < 32; i++) {
		if(posY%200==0){
			biale[i].setPosition(posX, posY);
			x[counter] = posX;
			y[counter] = posY;
			counter++;
			posX += size;
			//std::cout << "px" << posX << "py"<<posY<<std::endl;
			brazowe[i].setPosition(posX, posY);
			x[counter] = posX;
			y[counter] = posY;
			playableCounter[pCounter] = counter;
			pCounter++;
			counter++;
			posX += size;
		}
		else {
			brazowe[i].setPosition(posX, posY);
			x[counter] = posX;
			y[counter] = posY;
			playableCounter[pCounter] = counter;
			pCounter++;
			counter++;
			posX += size;
			//std::cout << "px" << posX << "py" << posY << std::endl;
			biale[i].setPosition(posX, posY);
			x[counter] = posX;
			y[counter] = posY;
			counter++;
			posX += size;
		}
		if (posX % 800 == 0) { posX = 0; posY += size; }
		//if ((posY+100) % 800 == 0) posY %= 800;
		brazowe[i].setTextur("Images/poleBraz.png");
	}
	//std::cout << "Licznik: " << counter;
}


void Pole::rysuj(RenderWindow &window) {
	Texture bial;
	bial.loadFromFile("Images/poleBiale.png");
	for (int i = 0; i < 32; i++) {
		biale[i].setTexture(bial);
		//brazowe[i].setTexture(braz);
	}
	//setImg();
	//setPosition();
	for (int i = 0; i < 32; i++) {
		window.draw(biale[i]);
		brazowe[i].rysuj(window);
	}
}

Vector2i Pole::findPossi(RenderWindow& window, Event& e, Ruch& ruch) {
	Vector2i pos = Mouse::getPosition(window);
	Vector2i color;
	bool zbijanie = false;
	int cur[2];
	int zbijany[2];
	int zbijanyNa[2];
	int curCounter=0;
	int zbijanyCounter=0;
	if(ruch.czyjRuch()){
		for (int i = 0; i < 32; i++) {
			if (y[playableCounter[i]] <= pos.y && (y[playableCounter[i]] + 100) >= pos.y){
				if (x[playableCounter[i]] <= pos.x && (x[playableCounter[i]] + 100) >= pos.x){
					std::cout << "Y: " << y[playableCounter[i]] << std::endl;
					std::cout << "X: " << x[playableCounter[i]] << std::endl;
					if(i%4==0 && y[playableCounter[i]]%200!=0){
						if (brazowe[i + 4].isUsed() || i + 4 > 32) {
							color = brazowe[i + 4].getColor();
							if (color.y) {
								std::cout << "pole braz nr: " << i + 4 << " jest zajete przez czarny pionek. " << std::endl;
								if (brazowe[i + 9].isUsed() || i +9 > 32) {
									std::cout << "pole braz nr: " << i + 9 << " jest zajete." << std::endl;
								}
								else {
									std::cout << "Mozna zbijac na pole " << i + 9  << std::endl;
									cur[curCounter] = i + 9;
									curCounter++;
									zbijany[zbijanyCounter] = i + 4;
									zbijanyNa[zbijanyCounter] = i + 9;
									zbijanyCounter++;
									zbijanie = true;
								}
							}
							else std::cout << "pole braz nr: " << i + 4 << " jest zajete przez bialy pionek. " << std::endl;
						}else{
							if(zbijanie==false){
								cur[curCounter] = i+4;
								curCounter++;
							}
						}
					}else if((i+1)%4==0 && y[playableCounter[i]]%200==0){
						if (brazowe[i + 4].isUsed() || i + 4 > 32) {
							color = brazowe[i + 4].getColor();
							if (color.y) {
								std::cout << "pole braz nr: " << i + 4 << " jest zajete przez czarny pionek. " << std::endl;
								if (brazowe[i + 7].isUsed() || i + 7 > 32) {
									std::cout << "pole braz nr: " << i + 7 << " jest zajete." << std::endl;
								}
								else {
									std::cout << "Mozna zbijac na pole " << i + 7 << std::endl;
									cur[curCounter] = i + 7;
									curCounter++;
									zbijany[zbijanyCounter] = i + 4;
									zbijanyNa[zbijanyCounter] = i + 7;
									zbijanyCounter++;
									zbijanie = true;
								}
							}
							else std::cout << "pole braz nr: " << i + 4 << " jest zajete przez bialy pionek. " << std::endl;
						}
						else {
							if (zbijanie == false) {
								cur[curCounter] = i + 4;
								curCounter++;
							}
						}
					}
					else if(y[playableCounter[i]] % 200 == 0){
						if (brazowe[i + 4].isUsed() || i + 4 > 32) {
							color = brazowe[i + 4].getColor();
							if (color.y) {
								if (i % 4 == 0 && y[playableCounter[i]] % 200 == 0) {
									std::cout << "pole braz nr: " << i + 4 << " jest zajete przez bialy pionek. " << std::endl;
									if (brazowe[i + 8].isUsed() || i + 8 >= 32) {
										std::cout << "pole braz nr: " << i + 8 << " jest zajete." << std::endl;
									}
									else {
										std::cout << "Mozna zbijac na polu " << i + 8 << std::endl;
										cur[curCounter] = i + 8;
										curCounter++;
										zbijany[zbijanyCounter] = i + 4;
										zbijanyNa[zbijanyCounter] = i + 8;
										zbijanyCounter++;
										zbijanie = true;
									}
								}
								else {
									std::cout << "pole braz nr: " << i + 4 << " jest zajete przez czarny pionek. " << std::endl;
									if (brazowe[i + 7].isUsed() || i + 7 > 32) {
										std::cout << "pole braz nr: " << i + 7 << " jest zajete." << std::endl;
									}
									else {
										std::cout << "Mozna zbijac na pole " << i + 7 << std::endl;
										cur[curCounter] = i + 7;
										curCounter++;
										zbijany[zbijanyCounter] = i + 4;
										zbijanyNa[zbijanyCounter] = i + 7;
										zbijanyCounter++;
										zbijanie = true;
									}
								}
							}
							else std::cout << "pole braz nr: " << i + 4 << " jest zajete przez bialy pionek. " << std::endl;
						}
						else {
							if (zbijanie == false) {
								cur[curCounter] = i + 4;
								curCounter++;
							}
						}
						if (brazowe[i + 5].isUsed() || i + 5 > 32) {
							color = brazowe[i + 5].getColor();
							if (color.y) {
									std::cout << "pole braz nr: " << i + 4 << " jest zajete przez czarny pionek. " << std::endl;
									if (brazowe[i + 9].isUsed() || i + 9 > 32) {
										std::cout << "pole braz nr: " << i + 9 << " jest zajete." << std::endl;
									}
									else {
										std::cout << "Mozna zbijac na pole " << i + 9 << std::endl;
										cur[curCounter] = i + 9;
										curCounter++;
										zbijany[zbijanyCounter] = i + 5;
										zbijanyNa[zbijanyCounter] = i + 9;
										zbijanyCounter++;
										zbijanie = true;
									}
							}
							else std::cout << "pole braz nr: " << i + 5 << " jest zajete przez bialy pionek. " << std::endl;
						}
						else {
							if (zbijanie == false) {
								cur[curCounter] = i + 5;
								curCounter++;
							}
						}
					}
					else if(y[playableCounter[i]] % 200 != 0){
						if (brazowe[i + 3].isUsed() || (i+3)>32) {
							color = brazowe[i + 3].getColor();
							if (color.y) {
								
									std::cout << "pole braz nr: " << i + 3 << " jest zajete przez czarny pionek. " << std::endl;
									if (brazowe[i + 7].isUsed() || i + 7 > 32) {
										std::cout << "pole braz nr: " << i + 7 << " jest zajete." << std::endl;
									}
									else {
										std::cout << "Mozna zbijac na pole " << i + 7 << std::endl;
										cur[curCounter] = i + 7;
										curCounter++;
										zbijany[zbijanyCounter] = i + 3;
										zbijanyNa[zbijanyCounter] = i + 7;
										zbijanyCounter++;
										zbijanie = true;
									}
							}
							else std::cout << "pole braz nr: " << i + 3 << " jest zajete przez bialy pionek. " << std::endl;
							//sprawdzanie czy jest do zbicia
						}
						else {
							if (zbijanie == false) {
								cur[curCounter] = i + 3;
								curCounter++;
							}
						}
						if (brazowe[i + 4].isUsed() || (i + 4) > 32) {
							color = brazowe[i + 4].getColor();
							if (color.y) {
								if ((i + 1) % 4 == 0 && y[playableCounter[i]] % 200 != 0) {
									std::cout << "pole braz nr: " << i - 4 << " jest zajete przez bialy pionek. " << std::endl;
									if (brazowe[i + 8].isUsed() || i + 8 > 32) {
										std::cout << "pole braz nr: " << i + 8 << " jest zajete." << std::endl;
									}
									else {
										std::cout << "Mozna zbijac na polu " << i + 8 << std::endl;
										cur[curCounter] = i + 8;
										curCounter++;
										zbijany[zbijanyCounter] = i + 4;
										zbijanyNa[zbijanyCounter] = i + 8;
										zbijanyCounter++;
										zbijanie = true;
									}
								}
								else {
									std::cout << "pole braz nr: " << i + 4 << " jest zajete przez czarny pionek. " << std::endl;
									if (brazowe[i + 9].isUsed() || i + 9 > 32) {
										std::cout << "pole braz nr: " << i + 9 << " jest zajete." << std::endl;
									}
									else {
										std::cout << "Mozna zbijac na polu " << i + 9 << std::endl;
										cur[curCounter] = i + 9;
										curCounter++;
										zbijany[zbijanyCounter] = i + 4;
										zbijanyNa[zbijanyCounter] = i + 9;
										zbijanyCounter++;
										zbijanie = true;
									}
								}
							}
							else std::cout << "pole braz nr: " << i + 4 << " jest zajete przez bialy pionek. " << std::endl;
						}
						else {
							if (zbijanie == false) {
								cur[curCounter] = i + 4;
								curCounter++;
							}
						}
					}
				}
			}
		}
	}//----------------------------------------------DLA CZARNYCH------------------------------------------------
	else {
		for (int i = 0; i < 32; i++) {
			if (y[playableCounter[i]] <= pos.y && (y[playableCounter[i]] + 100) >= pos.y) {
				if (x[playableCounter[i]] <= pos.x && (x[playableCounter[i]] + 100) >= pos.x) {
					std::cout << "Y: " << y[playableCounter[i]] << std::endl;
					std::cout << "X: " << x[playableCounter[i]] << std::endl;
					if (i % 4 == 0 && y[playableCounter[i]] % 200 != 0) {
						if (brazowe[i - 4].isUsed() || i - 4 <= 0) {
							color = brazowe[i - 4].getColor();
							if (color.x) {
								std::cout << "pole braz nr: " << i - 4 << " jest zajete przez bialy pionek. " << std::endl;
								if (brazowe[i - 7].isUsed() || i - 7 <= 0) {
									std::cout << "pole braz nr: " << i - 7<< " jest zajete." << std::endl;
								}
								else {
									std::cout << "Mozna zbijac na polu " << i - 7 << std::endl;
									cur[curCounter] = i - 7;
									curCounter++;
									zbijany[zbijanyCounter] = i - 4;
									zbijanyNa[zbijanyCounter] = i -7;
									zbijanyCounter++;
									zbijanie = true;
								}
							}
							else std::cout << "pole braz nr: " << i - 4 << " jest zajete przez czarny pionek. " << std::endl;
						}
						else {
							cur[curCounter] = i - 4;
							curCounter++;
						}
					}
					else if ((i + 1) % 4 == 0 && y[playableCounter[i]] % 200 == 0) {
						if (brazowe[i - 4].isUsed() || i - 4 <= 0) {
							color = brazowe[i - 4].getColor();
							if (color.x) {
								std::cout << "pole braz nr: " << i - 4 << " jest zajete przez bialy pionek. " << std::endl;
								if (brazowe[i - 9].isUsed() || i - 9 <= 0) {
									std::cout << "pole braz nr: " << i - 9 << " jest zajete." << std::endl;
								}
								else {
									std::cout << "Mozna zbijac na polu " << i -9 << std::endl;
									cur[curCounter] = i - 9;
									curCounter++;
									zbijany[zbijanyCounter] = i - 4;
									zbijanyNa[zbijanyCounter] = i - 9;
									zbijanyCounter++;
									zbijanie = true;
								}
							}
							else std::cout << "pole braz nr: " << i - 4 << " jest zajete przez czarny pionek. " << std::endl;
						}
						else {
							cur[curCounter] = i - 4;
							curCounter++;
						}
					}
					else if (y[playableCounter[i]] % 200 != 0) {
						if (brazowe[i - 4].isUsed() || i - 4 <= 0) {
							color = brazowe[i - 4].getColor();
							if (color.x) {
								if ((i + 1) % 4 == 0 && y[playableCounter[i]] % 200 != 0) {
									std::cout << "pole braz nr: " << i - 4 << " jest zajete przez bialy pionek. " << std::endl;
									if (brazowe[i - 8].isUsed() || i - 8 <= 0) {
										std::cout << "pole braz nr: " << i - 8 << " jest zajete." << std::endl;
									}
									else {
										std::cout << "Mozna zbijac na polu " << i - 8 << std::endl;
										cur[curCounter] = i - 8;
										curCounter++;
										zbijany[zbijanyCounter] = i - 4;
										zbijanyNa[zbijanyCounter] = i - 8;
										zbijanyCounter++;
										zbijanie = true;
									}
								}
								else{
									std::cout << "pole braz nr: " << i - 4 << " jest zajete przez bialy pionek. " << std::endl;
									if (brazowe[i - 7].isUsed() || i - 7 <= 0) {
										std::cout << "pole braz nr: " << i - 7 << " jest zajete." << std::endl;
									}
									else {
										std::cout << "Mozna zbijac na polu " << i -7 << std::endl;
										cur[curCounter] = i - 7;
										curCounter++;
										zbijany[zbijanyCounter] = i - 4;
										zbijanyNa[zbijanyCounter] = i - 7;
										zbijanyCounter++;
										zbijanie = true;
									}
								}
							}
							else std::cout << "pole braz nr: " << i - 4 << " jest zajete przez czarny pionek. " << std::endl;
						}
						else {
							cur[curCounter] = i - 4;
							curCounter++;
						}
						if (brazowe[i - 5].isUsed() || i - 5 <= 0) {
							color = brazowe[i - 5].getColor();
							if (color.x) {
									std::cout << "pole braz nr: " << i - 5 << " jest zajete przez bialy pionek. " << std::endl;
									if (brazowe[i - 9].isUsed() || i - 9 <= 0) {
										std::cout << "pole braz nr: " << i - 9 << " jest zajete." << std::endl;
									}
									else {
										std::cout << "Mozna zbijac na polu " << i - 9 << std::endl;
										cur[curCounter] = i - 9;
										curCounter++;
										zbijany[zbijanyCounter] = i - 5;
										zbijanyNa[zbijanyCounter] = i - 9;
										zbijanyCounter++;
										zbijanie = true;
									}
							}
							else std::cout << "pole braz nr: " << i - 5 << " jest zajete przez czarny pionek. " << std::endl;
						}
						else {
							cur[curCounter] = i - 5;
							curCounter++;
						}
					}
					else if (y[playableCounter[i]] % 200 == 0) {
						if (brazowe[i - 3].isUsed() || (i - 3) <= 0) {
							color = brazowe[i - 3].getColor();
							if (color.x) {
									std::cout << "pole braz nr: " << i - 4 << " jest zajete przez bialy pionek. " << std::endl;
									if (brazowe[i - 7].isUsed() || i - 7 <= 0) {
										std::cout << "pole braz nr: " << i - 7 << " jest zajete." << std::endl;
									}
									else {
										std::cout << "Mozna zbijac na polu " << i - 7 << std::endl;
										cur[curCounter] = i - 7;
										curCounter++;
										zbijany[zbijanyCounter] = i - 3;
										zbijanyNa[zbijanyCounter] = i - 7;
										zbijanyCounter++;
										zbijanie = true;
									}
							}
							else std::cout << "pole braz nr: " << i - 3 << " jest zajete przez czarny pionek. " << std::endl;
						}
						else {
							cur[curCounter] = i - 3;
							curCounter++;
						}
						if (brazowe[i - 4].isUsed() || (i - 4) <= 0) {
							color = brazowe[i - 4].getColor();
							if (color.x) {
								if (i % 4 == 0 && y[playableCounter[i]] % 200 == 0) {
									std::cout << "pole braz nr: " << i - 4 << " jest zajete przez bialy pionek. " << std::endl;
									if (brazowe[i - 8].isUsed() || i - 8 <= 0) {
										std::cout << "pole braz nr: " << i - 8 << " jest zajete." << std::endl;
									}
									else {
										std::cout << "Mozna zbijac na polu " << i - 8 << std::endl;
										cur[curCounter] = i - 8;
										curCounter++;
										zbijany[zbijanyCounter] = i - 4;
										zbijanyNa[zbijanyCounter] = i - 8;
										zbijanyCounter++;
										zbijanie = true;
									}
								}
								else {
									std::cout << "pole braz nr: " << i - 4 << " jest zajete przez bialy pionek. " << std::endl;
									if (brazowe[i - 9].isUsed() || i - 9 <= 0) {
										std::cout << "pole braz nr: " << i - 9 << " jest zajete." << std::endl;
									}
									else {
										std::cout << "Mozna zbijac na polu " << i - 9 << std::endl;
										cur[curCounter] = i - 9;
										curCounter++;
										zbijany[zbijanyCounter] = i - 4;
										zbijanyNa[zbijanyCounter] = i - 9;
										zbijanyCounter++;
										zbijanie = true;
									}
								}
							}
							else std::cout << "pole braz nr: " << i - 4 << " jest zajete przez czarny pionek. " << std::endl;
						}
						else {
							cur[curCounter] = i - 4;
							curCounter++;
						}
					}
				}
			}
		}
	}
	if (zbijanyCounter == 2) {
		ruch.setZbijany(zbijany);
		ruch.setZbijanyNa(zbijanyNa);
	}
	else if (zbijanyCounter == 1) {
		zbijany[1] = -1;
		zbijanyNa[1] = -1;
		ruch.setZbijany(zbijany);
		ruch.setZbijanyNa(zbijanyNa);
	}
	else {
		zbijany[0] = -1;
		zbijanyNa[0] = -1;
		zbijany[1] = -1;
		zbijanyNa[1] = -1;
		ruch.setZbijany(zbijany);
		ruch.setZbijanyNa(zbijanyNa);
	}
	if(curCounter ==2){
		if (zbijanie) {
			std::cout << "Zbijanie" << cur[0] << std::endl;
			if (zbijanyCounter > 0){
				if (cur[0] == zbijanyNa[0] || cur[0] == zbijanyNa[1])
					std::cout << "Zbijany ok" << cur[0] << std::endl;
				else { 
					cur[0] = cur[1];
					cur[1] = -1;
					curCounter = 1;
				}
				if (cur[1] == zbijanyNa[0] || cur[1] == zbijanyNa[1])
				{
					std::cout << "Zbijany ok" << cur[1] << std::endl;
				}
				else {
					cur[1] = -1;
					curCounter = 1;
				}
			}
		}
		for (int i = 0; i < curCounter; i++) {
			std::cout << "Img pola: " << brazowe[cur[i]].img << std::endl;
			std::cout << "Mozliwe do postawienia X: " << cur[i] << std::endl;
			brazowe[cur[i]].setTextur("Images/poleBrazPos.png");
			brazowe[cur[i]].rysuj(window);
			std::cout << "Img pola: " << brazowe[cur[i]].img << std::endl;
		}
		return Vector2i(cur[0],cur[1]);
	}
	else if(curCounter==1) {
		for (int i = 0; i < curCounter; i++) {
			std::cout << "Img pola: " << brazowe[cur[i]].img << std::endl;
			std::cout << "Mozliwe do postawienia X: " << cur[i] << std::endl;
			brazowe[cur[i]].setTextur("Images/poleBrazPos.png");
			brazowe[cur[i]].rysuj(window);
			std::cout << "Img pola: " << brazowe[cur[i]].img << std::endl;
		}
		return Vector2i(cur[0],-1);
	}
	else {
		return Vector2i(-1, -1);
	}
}

void Pole::setUse(bool use, int number, bool biale, bool czarne) {
	brazowe[number].setUsage(use);
	brazowe[number].setColor(biale, czarne);
}

Vector2i Pole::getXY(int number) {
	return brazowe[number].getPosition();
}

Vector2i Pole::getColor(int number) {
	return brazowe[number].getColor();
}


bool Pole::getUse(int number) {
	return brazowe[number].isUsed();
}