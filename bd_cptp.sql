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
	email VARCHAR(100) NOT NULL,
	tipo ENUM('organizador','juradoPopular','juradoProfesional','establecimiento') NOT NULL
	
);

CREATE TABLE organizador(
	id_usuario VARCHAR(15) PRIMARY KEY NOT NULL,
	descripcionOrga VARCHAR(200) NULL,
	CONSTRAINT FK_usuario_organizador FOREIGN KEY  (id_usuario) REFERENCES usuario(id_usuario)

);

CREATE TABLE juradoPopular(
	id_usuario VARCHAR(15) PRIMARY KEY NOT NULL,
	residencia VARCHAR(100) NOT NULL,
	CONSTRAINT FK_usuario_juradoPopular FOREIGN KEY  (id_usuario) REFERENCES usuario(id_usuario)
);

CREATE TABLE juradoProfesional(
	id_usuario VARCHAR(15) PRIMARY KEY NOT NULL,
	profesion VARCHAR(30) NOT NULL,
	FK_organizador_jPro VARCHAR(15) NOT NULL,
	CONSTRAINT FK_usuario_juradoProfesional FOREIGN KEY  (id_usuario) REFERENCES usuario(id_usuario),
	CONSTRAINT FK_organizador_juradoProfesional FOREIGN KEY  (FK_organizador_jPro) REFERENCES organizador(id_usuario)
);

CREATE TABLE concurso(
	id_concurso VARCHAR(15) PRIMARY KEY NOT NULL,
	nombre VARCHAR(100) NOT NULL,
	localizacion VARCHAR(100) NOT NULL,
	descripcion VARCHAR(300) NULL,
	FK_organizador_conc VARCHAR(15) NOT NULL,
	CONSTRAINT FK_organizador_concurso FOREIGN KEY  (FK_organizador_conc) REFERENCES organizador(id_usuario)
);


CREATE TABLE establecimiento(
	id_usuario VARCHAR(15) PRIMARY KEY NOT NULL,
	localizacion VARCHAR(100) NOT NULL,
	descripcion VARCHAR(300) NOT NULL,
	CONSTRAINT FK_usuario_establecimiento FOREIGN KEY  (id_usuario) REFERENCES usuario(id_usuario)
);


CREATE TABLE pincho(
	id_pincho INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
	nombre VARCHAR(100) NOT NULL,
	descripcion VARCHAR(300) NOT NULL,
	celiaco BOOLEAN NOT NULL,
	validado BOOLEAN NOT NULL,
	num_votos INT,
	FK_concurso_pinc VARCHAR(15) NOT NULL,
	FK_establecimiento_pinc VARCHAR(15) NOT NULL,
	CONSTRAINT FK_establecimiento_pincho FOREIGN KEY  (FK_establecimiento_pinc) REFERENCES establecimiento(id_usuario),
	CONSTRAINT FK_concurso_pincho FOREIGN KEY  (FK_concurso_pinc) REFERENCES concurso(id_concurso)
);

CREATE TABLE premio(
	id_premio VARCHAR(10) PRIMARY KEY NOT NULL,
	tipo VARCHAR(100) NOT NULL
);

CREATE TABLE premiados(
	FK_pincho_prem INT NOT NULL,
	FK_premio_prem VARCHAR(10) NOT NULL,
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
	ronda INT NOT NULL,
	votacion INT,
	CONSTRAINT PK_vota_pro PRIMARY KEY (FK_juradoProfesional_vota,FK_pincho_vota, ronda),
	CONSTRAINT FK_juradoProfesional_vota_pro FOREIGN KEY  (FK_juradoProfesional_vota) REFERENCES juradoProfesional(id_usuario) ON DELETE CASCADE,
	CONSTRAINT FK_pincho_vota_pro FOREIGN KEY  (FK_pincho_vota) REFERENCES pincho(id_pincho)
);

CREATE TABLE asignar_jRegistrado(
	FK_juradoProfesional_asig VARCHAR(15) NOT NULL,
	FK_pincho_asig INT NOT NULL,
	FK_organizador_asig VARCHAR(15) NOT NULL,
	CONSTRAINT PK_asignar_jRegistrado PRIMARY KEY (FK_juradoProfesional_asig,FK_pincho_asig,FK_organizador_asig),
	CONSTRAINT FK_juradoProfesional_asignar FOREIGN KEY  (FK_juradoProfesional_asig) REFERENCES juradoProfesional(id_usuario) ON DELETE CASCADE,
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
    ingrediente VARCHAR(20) NOT NULL,
	PRIMARY KEY (FK_pincho_ing,ingrediente),
    CONSTRAINT FK_pincho_ing FOREIGN KEY  (FK_pincho_ing) REFERENCES pincho(id_pincho)
);

/*
-------------------------------------------------------------------------------------------
----------------------------------------- INSERTS -----------------------------------------
-------------------------------------------------------------------------------------------
*/
INSERT INTO `usuario` (`id_usuario`, `nombre`, `password`, `email`, `tipo`) VALUES
('manu', 'Manuel', 'manu', 'manu@manu.com', 'organizador'),
('isa', 'Isabel', 'isa', 'isa@isa.com', 'organizador'),
('miguel', 'Miguel', 'miguel', 'miguel@miguel.com', 'organizador'),
('borja', 'Borja', 'borja', 'borja@borja.com', 'organizador'),
('cesar', 'Cesar', 'cesar', 'cesar@cesar.com', 'organizador'),
('miriam', 'Miriam', 'miriam', 'miriam@miriam.com', 'juradoPopular'),
('cris', 'Cristina', 'cris', 'cris@cris.com', 'juradoPopular'),
('xeila', 'Xeila', 'xeila', 'xeila@xeila.com', 'juradoPopular'),
('abel', 'Abel', 'abel', 'abel@abel.com', 'juradoPopular'),
('dani', 'Daniel', 'dani', 'dani@dani.com', 'juradoPopular'),
('diego', 'Diego R.', 'diego', 'diego@diego.com', 'juradoProfesional'),
('lucia', 'Lucia D.', 'lucia', 'lucia@lucia.com', 'juradoProfesional'),
('alex', 'Alejandro M.', 'alex', 'alex@alex.com', 'juradoProfesional'),
('esteban', 'Esteban P.', 'esteban', 'esteban@esteban.com', 'juradoProfesional'),
('orcar', 'Oscar F.', 'orcar', 'orcar@orcar.com', 'juradoProfesional'),
('palleira', 'A Palleria', 'palleira', 'palleira@palleira.com', 'establecimiento'),
('adegaCaneda', 'Adega do Caneda', 'adegaCaneda', 'adegaCaneda@adegaCaneda.com', 'establecimiento'),
('soutoCadeas', 'O souto das cadeas', 'soutoCadeas', 'soutoCadeas@soutoCadeas.com', 'establecimiento'),
('tamega', 'Taperia Tamega', 'tamega', 'tamega@tamega.com', 'establecimiento'),
('lousa', 'A Lousa', 'lousa', 'lousa@lousa.com', 'establecimiento');


INSERT INTO `organizador` (`id_usuario`, `descripcionOrga`) VALUES
('manu', 'Jefe de organizador'),
('isa', 'organizador concurso'),
('miguel', 'organizador pinchos'),
('borja', 'organizador establecimientos'),
('cesar', 'relaciones publicas');

INSERT INTO `establecimiento` (`id_usuario`, `localizacion`, `descripcion`) VALUES
('palleira', 'A Veiga, 10', 'Cafe/Bar/Taperia, servimos bocadillos, hamburguesas y tapas'),
('adegaCaneda', 'Paseo del Tamega', 'Taperia con vistas al rio.'),
('soutoCadeas', 'Plaza Garcia Barbon', 'Taperia en el centro.'),
('tamega', 'Avd de Sousas N 83', 'Taperia, disponemos de menu del dia.'),
('lousa', 'Castelao 3', 'Churrasqueria, tapas y cocina gallega.');

INSERT INTO `juradopopular` (`id_usuario`, `residencia`) VALUES
('miriam', 'Ourense'),
('xeila', 'Verin'),
('abel', 'Ourense'),
('dani', 'Ourense'),
('cris', 'Ourense');

INSERT INTO `juradoprofesional` (`id_usuario`, `profesion`, `FK_organizador_jPro`) VALUES
('diego', 'cocinero', 'manu'),
('lucia', 'camarero', 'isa'),
('alex', 'dueño restaurante', 'miguel'),
('esteban', 'cocinero', 'borja'),
('orcar', 'camarero', 'cesar');

INSERT INTO `concurso` (`id_concurso`, `nombre`, `localizacion`, `descripcion`, `FK_organizador_conc`) VALUES
('pinchosOurense', 'Concurso de Pincho', 'Ourense', 'Concurso de pinchos de la ciudad de Ourense, vengan y disfruten de todos los sabores de la ciudad. Recorran los establecimientos, probando sus pinchos, votando por aquellos que mas le gusten. Sobretodo disfruten del buen comer.', 'manu');

INSERT INTO `pincho` (`id_pincho`, `nombre`, `descripcion`, `celiaco`, `validado`, `num_votos`, `FK_concurso_pinc`, `FK_establecimiento_pinc`) VALUES
('1', 'cappuccino de castaña', 'pincho de otoño, una manera diferente de tomar la castaña', 0, 1, 1, 'pinchosOurense', 'palleira'),
('2', 'tosta de lomo con queso', 'tosta de lomo de cerdo con queso de Arzua', 0, 0, 0, 'pinchosOurense', 'adegaCaneda'),
('3', 'chipirones con verduras', 'chipirones a la plancha con verduras cortadas muy pequeño', 0, 0, 0, 'pinchosOurense', 'soutoCadeas'),
('4', 'tosta de hamburguesa', 'tosta de mini hamburquesa de ternera con queso de tetilla', 0, 1, 0, 'pinchosOurense', 'tamega'),
('5', 'pulpo', 'pulpo cocino con pimentos, dulce o picante', 0, 0, 0, 'pinchosOurense', 'lousa');

INSERT INTO `asignar_jregistrado` (`FK_juradoProfesional_asig`, `FK_pincho_asig`, `FK_organizador_asig`) VALUES
('diego', 1, 'manu'),
('orcar', 1, 'manu'),
('diego', 4, 'manu'),
('lucia', 4, 'manu');

INSERT INTO `codigo` (`FK_establecimiento_cod`, `id_codigo`, `usado`) VALUES
('palleira', 1, 1),
('palleira', 2, 1),
('palleira', 3, 0),
('palleira', 4, 0),
('palleira', 5, 0),
('palleira', 6, 0),
('palleira', 7, 0),
('palleira', 8, 0),
('palleira', 9, 0),
('palleira', 10, 0),
('palleira', 11, 0),
('palleira', 12, 0),
('palleira', 13, 0),
('palleira', 14, 0),
('palleira', 15, 0),
('palleira', 16, 0),
('palleira', 17, 0),
('palleira', 18, 0),
('palleira', 19, 0),
('palleira', 20, 0),
('palleira', 21, 0),
('palleira', 22, 0),
('palleira', 23, 0),
('palleira', 24, 0),
('palleira', 25, 0),
('palleira', 26, 0),
('palleira', 27, 0),
('palleira', 28, 0),
('palleira', 29, 0),
('palleira', 30, 0),
('palleira', 31, 0),
('palleira', 32, 0),
('palleira', 33, 0),
('palleira', 34, 0),
('palleira', 35, 0),
('palleira', 36, 0),
('palleira', 37, 0),
('palleira', 38, 0),
('palleira', 39, 0),
('palleira', 40, 0),
('palleira', 41, 0),
('palleira', 42, 0),
('palleira', 43, 0),
('palleira', 44, 0),
('palleira', 45, 0),
('palleira', 46, 0),
('palleira', 47, 0),
('palleira', 48, 0),
('palleira', 49, 0),
('palleira', 50, 0),
('palleira', 51, 0),
('palleira', 52, 0),
('palleira', 53, 0),
('palleira', 54, 0),
('palleira', 55, 0),
('palleira', 56, 0),
('palleira', 57, 0),
('palleira', 58, 0),
('palleira', 59, 0),
('palleira', 60, 0),
('palleira', 61, 0),
('palleira', 62, 0),
('palleira', 63, 0),
('palleira', 64, 0),
('palleira', 65, 0),
('palleira', 66, 0),
('palleira', 67, 0),
('palleira', 68, 0),
('palleira', 69, 0),
('palleira', 70, 0),
('palleira', 71, 0),
('palleira', 72, 0),
('palleira', 73, 0),
('palleira', 74, 0),
('palleira', 75, 0),
('palleira', 76, 0),
('palleira', 77, 0),
('palleira', 78, 0),
('palleira', 79, 0),
('palleira', 80, 0),
('palleira', 81, 0),
('palleira', 82, 0),
('palleira', 83, 0),
('palleira', 84, 0),
('palleira', 85, 0),
('palleira', 86, 0),
('palleira', 87, 0),
('palleira', 88, 0),
('palleira', 89, 0),
('palleira', 90, 0),
('palleira', 91, 0),
('palleira', 92, 0),
('palleira', 93, 0),
('palleira', 94, 0),
('palleira', 95, 0),
('palleira', 96, 0),
('palleira', 97, 0),
('palleira', 98, 0),
('palleira', 99, 0),
('palleira', 100, 0),
('tamega', 101, 0),
('tamega', 102, 0),
('tamega', 103, 0),
('tamega', 104, 0),
('tamega', 105, 0),
('tamega', 106, 0),
('tamega', 107, 0),
('tamega', 108, 0),
('tamega', 109, 0),
('tamega', 110, 0),
('tamega', 111, 0),
('tamega', 112, 0),
('tamega', 113, 0),
('tamega', 114, 0),
('tamega', 115, 1),
('tamega', 116, 0),
('tamega', 117, 0),
('tamega', 118, 0),
('tamega', 119, 0),
('tamega', 120, 0),
('tamega', 121, 0),
('tamega', 122, 0),
('tamega', 123, 0),
('tamega', 124, 0),
('tamega', 125, 0),
('tamega', 126, 0),
('tamega', 127, 0),
('tamega', 128, 0),
('tamega', 129, 0),
('tamega', 130, 0),
('tamega', 131, 0),
('tamega', 132, 0),
('tamega', 133, 0),
('tamega', 134, 0),
('tamega', 135, 0),
('tamega', 136, 0),
('tamega', 137, 0),
('tamega', 138, 0),
('tamega', 139, 0),
('tamega', 140, 0),
('tamega', 141, 0),
('tamega', 142, 0),
('tamega', 143, 0),
('tamega', 144, 0),
('tamega', 145, 0),
('tamega', 146, 0),
('tamega', 147, 0),
('tamega', 148, 0),
('tamega', 149, 0),
('tamega', 150, 0),
('tamega', 151, 0),
('tamega', 152, 0),
('tamega', 153, 0),
('tamega', 154, 0),
('tamega', 155, 0),
('tamega', 156, 0),
('tamega', 157, 0),
('tamega', 158, 0),
('tamega', 159, 0),
('tamega', 160, 0),
('tamega', 161, 0),
('tamega', 162, 0),
('tamega', 163, 0),
('tamega', 164, 0),
('tamega', 165, 0),
('tamega', 166, 0),
('tamega', 167, 0),
('tamega', 168, 0),
('tamega', 169, 0),
('tamega', 170, 0),
('tamega', 171, 0),
('tamega', 172, 0),
('tamega', 173, 0),
('tamega', 174, 0),
('tamega', 175, 0),
('tamega', 176, 0),
('tamega', 177, 0),
('tamega', 178, 0),
('tamega', 179, 0),
('tamega', 180, 0),
('tamega', 181, 0),
('tamega', 182, 0),
('tamega', 183, 0),
('tamega', 184, 0),
('tamega', 185, 0),
('tamega', 186, 0),
('tamega', 187, 0),
('tamega', 188, 0),
('tamega', 189, 0),
('tamega', 190, 0),
('tamega', 191, 0),
('tamega', 192, 0),
('tamega', 193, 0),
('tamega', 194, 0),
('tamega', 195, 0),
('tamega', 196, 0),
('tamega', 197, 0),
('tamega', 198, 0),
('tamega', 199, 0),
('tamega', 200, 0);

INSERT INTO `vota_pop` (`FK_juradoPopular_vot`, `FK_cod`) VALUES
('xeila', 1);
