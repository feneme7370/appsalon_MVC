create table usuarios (
    id_usrs         INT(11)         NOT NULL        AUTO_INCREMENT,
    nombre_usrs     VARCHAR(60)     NOT NULL,
    apellido_usrs  VARCHAR(60)     NOT NULL,
    email_usrs      VARCHAR(60)     NOT NULL,
    password_usrs      VARCHAR(60)     NOT NULL,
    telefono_usrs   VARCHAR(60)     NOT NULL,
    admin_usrs      TINYINT(1)      NOT NULL,
    confirmado_usrs TINYINT(1)      NOT NULL,
    token_usrs      VARCHAR(15)     NOT NULL,

    PRIMARY KEY (id_usrs) 
);