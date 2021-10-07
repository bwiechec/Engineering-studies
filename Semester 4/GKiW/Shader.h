#pragma once

#include<iostream>
#include<fstream>
#include<string>

#include<glew.h>
#include<glfw3.h>

#include<glm.hpp>
#include<vec2.hpp>
#include<vec3.hpp>
#include<vec4.hpp>
#include<mat4x4.hpp>
#include<gtc\matrix_transform.hpp>
#include<gtc\type_ptr.hpp>

class Shader {
private:
	GLuint id;
	int verMajor = 4;
	int verMinor = 4;

	std::string loadShaderSrc(char* fileName) {

		std::string temp = "";
		std::string src = "";

		std::fstream inFile;

		//VERTEX
		inFile.open(fileName);

		if (inFile.is_open()) {
			while (std::getline(inFile, temp)) {
				src += temp + "\n";
			}
		}
		else {
			std::cout << "ERROR::SHADER::NOT_OPEN_FILE_:"<<fileName<<"\n";
		}

		inFile.close();

		return src;
	}

	GLuint loadShader(GLenum type, char* filename) {

		char infolog[512];
		GLint success;

		GLuint shader = glCreateShader(type);
		std::string strSrc = this->loadShaderSrc(filename);
		const GLchar* src = strSrc.c_str();
		glShaderSource(shader, 1, &src, NULL);
		glCompileShader(shader);

		glGetShaderiv(shader, GL_COMPILE_STATUS, &success);
		if (!success) {
			glGetShaderInfoLog(shader, 512, NULL, infolog);
			std::cout << "ERROR::SHADER::COMPILE_ERROR_SHADER "<<filename<<"\n";
			std::cout << infolog << "\n";
		}

		return shader;
	}

	void linkProgram(GLuint vertexShader, GLuint geometryShader, GLuint fragmentShader) {

		char infolog[512];
		GLint success;

		this->id = glCreateProgram();

		glAttachShader(this->id, vertexShader);

		glAttachShader(this->id, fragmentShader);

		if (geometryShader) {
			glAttachShader(this->id, geometryShader);
		}

		glLinkProgram(this->id);

		glGetProgramiv(this->id, GL_LINK_STATUS, &success);

		if (!success) {
			glGetProgramInfoLog(this->id, 512, NULL, infolog);
			std::cout << "ERROR::SHADER::COMPILE_ERROR_PROGRAM\n";
			std::cout << infolog << "\n";
		}

		glUseProgram(0);

	}

public:

	//Constructor/Destructor
	Shader(char* vertexFile, char* fragmentFile, char* geometryFile = "") {
		GLuint vertexShader = 0;
		GLuint geometryShader = 0;
		GLuint fragmentShader = 0;

		vertexShader = loadShader(GL_VERTEX_SHADER, vertexFile);

		if (geometryFile != "") geometryShader = loadShader(GL_GEOMETRY_SHADER, geometryFile);

		fragmentShader = loadShader(GL_FRAGMENT_SHADER, fragmentFile);

		this->linkProgram(vertexShader, geometryShader, fragmentShader);

		//END
		glDeleteShader(vertexShader);
		glDeleteShader(geometryShader);
		glDeleteShader(fragmentShader);

	}

	~Shader() {
		glDeleteProgram(this->id);
	}

	//Set uniform funct
	void use() {
		glUseProgram(this->id);
	}

	void unuse() {
		glUseProgram(0);
	}

	void setTexture(GLint value, const GLchar* name){

		this->use();

		glUniform1i(glGetUniformLocation(this->id, name), value);

		this->unuse();
	}

	void set1f(GLfloat value, const GLchar* name) {
		this->use();

		glUniform1f(glGetUniformLocation(this->id, name), value);

		this->unuse();
	}

	void setVec2f(glm::fvec2 value, const GLchar* name) {
		this->use();

		glUniform2fv(glGetUniformLocation(this->id, name), 1, glm::value_ptr(value));

		this->unuse();
	}

	void setVec3f(glm::fvec3 value, const GLchar* name) {
		this->use();

		glUniform3fv(glGetUniformLocation(this->id, name), 1, glm::value_ptr(value));

		this->unuse();
	}

	void setVec4f(glm::fvec4 value, const GLchar* name) {
		this->use();

		glUniform4fv(glGetUniformLocation(this->id, name), 1, glm::value_ptr(value));

		this->unuse();
	}

	void setMat3fv(glm::mat3 value, const GLchar* name, GLboolean transpose = GL_FALSE) {
		this->use();

		glUniformMatrix3fv(glGetUniformLocation(this->id, name), 1, transpose, glm::value_ptr(value));

		this->unuse();
	}

	void setMat4fv(glm::mat4 value, const GLchar* name, GLboolean transpose = GL_FALSE) {
		this->use();

		glUniformMatrix4fv(glGetUniformLocation(this->id, name), 1, transpose, glm::value_ptr(value));

		this->unuse();
	}

};