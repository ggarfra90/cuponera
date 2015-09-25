<?php

/**
 * Description of ConnectionMSSQL
 * Clase estatica que me permite gestionar las conexiones con BD Sql Server
 *
 * @author CHL007
 */
class ConnectionMSSQL {
    private $myServer = "192.168.1.34";//ip
    private $myUser = "sa";
    private $myPass = "gclv";
    private $myDB = "NETAFIMPER";
    
    private $conn;
    private $rs;
    
    public function __construct() {
        $this->conectar();
    }
    
    public function conectar(){
        try {
            //create an instance of the  ADO connection object
            $this->conn = new COM("ADODB.Connection")or die("Cannot start ADO");
            //define connection string, specify database driver
            $connStr = "PROVIDER=SQLOLEDB;SERVER=".$this->myServer.";UID=".$this->myUser.";PWD=".$this->myPass.";DATABASE=".$this->myDB;
            //open the connection to the database
            $this->conn->open($connStr);
        } catch (PDOException  $e) {
            throw new ModeloException("No fue posible realizar la conexión con la base de datos");
        }
    }
    
    public function ejecutar($sql){
        //execute the SQL statement and return records
        $this->rs = $this->conn->execute($sql);
        return $this->rs;
    }
    
    public function close(){
        $this->rs->Close();
        $this->conn->Close();
    }
}
