# MyPDO Wrapper Class

## Description

The current version of ezsql is no longer easy to use. The older versions will not work on PHP 7 and up. If your application used the older versions of ezsql and you want it to run on PHP 7+, this is the solution.

## Usage

```php
include_once "mypdo.class.php";

$db = new MyPDO();
$id = 1;

# Get one value 
$name = $db->get_var('SELECT firstname FROM admin WHERE id = ?',[$id]);

# Get one row
$data = $db->get_row('SELECT * FROM admin WHERE id = ?',[$id]);

# Get one or more rows
$data = $db->get_results('SELECT * FROM admin');
```

### OOP Example (Dependency Injection)

```php
include_once "mypdo.class.php";

class Users
{
    protected $db;

    protected $data;

    public function __construct(MyPDO $db)
    {
        $this->db = $db;
    }

    public function find($id)
    {        
        return $this->data = $this->db->get_row("SELECT * FROM users WHERE id = ?", [$id]);
    }
}

$id   = 1;
$db   = new MyPDO();
$user = new Users($db);

$result = $user->find($id);
```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)