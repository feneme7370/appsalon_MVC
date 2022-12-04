<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia sesion con tus datos</p>

<?php 
    //llamo al template con las alertas de errores o exitos
    include_once __DIR__ . '/../templates/alertas.php';
?>

<form action="/" method="POST" class="formulario">
    <div class="campo">
        <label for="">Email</label>
        <input 
            type="email"
            placeholder="Su email"
            id="email"
            name="email"
            value="<?php echo s($auth->email); ?>"
            autofocus
            
        >
    </div>
    <div class="campo">
        <label for="">Password</label>
        <input 
            type="text"
            placeholder="Su password"
            id="password"
            name="password"
        >
    </div>
    <input type="submit" class="boton" value="Iniciar sesion">
</form>

<div class="acciones">
    <a href="/crear-cuenta">Crear una cuenta</a>
    <a href="/olvide">¿Olvidaste tu password?</a>
</div>