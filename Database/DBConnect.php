<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DBConnect
 *
 * @author MSI
 */
class DBConnect extends PDO
{
    private $type = DB_TYPE;
    
    private $host = DB_HOST;
    
    private $username = DB_USERNAME;
    
    private $password = DB_PASSWORD;
    
    private $dbName = DB_DBNAME;
    
    private $port = DB_PORT;
    
    private $charset = 'utf-8';
    
    private $stmt;
    
    public function __construct() 
    {
        $this->host = DB_HOST;
        $this->dbName = DB_DBNAME;
        $this->username = DB_USERNAME;
        $this->password = DB_PASSWORD;
        $this->type = DB_TYPE;
        $this->port = DB_PORT;
        
        $this->connect();
    }
    
    protected function connect()
    {
        try {
            $defaultOptions = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ];
            
            $options = $this->charset ? array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . $this->charset) : NULL;
            
            $options = array_merge($defaultOptions, $options);
            
            $dsn = $this->type . ':host=' . $this->host . ';port=' . $this->port . ';dbname=' . $this->dbName;
            
            parent::__construct($dsn, $this->username, $this->password, $options);
            
        } catch (Exception $ex) {
            echo "Error {$ex->getMessage()}";
        }
    }
    
    public function query($query)
    {
        $this->stmt = parent::prepare($query);
    }
    
    public function execute()
    {
        $this->stmt->execute();
    }
    
    public function bind($param, $value, $type = NULL)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
                    break;
            }
        }
        
        $this->stmt->bindValue($param, $value, $type);
    }
    
    public function single()
    {
        $this->execute();
        return $this->stmt->fetch();
    }
    
    public function resultSet()
    {
        $this->execute();
        return $this->stmt->fetchAll();
    }
    
    public function lastInsertId()
    {
        return parent::lastInsertId() ? parent::lastInsertId() : true;
    }
}
