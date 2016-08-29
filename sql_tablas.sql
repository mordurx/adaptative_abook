create table Respuesta_pregunta
(
	id_pregunta int,
	FOREIGN KEY (id_pregunta) REFERENCES Pregunta(id_pregunta),
	nombre_usuario varchar(50),
	FOREIGN KEY (nombre_usuario) REFERENCES Pregunta(nombre),
	id_pagina int,
	FOREIGN KEY (id_pagina) REFERENCES Pagina(id_pagina),
	id_feedback  int,
	resp_user varchar(50),
	resultado int,
	estado int default 0,
	intento int,
	primary key (id_pregunta,nombre_usuario)
	
)
create table Cuento_por_Usuario
(
	id_usuario varchar(50),
	FOREIGN KEY (id_usuario) REFERENCES Pregunta(nombre),
	id_cuento int,
	FOREIGN KEY (id_cuento) REFERENCES Cuento(id_cuento),
	veces_leido int default 1,
	ind_pagina int default 1,
	primary key(id_usuario,id_cuento)
	

	
)

create table Reader_profile
(
	id_usuario varchar(50),
	FOREIGN KEY (id_usuario) REFERENCES Usuario(nombre),
	cond_exp_infer int,
	cond_exp_monit int,
	cond_exp_struct int,
	primary	key (id_usuario),
	total_infer int,
	total_monit	int,
	total_struct int
)
create table Pagina_by_user
(
	id_pagina int not null,
	id_cuento int NOT NULL,
	FOREIGN KEY (id_cuento) REFERENCES Cuento_por_Usuario(id_cuento),
	
	texto_pagina text,
	numeracion int,
	id_usuario varchar(50) NOT NULL,
	FOREIGN KEY (id_usuario) REFERENCES Usuario(nombre),
	intento int,
	overlap int,
	primary KEY(id_usuario,id_pagina)
)


################## TRUNCATE TABLE #####################

TRUNCATE TABLE Cuento;
TRUNCATE TABLE Cuento_por_Usuario;
TRUNCATE TABLE Pagina;
TRUNCATE TABLE Pregunta;
TRUNCATE TABLE Respuesta_pregunta;
TRUNCATE TABLE Usuario;

################## DROP TABLE #####################

DROP TABLE Cuento;
DROP TABLE Cuento_por_Usuario;
DROP TABLE Pagina;
DROP TABLE Pregunta;
DROP TABLE Respuesta_pregunta;
DROP TABLE Usuario;

DROP TABLE  Reader_profile;
DROP table  Pagina_by_user;