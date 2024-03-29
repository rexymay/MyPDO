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
    /* 
     * $db = new MyPDO();
     * $name = $db->get_var('SELECT firstname FROM admin WHERE id = ?',[$id]);
     */
    function get_var($sql, $args = [])
    {
        $debug = 0;
        $result = $this->run($sql, $args)->fetch(PDO::FETCH_COLUMN,0);
        if($debug) var_dump($result);
        return $result;
    }

    # Get one row from a query
    /* 
     * $db = new MyPDO();
     * $data = $db->get_row('SELECT * FROM admin WHERE id = ?',[$id]);
     */
    function get_row($sql, $args = [])
    {
        $debug = 0;
        $result = $this->run($sql, $args)->fetch();
        if($debug) var_dump($result);
        else return $result;
    }

    # Get one or more rows from a query
    /* 
     * $db = new MyPDO();
     * $data = $db->get_results('SELECT * FROM admin');
     */
    function get_results($sql, $args = [])
    {
        $debug = 0;
        $result = $this->run($sql, $args)->fetchAll();
        if($debug) var_dump($result);
        else return $result;
    }
}
?>