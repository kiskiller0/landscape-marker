<?php

//namespace table;
//use table;

//die('table included successfully!');

define("EQ", '=');
define("GT", '>');
define("GTE", '>=');
define("LT", '<');
define("LTE", '<=');


enum MODE: string
{
    case EQ = '=';
    case GT = '>';
    case GTE = '>=';
    case LT = '<';
    case LTE = '<=';
}

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

    protected $batch = 2;


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
            if (!in_array($key, array_keys($arr))) {
                continue;
            }
            $s = $this->pdo->prepare(sprintf("SELECT * FROM %s WHERE %s = ?", $this->name, $key));
            $s->execute([$arr[$key]]);
            if ($s->fetch()) {
                return ['error' => true, 'msg' => sprintf("value %s: %s is not unique!", $key, $arr[$key])];
            }
        }


        $sql = sprintf(
            "INSERT INTO %s(%s) VALUES(%s)",
            $this->name,
            implode(',', $this->needed_fields),
            implode(',', str_split(str_repeat('?', count($this->needed_fields)), 1))
        );

        $s = $this->pdo->prepare(
            sprintf(
                "INSERT INTO %s(%s) VALUES(%s)",
                $this->name,
                implode(',', $this->needed_fields),
                implode(',', str_split(str_repeat('?', count($this->needed_fields)), 1))
            ));


//        die(json_encode([$sql, $arr]));

        // TODO: add try except here in order to avoid errors!

        // FIX: the current error is the result of arg missmatch, the order of elements in $arr, is not the same in $needed_fields
//        if ($s->execute($arr)) {


//        die(json_encode([$sql, Table::extractArrayFromAssoc($this->needed_fields, $arr)]));

// array_map(extractArrayFromAssoc($this->needed_fields, $arr), $this->needed_fields)
        $orderedArray = Table::extractArrayFromAssoc($this->needed_fields, $arr);
        if ($s->execute($orderedArray)) {
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

    // the only problem is namespace pollution
    // idea! : use namespaces!

    //public function getByUniqueValue($key, $value); // $key is the name of the field ex: getByUniqueValue("id", 5);
    // ex: getByUniqueValue("username", "aymenIsHomo321");

    public function getByUniqueValue(string $key, string $value)
    {
        if (!in_array($key, $this->unique_fields)) {
            return ['error' => true, 'msg' => $key . ' is not a unique key in the table, does it even exist?'];
        }
        if ($key == 'iddd')
            return ['error' => true, 'sql' => sprintf("SELECT * FROM %s WHERE %s = ?", $this->name, $key), 'value' => $value];

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
//        echo sprintf("SELECT * FROM %s WHERE %s %s ?", $this->name, $key, $mode);
//        return;
        $s = $this->pdo->prepare(sprintf("SELECT * FROM %s WHERE %s %s ?", $this->name, $key, $mode));
        $s->execute([$value]);

        $error = true;
        $msg = 'no records fetched!';
        $data = [];

        if ($fetched = $s->fetchAll()) {
            $error = false;
            $msg = 'success';
            $data = $fetched;
        }

        return ['error' => $error, 'msg' => $msg, 'data' => $data];
    }


    public function getByFieldBatched($key, $value, $mode)
    {
//        echo sprintf("SELECT * FROM %s WHERE %s %s ?", $this->name, $key, $mode);
//        return;
        //WHERE %s < ? ORDER BY id DESC LIMIT %
        $s = $this->pdo->prepare(sprintf("SELECT * FROM %s WHERE %s %s ? ORDER BY %s DESC LIMIT %s", $this->name, $key, $mode, $key, $this->batch));
        $s->execute([$value]);

        $error = true;
        $msg = 'no records fetched!';
        $data = [];

        if ($fetched = $s->fetchAll()) {
            $error = false;
            $msg = 'success';
            $data = $fetched;
        }

        return ['error' => $error, 'msg' => $msg, 'data' => $data];
    }

    public static function extractArrayFromAssoc($needed, $assoc)
    {
        // TODO: remove this and use the built in array_intersect
        $result = [];
        foreach ($needed as $key) {
            array_push($result, $assoc[$key]);
        }

        return $result;
    }

    public function getLastInserted($count = null)
    {
        if (!$count) {
            $count = $this->batch;
        }

        $s = $this->pdo->prepare(sprintf("SELECT * FROM %s ORDER BY id DESC LIMIT %d", $this->name, $count));
        $s->execute();

        $error = true;
        $msg = 'no records fetched!';
        $data = [];

        if ($count == 1) {
            $fetched = $s->fetch();
        } else {
            $fetched = $s->fetchAll();
        }
        if ($fetched) {
            $error = false;
            $msg = 'success';
            $data = $fetched;
        }

        return ['error' => $error, 'msg' => $fetched];
    }


    public function getUniqueFields(): array
    {
        return $this->unique_fields;
    }

    public function getNeededFields(): array
    {
        return $this->needed_fields;
    }

    // TODO: create a getByFields function that takes an array of arrays: getByFields(['id', 5, GT], ['username', 'kiskiller0', NEQ] ....);
    // and builds a complex query that returns records according to all the passed conditions
}



