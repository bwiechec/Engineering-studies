#pragma once

#include "Model.h"
#include "Texture.h"
#include "Shader.h"
#include "Material.h"
#include "ObjLoader.h"

class Model {
private:
	Material* material;
	Texture* textureDiffuse;
	Texture* textureSpecular;

	std::vector<Mesh*> meshes;
	glm::vec3 position;

	void updateUniforms() {

	}

public:
	Model(glm::vec3 position, Material* material, Texture* textureDiffuse, Texture* textureSpecular, std::vector<Mesh*> meshes) {
		this->position = position;
		this->material = material;
		this->textureDiffuse = textureDiffuse;
		this->textureSpecular = textureSpecular;

		for (auto*i : meshes){
			this->meshes.push_back(new Mesh(*i));
		}

		for (auto& i : this->meshes){
			i->move(this->position);
			i->setOrigin(this->position);
		}
	}
	//OBJ FILE MODEL
	Model(glm::vec3 position, Material* material, Texture* textureDiffuse, Texture* textureSpecular, const char* objFile) {
		this->position = position;
		this->material = material;
		this->textureDiffuse = textureDiffuse;
		this->textureSpecular = textureSpecular;

		std::vector<Vertex> mesh = loadObj(objFile);

		this->meshes.push_back(new Mesh(mesh.data(), mesh.size(), NULL, 0, glm::vec3(1.f, 0.f, 0.f),
			glm::vec3(0.f), glm::vec3(0.f), glm::vec3(1.f)));

		for (auto& i : this->meshes) {
			i->move(this->position);
			i->setOrigin(this->position);
		}
	}

	~Model(){
		for (auto*& i : this->meshes)
			delete i;
	}

	void rotate(const glm::vec3 rotation) {
		for (auto& i : this->meshes)
			i->rotate(rotation);
	}

	void update(std::vector<Mesh*> meshes) {
	}

	void render(Shader* shader) {
		this->updateUniforms();

		this->material->sendToShader(*shader);

		//Use a program
		shader->use();

		for (auto& i : this->meshes) {
		//Activate texture
			this->textureDiffuse->bind(0);
			this->textureSpecular->bind(1);

		//Draw
			i->render(shader);
		}
	}

};