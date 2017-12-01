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

    function count($table) {
        $query = "SELECT COUNT(*) FROM {$table}";
        $res = $this->connection->query($query);
        return $res->fetchColumn();
    }

    function insert($query, $bind)
    {
        if ($stmt = $this->connection->prepare($query)) {
            $stmt->execute($bind);
            $rowsAffected = $stmt->rowCount();
            $stmt->closeCursor();
            return array('id' => $this->connection->lastInsertId(), 'rowsAffected' => $rowsAffected);
        }
    }

    function fetch($query, $bind) {
        if ($stmt = $this->connection->prepare($query)) {
            $stmt->execute($bind);
            $out = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $out;
        }
    }

    function fetchAll($query, $bind) {
        if ($stmt = $this->connection->prepare($query)) {
            $stmt->execute($bind);
            $out = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $out;
        }
    }

    function delete($query, $bind) {
        if ($stmt = $this->connection->prepare($query)) {
            $stmt->execute($bind);
            $stmt->closeCursor();
        }
    }

}