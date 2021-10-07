#pragma once

#include "libs.h"

//ENUMS
enum shaderEnum {SHADER_CORE_PROGRAM = 0, SHADER_PARTICLE};
enum textureEnum{TEX_GRAVEL, TEX_GRAVEL_SPECULAR, TEX_WUL, TEX_WUL_SPECULAR, TEX_PART_DYM, TEX_PART_LAWA};
enum materialEnum{MATERIAL_1};
enum meshEnum{MESH_QUAD = 0};


class Game {
private:
	GLFWwindow* window;
	const int windowWidth;
	const int windowHeight;
	int fbWidth;
	int fbHeight;

	const int GLVerMajor;
	const int GLVerMinor;

	float dt;
	float curTime;
	float lastTime;

	double lastMouseX;
	double lastMouseY;
	double mouseX;
	double mouseY;
	double mouseOffSetX;
	double mouseOffSetY;
	bool firstMouse;

	glm::vec3 camPosition;
	glm::vec3 worldUp;
	glm::vec3 camFront;
	glm::mat4 viewMatrix;
	glm::mat4 projectionMatrix;
	float fov;
	float nearPlane;
	float farPlane;

	std::vector<Shader*> shaders;

	std::vector<Texture*> textures;

	std::vector<Material*> materials;

	std::vector<Model*> models;

	std::vector<PointLight*> pointLights;


	Camera camera;

	void initGLFW();
	void initWindow(const char* title);
	void initGLEW();
	void initOpenGlOpt();
	void initMatrices();
	void initShaders();
	void initTextures();
	void initMaterials();
	void initObjModels();
	void initModels();
	void initPointLights();
	void initLights();
	void initUniforms();
	void updateUniforms();
	void initParticles(); 

public:
	Game(const char* title, const int width, const int height, int GLmajorVer, int GLminorVer);
	virtual ~Game();

	int getWindowShouldClose();

	void setWindowShouldClose();

	void updateDt();
	void updateKeyInput();
	void updateMouseInput();

	void update();
	void render();

};