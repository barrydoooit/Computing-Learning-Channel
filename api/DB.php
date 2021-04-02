<?php
class DB
{
    private $pdo;
    public function __construct($host, $dbname, $username, $password)
    {
        $pdo = new PDO('mysql:host=' . $host . ';dbname=' . $dbname . ';charset=utf8', $username, $password); //'mysql:host=127.0.0.1;dbname=blog;charset=utf8', 'root', ''
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo = $pdo;
    }

    public function query($query, $params = array())
    {
        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute($params);
        if (explode(' ', $query)[0] == "SELECT") {
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }
        return $result;
    }

    public function select($attrs, $tables, $conditions)
    {
        $sql = "SELECT";
        foreach ($attrs as $attr) {
            $sql = $sql . " $attr,";
        }
        $sql = substr($sql, 0, strlen($sql) - 1);
        $sql .= " FROM";
        foreach ($tables as $table) {
            $sql = $sql . " $table,";
        }
        $sql = substr($sql, 0, strlen($sql) - 1);
        if (count($conditions)) {
            $sql .= " WHERE";
            $i = 0;
            foreach ($conditions as $key => $value) {
                if ($i === 0) {
                    $sql = $sql . " $key='$value'";
                } else {
                    $sql = $sql . " AND $key='$value'";
                }
                $i++;
            }
        }
       
        return $this->query($sql);
    }

    public function insert($table, $params)
    {
        $columns = implode(",", array_keys($params));
        $data =  '';
        foreach ($params as $key => $value) {
            $data = $data . '\'' . $value . '\'' . ',';
        }
        $data = substr($data, 0, strlen($data) - 1);
        $sql = 'INSERT INTO ' . $table . ' (' . $columns . ') VALUES (' . $data . ')';
        $this->query($sql);
        return $this->query('SELECT LAST_INSERT_ID()')[0]['LAST_INSERT_ID()'];
    }

    public function delete($table, $conditions)
    {
        $sql = "DELETE FROM $table WHERE";
        $i = 0;
        foreach ($conditions as $key => $value) {
            if ($i === 0) {
                $sql = $sql . " $key=$value";
            } else {
                $sql = $sql . " AND $key=$value";
            }
            $i++;
        }

        $this->query($sql);
    }

    public function update($table, $conditions, $newValue)
    {
        $sql = "UPDATE $table SET";
        foreach ($newValue as $key => $value) {
            $sql = $sql . " $key=$value,";
        }
        $sql = substr($sql, 0, strlen($sql) - 1);
        $sql .= " WHERE";
        $i = 0;
        foreach ($conditions as $key => $value) {
            if ($i === 0) {
                $sql = $sql . " $key=$value";
            } else {
                $sql = $sql . " AND $key=$value";
            }
            $i++;
        }
        $this->query($sql);
        
    }
    public function display($data)
    {
        echo "<pre>", print_r($data, true), "</pre>";
        die();
    }
}
