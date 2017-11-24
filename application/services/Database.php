<?php


class Database
{
    protected static $self;
    protected $connection;
    public $test;

    # Removing protected for testing purposes
    public function __construct($host, $user, $password, $db)
    {
        $dsn = "mysql:dbname={$db};host={$host}";
        $this->connection = new PDO($dsn, $user, $password);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function getInstance()
    {
        if (empty(static::$self)) {
            static::$self = new Database(
                getenv('DB_HOST'),
                getenv('DB_USER'),
                getenv('DB_PASSWORD'),
                getenv('DB_DB')
            );
        }
        return static::$self;
    }


    function insert($query, $bind)
    {
        if ($stmt = $this->connection->prepare($query)) {
            $stmt->execute($bind);
            return $this->connection->lastInsertId();
        }
    }

    function fetch($query, $bind) {
        if ($stmt = $this->connection->prepare($query)) {
            $stmt->execute($bind);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }

    function delete($query, $bind) {
        if ($stmt = $this->connection->prepare($query)) {
            $stmt->execute($bind);
        }
    }

}