<?php 
namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {

    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion()
    {
        //crear objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'b3ee8f1ce48563';
        $mail->Password = '35e3d748a391ce';

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');
        $mail->Subject = 'confirma tu cuenta';

        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';



        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong></p>";
        $contenido .= "<p>Has creado tu cuenta en app salon, confirma tu mail con el siguiente link</p>";
        $contenido .= "<p>Presionar aqui: <a href='http://localhost:3000/confirmar-cuenta?token=" . $this->token . "'>Confirmar cuenta</a></p>";
        $contenido .= "<p>Si tu no solicitaste esta cuenta, ignora el mensaje</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;
        $mail->send();
    }

    public function enviarInstrucciones(){
        //crear objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'b3ee8f1ce48563';
        $mail->Password = '35e3d748a391ce';

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');
        $mail->Subject = 'reestablece tu password';

        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';



        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong></p>";
        $contenido .= "<p>Para reestablecer tu password has click en el siguiente enlace</p>";
        $contenido .= "<p>Presionar aqui: <a href='http://localhost:3000/recuperar?token=" . $this->token . "'>Reestablecer password</a></p>";
        $contenido .= "<p>Si tu no solicitaste esta cuenta, ignora el mensaje</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;
        $mail->send();
    }
}
?>
