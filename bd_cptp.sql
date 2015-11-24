drop database if exists cptp;
create database cptp default character set utf8 default collate utf8_spanish_ci;
grant usage on *.* to 'usercptp'@'localhost';
drop user 'usercptp'@'localhost';
create user 'usercptp'@'localhost' identified by 'usercptp';
grant all on cptp.* to 'usercptp'@'localhost';

use cptp;

CREATE TABLE usuario(
	id_usuario VARCHAR(15) PRIMARY KEY NOT NULL,
	nombre VARCHAR(100) NOT NULL,
	password CHAR(32) NOT NULL,
	email VARCHAR(15) NOT NULL,
	tipo ENUM('organizador','juradoPopular','juradoProfesional','establecimiento') NOT NULL
	
);

CREATE TABLE organizador(
	id_usuario VARCHAR(15) PRIMARY KEY NOT NULL,
	descripcionOrga VARCHAR(140) NULL,
	CONSTRAINT FK_usuario_organizador FOREIGN KEY  (id_usuario) REFERENCES usuario(id_usuario)

);

CREATE TABLE juradoPopular(
	id_usuario VARCHAR(15) PRIMARY KEY NOT NULL,
	residencia VARCHAR(15) NOT NULL,
	CONSTRAINT FK_usuario_juradoPopular FOREIGN KEY  (id_usuario) REFERENCES usuario(id_usuario)
);

CREATE TABLE juradoProfesional(
	id_usuario VARCHAR(15) PRIMARY KEY NOT NULL,
	profesion VARCHAR(15) NOT NULL,
	FK_organizador_jPro VARCHAR(15) NOT NULL,
	CONSTRAINT FK_usuario_juradoProfesional FOREIGN KEY  (id_usuario) REFERENCES usuario(id_usuario),
	CONSTRAINT FK_organizador_juradoProfesional FOREIGN KEY  (FK_organizador_jPro) REFERENCES organizador(id_usuario)
);

CREATE TABLE concurso(
	id_concurso VARCHAR(15) PRIMARY KEY NOT NULL,
	nombre VARCHAR(15) NOT NULL,
	localizacion VARCHAR(30) NOT NULL,
	descripcion VARCHAR(200) NULL,
	FK_organizador_conc VARCHAR(15) NOT NULL,
	CONSTRAINT FK_organizador_concurso FOREIGN KEY  (FK_organizador_conc) REFERENCES organizador(id_usuario)
);


CREATE TABLE establecimiento(
	id_usuario VARCHAR(15) PRIMARY KEY NOT NULL,
	localizacion VARCHAR(30) NOT NULL,
	descripcion VARCHAR(140) NOT NULL,
	CONSTRAINT FK_usuario_establecimiento FOREIGN KEY  (id_usuario) REFERENCES usuario(id_usuario)
);


CREATE TABLE pincho(
	id_pincho INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
	nombre VARCHAR(15) NOT NULL,
	descripcion VARCHAR(100) NOT NULL,
	celiaco BOOLEAN NOT NULL,
	validado BOOLEAN NOT NULL,
	num_votos INT,
	FK_organizador_pinc VARCHAR(15) NOT NULL,
	FK_concurso_pinc VARCHAR(15) NOT NULL,
	FK_establecimiento_pinc VARCHAR(15) NOT NULL,
	CONSTRAINT FK_establecimiento_pincho FOREIGN KEY  (FK_establecimiento_pinc) REFERENCES establecimiento(id_usuario),
	CONSTRAINT FK_organizador_pincho FOREIGN KEY  (FK_organizador_pinc) REFERENCES organizador(id_usuario),
	CONSTRAINT FK_concurso_pincho FOREIGN KEY  (FK_concurso_pinc) REFERENCES concurso(id_concurso)
);

CREATE TABLE premio(
	id_premio VARCHAR(10) PRIMARY KEY NOT NULL,
	tipo VARCHAR(15) NOT NULL
);

CREATE TABLE premiados(
	FK_pincho_prem VARCHAR(15) NOT NULL,
	FK_premio_prem INT NOT NULL,
	posicion VARCHAR(15) NOT NULL,
	CONSTRAINT PK_premiados PRIMARY KEY (FK_pincho_prem,FK_premio_prem),
	CONSTRAINT FK_pincho_premiados FOREIGN KEY  (FK_pincho_prem) REFERENCES pincho(id_pincho),
	CONSTRAINT FK_premio_premiados FOREIGN KEY  (FK_premio_prem) REFERENCES premio(id_premio)
);


CREATE TABLE codigo(
	FK_establecimiento_cod VARCHAR(15) NOT NULL,
	id_codigo INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	usado BOOLEAN NOT NULL,
	CONSTRAINT FK_establecimiento_codigo FOREIGN KEY  (FK_establecimiento_cod) REFERENCES establecimiento(id_usuario)
);



CREATE TABLE vota_pro(
	FK_juradoProfesional_vota VARCHAR(15) NOT NULL,
	FK_pincho_vota INT NOT NULL,
	votacion INT,
	ronda VARCHAR(10) NOT NULL,
	CONSTRAINT PK_vota_pro PRIMARY KEY (FK_juradoProfesional_vota,FK_pincho_vota),
	CONSTRAINT FK_juradoProfesional_vota_pro FOREIGN KEY  (FK_juradoProfesional_vota) REFERENCES juradoProfesional(id_usuario),
	CONSTRAINT FK_pincho_vota_pro FOREIGN KEY  (FK_pincho_vota) REFERENCES pincho(id_pincho)
);

CREATE TABLE asignar_jRegistrado(
	FK_juradoProfesional_asig VARCHAR(15) NOT NULL,
	FK_pincho_asig INT NOT NULL,
	FK_organizador_asig VARCHAR(15) NOT NULL,
	CONSTRAINT PK_asignar_jRegistrado PRIMARY KEY (FK_juradoProfesional_asig,FK_pincho_asig,FK_organizador_asig),
	CONSTRAINT FK_juradoProfesional_asignar FOREIGN KEY  (FK_juradoProfesional_asig) REFERENCES juradoProfesional(id_usuario),
	CONSTRAINT FK_pincho_asignar FOREIGN KEY  (FK_pincho_asig) REFERENCES pincho(id_pincho),
	CONSTRAINT FK_organizador_asignar FOREIGN KEY  (FK_organizador_asig) REFERENCES organizador(id_usuario)
);

CREATE TABLE vota_pop(
	FK_juradoPopular_vot VARCHAR(15) NOT NULL,
	FK_cod INT NOT NULL,
	CONSTRAINT PK_vota_pop PRIMARY KEY (FK_juradoPopular_vot,FK_cod),
	CONSTRAINT FK_codigo FOREIGN KEY  (FK_cod) REFERENCES codigo(id_codigo),
	CONSTRAINT FK_juradoPopular_vota_pop FOREIGN KEY  (FK_juradoPopular_vot) REFERENCES juradoPopular(id_usuario)
);

CREATE TABLE ingrediente(
    FK_pincho_ing INT NOT NULL,
    ingrediente VARCHAR(15) NOT NULL,
	PRIMARY KEY (FK_pincho_ing,ingrediente),
    CONSTRAINT FK_pincho_ing FOREIGN KEY  (FK_pincho_ing) REFERENCES pincho(id_pincho)
);