<?php

class Database {
    
    private static $pdo;
    
    private function __construct(){   

    }

    public static function getInstance()
    {
        if (!isset(self::$pdo)){
            try {
                self::$pdo =  new \PDO ('mysql:host=127.0.0.1;dbname=chat;charset=utf8','user','123456',[
                        \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8',
                        \PDO::ATTR_EMULATE_PREPARES => false,
                        \PDO::NULL_TO_STRING => true,
                        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
                    ]);                

            } catch(\PDOException $e){
                echo $e->getMessage();
            }
        }  
		
		return self::$pdo;
    }
}