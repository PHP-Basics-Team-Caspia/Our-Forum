<?php

/**
 * Mysql database class - only one connection alowed.
 *
 * DataBase description.
 *
 * @version 1.0
 * @author Plamen
 */
class Database
{
    private $connection;
	private static $_instance; //The single instance
	private $host = "host";
	private $username = "name";
	private $pass = "pass";
    private $database="base";

     /**
     *Get an instance of database
     *@return Instance
     */
     public static function getInstance(){
         if(!self::$_instance){
             self::$_instance=new self;
         }
         return self::$_instance;
     }
    //Set parameters for Databese
     public function setParameters($host,$username,$pass,$databace){
         $this->host=$host;
         $this->username=$username;
         $this->pass=$pass;
         $this->database=$databace;         
     }
    //Constructor
     private function __construct(){
         
	}
     // Magic method clone is empty to prevent duplication of connection
     private function __clone() { }
    /**
     *Get connection
     *@return Connection
     */
    public function getConnection(){
        $this->connection=new mysqli($this->host,$this->username,$this->pass,$this->database);
        // Error handling
		if(mysqli_connect_error()) {
			trigger_error("Failed to connect to MySQL: " . mysql_connect_error(),
				 E_USER_ERROR);
		}
        else{
            return $this->connection;
        }
        
    }
     
}
