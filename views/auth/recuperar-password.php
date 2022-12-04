<h1 class="nombre-pagina">Recuperar password</h1>
<p class="descripcion-pagina">Ingresa tu nuevo password</p>

<?php 
    //llamo al template con las alertas de errores o exitos
    include_once __DIR__ . '/../templates/alertas.php';
?>

<?php if($error === false){ ?>

    <!-- no va el action porque borraria el token -->
    <form method="POST" class="formulario">
        <div class="campo">
            <label for="">Password</label>
            <input 
                type="password"
                placeholder="Su password"
                id="password"
                name="password"
            >
        </div>
        <input type="submit" class="boton" value="Generar password">
    </form>
<?php } ?>


<div class="acciones">
    <a href="/">¿Ya tienes cuenta? iniciar sesion</a>
    <a href="/crear-cuenta">Registrarse</a>
</div>