<?php
//======================================================================
// Clase para gestionar la base de datos
//======================================================================
class DB
{
    //-----------------------------------------------------
    // Variables
    //-----------------------------------------------------
    private $file = 'login.sqlite';
    private $myPDO = null;

    //-----------------------------------------------------
    // Constructor
    //-----------------------------------------------------
    function __construct()
    {
        $hostPDO = "sqlite:$this->file";
        $this->myPDO = new PDO($hostPDO);
    }

    //-----------------------------------------------------
    // GET
    //-----------------------------------------------------


    //-----------------------------------------------------
    // Métodos
    //-----------------------------------------------------
    /**
     * Método que comprueba si el usuario y la contraseña se encuentra en un usuario
     * @param {string} $email - Email
     * @param {string} $password - Contraseña
     * @return {bool}
     */
    public function validarUsuario(string $email, string $password): bool
    {
        $miConsulta = $this->myPDO->prepare('SELECT password FROM users WHERE email = :email AND active != 0');
        $miConsulta->execute([
            'email' => $email
        ]);
        $resultado = $miConsulta->fetch();
        // Existe el usuario
        if ($resultado) {
            // Comprobamos la contrasenya si es válida
            return password_verify($password, $resultado['password']);
        } else {
            return False;
        }
    }

    /**
     * Método que actualizar el token del usuario
     * @param {string} $email - Email
     * @param {string} $token - Token
     * @return {bool}
     */
    public function actualizarToken(string $email, string $token): bool
    {
        $miUpdate = $this->myPDO->prepare('UPDATE users SET token = :token WHERE email = :email');
        return $miUpdate->execute([
            'email' => $email,
            'token' => $token
        ]);
    }

    /**
     * Método que verifica si existe el email en la base de datos
     * @param {string} $email - Email
     * @return {bool}
     */
    public function comprobarExisteCorreo(string $email): bool
    {
        $miSelect = $this->myPDO->prepare('SELECT COUNT(*) as cantidad FROM users WHERE email = :email AND active != 0');
        $miSelect->execute([
            'email' => $email
        ]);
        $resultados = $miSelect->fetch();
        return (int) $resutados['cantidad'] !== 0;
    }

    /**
     * Método que verifica si existe el token
     * @param {string} $token - Token
     * @param {string} $email - Email
     * @return {bool}
     */
    public function comprobarToken(string $token, string $email): bool
    {
        $miSelect = $this->myPDO->prepare('SELECT COUNT(*) as cantidad FROM users WHERE email = :email AND active != 0 AND token = :token');
        $miSelect->execute([
            'token' => $token,
            'email' => $email
        ]);
        $resultados = $miSelect->fetch();
        return (int) $resutados['cantidad'] !== 0;
    }
}
