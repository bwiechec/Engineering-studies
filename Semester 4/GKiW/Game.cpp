#include "Game.h"

void Game::initGLFW() {
	if (glfwInit() == GLFW_FALSE) {
		std::cout << "ERROR::GLFW_INIT_FAILED\n";
		glfwTerminate();
	}
}

void Game::initWindow(const char* title) {

	glfwWindowHint(GLFW_OPENGL_PROFILE, GLFW_OPENGL_CORE_PROFILE);
	glfwWindowHint(GLFW_CONTEXT_VERSION_MAJOR, this->GLVerMajor);
	glfwWindowHint(GLFW_CONTEXT_VERSION_MINOR, this->GLVerMinor);
	glfwWindowHint(GLFW_RESIZABLE, GLFW_FALSE);

	this->window = glfwCreateWindow(this->windowWidth, this->windowHeight, title, NULL, NULL);

	if (this->window == nullptr) {
		std::cout << "ERROR::GLFWwindow_INIT_FAILED\n";
		glfwTerminate();
	}

	glfwGetFramebufferSize(window, &this->fbWidth, &this->fbHeight);
	glViewport(0, 0, this->fbWidth, this->fbHeight);

	glfwMakeContextCurrent(window); //IMPORTANT

}

void Game::initGLEW() {
	glewExperimental = GL_TRUE;
	if (glewInit() != GLEW_OK) {
		std::cout << "ERROR::GLEW_INIT_FAILED" << std::endl;
		glfwTerminate();
	}
}

void Game::initOpenGlOpt() {

	glEnable(GL_DEPTH_TEST);

	glEnable(GL_CULL_FACE);

	glCullFace(GL_BACK);
	glFrontFace(GL_CCW);

	glEnable(GL_BLEND);
	glBlendFunc(GL_SRC_ALPHA, GL_ONE_MINUS_SRC_ALPHA);

	glPolygonMode(GL_FRONT_AND_BACK, GL_FILL);

	glfwSetInputMode(this->window, GLFW_CURSOR, GLFW_CURSOR_DISABLED);
}

void Game::initMatrices()
{
	this->viewMatrix = glm::mat4(1.f);
	this->viewMatrix = glm::lookAt(this->camPosition, this->camPosition + this->camFront, this->worldUp);

	this->projectionMatrix = glm::mat4(1.f);
	this->projectionMatrix = glm::perspective(glm::radians(this->fov), static_cast<float>(this->fbWidth) / this->fbHeight, this->nearPlane, this->farPlane);

}

void Game::initShaders(){
	this->shaders.push_back(new Shader("vertex_core.glsl", "fragment_core.glsl"));
	//this->shaders.push_back(new Shader("part_vertex.glsl", "part_fragment.glsl"));
}

void Game::initTextures(){

	//TEX 0
	this->textures.push_back(new Texture("Images/gravel.jpg", GL_TEXTURE_2D));
	this->textures.push_back(new Texture("Images/gravel_specular.jpg", GL_TEXTURE_2D));

	//TEX 1
	this->textures.push_back(new Texture("Images/text.png", GL_TEXTURE_2D));
	this->textures.push_back(new Texture("Images/pika_specular.png", GL_TEXTURE_2D));

	//TEX_SMOKE and TEX_LAVA
	this->textures.push_back(new Texture("Images/smoke.png", GL_TEXTURE_2D));
	this->textures.push_back(new Texture("Images/lava.png", GL_TEXTURE_2D));

}

void Game::initMaterials(){
	this->materials.push_back(new Material(glm::vec3(0.1f), glm::vec3(10.f), glm::vec3(2.f), 0, 1));
}

void Game::initObjModels(){
	std::vector<Vertex> temp;
	temp = loadObj("obj/WULKANO.obj");
}

void Game::initModels(){

	std::vector<Mesh*> meshes;

	//Particle* particle(new Particle(glm::vec3(0.f, 5.f, 0.f), glm::vec3(rand() % 1, rand() % 5 + 1, rand()), glm::vec4(1.f), 10.f));

	meshes.push_back(new Mesh(&Quad(), glm::vec3(0.f), glm::vec3(0.f), glm::vec3(-90.f, 0.f, 0.f), glm::vec3(100.f)));

	/*for (size_t i = 0; i < 20; i++)
	{
		meshesPartSmoke.push_back(new Mesh(particle, &Quad(), glm::vec3(0.f), glm::vec3(0.01f)));
		meshesPartLava.push_back(new Mesh(particle, &Quad(), glm::vec3(0.f), glm::vec3(0.01f)));
	}*/
		
	//this->models.push_back(new Model(glm::vec3(4.f, 0.f, 4.f), this->materials[MATERIAL_1], this->textures[TEX_WUL], this->textures[TEX_WUL_SPECULAR],
	//	"obj/WULKANO.obj"));
	
	this->models.push_back(new Model(glm::vec3(2.f, -5.f, 2.f), this->materials[MATERIAL_1], this->textures[TEX_GRAVEL], this->textures[TEX_GRAVEL_SPECULAR],
		meshes));

	/*this->models.push_back(new Model(glm::vec3(4.f, 5.f, 4.f), this->materials[MATERIAL_1], this->textures[TEX_PART_DYM], this->textures[TEX_PART_DYM],
		meshesPartSmoke));

	this->models.push_back(new Model(glm::vec3(4.f, 5.f, 4.f), this->materials[MATERIAL_1], this->textures[TEX_PART_LAWA], this->textures[TEX_PART_LAWA],
		meshesPartLava));*/

	//this->models.push_back(new Model(glm::vec3(0.f, 5.f, 0.f), this->materials[MATERIAL_1], this->textures[TEX_GRAVEL], this->textures[TEX_GRAVEL_SPECULAR], particles));

	for (auto*& i : meshes)
		delete i;

}

void Game::initPointLights(){
	this->pointLights.push_back(new PointLight(glm::vec3(0.f)));
}

void Game::initLights(){
	this->initPointLights();
}

void Game::initUniforms(){

	this->shaders[SHADER_CORE_PROGRAM]->setMat4fv(this->viewMatrix, "ViewMatrix");
	this->shaders[SHADER_CORE_PROGRAM]->setMat4fv(this->projectionMatrix, "ProjectionMatrix");

	for each (PointLight* pl in this->pointLights){
		pl->sendToShader(*this->shaders[SHADER_CORE_PROGRAM]);
	}
}

void Game::updateUniforms(){

	this->viewMatrix = this->camera.getViewMat();

	this->shaders[SHADER_CORE_PROGRAM]->setMat4fv(this->viewMatrix, "ViewMatrix");
	this->shaders[SHADER_CORE_PROGRAM]->setVec3f(this->camera.getPosition(), "camPosition"); 
	for each (PointLight * pl in this->pointLights){
		pl->sendToShader(*this->shaders[SHADER_CORE_PROGRAM]);
	}

//update frame buffer and projection matrix
	glfwGetFramebufferSize(this->window, &this->fbWidth, &this->fbHeight);

	this->projectionMatrix = glm::mat4(1.f);
	this->projectionMatrix = glm::perspective(glm::radians(fov), static_cast<float>(this->fbWidth) / this->fbHeight, this->nearPlane, this->farPlane);
	this->shaders[SHADER_CORE_PROGRAM]->setMat4fv(this->projectionMatrix, "ProjectionMatrix");

}

void Game::initParticles(){

}

Game::Game(const char* title, const int width, const int height, int GLmajorVer, int GLminorVer) :
windowHeight(height), windowWidth(width), GLVerMajor(GLmajorVer), GLVerMinor(GLminorVer), 
camera(glm::vec3(0.f, 0.f, 1.f), glm::vec3(0.f, 0.f, 1.f), glm::vec3(0.f, 1.f, 0.f)){
	this->fbWidth = width;
	this->fbHeight = height;
	this->window = nullptr;


	this->worldUp = glm::vec3(0.f, 100.f, 0.f);
	this->camFront = glm::vec3(0.f, 0.f, -1.f);
	this->camPosition = glm::vec3(1000.f, 1000.f, 1000.f);

	this->fov = 90.f;
	this->nearPlane = 0.1f;
	this->farPlane = 1000.f;
	
	this->dt = 0.f;
	this->curTime = 0.f;
	this->lastTime = 0.f;

	this->lastMouseX = 0.0;
	this->lastMouseY = 0.0;
	this->mouseX = 0.0;
	this->mouseY = 0.0;
	this->mouseOffSetX = 0.0;
	this->mouseOffSetY = 0.0;
	this->firstMouse = true;

	this->initGLFW();
	this->initWindow(title);
	this->initGLEW();
	this->initOpenGlOpt();

	this->initMatrices();
	this->initShaders();
	this->initTextures();
	this->initMaterials();
	this->initParticles();
	//this->initObjModels();
	this->initModels();
	this->initLights();
	this->initUniforms();
}

Game:: ~Game() {
	glfwDestroyWindow(this->window);
	glfwTerminate();

	for (size_t i = 0; i < this->shaders.size(); i++){
		delete this->shaders[i];
	}
	for (size_t i = 0; i < this->textures.size(); i++) {
		delete this->textures[i];
	}
	for (size_t i = 0; i < this->materials.size(); i++) {
		delete this->materials[i];
	}
	for (size_t i = 0; i < this->models.size(); i++) {
		delete this->models[i];
	}
	for (size_t i = 0; i < this->pointLights.size(); i++) {
		delete this->pointLights[i];
	}

}

int Game::getWindowShouldClose()
{
	return glfwWindowShouldClose(this->window);
}

void Game::setWindowShouldClose()
{
	glfwSetWindowShouldClose(this->window, GLFW_TRUE);
}

void Game::updateDt(){
	this->curTime = static_cast<float>(glfwGetTime());
	this->dt = this->curTime - this->lastTime;
	this->lastTime = this->curTime;
}

void Game::updateKeyInput() {
	if (glfwGetKey(this->window, GLFW_KEY_ESCAPE) == GLFW_PRESS) {
		this->setWindowShouldClose();
	}
	else if (glfwGetKey(this->window, GLFW_KEY_W) == GLFW_PRESS) {
		this->camera.move(this->dt, FORWARD);
	}
	else if (glfwGetKey(this->window, GLFW_KEY_S) == GLFW_PRESS) {
		this->camera.move(this->dt, BACK);
	}
	else if (glfwGetKey(this->window, GLFW_KEY_A) == GLFW_PRESS) {
		this->camera.move(this->dt, LEFT);
	}
	else if (glfwGetKey(this->window, GLFW_KEY_D) == GLFW_PRESS) {
		this->camera.move(this->dt, RIGHT);
	}
	/*else if (glfwGetKey(this->window, GLFW_KEY_C) == GLFW_PRESS) {
		this->camPosition.y -= 0.05f;
	}
	else if (glfwGetKey(this->window, GLFW_KEY_SPACE) == GLFW_PRESS) {
		this->camPosition.y += 0.05f;
	}*/  
}

void Game::updateMouseInput(){
	glfwGetCursorPos(this->window, &this->mouseX, &this->mouseY);

	if (this->firstMouse)
	{
		this->lastMouseX = this->mouseX;
		this->lastMouseY = this->mouseY;
		this->firstMouse = false;
	}

	this->mouseOffSetX = this->mouseX - this->lastMouseX;
	this->mouseOffSetY = this->lastMouseY - this->mouseY;

	this->lastMouseX = this->mouseX;
	this->lastMouseY = this->mouseY;

	this->pointLights[0]->setPosition(this->camera.getPosition());
}

void Game::update() {
	//update input
	glfwPollEvents();
	this->updateDt();
	this->updateKeyInput(); 
	this->updateMouseInput();
	this->camera.updateInput(dt, -1, this->mouseOffSetX, this->mouseOffSetY);
	
	//for (size_t i = 0; i < 20; i++)
	//{
	//	meshesPartSmoke[i]->move(smokeVel);
	//	meshesPartLava[i]->move(lavaVel);
	//}

	//this->models[1]->update(meshesPartLava);
	//this->models[2]->update(meshesPartLava);

	//this->models[0]->rotate(glm::vec3(0.f,1.f,0.f));
	//this->models[1]->rotate(glm::vec3(0.f,1.f,0.f));
	//this->models[2]->rotate(glm::vec3(0.f,1.f,0.f));

}

void Game::render() {

	//UPDATE
	//updateInput(window);

	//DRAW
		//Clrear
	glClearColor(0.f, 0.f, 0.f, 1.f);
	glClear(GL_COLOR_BUFFER_BIT | GL_DEPTH_BUFFER_BIT | GL_STENCIL_BUFFER_BIT);
	
	this->updateUniforms();

	for (size_t i = 0; i < this->models.size(); i++)
	{
		this->models[i]->render(this->shaders[SHADER_CORE_PROGRAM]);
	}


	//End draw
	glfwSwapBuffers(window);
	glFlush();

	glBindVertexArray(0);
	glUseProgram(0);
	glActiveTexture(0);
	glBindTexture(GL_TEXTURE_2D, 0);
}