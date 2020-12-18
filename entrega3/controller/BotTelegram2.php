<?php
class BotTelegram2 extends Base
{
    function __construct()
    {
    }
    public function menuManiana()
    {
        $hoy = (new DateTime());
        $hoy->add(new DateInterval('P1D'));
        $tomorrow=date_format($hoy, 'Y-m-d');
        $menus = MenuModel::getInstance()->obtenerMenu($tomorrow); //recibe false si no hay menu
        if ( $menus != false ){
            return $menus;
        }else {
            return false;
        }
    }
    public function menuHoy()
    {
        $hoy = (new DateTime())->format('Y-m-d');
        $menus = MenuModel::getInstance()->obtenerMenu($hoy); //recibe false si no hay menu
        if ( $menus != false ){
            return $menus;
        }else {
            return false;
        }
    }

    public function respuesta($value,$titulo)
    {
        if ($value != false ) {
            $texto="El menú del dia es:\n";
            foreach ($value as $key => $value) {
                $texto .= $value['nombre_producto'] . "\n";
            }
            return $texto .= "\n" . $titulo;
        }
        return 	$texto="Aún no hay menú\nVuelva a intentarlo más tarde.\n" . $titulo;
    }

    public function enviarMenu()
    {
        define('BOT_TOKEN', '270810209:AAEe8VV5BleJoTvgLFgZA6TMjdb83JBHr2s');
        define('API_URL', 'https://api.telegram.org/bot'.BOT_TOKEN.'/');

        $configuracion = ConfiguracionModel::getInstance()->traerConfiguracion();
        $datos=SuscripcionModel::getInstance()->obtenerSuscriptos();
        if (!empty($datos)) {
            $menu=self::menuHoy();
            $reply=self::respuesta($menu,$configuracion['titulo']);
            if ($menu != false) {
                # code...
                foreach ($datos as $key => $value) {
                    $sendto =API_URL."sendmessage?chat_id=".$value['chat_id']."&text=". urlencode($reply);
                    file_get_contents($sendto);
                }
                return "Menú enviado con exito";
            }else return "No hay menu para enviar";
        }else return "No se pudo enviar ,no hay suscritos.";
    }

    public function suscribe($value)
    {
        $valor=SuscripcionModel::getInstance()->crearSuscripcion($value);
        if($valor > 0)
            return "Suscripto exitosamente!";
        else
            return "Usted ya se encuentra inscripto";
    }

    public function delSuscribe($value)
    {
        $valor=SuscripcionModel::getInstance()->eliminarSuscripcion($value);
        if($valor > 0)
            return "Desuscripto exitosamente!";
        else
            return "Usted no está inscripto";
    }

    public function verificacion()
    {
        $content = file_get_contents("php://input");
        $update = json_decode($content, true);
        if (!$update) {
            // receive wrong update, must not happen
            return false;
        }
        return true;
    }

    public function init($m = null)
    {
        define('BOT_TOKEN', '270810209:AAEe8VV5BleJoTvgLFgZA6TMjdb83JBHr2s');
        define('API_URL', 'https://api.telegram.org/bot'.BOT_TOKEN.'/');


        $configuracion = ConfiguracionModel::getInstance()->traerConfiguracion();

        // read incoming info and grab the chatID
        $content = file_get_contents("php://input");
        $update = json_decode($content, true);

        if(! empty($m))
            $message = $m;
        else
            $message = $update["message"]["text"];

        $chatID = $update["message"]["chat"]["id"];

        // compose reply
        switch ($message) {
            case '/start':
                $reply = 'Hola ' . $update['message']['from']['first_name'] . "\n" . '¿Como puedo ayudarte? Puedes utilizar el comando /help';
                break;
            case '/hoy':
                $menu=self::menuHoy();
                $reply=self::respuesta($menu,$configuracion['titulo']);
                break;

            case '/mañana':
                $menu=self::menuManiana();
                $reply=self::respuesta($menu,$configuracion['titulo']);
                break;
            case '/help':
                $reply = "Indique /hoy o /mañana para obtener el menú.\n Además puede suscribirse al menu diario con /suscribirse .\n En caso de darse de baja use /desuscribirse . \n /help para mostrar el mismo mensaje. \n" . $configuracion['titulo'];
                break;
            case '/suscribirse':
                $res = self::suscribe($update);
                $reply = 'Hola ' . $update['message']['from']['first_name'] . "\n" . $res;
                break;
            case '/desuscribirse':
                $res = self::delSuscribe($update);
                $reply = 'Hola ' . $update['message']['from']['first_name'] . "\n" . $res;
                break;
            case '/enviarMenu':
                $msg=self::enviarMenu();
                $reply = 'Hola ' . $update['message']['from']['first_name'] . "\n" . $msg;
                break;
            default:

                $reply = 'Hola ' . $update['message']['from']['first_name'] . "\n" . "Disulpe no entiendo el mensaje: \n         ".$message." \nPruebe con /help . \n " . $configuracion['titulo'];

                break;
        }
        // send reply
        $sendto =API_URL."sendmessage?chat_id=".$chatID."&text=". urlencode($reply);
        file_get_contents($sendto);
        return $sendto;
    }

}

?>