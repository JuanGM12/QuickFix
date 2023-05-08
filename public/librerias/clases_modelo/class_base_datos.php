<?php

class base_datos {

    protected $conn;
    protected $result;
    protected $record;
    protected $db;
    protected $port;
    protected $query_count;

    //Funcion inicial de la clase
    public function initial_database() {
        global $DB;
        $this->query_count = 0;
    }

    //Conectarse a la base de datos
    public function connect() {
        global $DB;
        $this->conn = mysqli_connect($DB['host'], $DB['user'], $DB['pass'], $DB['dbName']);
        if ($this->conn->connect_error) {
            $response = $this->sql_error("Error de conexion");
        } else {
            $response = mysqli_set_charset($this->conn, "utf8");
        }
        return $response;
    }

    //Ejecutar Querys en la base de datos
    public function query($query_string, $funcion) {
        $this->result = mysqli_query($this->conn, $query_string);
        $this->query_count++;
        if (!$this->result) {
            $mensaje = "Error en el query ($query_string) \n En la clase y funcion ($funcion) \n";
            $response = $this->sql_error($mensaje);
        } else {
            $response = $this->result;
        }
        return $response;
    }

    public function fetch_array($query_id) {
        # $this->record = mysqli_fetch_array($query_id, MYSQLI_ASSOC);
        $this->record = $query_id->fetch_array(MYSQLI_ASSOC);
        return $this->record;
    }

    public function num_rows($query_id) {
        return ($query_id) ? mysqli_num_rows($query_id) : 0;
    }

    public function num_fields($query_id) {
        return ($query_id) ? mysqli_num_fields($query_id) : 0;
    }

    public function free_result($query_id) {
        return mysqli_free_result($query_id);
    }

    public function affected_rows() {
        return mysqli_affected_rows($this->conn);
    }

    public function last_insert() {
        return mysqli_insert_id($this->conn);
    }

    public function close_db() {
        if ($this->conn) {
            $response = mysqli_close($this->conn);
        } else {
            $response = false;
        }
        return $response;
    }


    public function sql_error($mensaje) {
        global $DB;
        $descripcion = mysqli_error($mensaje);
        $numero = mysqli_error($mensaje);

        $error = "Error MySQL : $mensaje\n";
        $error .= "Numero Error: $numero $descripcion\n";
        $error .= "Fecha       : " . date("D, F j, Y H:i:s") . "\n";
        $error .= "IP          : " . getenv("REMOTE_ADDR") . "\n";
        $error .= "Navegador   : " . getenv("HTTP_USER_AGENT") . "\n";
        $error .= "Referencia  : " . getenv("HTTP_REFERER") . "\n";
        $error .= "PHP Version : " . PHP_VERSION . "\n";
        $error .= "OS          : " . PHP_OS . "\n";
        $error .= "Server      : " . getenv("SERVER_SOFTWARE") . "\n";
        $error .= "Server Name : " . getenv("SERVER_NAME") . "\n";
        $error .= "Script Name : " . getenv("SCRIPT_NAME") . "\n";

        $lstrRutaLog = $DB["rutaLog"];

        return false;
    }
}
