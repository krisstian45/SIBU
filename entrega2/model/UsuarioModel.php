 <?php

class UsuarioModel extends PDORepository  {

    private $id;
    private $usuario;
    private $clave;
    private $nombre;
    private $apellido;
    private $tipoDocumento; // TODO: Preguntar si va tipo documento.
    private $numeroDocumento;
    private $email;
    private $telefono;
    private $rol_id;
    private $ubicacion_id;
    private $habilitado;

    protected function __construct() {

    }

    public function do_login($username, $password) {
        $userData = array($username, $password);
        // TODO: Pregutar si es necesario usar bindParam o asi esta bien
        $stmt = $this->query("SELECT * FROM usuario WHERE usuario = ? AND clave = ?", $userData);
        if($stmt->rowCount() > 0){
            $user = $stmt->fetch();
            if ($user['habilitado'] == 1)
                return ($user);
            else
                throw new Exception("Lo sentimos, aún no está habilitado.");
        }
        else
            throw new Exception("Los datos son incorrectos. Por favor, intente de nuevo");
    }

    public function crear($data)
    {
        $arrayData = self::setUsuario($data);
        //$arrayData[2]= password_hash($data['clave'], PASSWORD_DEFAULT);
        if(!(self::usuarioExiste())){ //Si el usuario no existe
            $this->query("INSERT INTO usuario (id, usuario, clave, nombre, apellido, tipoDocumento, numeroDocumento, email, telefono, rol_id, ubicacion_id,habilitado)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", $arrayData);
            return 0;
        }
        else
            throw new Exception("El nombre de usuario ya existe intente con otro.");
    }

    public function modificar($data, $usuarioActual)
    {
        if ($data['habilitado'] == 0 && $data['usuario'] == $usuarioActual )
            throw new Exception("No puede autodeshabilitarse");

        $arrayData = self::setUsuario($data);
        if(self::usuarioExiste() && !empty ($data['id'])){ //Si el usuario no existe
                $arrayData[0]= $data['id'];
                //$arrayData[2]= password_hash($data['clave'], PASSWORD_DEFAULT);
                array_push($arrayData, $data['id']); //Esto es para el WHERE tome id=? (ultimo parametro del array)
                $this->query("UPDATE usuario
                    SET id=?, usuario=?, clave=?, nombre=?, apellido=?, tipoDocumento=?, numeroDocumento=?, email=?, telefono=?, rol_id=?, ubicacion_id=?, habilitado=?
                    WHERE id=?", $arrayData);
                return 0;
        }
        else
            throw new Exception("El usuario que intenta modificar no existe");
    }

    public function borrar($usuarioAborrar, $usuarioActual)
    {
        if($usuarioActual == $usuarioAborrar)
            throw new Exception("Error, no puede borrarse a sí mismo.");
        else{
            $this->usuario= $usuarioAborrar;
            if(self::usuarioExiste() ){
                $usr = array($usuarioAborrar);
                $this->query("DELETE FROM usuario WHERE usuario=?", $usr);
                return 0;
            }
            else
                throw new Exception("Error al borrar, el usuario no existe.");
        }
    }


    public function setUsuario($data)
    {
        $this->id = null; //Esto es porque el insert lo hace autoincrementable.
        $this->usuario = $data['usuario'];
        $this->clave = $data['clave'];
        $this->nombre = $data['nombre'];
        $this->apellido = $data['apellido'];
        $this->tipoDocumento = $data['tipoDocumento'];
        $this->numeroDocumento = $data['numeroDocumento'];
        $this->email = $data['email'];
        $this->telefono = $data['telefono'];

        if ( $data['rol'] == "administrador" )
            $this->rol_id = 1;
        else
            if( $data['rol'] == "gestion" )
                $this->rol_id = 2;
            else
                $this->rol_id = 3;

        $this->ubicacion_id = intval($data['ubicacion_id']);
        if ($data['habilitado'] == "habilitado")
            $this->habilitado = 1;
        else
            $this->habilitado = 0;

        $arrayData = (array)get_object_vars($this);
        return array_values($arrayData);
    }

    public function usuarioExiste()
    {
        $data= (array) $this->usuario;
        $stmt = $this->query("SELECT * FROM usuario WHERE usuario = ?", $data);
        return ($stmt->rowCount() > 0);
    }

    public function obtenerUsuarios()
    {
        $stmt = $this->query("SELECT * FROM usuario  INNER JOIN ubicacion on usuario.ubicacion_id = ubicacion.id ");
        return $stmt->fetchAll();
    }

    public function obtenerUbicacion()
    {
        $stmt = $this->query("SELECT * FROM ubicacion");
        return $stmt->fetchAll();
    }

    public function obtenerUsuario($usuario)
    {
        $data= (array)$usuario;
        $stmt = $this->query("SELECT * FROM usuario WHERE usuario = ?", $data);
        return $stmt->fetchAll();
    }

    public function obtenerAdministradores()
    {
        $stmt = $this->query("SELECT * FROM usuario WHERE rol_id = 1");
        return $stmt->fetchAll();
    }

    public function obtenerUbicaciones()
    {
        $stmt = $this->query("SELECT * FROM ubicacion");
        return $stmt->fetchAll();
    }

}
?>