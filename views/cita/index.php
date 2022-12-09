<h1 class="nombre-pagina">Crear nueva cita</h1>
<p class="descripcion-pagina">Elige el servicio</p>

<?php include __DIR__ . '/../templates/barra.php' ?>


<div id="app">
    <nav class="tabs">
        <button class="actual" type="button" data-paso="1">Servicios</button>
        <button type="button" data-paso="2">Informacion cita</button>
        <button type="button" data-paso="3">Resumen</button>
    </nav>

    <div id="paso-1" class="seccion">
        <h2>Servicios</h2>
        <p class="text-align-center">Elige tus servicios a continuacion</p>
        <div id="servicios" class="listado-servicios"></div>
    </div>

    <div id="paso-2" class="seccion">
        <h2>Tus datos y cita</h2>
        <p class="text-align-center">Coloca tus datos y fecha de la cita</p>

        <form class="formulario">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input 
                    type="text"
                    id="nombre"
                    placeholder="Tu nombre"
                    value="<?php echo $nombre; ?>"
                    readonly
                    
                >
            </div>
            <div class="campo">
                <label for="fecha">Fecha</label>
                <input 
                    type="date"
                    id="fecha"
                    min="<?php echo date('Y-m-d', strtotime('+0 day')); ?>"
                >
            </div>
            <div class="campo">
                <label for="hora">Hora</label>
                <input 
                    type="time"
                    id="hora"
                    value="<?php echo time(); ?>"
                >
            </div>
            <input type="hidden" id="id" value="<?php echo $id; ?>">
            
            
        </form>
    </div>

    <div id="paso-3" class="seccion">
        <h2>Resumen</h2>
        <p class="text-align-center">Verifica que la informacion sea correcta</p>
        <div class="contenido-resumen"></div>
    </div>

    <div class="paginacion">
        <button
            id="anterior"
            class="boton"
        >&laquo; Anterior</button>

        <button
            id="siguiente"
            class="boton"
        >Siguiente &raquo;</button>
    </div>

</div>

<?php 
    //agrega el script solo en la view correspondiente, en layout esta que si $script no tiene nada en la view es null
    //<script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    $script = "
        <script src='build/js/sweetalert2@11.js'></script>
        <script src='build/js/app.js'></script>
    
    ";
?>
