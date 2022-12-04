CREATE TABLE servicios (
    id_srvcs         INT(11)         NOT NULL        AUTO_INCREMENT,
    nombre_srvcs     VARCHAR(60)     NOT NULL,
    precio_srvcs     DECIMAL(5,2)     NOT NULL,


    PRIMARY KEY (id_srvcs) 
);