<?php

/**
 * @author Sascha Bröning <sascha.broening@gmail.com>
 * @license LGPL-3.0
 * @copyright (c) 2014, Sascha Bröning
 * @version v 1.0 2014-08-28
 * @todo too much :)
 */
class Database
{

    /**
     * Databasehandler
     * 
     * @var string
     */
    private $dbh;

    /**
     * Error Message Container
     * 
     * @var string
     */
    private $error;

    /**
     * Statement
     * 
     * @var string
     */
    private $stmt;

    /**
     *
     * @method Constructor
     * @param string $host            
     * @param string $user            
     * @param string $pass            
     * @param string $dbname            
     */
    public function __construct($host, $user, $pass, $dbname)
    {
        $dsn = 'mysql:host=' . $host . ';dbname=' . $dbname;
        
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
        );
        
        try {
            $this->dbh = new PDO($dsn, $user, $pass, $options);
        } 

        catch (PDOException $e) {
            $this->error = $e->getMessage();
        }
    }

    /**
     *
     * @method Prepare Query
     * @param string $query            
     */
    public function query($query)
    {
        $this->stmt = $this->dbh->prepare($query);
    }

    /**
     *
     * @method Bind Values
     * @param string $param            
     * @param string $value            
     * @param int $type            
     */
    public function bind($param, $value, $type = null)
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
            }
        }
        
        $this->stmt->bindValue($param, $value, $type);
    }

    /**
     *
     * @method Bind Array
     * @param array $param_array            
     */
    public function bind_all($param_array)
    {
        array_map(array(
            $this,
            'bind'
        ), array_keys($param_array), array_values($param_array));
    }

    /**
     *
     * @method Execute Statement
     * @return bool
     */
    public function execute()
    {
        return $this->stmt->execute();
    }

    /**
     *
     * @method Fetch Multiple Result
     * @return array
     */
    public function resultset()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     *
     * @method Fetch Single Result
     * @return array
     */
    public function single()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     *
     * @method Return Rowcount
     * @return int
     */
    public function rowCount()
    {
        return $this->stmt->rowCount();
    }

    /**
     *
     * @method Return Last Insert ID
     * @return int
     */
    public function lastInsertId()
    {
        return $this->dbh->lastInsertId();
    }

    /**
     *
     * @method Begin Transaction
     * @return bool
     */
    public function beginTransaction()
    {
        return $this->dbh->beginTransaction();
    }

    /**
     *
     * @method Commit Transaction
     * @return bool
     */
    public function endTransaction()
    {
        return $this->dbh->commit();
    }

    /**
     *
     * @method Cancel Transaction
     * @return bool
     */
    public function cancelTransaction()
    {
        return $this->dbh->rollBack();
    }

    /**
     *
     * @method Debug Params
     * @return string
     */
    public function debugDumpParams()
    {
        return $this->stmt->debugDumpParams();
    }
}