CREATE DATABASE smallShop;
USE smallShop;

CREATE TABLE users (
	idUser SMALLINT AUTO_INCREMENT,
	username VARCHAR(100) NOT NULL,
	pass VARCHAR(100) NOT NULL,
	fullName VARCHAR(100) NOT NULL,
	email VARCHAR(100) NOT NULL UNIQUE,
	PRIMARY KEY (idUser)
)ENGINE = InnoDB;

CREATE TABLE costumers (
	idCostumer SMALLINT AUTO_INCREMENT,
	nameCostumer VARCHAR(100) NOT NULL,
	surname VARCHAR(100) NOT NULL,
	imageName VARCHAR(200),
	idUserCreator SMALLINT,
	idUserLastModify SMALLINT,
	PRIMARY KEY (idCostumer),
	CONSTRAINT fk_user_creator FOREIGN KEY (IdUserCreator) REFERENCES users (idUser)
	ON UPDATE CASCADE
	ON DELETE SET NULL,
	CONSTRAINT fk_user_last_modify FOREIGN KEY (IdUserLastModify) REFERENCES users (idUser)
	ON UPDATE CASCADE
	ON DELETE SET NULL
)ENGINE= InnoDB;