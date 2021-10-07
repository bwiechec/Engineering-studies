#version 440

struct Material
{
	vec3 ambient;
	vec3 diffuse;
	vec3 specular;
	sampler2D diffuseTex;
	sampler2D specularTex;
};

struct PointLight{
	vec3 position;
	float intensity;
	vec3 color;
	float constant;
	float linear;
	float quadratic;
};

in vec3 vs_position;
in vec3 vs_color;
in vec2 vs_textcoord;
in vec3 vs_normal;

out vec4 fs_color;

uniform Material material;
uniform PointLight pointLight;
uniform vec3 lightPos0;
uniform vec3 camPosition;

//FUNCTIONS
vec3 calculateAmbient(Material material){
	return material.ambient;
}

vec3 calculateDiffuse(Material material, vec3 vs_position, vec3 lightPos0, vec3 vs_normal){
	vec3 posToLightDirVec = normalize(lightPos0 - vs_position);
	float diffuse = clamp(dot(posToLightDirVec, normalize(vs_normal)), 0, 1);
	vec3 diffuseLight = material.diffuse * diffuse;

	return diffuseLight;
}

vec3 calculateSpecular(Material material, vec3 lightPos0, vec3 vs_position, vec3 vs_normal, vec3 camPosition){
	vec3 lightToPosDirVec = normalize(vs_position - lightPos0);
	vec3 reflectDirVec = normalize(reflect(lightToPosDirVec, normalize(vs_normal)));
	vec3 posToViewDirVec = normalize(camPosition - vs_position);
	float specularConst = pow(max(dot(posToViewDirVec, reflectDirVec), 0), 30);
	vec3 specularLight = material.specular * specularConst * texture(material.specularTex, vs_textcoord).rgb;

	return specularLight;
}


void main(){
	//fs_color = vec4(vs_color, 1.f);
	//fs_color = texture(texture0, vs_textcoord) * texture(texture1, vs_textcoord) * vec4(vs_color, 1.f);
	
	//Ambient light
	vec3 ambientLight = calculateAmbient(material);

	//Diffuse light
	vec3 diffuseLight = calculateDiffuse(material, vs_position, pointLight.position, vs_normal);

	//Specular light
	vec3 specularLight = calculateSpecular(material, pointLight.position, vs_position, vs_normal, camPosition);


	//Attenuation
	float distance = length(pointLight.position - vs_position);
	//constant linear quadratic
	float atenuation = pointLight.constant / (1.f + pointLight.linear * distance + pointLight.quadratic * (distance * distance));

	//Final light 
	ambientLight *=atenuation;
	diffuseLight *= atenuation;
	specularLight *= atenuation;

	fs_color = texture(material.diffuseTex, vs_textcoord) * (vec4(ambientLight, 1.f) + vec4(diffuseLight, 1.f) + vec4(specularLight, 1.f));
}