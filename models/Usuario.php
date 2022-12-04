<?php 
//poner el namespace de lo que correspondel, osea model
namespace Model;

//llamar AR para poder heredar
use Model\ActiveRecord;

//crear objeto herendando todo
class Usuario extends ActiveRecord{

    //pasar nombre de la tabla
    protected static $tabla = 'usuarios';
    //pasar columnas exactas de la tabla
    protected static $columnasDB = [
        'id', 
        'nombre', 
        'apellido', 
        'email', 
        'password', 
        'telefono', 
        'admin', 
        'confirmado', 
        'token'
    ];
    
    //crear atributos
    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    //asignar valores a los atributos
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;        
        $this->nombre = $args['nombre'] ?? '';        
        $this->apellido = $args['apellido'] ?? '';        
        $this->email = $args['email'] ?? '';        
        $this->password = $args['password'] ?? '';        
        $this->telefono = $args['telefono'] ?? '';        
        $this->admin = $args['admin'] ?? '0';        
        $this->confirmado = $args['confirmado'] ?? '0';        
        $this->token = $args['token'] ?? '';        
    }

    //mensajes de validacion para creacion de cuenta
    public function validarNuevaCuenta(){
        if(!$this->nombre){
            self::$alertas['error'][] = 'el nombre es obligatorio';
        }
        if(!$this->apellido){
            self::$alertas['error'][] = 'el apellido es obligatorio';
        }
        if(!$this->email){
            self::$alertas['error'][] = 'el email es obligatorio';
        }
        if(!$this->telefono){
            self::$alertas['error'][] = 'el telefono es obligatorio';
        }
        if(strlen($this->password) < 6){
            self::$alertas['error'][] = 'el password debe contener al menos 6 caracteres';
        }

        return self::$alertas;
    }

    //mensajes de validacion para login
    public function validarLogin(){
        if(!$this->email){
            self::$alertas['error'][] = 'el email es obligatorio';
        }
        if(!$this->password){
            self::$alertas['error'][] = 'el password es obligatorio';
        }

        return self::$alertas;
    }

    //revisar si usuario existe
    public function existeUsuario(){
        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";
        
        $resultado = self::$db->query($query);
        if($resultado->num_rows){
            self::$alertas['error'][] = 'el usuario ya esta registrado';
        }

        return $resultado;
    }

    public function hashPassword(){
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);    
    }

    public function crearToken(){
        $this->token =uniqid();
    }

    //verificar password
    public function comprobarPasswordAndVerificado($password){
        $resultado = password_verify($password, $this->password);
        if(!$resultado || !$this->confirmado){
            self::$alertas['error'][] = 'la cuenta no esta confirmada o el password es incorrecto';
        }else{
            return true;
        }
    }
    //validar email campo
    public function validarEmail(){
        if(!$this->email){
            self::$alertas['error'][] = 'el email es obligatorio';
        }

        return self::$alertas;
    }
    //validar email campo
    public function validarPassword(){
        if(!$this->password){
            self::$alertas['error'][] = 'el password es obligatorio';
        }
        if(strlen($this->password) < 6){
            self::$alertas['error'][] = 'el password debe tener al menos 6 caracteres';
        }

        return self::$alertas;
    }
};