drop database if exists G33cptp;
create database G33cptp default character set utf8 default collate utf8_spanish_ci;
grant usage on *.* to 'G33usercptp'@'localhost';
drop user 'G33usercptp'@'localhost';
create user 'G33usercptp'@'localhost' identified by 'G33usercptp';
grant all on G33cptp.* to 'G33usercptp'@'localhost';

use G33cptp;

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
	imagen VARCHAR(111) NOT NULL,
	FK_concurso_pinc VARCHAR(15) NOT NULL,
	FK_establecimiento_pinc VARCHAR(15) NOT NULL,
	CONSTRAINT FK_establecimiento_pincho FOREIGN KEY  (FK_establecimiento_pinc) REFERENCES establecimiento(id_usuario),
	CONSTRAINT FK_concurso_pincho FOREIGN KEY  (FK_concurso_pinc) REFERENCES concurso(id_concurso)
);

CREATE TABLE premio(
	id_premio VARCHAR(10) PRIMARY KEY NOT NULL,
	tipo ENUM('popular','profesional') NOT NULL
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
	CONSTRAINT PK_vota_pro PRIMARY KEY (FK_juradoProfesional_vota,FK_pincho_vota,ronda),
	CONSTRAINT FK_juradoProfesional_vota_pro FOREIGN KEY  (FK_juradoProfesional_vota) REFERENCES juradoProfesional(id_usuario) ON DELETE CASCADE,
	CONSTRAINT FK_pincho_vota_pro FOREIGN KEY  (FK_pincho_vota) REFERENCES pincho(id_pincho)
);

CREATE TABLE vota_pop(
	FK_juradoPopular_vot VARCHAR(15) NOT NULL,
	FK_cod INT NOT NULL,
	CONSTRAINT PK_vota_pop PRIMARY KEY (FK_juradoPopular_vot,FK_cod),
	CONSTRAINT FK_codigo FOREIGN KEY  (FK_cod) REFERENCES codigo(id_codigo),
	CONSTRAINT FK_juradoPopular_vota_pop FOREIGN KEY  (FK_juradoPopular_vot) REFERENCES juradoPopular(id_usuario)
);

CREATE TABLE comentarios(
	FK_juradoPopular_vot VARCHAR(15) NOT NULL,
	FK_cod INT NOT NULL,
	comentario VARCHAR(300),
	CONSTRAINT PK_pinchosProbados PRIMARY KEY (FK_juradoPopular_vot,FK_cod),
	CONSTRAINT FK_pincho_probado FOREIGN KEY  (FK_cod) REFERENCES pincho(id_pincho),
	CONSTRAINT FK_juradoPopular_Probado FOREIGN KEY  (FK_juradoPopular_vot) REFERENCES juradoPopular(id_usuario)
);

CREATE TABLE ingrediente(
    FK_pincho_ing INT NOT NULL,
    ingrediente VARCHAR(20) NOT NULL,
	PRIMARY KEY (FK_pincho_ing,ingrediente),
    CONSTRAINT FK_pincho_ing FOREIGN KEY  (FK_pincho_ing) REFERENCES pincho(id_pincho) ON DELETE CASCADE
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
('paquito86', 'Paco', 'paquito86', 'paquito86@hotmail.com', 'organizador'),
('blanquita_7', 'blanca', 'blanquita_7', 'bianca7@gmail.com', 'organizador'),
('pepiño', 'Pepe', 'pepiño', 'pepiño77@gmail.com', 'organizador'),
('manolito22', 'Manolo', 'manolito22', 'manolito22@gmail.com', 'organizador'),
('miriam', 'Miriam', 'miriam', 'miriam@miriam.com', 'juradoPopular'),
('cris', 'Cristina', 'cris', 'cris@cris.com', 'juradoPopular'),
('xeila', 'Xeila', 'xeila', 'xeila@xeila.com', 'juradoPopular'),
('abel', 'Abel', 'abel', 'abel@abel.com', 'juradoPopular'),
('dani', 'Daniel', 'dani', 'dani@dani.com', 'juradoPopular'),
('pacaLoca', 'Francisca', 'pacaLoca', 'pacaLoca@gmail.com', 'juradoPopular'),
('martaf_94', 'Marta', 'martaf_94', 'martaf_94@gmail.com', 'juradoPopular'),
('lucia_13', 'Lucia', 'lucia_13', 'lucia_13@gmail.com', 'juradoPopular'),
('andreatp', 'Andrea', 'andreatp', 'andreatp@gmail.com', 'juradoPopular'),
('mayas17', 'Carla', 'mayas17', 'mayas17@gmail.com', 'juradoPopular'),
('marioMars', 'Mario', 'marioMars', 'marioMars@gmail.com', 'juradoPopular'),
('sCameron12', 'Pablo', 'sCameron12', 'sCameron12@gmail.com', 'juradoPopular'),
('iluminati22', 'Javier', 'iluminati22', 'iluminati22@gmail.com', 'juradoPopular'),
('mauricioMacri', 'Manuel', 'mauricioMacri', 'mauricioMacri@gmail.com', 'juradoPopular'),
('homerSimpson66', 'Jorge', 'homerSimpson66', 'homerSimpson66@gmail.com', 'juradoPopular'),
('violeta88', 'Violeta', 'violeta88', 'violeta88@gmail.com', 'juradoPopular'),
('paraSito', 'Carlos', 'paraSito', 'paraSito@gmail.com', 'juradoPopular'),
('marcForbes', 'Marcos', 'marcForbes', 'marcForbes@gmail.com', 'juradoPopular'),
('coquincha3', 'Concha', 'coquincha3', 'coquincha3@gmail.com', 'juradoPopular'),
('ameliaWebber', 'Amelia', 'ameliaWebber', 'ameliaWebber@gmail.com', 'juradoPopular'),
('caraculeta_86', 'Jaime', 'caraculeta_86', 'caraculeta_86@gmail.com', 'juradoPopular'),
('ash27', 'Pedro', 'ash27', 'ash27@gmail.com', 'juradoPopular'),
('florDeLis', 'Paula', 'florDeLis', 'florDeLis@gmail.com', 'juradoPopular'),
('azufreAmarillo', 'Mariano', 'azufreAmarillo', 'azufreAmarillo@gmail.com', 'juradoPopular'),
('marcoscorron', 'Marcos', 'marcoscorron', 'marcoscorron@gmail.com', 'juradoPopular'),
('diego', 'Diego R.', 'diego', 'diego@diego.com', 'juradoProfesional'),
('lucia', 'Lucia D.', 'lucia', 'lucia@lucia.com', 'juradoProfesional'),
('alex', 'Alejandro M.', 'alex', 'alex@alex.com', 'juradoProfesional'),
('esteban', 'Esteban P.', 'esteban', 'esteban@esteban.com', 'juradoProfesional'),
('oscar', 'Oscar F.', 'oscar', 'oscar@orcar.com', 'juradoProfesional'),
('señoritaPerez', 'Aldara', 'señoritaPerez', 'señoritaPerez@gmail.com', 'juradoProfesional'),
('ana_45', 'Ana', 'ana_45', 'ana_45@gmail.com', 'juradoProfesional'),
('lopezSanchez317', 'Victor', 'lopezSanchez317', 'lopezSanchez317@gmail.com', 'juradoProfesional'),
('aliciajs', 'Alicia', 'aliciajs', 'aliciajs@gmail.com', 'juradoProfesional'),
('adrianef', 'Adrian', 'adrianef', 'adrianef@gmail.com', 'juradoProfesional'),
('dafne963', 'Dafne', 'dafne963', 'dafne963@gmail.com', 'juradoProfesional'),
('borja35', 'Borja', 'borja35', 'borja35@gmail.com', 'juradoProfesional'),
('ffsantos', 'Fabio', 'ffsantos', 'ffsantos@gmail.com', 'juradoProfesional'),
('sonia_23', 'Sonia', 'sonia_23', 'sonia_23@gmail.com', 'juradoProfesional'),
('tfsantos', 'Tamara', 'tfsantos', 'tfsantos@gmail.com', 'juradoProfesional'),
('carlos_ou', 'Carlos', 'carlos_ou', 'carlos_ou@gmail.com', 'juradoProfesional'),
('jfvalencia', 'Jacobo', 'jfvalencia', 'jfvalencia@gmail.com', 'juradoProfesional'),
('carla83', 'Carla', 'carla83', 'carla83@gmail.com', 'juradoProfesional'),
('beliguntum', 'Belinda', 'beliguntum', 'beliguntum@gmail.com', 'juradoProfesional'),
('carpab', 'Tania', 'carpab', 'carpab@gmail.com', 'juradoProfesional'),
('luzSanz74', 'Luz', 'luzSanz74', 'luzSanz74@gmail.com', 'juradoProfesional'),
('rrbeca', 'Rebeca', 'rrbeca', 'rrbeca@gmail.com', 'juradoProfesional'),
('marcosjf', 'Marcos', 'marcosjf', 'marcosjf@gmail.com', 'juradoProfesional'),
('aranchaJ', 'Arancha', 'aranchaJ', 'aranchaJ@gmail.com', 'juradoProfesional'),
('ssvazquez', 'Sara', 'ssvazquez', 'ssvazquez@gmail.com', 'juradoProfesional'),
('palleira', 'A Palleria', 'palleira', 'palleira@palleira.com', 'establecimiento'),
('adegaCaneda', 'Adega do Caneda', 'adegaCaneda', 'adegaCaneda@adegaCaneda.com', 'establecimiento'),
('soutoCadeas', 'O souto das cadeas', 'soutoCadeas', 'soutoCadeas@soutoCadeas.com', 'establecimiento'),
('tamega', 'Taperia Tamega', 'tamega', 'tamega@tamega.com', 'establecimiento'),
('lousa', 'A Lousa', 'lousa', 'lousa@lousa.com', 'establecimiento'),
('cafeCosta', 'Cafe costa', 'cafeCosta', 'cafeCosta@gmail.com', 'establecimiento'),
('cafeRubi', 'Cafe rubi', 'cafeRubi', 'cafeRubi@gmail.com', 'establecimiento'),
('BeerParaCreer', 'Beer para creer', 'BeerParaCreer', 'BeerParaCreer@gmail.com', 'establecimiento'),
('cafeDulce', 'Cafe dulce', 'cafeDulce', 'cafeDulce@gmail.com', 'establecimiento'),
('laCantina36', 'La cantina', 'laCantina36', 'laCantina36@gmail.com', 'establecimiento'),
('ElPaso10', 'El paso', 'ElPaso10', 'ElPaso10@gmail.com', 'establecimiento'),
('barMou', 'Bar de Mou', 'barMou', 'barDeMou@gmail.com', 'establecimiento'),
('elChiringuito85', 'El chiringuito', 'elChiringuito85', 'elChiringuito85@gmail.com', 'establecimiento'),
('granVia27', 'Gran via 27', 'granVia27', 'granVia27@gmail.com', 'establecimiento'),
('laParada5', 'Cafe bar La parada', 'laParada5', 'laParada5@gmail.com', 'establecimiento'),
('laPlaza74', 'Bar la plaza', 'laPlaza74', 'laPlaza74@gmail.com', 'establecimiento'),
('casablanca_86', 'Casablanca', 'casablanca_86', 'casablanca_86@gmail.com', 'establecimiento'),
('mundo_92', 'Bar mundo', 'mundo_92', 'mundo_92@gmail.com', 'establecimiento'),
('elquetedije50', 'El que te dije', 'elquetedije50', 'elquetedije50@gmail.com', 'establecimiento'),
('porCopas2', 'A tomar por copas', 'porCopas2', 'porCopas2@gmail.com', 'establecimiento'),
('losada_33', 'Cafe Losada', 'losada_33', 'losada_33@gmail.com', 'establecimiento'),
('miBar8', 'Mi bar', 'miBar8', 'miBar8@gmail.com', 'establecimiento'),
('tascagao7', 'Tasca Gao', 'tascagao7', 'tascagao7@gmail.com', 'establecimiento'),
('barclays36', 'Bar clays', 'barclays36', 'barclays36@gmail.com', 'establecimiento'),
('tapillaSixtina', 'La tapilla Sixtina', 'tapillaSixtina', 'tapillaSixtina@gmail.com', 'establecimiento');


INSERT INTO `organizador` (`id_usuario`, `descripcionOrga`) VALUES
('manu', 'Jefe de organizador'),
('isa', 'organizador concurso'),
('miguel', 'organizador pinchos'),
('borja', 'organizador establecimientos'),
('cesar', 'relaciones publicas'),
('paquito86', 'organizador de jurados'),
('blanquita_7', 'organizador de premios'),
('pepiño', 'organizador de pinchos'),
('manolito22', 'organizador de pinchos');

INSERT INTO `establecimiento` (`id_usuario`, `localizacion`, `descripcion`) VALUES
('palleira', 'A Veiga, 10', 'Cafe/Bar/Taperia, servimos bocadillos, hamburguesas y tapas'),
('adegaCaneda', 'Paseo del Tamega', 'Taperia con vistas al rio.'),
('soutoCadeas', 'Plaza Garcia Barbon', 'Taperia en el centro.'),
('tamega', 'Avd de Sousas N 83', 'Taperia, disponemos de menu del dia.'),
('lousa', 'Castelao 3', 'Churrasqueria, tapas y cocina gallega.'),
('cafeCosta', 'Av Portugal N 26', 'Cafe en el centro de la ciudad'),
('cafeRubi', 'Av/ Habana N58', 'Cafe/Bar con precios económicos'),
('BeerParaCreer', 'Av/ Buenos Aires N 62', 'Tapería centrada en la gastronomía gallega'),
('cafeDulce', 'C/ Vicente Risco N 10', 'Cafetería con mesu del día a 7€'),
('laCantina36', 'Av Santiago N 44', 'Bar céntrico con fabulosos precios'),
('ElPaso10', 'Plaza del Hierro N 3', 'Tapería con grandes pinchos'),
('barMou', 'C/ Curros Enriquez N 36', 'Bar centrico con bocadillos a 1€'),
('elChiringuito85', 'C/ Zurbarán N 16', 'Cafe/Bar con grandes vistas del casco viejo'),
('granVia27', 'C/ Dalí N 3', 'Cafetería en el casco viejo'),
('laParada5', 'C/ Cardenal Quevedo N 7', 'Tapería famosa por sus pinchos'),
('laPlaza74', 'Plaza Paz Novoa N 4', 'Churrasquería centrada en la gastronomía gallega'),
('casablanca_86', 'C/ Cardenal Quiroga N 35', 'Cafe/Bar con especialidades en gastronomía italiana'),
('mundo_92', 'C/ Saenz Díez N 24', 'Taperia especial para veganos'),
('elquetedije50', 'C/ Castelao N 47', 'Bar de hamburguesas y tapas'),
('porCopas2', 'C/ Celso Emilio Ferreiro N 43', 'Bar cerca del río'),
('losada_33', 'Calle Bedoya N 29', 'Tapería especializada en carnes'),
('miBar8', 'Calle Concordia N 25', 'Bar/Tapería en el casco histórico'),
('tascagao7', 'C/ Vicente Risco N 35', 'Bar de gastronomía española'),
('barclays36', 'Av Otero Pedrayo N 26', 'Bar con menús del día muy baratos'),
('tapillaSixtina', 'Av Marín N 7', 'Cafe/Bar/Tapería de gastronomía italiana');

INSERT INTO `juradoPopular` (`id_usuario`, `residencia`) VALUES
('miriam', 'Ourense'),
('xeila', 'Verin'),
('abel', 'Ourense'),
('dani', 'Ourense'),
('cris', 'Ourense'),
('pacaLoca', 'Ourense'),
('martaf_94', 'Xinzo de Limia'),
('lucia_13', 'O Barco'),
('andreatp', 'A Rúa'),
('mayas17', 'Santiago de Compostela'),
('marioMars', 'Vigo'),
('sCameron12', 'Pontevedra'),
('iluminati22', 'A Coruña'),
('mauricioMacri', 'Lugo'),
('homerSimpson66', 'Laza'),
('violeta88', 'Monforte'),
('paraSito', 'Vigo'),
('marcForbes', 'Xinzo de Limia'),
('coquincha3', 'Ourense'),
('ameliaWebber', 'Ourense'),
('caraculeta_86', 'Santiago'),
('ash27', 'Vigo'),
('florDeLis', 'Monforte'),
('azufreAmarillo', 'Ourense'),
('marcoscorron', 'Ourense');

INSERT INTO `juradoProfesional` (`id_usuario`, `profesion`, `FK_organizador_jPro`) VALUES
('diego', 'cocinero', 'manu'),
('lucia', 'camarero', 'isa'),
('alex', 'dueño restaurante', 'miguel'),
('esteban', 'cocinero', 'borja'),
('oscar', 'camarero', 'cesar'),
('señoritaPerez', 'Chef', 'borja'),
('ana_45', 'Crítico gastronómico', 'isa'),
('lopezSanchez317', 'Cocinero', 'paquito86'),
('aliciajs', 'Periodista', 'pepiño'),
('adrianef', 'Periodista', 'cesar'),
('dafne963', 'Cocinero', 'blanquita_7'),
('borja35', 'Periodista', 'manolito22'),
('ffsantos', 'Chef', 'manu'),
('sonia_23', 'Crítico gastronómico', 'isa'),
('tfsantos', 'Crítico gastronómico', 'miguel'),
('carlos_ou', 'Chef', 'paquito86'),
('jfvalencia', 'Crítico gastronómico', 'blanquita_7'),
('carla83', 'Periodista', 'cesar'),
('beliguntum', 'Periodista', 'miguel'),
('carpab', 'Crítico gastronómico', 'manolito22'),
('luzSanz74', 'Chef', 'blanquita_7'),
('rrbeca', 'Chef', 'borja'),
('marcosjf', 'Crítico gastronómico', 'manu'),
('aranchaJ', 'Periodista', 'pepiño'),
('ssvazquez', 'Chef', 'paquito86');

INSERT INTO `concurso` (`id_concurso`, `nombre`, `localizacion`, `descripcion`, `FK_organizador_conc`) VALUES
('pinchosOurense', 'Concurso de Pincho', 'Ourense', 'Concurso de pinchos de la ciudad de Ourense, vengan y disfruten de todos los sabores de la ciudad. Recorran los establecimientos, probando sus pinchos, votando por aquellos que mas le gusten. Sobretodo disfruten del buen comer.', 'manu');


INSERT INTO `pincho` (`id_pincho`, `nombre`, `descripcion`, `celiaco`, `validado`, `num_votos`, `imagen`, `FK_concurso_pinc`, `FK_establecimiento_pinc`) VALUES
(1, 'cappuccino de castaña', 'pincho de otoño, una manera diferente de tomar la castaña', 0, 1, 3, 'cappuccino de castaña.jpg', 'pinchosOurense', 'palleira'),
(2, 'tosta de lomo con queso', 'tosta de lomo de cerdo con queso de Arzua', 0, 0, 0, 'tosta de lomo con queso.JPG', 'pinchosOurense', 'adegaCaneda'),
(3, 'chipirones con verduras', 'chipirones a la plancha con verduras cortadas muy pequeño', 0, 0, 0, 'chipirones con verduras.jpg', 'pinchosOurense', 'soutoCadeas'),
(4, 'tosta de hamburguesa', 'tosta de mini hamburquesa de ternera con queso de tetilla', 0, 1, 3, 'tosta de hamburguesa.JPG', 'pinchosOurense', 'tamega'),
(5, 'pulpo', 'pulpo cocino con pimentos, dulce o picante', 0, 0, 0, 'pulpo.jpg', 'pinchosOurense', 'lousa'),
(6, 'Carpaccio con nueces', 'Carpaccio con tapenade de nueces en hojaldre', 1, 0, 0, 'Carpaccio con tapenade de nueces en hojaldre.jpg', 'pinchosOurense', 'cafeCosta'),
(7, 'Hojaldre con paté de perdiz', 'Maravilloso paté de perdiz, manzana y trufa sobre una fina capa de hojaldre', 0, 1, 1, 'Hojaldre con paté de perdiz.jpg', 'pinchosOurense', 'cafeRubi'),
(8, 'pimientos con salsa', 'Fabulosos pimientos del piquillo con salsa de ostras', 0, 0, 0, 'pimientos con salsa.jpg', 'pinchosOurense', 'BeerParaCreer'),
(9, 'Calamares encebollados', 'Calamares encebollados al albariño con jamón', 0, 0, 0, 'Calamares encebollados.jpg', 'pinchosOurense', 'cafeDulce'),
(10, 'Higos, mozzaralla y albahaca', 'Brocheta de higos, mozzarella y albahaca aderezados con aceita de oliva', 1, 0, 0, 'Higos, mozzaralla y albahaca.jpg', 'pinchosOurense', 'laCantina36'),
(11, 'Pinchos de melón con anchoa y mermelada de cebolla', 'Combinación de sabores dulces y salados que resulta elegante al paladar', 1, 1, 1, 'Pinchos de melón con anchoa y mermelada de cebolla.jpg', 'pinchosOurense', 'ElPaso10'),
(12, 'Huevos rellenos', 'Deliciosos huevos rellenos de boletus y trufa', 0, 0, 0, 'Huevos rellenos.jpg', 'pinchosOurense', 'elChiringuito85'),
(13, 'Corte de mousse', 'Magnífico corte de mousse de foie y boniato', 0, 0, 0, 'Corte de mousse.jpg', 'pinchosOurense', 'granVia27'),
(14, 'Pincho de tortilla de patata', 'Pinchos de tortilla de patata violeta con cebolla caramelizada y cabrales', 1, 0, 0, 'Pincho de tortilla de patata.jpg', 'pinchosOurense', 'laParada5'),
(15, 'Seta de cardo', 'Rica seta de cardo confitada con romero y ajo', 1, 1, 0, 'Seta de cardo.jpg', 'pinchosOurense', 'laPlaza74'),
(16, 'Tramezzini', 'Tramezzini con pavo ahumado y pesto trapanese', 0, 0, 0, 'Tramezzini.jpg', 'pinchosOurense', 'casablanca_86'),
(17, 'Palitos de polenta', 'Palitos de polenta con parmesano y romero', 0, 0, 0, 'Palitos de polenta.jpg', 'pinchosOurense', 'mundo_92'),
(18, 'Hojas de cogollo con aguacate y tomate', 'Fabulosas hojas de cogollo con aguacate, tomate y maíz', 0, 1, 0, 'Hojas de cogollo con aguacate y tomate.jpg', 'pinchosOurense', 'elquetedije50'),
(19, 'Sepia con jenjibre', 'Sepia con jenjibre y leche de coco', 1, 0, 0, 'Sepia con jenjibre.jpg', 'pinchosOurense', 'porCopas2'),
(20, 'Patatas', 'Patatas al horno con pasta de soja y guindilla', 0, 0, 0, 'Patatas.jpg', 'pinchosOurense', 'losada_33');

INSERT INTO `codigo` (`FK_establecimiento_cod`, `id_codigo`, `usado`) VALUES
('palleira', 1, 1),
('palleira', 2, 1),
('palleira', 3, 1),
('palleira', 4, 1),
('palleira', 5, 1),
('palleira', 6, 1),
('palleira', 7, 1),
('palleira', 8, 0),
('palleira', 9, 0),
('palleira', 10, 1),
('palleira', 11, 1),
('palleira', 12, 1),
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
('palleira', 70, 1),
('palleira', 71, 0),
('palleira', 72, 0),
('palleira', 73, 0),
('palleira', 74, 0),
('palleira', 75, 0),
('palleira', 76, 0),
('palleira', 77, 0),
('palleira', 78, 0),
('palleira', 79, 0),
('palleira', 80, 1),
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
('tamega', 110, 1),
('tamega', 111, 0),
('tamega', 112, 0),
('tamega', 113, 0),
('tamega', 114, 0),
('tamega', 115, 0),
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
('tamega', 150, 1),
('tamega', 151, 1),
('tamega', 152, 1),
('tamega', 153, 0),
('tamega', 154, 0),
('tamega', 155, 0),
('tamega', 156, 0),
('tamega', 157, 1),
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
('tamega', 200, 1);

INSERT INTO `vota_pop` (`FK_juradoPopular_vot`, `FK_cod`) VALUES
('xeila', 3),
('xeila', 12),
('xeila', 110),
('xeila', 152),
('abel', 157);


INSERT INTO `vota_pro` (`FK_juradoProfesional_vota`, `FK_pincho_vota`, `ronda`, `votacion`) VALUES
('adrianef', 1, 1, 0),
('adrianef', 4, 1, 0),
('ana_45', 4, 1, 0),
('ana_45', 7, 1, 0),
('diego', 4, 1, 1),
('diego', 11, 1, 4),
('esteban', 4, 1, 2),
('esteban', 15, 1, 0),
('ssvazquez', 4, 1, 0),
('ssvazquez', 15, 1, 0);



INSERT INTO `premio` (`id_premio`, `tipo`) VALUES
('ganadorPop', 'popular'),
('ganadorPro', 'profesional');


INSERT INTO `comentarios` (`FK_juradoPopular_vot`, `FK_cod`, `comentario`) VALUES
('abel', 1, 'ja ja'),
('abel', 4, 'tosta.......'),
('xeila', 1, 'prueba de comentario en palleira'),
('xeila', 4, NULL);
