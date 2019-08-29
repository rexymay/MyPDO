<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'dbname');
define('DB_USER', 'dbuser');
define('DB_PASS', 'dbpass');
define('DB_CHAR', 'utf8');

class MyPDO
{
    protected static $instance;
    protected $pdo;

    public function __construct() {
        $opt  = array(
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_EMULATE_PREPARES   => FALSE,
        );
        $dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset='.DB_CHAR;
        $this->pdo = new PDO($dsn, DB_USER, DB_PASS, $opt);
    }

    # a classical static method to make it universally available
    public static function instance()
    {
        if (self::$instance === null)
        {
            self::$instance = new self;
        }
        return self::$instance;
    }

    # a proxy to native PDO methods
    public function __call($method, $args)
    {
        return call_user_func_array(array($this->pdo, $method), $args);
    }

    # a helper function to run prepared statements smoothly
    public function run($sql, $args = [])
    {
        if (!$args)
        {
            return $this->query($sql);
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($args);
        return $stmt;
    }

    # Get one variable
    function get_var($sql)
    {
        $debug = 0;
        $result = $this->run($sql)->fetch(PDO::FETCH_COLUMN,0);
        if($debug) var_dump($result);
        return $result;
    }

    # Get results from a query
    function get_row($sql)
    {
        $debug = 0;
        $result = $this->run($sql)->fetch();
        if($debug) var_dump($result);
        else return $result;
    }

    # Get results from a query
    function get_results($sql)
    {
        $debug = 0;
        $result = $this->run($sql)->fetchAll();
        if($debug) var_dump($result);
        else return $result;
    }
}
?>