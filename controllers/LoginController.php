<?php 
//agregar namespace para que autoload lo tenga cargado en app

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

//crear clase con atributos y metodos
class LoginController {
    public static function login(Router $router){
        //alertas para validacion de login
        $alertas = [];

        //guardar datos enviados incorrectamente en el form, se pasa a vistas, y en form se agrega en value
        $auth = new Usuario;

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Usuario($_POST);
            $alertas = $auth->validarLogin();

            if(empty($alertas)){
                //comprobar que existe el usuario
                $usuario = Usuario::where('email', $auth->email);
                if($usuario){
                    if($usuario->comprobarPasswordAndVerificado($auth->password)){
                        //autenticar el usuario

                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre;
                        $_SESSION['apellido'] = $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        //redireccionamiento

                        if($usuario->admin === '1'){
                            $_SESSION['admin'] = $usuario->admin ?? null;
                            header('Location: /admin');
                        }else{
                            header('Location: /citas');
                        }
                        debuguear($_SESSION);
                    }
                }else{
                    Usuario::setAlerta('error', 'usuario no encontrado');
                }
            }
        }
        
        $alertas = Usuario::getAlertas();

        $router->render('auth/login',[
            'alertas' => $alertas,
            'auth' => $auth
        ]);
    }
    public static function logout(){
        echo "hola logout";
    }
    public static function olvide(Router $router){
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();
        
            if(empty($alertas)){
                $usuario = Usuario::where('email', $auth->email);
                
                if($usuario && $usuario->confirmado === '1'){
                    //generar token
                    $usuario->crearToken();
                    $usuario->guardar();

                    //enviar el email

                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();

                    //Alerta de exito
                    Usuario::setAlerta('exito', 'revisa tu mail para generar un nuevo password');
                    $alertas = Usuario::getAlertas();
                }else{
                    Usuario::setAlerta('error', 'el usuario no existe o no esta confirmado');
                    $alertas = Usuario::getAlertas();
                }
            }
        }

        $router->render('auth/olvide-password', [
            'alertas' => $alertas
        ]);
    }
    public static function recuperar(Router $router){
        
        $alertas = [];
        $error = false;

        $token = s($_GET['token']);
        //buscar usuario por token (columna, valor)
        $usuario = Usuario::where('token', $token);
        
        if(empty($usuario) || $usuario === null){
            Usuario::setAlerta('error', 'token no valido');
            $error = true;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //leer nuevo password y guardar
            $password = new Usuario($_POST);
            $password->validarPassword();

            if(empty($alertas)){
                //acomodo el objeto usuario cambiandole el password y poniendo en null el token
                $usuario->password = null;
                
                $usuario->password = $password->password;
                $usuario->hashPassword();
                
                $usuario->token = null;

                $resultado = $usuario->guardar();
                if($resultado){
                    header('Location: /');
                }

            }
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/recuperar-password', [
            'alertas' => $alertas,
            'token' => $token,
            'error' => $error
        ]);
    }
    public static function confirmar(Router $router){
        $alertas = [];
        $token = s($_GET['token'] ?? null);

        $usuario = Usuario::where('token', $token);
        
        if(empty($usuario) || $token === ''){
            //mostrar mensaje de error si no es valido
            Usuario::setAlerta('error', 'token no valido');
        }else{
            //mostrar token valido
            $usuario->confirmado = '1';
            $usuario->token = null;
            $usuario->guardar($usuario->id);
            Usuario::setAlerta('exito','cuenta comprobada correctamente');
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/confirmar-cuenta', [
            'alertas' => $alertas,
            'token' => $token
        ]);
    }
    public static function mensaje(Router $router){
        $router->render('auth/mensaje', [
            
        ]);
    }
    public static function crear(Router $router){
        
        //se crea usuario vacio, que se va a ir llenando al hacer POST, sirve para que no se borren los campos
        $usuario = new Usuario;
        
        //alertas vacias
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //sincronizar sirve para ir llenando el objeto vacio de arriba
            $usuario->sincronizar($_POST);
            //llamar las alertas de errores
            $alertas = $usuario->validarNuevaCuenta();

            if(empty($alertas)){
                //verificar que el usuario no exista
                $resultado = $usuario->existeUsuario();
                
                //si existen creo nuevamente alertas para dar el error
                if($resultado->num_rows){
                    $alertas = Usuario::getAlertas();
                
                }else{
                    //hashear el password
                    $usuario->hashPassword();
                    //generar tokken
                    $usuario->crearToken();
                    //enviar mail por mailtrap
                        //se creo una clase para no poner todo el codigo aca, y se llama al objeto Email que contiene datos
                    //$email = new Email($usuario->email,$usuario->nombre,$usuario->token);
                    //$email->enviarConfirmacion();
                    
                    //crear usuario
                    $resultado = $usuario->guardar();

                    if($resultado){
                        header("Location: /mensaje");
                    }
                    //debuguear($email);
                    //debuguear($usuario);
                }
            }
        }

        $router->render('auth/crear-cuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }
}