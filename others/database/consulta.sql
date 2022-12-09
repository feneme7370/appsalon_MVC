SELECT 
	citas.id, 
    citas.hora, 
    CONCAT(usuarios.nombre, ' ', usuarios.apellido) as cliente, 
    usuarios.email, 
    usuarios.telefono, 
    servicios.nombre, 
    servicios.precio
FROM citas
LEFT JOIN usuarios
	ON citas.usuarioId=usuarios.id
LEFT JOIN citasservicios
	ON citasservicios.citaId=citas.id
LEFT JOIN servicios
	ON servicios.id=citasservicios.servicioId
WHERE fecha = '2022-12-13'