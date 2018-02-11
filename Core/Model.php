<?php

namespace Core;

use PDO;
use App\Config;

/**
 * Base model
 *
 * PHP version 7.0
 */
abstract class Model
{

    /**
     * Get the PDO database connection
     *
     * @return mixed
     */

    protected static $table = '';


    protected static function getDB()
    {
        static $db = null;

        if ($db === null) {
            $dsn = 'mysql:host=' . Config::DB_HOST . ';dbname=' . Config::DB_NAME . ';charset=utf8';
            $db = new PDO($dsn, Config::DB_USER, Config::DB_PASSWORD);

            // Throw an Exception when an error occurs
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return $db;
    }

    public static function where($column,$condition,$value){
        $query = 'SELECT * FROM '.static::$table.' WHERE '.$column.' '.$condition.' '.$value;
        return self::execute($query);

    }

    public static function execute($query){
        $db = static::getDB();
//        $query = $db->prepare($query);
        $stmt = $db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function save($query){
        $db = static::getDB();
        $stmt = $db->query($query);

        return true;
    }
}
