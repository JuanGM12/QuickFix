<?php

class base_datos {

    protected $conn;
    protected $result;
    protected $record;
    protected $db;
    protected $port;
    protected $query_count;

    public function initial_database() {
        global $DB;
        $this->query_count = 0;
    }

    public function connect() {
        global $DB;
        $this->conn = mysqli_connect($DB['host'], $DB['user'], $DB['pass'], $DB['dbName']);
        if($this->conn->connect_error) {
            $response = $this->sql_error("Error de conexión");
        }else {
            $response = mysqli_set_charset($this->conn, "utf8");
        }
        return $response;
    }

    public function query($query_string $funcion) {
        $this->result = mysqli_query($this->conn, $query_string);
        $this->query_count++;
        if(!$this->result) {
            $mensaje = "Error en el query ($query_string) \n En la clase y función ($funcion) \n";
            $response = $this->sql_error($mensaje);
        }
        else {
            $response = $this->result;
        }
        return $response;
    }

    public function fetch_array($query_id) {
        $this->record = $query_id->fetch_array(MYSQLI_ASSOC);
        return $this->record;
    }

    public function num_rows($query_id) {
        return ($query_id) ? mysqli_num_fields($query_id) : 0;
    }

}