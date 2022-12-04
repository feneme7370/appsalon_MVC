CREATE TABLE citas (
    id_cts      INT(11)         NOT NULL        AUTO_INCREMENT,
    fecha_cts   DATE            NOT NULL,
    hora_cts    TIME            NOT NULL,
    usuarioId_cts   INT(11)         NOT NULL,

    PRIMARY KEY (id_cts),

);

