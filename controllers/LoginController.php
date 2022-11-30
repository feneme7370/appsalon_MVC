<?php 
//agregar namespace para que autoload lo tenga cargado en app

namespace Controllers;

use MVC\Router;

//crear clase con atributos y metodos
class LoginController {
    public static function login(Router $router){
        $router->render('auth/login',[

        ]);
    }
    public static function logout(){
        echo "hola logout";
    }
    public static function olvide(){
        echo "desde olvide";
    }
    public static function recuperar(){
        echo "desde recuperar";
    }
    public static function crear(){
        echo "desde crear";
    }
}