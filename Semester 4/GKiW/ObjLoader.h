#pragma once

#include <iostream>
#include <string>
#include <fstream>
#include <vector>
#include <sstream>
#include <algorithm>

#include <glew.h>

#include <glfw3.h>

#include <glm.hpp>
#include <vec3.hpp>
#include <vec4.hpp>
#include <mat4x4.hpp>
#include <gtc/matrix_transform.hpp>
#include <gtc/type_ptr.hpp>

#include "Vertex.h"

static std::vector<Vertex> loadObj(const char* filename) {
	//Vertex vectors
	std::vector<glm::fvec3> vertexPosition;
	std::vector<glm::fvec2> vertexTexcoord;
	std::vector<glm::fvec3> vertexNormal;

	//Face vectors
	std::vector<GLint> vertexPositionIndices;
	std::vector<GLint> vertexTexcoordIndices;
	std::vector<GLint> vertexNormalIndices;

	//Vertex array
	std::vector<Vertex> vertices;

	std::stringstream ss;
	std::ifstream inFile(filename);
	std::string line = "";
	std::string prefix = "";
	glm::vec3 tempVec3;
	glm::vec2 tempVec2;
	GLuint tempGlint = 0;

	if (!inFile.is_open()) {
		std::cout << "ERROR::OBJLOADER::COULD_NOT_OPEN_FILE\n";
	}
	else {
		while (std::getline(inFile, line)) {
			ss.clear();
			ss.str(line);
			ss >> prefix;

			if (prefix =="#") {
				//ignore
			}
			else if (prefix == "o") {
				//ignore
			}
			else if (prefix == "s") {
				//ignore
			}
			else if (prefix == "use_ntl") {
				//ignore
			}
			else if (prefix == "v") { //vertex pos
				ss >> tempVec3.x >> tempVec3.y >> tempVec3.z;
				vertexPosition.push_back(tempVec3);
			}
			else if (prefix == "vn") { //vertex normals
				ss >> tempVec3.x >> tempVec3.y >> tempVec3.z;
				vertexNormal.push_back(tempVec3);
			}
			else if (prefix == "vt") { //vertex texcoords
				ss >> tempVec2.x >> tempVec2.y;
				vertexTexcoord.push_back(tempVec2);
			}
			else if (prefix == "f") { //
				int counter = 0;
				while (ss >> tempGlint) {
					if (counter == 0)
						vertexPositionIndices.push_back(tempGlint);
					else if (counter == 1)
						vertexTexcoordIndices.push_back(tempGlint);
					else if (counter == 2)
						vertexNormalIndices.push_back(tempGlint);

					if (ss.peek() == '/') {
						++counter;
						ss.ignore(1, '/');
					}
					else if (ss.peek() == ' ') {
						++counter;
						ss.ignore(1, ' ');
					}

					if (counter > 2) counter = 0;
				}
			}
			else {

			}


			//debug
			//std::cout << line << "\n";
			//std::cout << "nr of vertices" << vertexPosition.size() << "\n";

		
			
		}
	}


	//final vertex array
	vertices.resize(vertexPositionIndices.size(), Vertex());

	//load in indices
	for (size_t i = 0; i < vertices.size(); i++)
	{
		vertices[i].position = vertexPosition[vertexPositionIndices[i]-1];
		vertices[i].texcoord = vertexTexcoord[vertexTexcoordIndices[i]-1];
		vertices[i].normal = vertexNormal[vertexNormalIndices[i]-1];
		vertices[i].color = glm::vec3(1.f, 1.f, 1.f);
	}

	//Loaded success
	return vertices;
}