<?php
require_once "conexion.php";

class modeloMovimientos {

    private $db;

    public function __construct() {
        $conexion = new Database();
        $this->db = $conexion->conectar(); // PDO
    }

    // Obtener todos los movimientos
    public function obtenerMovimientos() {
        $sql = "SELECT m.idMovimiento, m.tipo,
                       u.idUsuario, u.nombreU,
                       p.nombreP, m.cantidad, m.fechaM
                FROM movimientos m
                JOIN usuario u ON m.idUsuario = u.idUsuario
                JOIN producto p ON m.idProducto = p.idProducto
                ORDER BY m.fechaM DESC";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener movimientos por usuario
    public function obtenerMovimientosPorUsuario($idUsuario) {
        $sql = "SELECT m.idMovimiento, m.tipo,
                       u.idUsuario, u.nombreU,
                       p.nombreP, m.cantidad, m.fechaM
                FROM movimientos m
                JOIN usuario u ON m.idUsuario = u.idUsuario
                JOIN producto p ON m.idProducto = p.idProducto
                WHERE m.idUsuario = :id
                ORDER BY m.fechaM DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([":id" => $idUsuario]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Movimientos filtrados
    public function obtenerMovimientosFiltrados($fechaInicio = null, $fechaFin = null, $idProducto = null, $idUsuario = null) {

        $sql = "SELECT m.idMovimiento, m.idProducto, m.tipo, m.cantidad, m.fechaM,
                       p.nombreP, u.nombreU
                FROM movimientos m
                JOIN producto p ON m.idProducto = p.idProducto
                JOIN usuario u ON m.idUsuario = u.idUsuario
                WHERE 1=1";

        $params = [];

        if (!empty($fechaInicio)) {
            $sql .= " AND m.fechaM >= :inicio";
            $params[":inicio"] = $fechaInicio . " 00:00:00";
        }

        if (!empty($fechaFin)) {
            $sql .= " AND m.fechaM <= :fin";
            $params[":fin"] = $fechaFin . " 23:59:59";
        }

        if (!empty($idProducto)) {
            $sql .= " AND m.idProducto = :prod";
            $params[":prod"] = $idProducto;
        }

        if (!empty($idUsuario)) {
            $sql .= " AND m.idUsuario = :user";
            $params[":user"] = $idUsuario;
        }

        $sql .= " ORDER BY m.fechaM DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
