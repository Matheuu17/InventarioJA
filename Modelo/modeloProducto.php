<?php
require_once __DIR__ . "/conexion.php";

class modeloProducto {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->conectar(); // Ahora es PDO
    }

    /* ===========================
        OBTENER USUARIOS
    ============================ */
    public function obtenerUsuarios() {
        $sql = "SELECT idUsuario, nombreU FROM usuario ORDER BY nombreU";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ===========================
        OBTENER PRODUCTOS
    ============================ */
    public function obtenerProductos() {
        $sql = "SELECT idProducto, nombreP, descripcionP, stock, fechaI FROM producto";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ===========================
        AGREGAR PRODUCTO + MOVIMIENTO
    ============================ */
    public function agregarProducto($idUsuario, $nombreP, $descripcionP, $stock) {
        try {
            $this->db->beginTransaction();

            // Insertar producto
            $sql = "INSERT INTO producto (idUsuario, nombreP, descripcionP, stock)
                    VALUES (?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$idUsuario, $nombreP, $descripcionP, $stock]);

            $idProducto = $this->db->lastInsertId();

            // Registrar movimiento
            $sql2 = "INSERT INTO movimientos (tipo, idUsuario, idProducto, cantidad)
                     VALUES ('entrada', ?, ?, ?)";
            $stmt2 = $this->db->prepare($sql2);
            $stmt2->execute([$idUsuario, $idProducto, $stock]);

            $this->db->commit();
            return $idProducto;

        } catch (PDOException $e) {
            $this->db->rollBack();
            return false;
        }
    }

    /* ===========================
        ACTUALIZAR PRODUCTO
    ============================ */
    public function actualizarProducto($idProducto, $nombreP, $descripcionP, $stock) {
        $sql = "UPDATE producto 
                SET nombreP=?, descripcionP=?, stock=?
                WHERE idProducto=?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nombreP, $descripcionP, $stock, $idProducto]);
    }

    /* ===========================
        ELIMINAR PRODUCTO + MOVIMIENTOS
    ============================ */
    public function eliminarProducto($idProducto) {
        try {
            $this->db->beginTransaction();

            // Borrar movimientos
            $sql = "DELETE FROM movimientos WHERE idProducto=?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$idProducto]);

            // Borrar producto
            $sql2 = "DELETE FROM producto WHERE idProducto=?";
            $stmt2 = $this->db->prepare($sql2);
            $stmt2->execute([$idProducto]);

            $this->db->commit();
            return true;

        } catch (PDOException $e) {
            $this->db->rollBack();
            return false;
        }
    }

    /* ===========================
        OBTENER STOCK
    ============================ */
    public function obtenerStock($idProducto) {
        $sql = "SELECT stock FROM producto WHERE idProducto=?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idProducto]);
        return $stmt->fetchColumn() ?: 0;
    }

    /* ===========================
        REGISTRAR SALIDA
    ============================ */
    public function registrarSalida($tipo, $idUsuario, $idProducto, $cantidad) {
        try {
            $this->db->beginTransaction();

            // Registrar movimiento
            $sql = "INSERT INTO movimientos (tipo, idUsuario, idProducto, cantidad)
                    VALUES (?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$tipo, $idUsuario, $idProducto, $cantidad]);

            // Actualizar stock
            $sql2 = "UPDATE Producto SET stock = stock - ? WHERE idProducto=?";
            $stmt2 = $this->db->prepare($sql2);
            $stmt2->execute([$cantidad, $idProducto]);

            $this->db->commit();
            return true;

        } catch (PDOException $e) {
            $this->db->rollBack();
            return false;
        }
    }

    /* ===========================
        REGISTRAR DEVOLUCIÓN
    ============================ */
    public function registrarDevolucion($idUsuario, $idProducto, $cantidad) {
        try {
            $this->db->beginTransaction();

            // Movimiento devolución
            $sql = "INSERT INTO movimientos (tipo, idUsuario, idProducto, cantidad)
                    VALUES ('devolucion', ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$idUsuario, $idProducto, $cantidad]);

            // Sumar al stock
            $sql2 = "UPDATE producto SET stock = stock + ? WHERE idProducto=?";
            $stmt2 = $this->db->prepare($sql2);
            $stmt2->execute([$cantidad, $idProducto]);

            $this->db->commit();
            return true;

        } catch (PDOException $e) {
            $this->db->rollBack();
            return false;
        }
    }
}
?>
