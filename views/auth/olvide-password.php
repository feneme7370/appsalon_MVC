<h1 class="nombre-pagina">Olvide mi password</h1>
<p class="descripcion-pagina">Ingrese su email para recuperar su password</p>

<?php 
    //llamo al template con las alertas de errores o exitos
    include_once __DIR__ . '/../templates/alertas.php';
?>

<form action="/olvide" method="POST" class="formulario">
    <div class="campo">
        <label for="">Email</label>
        <input 
            type="email"
            placeholder="Su email"
            id="email"
            name="email"
            autofocus
        >
    </div>
    <input type="submit" class="boton" value="Enviar instrucciones">
</form>

<div class="acciones">
    <a href="/">Iniciar sesion</a>
    <a href="/crear-cuenta">¿Aun no tienes una cuenta?</a>
</div>