#include "Game.h"



int main() {

	Game game("Vulcano", 1280, 720, 4, 4);


	//MAIN LOOP
	while (!game.getWindowShouldClose()) {
		//UPDATE INPUT
		game.update();
		//RENDER
		game.render();
	}

	return 0;
}