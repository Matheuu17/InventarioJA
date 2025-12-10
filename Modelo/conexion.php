    <?php
    class Database {
        private $host;
        private $dbname;
        private $user;
        private $pass;
        private $port;
        public $conn;

        public function __construct() {
            // Render / AWS usan variables de entorno
            $this->host   = getenv("DB_HOST") ?: "localhost";
            $this->dbname = getenv("DB_NAME") ?: "inventario";
            $this->user   = getenv("DB_USER") ?: "root";
            $this->pass   = getenv("DB_PASS") ?: "";
            $this->port   = getenv("DB_PORT") ?: "3307";
        }
    
        public function conectar() {
            try {
                $this->conn = new PDO(
                    "mysql:host={$this->host};dbname={$this->dbname};port={$this->port};charset=utf8",
                    $this->user,
                    $this->pass
                );
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            } catch (PDOException $e) {
                die("Error de conexión: " . $e->getMessage());
            }

            return $this->conn;
        }
    }
?>