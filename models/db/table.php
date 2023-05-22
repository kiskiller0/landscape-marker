<?php

//namespace table;
//use table;

define("EQ", '=');
define("GT", '>');
define("GTE", '>=');
define("LT", '<');
define("LTE", '<=');

class Table
{
    public $name;
    protected $username = 'root';
    protected $password = 'bader';
    protected $host = 'localhost';
    protected $db = 'learning';
    protected $pdo;
    protected $needed_fields; // an array containing all the fields of the table; //don't add id and date ... (fields that are auto_inserted by db)
    protected $unique_fields;


    public function __construct($name, $needed_fields, $unique_fields)
    {
        $this->name = $name;
        $this->pdo = new PDO(sprintf("mysql:dbname=%s;host=%s", $this->db, $this->host), $this->username, $this->password);
        $this->needed_fields = $needed_fields;
        $this->unique_fields = $unique_fields;
    }

    public function addNew($arr = null)
    {
        if (!$arr || !count($arr)) {
            return ['error' => true, 'msg' => 'do no send me empty arrays!'];
        }
        // this check should be not be done here?
        foreach ($this->needed_fields as $key) {
            // the presence of values should be tested in the api endpoint that receives the post request?
            if (!in_array($key, array_keys($arr)) || trim($arr[$key]) == '') {
                return ['error' => true, 'msg' => sprintf('required field %s is missing!', $key)];
            }
        }

        // checking if its unique fields clash with existing fields
        foreach ($this->unique_fields as $key) {
            $s = $this->pdo->prepare(sprintf("SELECT * FROM %s WHERE %s = ?", $this->name, $key));
            $s->execute([$arr[$key]]);
            if ($s->fetch()) {
                return ['error' => true, 'msg' => sprintf("value %s: %s is not unique!", $key, $arr[$key])];
            }
        }

        $s = $this->pdo->prepare(
            sprintf(
                "INSERT INTO %s(%s) VALUES(%s)",
                $this->name,
                implode(',', $this->needed_fields),
                implode(',', str_split(str_repeat('?', count($this->needed_fields)), 1))
            ));

        if ($s->execute($arr)) {
            return ['error' => false, 'msg' => sprintf("recorde: %s \ncreated successfully", json_encode($arr))];
        } else {
            return ['error' => true, 'msg' => 'something happened, debug your code!'];
        }
    }

    //public function getOlderThan($date)
    //public function getOlderThanOrEqual($date)
    //public function getNewerThan($date)
    //public function getNewerThanOrEqual($date)
    //public function getByUniqueField($field)
    //public function getLastInsertedId()
    // TODO : think of a more generalized way of passing this part: older/bigger than, or equal ... like passing flags
    //public function getIdBiggerThan
    // => becomes: getById(4, BIGGER_THAN);
    // => becomes: getById(4, EQUAL); // this slightly alters the return value from $s->fetchAll, to $s->fetch
    // => becomes: getById(4, BIGGER_THAN_EQUAL);
    // => becomes: getById(4, SMALLER_THAN);
    // => becomes: getById(4, SMALLER_THAN_EQUAL);

    // the only problem is namespace pollution
    // idea! : use namespaces!

    //public function getByUniqueValue($key, $value); // $key is the name of the field ex: getByUniqueValue("id", 5);
    // ex: getByUniqueValue("username", "aymenIsHomo321");

    public function getByUniqueValue(string $key, string $value)
    {
        if (!in_array($key, $this->unique_fields)) {
            return ['error' => true, 'msg' => $key . ' is not a unique key in the table, does it even exist?'];
        }

        // checking if its unique fields clash with existing fields
        $s = $this->pdo->prepare(sprintf("SELECT * FROM %s WHERE %s = ?", $this->name, $key));
        $s->execute([$value]);
        $record = $s->fetch();

        $error = false;

        if (!$record) {
            $error = true;
            $msg = 'record does not exist';
        } else {
            $msg = $record;
        }

        return ['error' => $error, 'msg' => $msg];
    }

    public function getByField($key, $value, $mode)
    {
        echo sprintf("SELECT * FROM %s WHERE %s %s ?", $this->name, $key, $mode);
        return;
        $s = $this->pdo->prepare(sprintf("SELECT * FROM %s WHERE %s %s ?", $this->name, $key, $mode));
        $s->execute([$value]);
    }
}

//
//$comment = new Table('comment');
//var_dump($comment->getUniqueId(2));

$testTable = new Table('comment', ['username', 'email', 'password', 'first_name', 'last_name'], ['username', 'email']);
var_dump(
    $testTable->addNew()
);

$testTable->getByField('age', '16', GTE);