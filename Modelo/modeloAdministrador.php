<?php
require_once "conexion.php";

class modeloAdministrador {

    private $db;

    public function __construct() {
        $conexion = new Database();
        $this->db = $conexion->conectar(); // PDO
    }

    // Crear usuario
    public function createUser($nombreU, $apellidoU, $correo, $pass) {
        $hashedPass = password_hash($pass, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuario (nombreU, apellidoU, correo, pass) 
                VALUES (:nombreU, :apellidoU, :correo, :pass)";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ":nombreU"   => $nombreU,
            ":apellidoU" => $apellidoU,
            ":correo"    => $correo,
            ":pass"      => $hashedPass
        ]);
    }

    // Read usuario
    public function readUser() {
        $sql = "SELECT idUsuario, nombreU, apellidoU, correo, pass, esAdmin FROM usuario";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Actualizar usuario
    public function updateUser($idUsuario, $nombreU, $apellidoU, $correo, $pass) {
        // Si envían password nuevo → se actualiza
        if (!empty($pass)) {
            $hashed = password_hash($pass, PASSWORD_DEFAULT);
            $sql = "UPDATE usuario 
                    SET nombreU=:nombreU, apellidoU=:apellidoU, correo=:correo, pass=:pass 
                    WHERE idUsuario=:id";
            $params = [
                ":nombreU" => $nombreU,
                ":apellidoU" => $apellidoU,
                ":correo" => $correo,
                ":pass" => $hashed,
                ":id" => $idUsuario
            ];
        } 
        // Si NO envían password → se deja igual
        else {
            $sql = "UPDATE usuario 
                    SET nombreU=:nombreU, apellidoU=:apellidoU, correo=:correo
                    WHERE idUsuario=:id";
            $params = [
                ":nombreU" => $nombreU,
                ":apellidoU" => $apellidoU,
                ":correo" => $correo,
                ":id" => $idUsuario
            ];
        }

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    // Eliminar usuario
    public function deleteUser($idUsuario) {
        $this->db->beginTransaction();
        try {
            $sqlMov = "DELETE FROM movimientos WHERE idUsuario = :id";
            $stmtMov = $this->db->prepare($sqlMov);
            $stmtMov->execute([":id" => $idUsuario]);
            
            $sqlUser = "DELETE FROM usuario WHERE idUsuario = :id";
            $stmtUser = $this->db->prepare($sqlUser);
            $stmtUser->execute([":id" => $idUsuario]);
            
            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Error deleteUser: " . $e->getMessage());
            return false;
        }
    }
}
?>
