<?php
class DB
{
    private static function connect()
    {
        $pdo = new PDO('mysql:host=mysql.comp.polyu.edu.hk;dbname=clc;charset=utf8', 'clc', 'cloterra');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }

    public static function query($query, $params = array())
    {
        $stmt = self::connect()->prepare($query);
        $stmt->execute($params);
        if (explode(' ', $query)[0] == "SELECT") {
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }
    }

    public static function select($attrs, $tables, $conditions){
        $sql = "SELECT";

        foreach ($attrs as $attr){
            $sql = $sql . " $attr,"; 
        }
        $sql = substr($sql, 0, strlen($sql)-1);
        $sql .= " FROM";
        foreach ($tables as $table){
            $sql = $sql . " $table,"; 
        }
        $sql = substr($sql, 0, strlen($sql)-1);
        $sql .= " WHERE";
        $i = 0;
        foreach($conditions as $key=>$value){
            if ($i === 0){
                $sql = $sql . " $key=$value";
            } else{
                $sql = $sql . " AND $key=$value";
            }
            $i++;
        }     
        return DB::query($sql);

    }

    public static function insert($table, $params)
    {
        $columns = implode(",", array_keys($params));
        $data =  '';
        foreach ($params as $key => $value) {
            $data = $data . '\'' . $value . '\'' . ',';
        }
        $data = substr($data, 0, strlen($data)-1);
        $sql = 'INSERT INTO ' . $table . '(' . $columns . ') VALUES (' . $data . ')';
        DB::query($sql);
    }

    public static function delete($table, $conditions){
        $sql = "DELETE FROM $table WHERE";
        $i = 0;
        foreach($conditions as $key=>$value){
            if ($i === 0){
                $sql = $sql . " $key=$value";
            } else{
                $sql = $sql . " AND $key=$value";
            }
            $i++;
        }     
       
        DB::query($sql);
    }

    public static function update($table, $conditions, $newValue){
        $sql = "UPDATE $table SET";
        foreach($newValue as $key=>$value){    
            $sql = $sql . " $key=$value,"; 
        }     
        $sql = substr($sql, 0, strlen($sql)-1);
        $sql .= " WHERE";
        $i = 0;
        foreach($conditions as $key=>$value){
            if ($i === 0){
                $sql = $sql . " $key=$value";
            } else{
                $sql = $sql . " AND $key=$value";
            }
            $i++;
        }   
        
        DB::query($sql);
    }
    public static function display($data)
    {
        echo "<pre>", print_r($data, true), "</pre>";
        die();
    }
}
