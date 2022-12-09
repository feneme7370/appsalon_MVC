<h1 class="nombre-pagina">Panel de administracion</h1>
<p class="descripcion-pagina">Gestionar</p>

<?php include __DIR__ . '/../templates/barra.php' ?>
<?php
date_default_timezone_set('UTC');
date_default_timezone_set("America/Argentina/Buenos_Aires");
?>
<h2>Buscar citas</h2>
<div class="busqueda">
    <form class="formulario" action="">
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" name="fecha" value="<?php echo $fechaGET; ?>">
        </div>
    </form>
</div>

<?php 
    if(count($citas) === 0){
        echo "<h3>No hay citas en esta fecha</h3>";
    }
?>


<div class="citas-admin">
    <ul class="citas">
        <?php
        $idCita = null;
        foreach ($citas as $key => $cita) {
            if ($idCita !== $cita->id) {
                $total = 0;//va dentro de este if porque no se reinicia cada vez que se ejectua, sino cada vez que cambia de id
        ?>

                <li>
                    <p>ID: <span><?php echo $cita->id; ?></span></p>
                    <p>Hora: <span><?php echo $cita->hora; ?></span></p>
                    <p>Cliente: <span><?php echo $cita->cliente; ?></span></p>
                    <p>Email: <span><?php echo $cita->email; ?></span></p>
                    <p>telefono: <span><?php echo $cita->telefono; ?></span></p>

                    <h3>Servicios</h3>

                <?php 
                    $idCita = $cita->id;
                } //.. if 
                    $total += $cita->precio;
                ?>

                <p class="servicio"><?php echo $cita->servicio . " " . $cita->precio; ?></p>

                </li>
                <?php 
                    $actual = $cita->id;
                    $proximo = $citas[$key + 1]->id ?? 0;

                    if(isLast($actual, $proximo)){ ?>
                        <p class="total">Total: <span>$ <?php echo $total; ?></span></p>

                        <form action="/api/eliminar" method="POST">
                            <input type="hidden" name="id" value="<?php echo $cita->id;?>">
                            <input type="submit" class="boton-eliminar" value="Eliminar">
                        </form>
                    <?php }
                ?>
                
            <?php } //..foreach 
            ?>
    </ul>
</div>

<?php 
    $script = "<script src='build/js/buscador.js'></script>";
?>
