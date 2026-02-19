<?php

class Database {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $db_name = DB_NAME;

    private $dbh; // database handler
    private $stmt; // untuk querynya

    public function __construct()
    {
        // data source name
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->db_name;

        $option = [
            PDO::ATTR_PERSISTENT => true, // untuk menjaga koneksi databasenya
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        try {
            $this->dbh = new PDO($dsn, $this->user,  $this->pass, $option);
        } catch(PDOException $e){
            die($e->getMessage());
        }
    }

    public function query($query)
    {
        $this->stmt = $this->dbh->prepare($query);
    }

    public function bind($param, $value, $type = null)
    {
        if(is_null($type)){
            switch(true){
                case is_int($value) :
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value) :
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value) :
                    $type = PDO::PARAM_NULL;
                    break;
                default :
                    $type = PDO::PARAM_STR;
            }
        }

        $this->stmt->bindValue($param, $value, $type);
    }

    public function execute()
    {
        try {
            return $this->stmt->execute();
        } catch (PDOException $e) {
            // Simpan pesan exception agar bisa diambil oleh pemanggil
            $this->lastExceptionMessage = $e->getMessage();
            error_log('Database execute error: ' . $e->getMessage());
            return false;
        }
    }

    public function resultSet()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function single()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function rowCount()
    {
        return $this->stmt->rowCount();
    }

    public function lastInsertId()
    {
        return $this->dbh->lastInsertId();
    }

    public function errorInfo() 
    {
    return $this->dbh->errorInfo();
    }

    public function getError() {
        if ($this->stmt) {
            $error = $this->stmt->errorInfo();
            if (isset($error[0]) && $error[0] !== '00000') {
                return "SQLSTATE: " . $error[0] . " - Error: " . ($error[2] ?? 'Unknown');
            }
        }
        return null;
    }

    public function getLastQuery() {
        return $this->stmt->queryString;
    }
}

