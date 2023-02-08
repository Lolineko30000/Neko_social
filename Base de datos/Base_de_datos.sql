CREATE DATABASE PROYECTO_FINAL;
USE PROYECTO_FINAL;

CREATE TABLE PERSONAS (
      ID_persona int not NULL PRIMARY KEY AUTO_INCREMENT,
      nombre varchar(255),
      contrasenia varchar(255),
      foto_perfil varchar(255)
      );

CREATE TABLE SEGUIR(
      PK int not NULL PRIMARY key AUTO_INCREMENT,
      id_persona int,
      id_seguidor int,
      FOREIGN KEY (id_persona) REFERENCES PERSONAS (ID_persona),
      FOREIGN KEY (id_seguidor) REFERENCES PERSONAS (ID_persona)
);

CREATE TABLE Correo_Persona (
      PK int not NULL PRIMARY key AUTO_INCREMENT,
      correo varchar(255),
      id_persona int NOT NULL,
      FOREIGN KEY (id_persona) REFERENCES PERSONAS (ID_persona)
      );


      CREATE TABLE publicaciones_persona(
            PK int not NULL PRIMARY KEY AUTO_INCREMENT,
            cuerpo varchar(500),
            fecha DATE,
            likes int,
            id_usuario int,
            foto varchar(255),
            topic varchar(500),
            FOREIGN KEY (id_usuario) REFERENCES personas(id_persona)
      );


      CREATE TABLE token(
          token varchar(100) PRIMARY KEY,
          id_persona int NOT NULL,
          FOREIGN KEY (id_persona) REFERENCES PERSONAS(id_persona)
      );

      CREATE TABLE token_contrasenia(
          token varchar(100) PRIMARY KEY,
          id_persona int NOT NULL,
          FOREIGN KEY (id_persona) REFERENCES PERSONAS(id_persona)
      );


      CREATE TABLE post_likes(
            pk int not NULL PRIMARY KEY AUTO_INCREMENT,
            post_id int,
            id_persona int,
            FOREIGN KEY (id_persona) REFERENCES PERSONAS(id_persona)
      );



CREATE TABLE comentarios(
        pk int not NULL PRIMARY KEY AUTO_INCREMENT,
        comentario varchar(500),
        id_escritor int,
        fecha DATE,
        post_id int,
        FOREIGN KEY (post_id) REFERENCES publicaciones_persona(pk),
        FOREIGN KEY (id_escritor) REFERENCES PERSONAS(id_persona)
);


CREATE TABLE notificaciones(
      pk INT PRIMARY KEY AUTO_INCREMENT,
      tipo INT,
      id_destino int,
      id_destinatario int,
      informacion varchar(500),
      FOREIGN KEY (id_destino) REFERENCES PERSONAS(id_persona),
      FOREIGN KEY (id_destinatario) REFERENCES PERSONAS(id_persona)
);

CREATE TABLE mensajes(
      id INT PRIMARY KEY,
      cuerpo TEXT,
      visto boolean,
      id_destino int,
      id_destinatario int,
      FOREIGN KEY (id_destino) REFERENCES PERSONAS(id_persona),
      FOREIGN KEY (id_destinatario) REFERENCES PERSONAS(id_persona)
);






/*

CREATE TABLE videos_persona (
      PK int not NULL PRIMARY KEY AUTO_INCREMENT,
      videos varchar(255),
      id_persona int NOT NULL,
      FOREIGN KEY (id_persona) REFERENCES PERSONAS(ID_persona)
      );

CREATE table telefono_persona (
      PK int NOT NULL PRIMARY KEY AUTO_INCREMENT,
      telefono varchar(255),
      id_persona int NOT NULL,
      FOREIGN KEY (id_persona)REFERENCES PERSONAS (ID_persona)
      );

CREATE TABLE fotos_persona (
      PK int not NULL PRIMARY key AUTO_INCREMENT,
      fotos varchar(255),
      id_persona INt not NULL,
      FOREIGN key (id_persona) REFERENCES PERSONAS(ID_persona)
      );

CREATE TABLE documetos_persona (
      PK int not NULL PRIMARY key AUTO_INCREMENT,
      documetos varchar(255),
      id_persona int NOT NULL,
      FOREIGN key (id_persona) REFERENCES PERSONAS(ID_persona)
      );

CREATE TABLE pagina (
      nombre varchar(255) NOT NULL PRIMARY KEY,
      duenio varchar(255), area_de_interes varchar(255),
      id_persona int not NULL, FOREIGN KEY (id_persona)
      REFERENCES PERSONAS(ID_persona)
      );

CREATE TABLE publicaciones_pagina (
      PK int not NULL PRIMARY key,
      publicaciones varchar(255),
      nombre_pagina varchar(255) not NULL,
      FOREIGN key (nombre_pagina) REFERENCES pagina(nombre)
      );


      CREATE TABLE seguir (
            PK int not NULL PRIMARY KEY, nombre_pagina varchar(255) not NULL,
            id_persona int NOT NULL,
            FOREIGN key (nombre_pagina) REFERENCES pagina(nombre),
            FOREIGN KEY (id_persona) REFERENCES PERSONAS(ID_persona)
            );

*/
