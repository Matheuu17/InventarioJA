<?php
require_once __DIR__ . "/conexion.php";

class modeloUsuario {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->conectar(); // Conexión PDO
    }
        public function buscarPorNombreU(string $nombreU): ?array {
        $sql = "SELECT * FROM usuario WHERE nombreU = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$nombreU]);

        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res ?: null;
    }

    /* ====================================================
       BUSCAR USUARIO POR CORREO
       ==================================================== */
    public function buscarPorCorreo(string $correo): ?array {
        $sql  = "SELECT idUsuario FROM usuario WHERE correo = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$correo]);

        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res ?: null;
    }

    /* ====================================================
       GUARDAR TOKEN PARA RESET PASSWORD
       ==================================================== */
    public function guardarTokenReset(int $idUsuario, string $token, string $expira): void {
        $sql = "UPDATE usuario SET reset_token = ?, reset_expires = ? WHERE idUsuario = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$token, $expira, $idUsuario]);
    }

    /* ====================================================
       BUSCAR USUARIO POR TOKEN
       ==================================================== */
    public function buscarPorToken(string $token): ?array {
        $sql  = "SELECT idUsuario, reset_expires FROM usuario WHERE reset_token = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$token]);

        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res ?: null;
    }

    /* ====================================================
       ACTUALIZAR PASSWORD Y LIMPIAR TOKEN
       ==================================================== */
    public function actualizarPassword(int $idUsuario, string $hash): void {
        $sql = "UPDATE usuario
                SET pass = ?, reset_token = NULL, reset_expires = NULL
                WHERE idUsuario = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$hash, $idUsuario]);
    }
}
?>
