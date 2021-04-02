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
        $stmt->execute($params);
        if (explode(' ', $query)[0] == "SELECT") {
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }
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
        $sql = 'INSERT INTO ' . $table . '(' . $columns . ') VALUES (' . $data . ')';
       
        $this->query($sql);
    
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
        echo $sql;
        $this->query($sql);
    }
    public function display($data)
    {
        echo "<pre>", print_r($data, true), "</pre>";
        die();
    }
}
$db = new DB("127.0.0.1", "blog", "root", "");
class CustomerInfo
{
    public $id;
    public $name;
    public $pwd;
    public $email;
    public $gender;
    public $phone;
    public $check;
    public function __construct($id, $name, $pwd, $email, $gender, $phone, $check)
    {
        $this->id = $id;
        $this->name = $name;
        $this->pwd = $pwd;
        $this->email = $email;
        $this->gender = $gender;
        $this->phone = $phone;
        $this->check = $check;
    }
}

function updateInfo($db, $customerObject)
{
    if (!isLoggedIn())
        die("Please log in first");
    $db->update('customer', ['id' => $customerObject->id], [
        'name' => '\'' . $customerObject->name. '\'',
        'pwd' => '\''. $customerObject->pwd. '\'',
        'email' => '\''. $customerObject->email. '\'',
        'gender' => '\''. $customerObject->gender. '\'',
        'phone' => '\''. $customerObject->phone. '\''
    ]);
}
function isLoggedIn()
{ #simulates the fetching of the customer id
    $currentUserId = 1;
    return $currentUserId;
}

if (isset($_POST['submit-btn'])) {
    $currentCustomerId = isLoggedIn();
    echo $_POST['name'];
    $customerInfo = new CustomerInfo($currentCustomerId, $_POST['name'], $_POST['pwd'], $_POST['email'], $_POST['gender'], $_POST['phone'], $_POST['check']);
    /*$db->insert('customer', [
        'name' => $customerInfo->name,
        'pwd' => $customerInfo->pwd,
        'email' => $customerInfo->email,
        'gender' => $customerInfo->gender,
        'phone' => $customerInfo->phone
    ]);*/
    updateInfo($db, $customerInfo);
}

?>
<html>

<body>
    <form action="Q2.php" method="post">
        <div class="form-title">Change profile</div>

        <div class="form-item">
            <label>name</label>
            <input type="text" placeholder="name" name="name" class="text-input">
        </div>
        <div class="form-item">
            <label>pwd</label>
            <input type="text" placeholder="pwd" name="pwd" class="text-input">
        </div>
        <div class="form-item">
            <label>email</label>
            <input type="text" placeholder="email" name="email" class="text-input">
        </div> 
        <div class="form-item">
            <label>gender</label>
            <input type="text" placeholder="gender" name="gender" class="text-input">
        </div> 
        <div class="phone">
            <label>phone</label>
            <input type="text" placeholder="phone" name="phone" class="text-input">
        </div> 
        <div class="check">
            <label>check</label>
            <input type="text" placeholder="check" name="check" class="text-input">
        </div>
        <button type="submit" name="submit-btn" class="submit-btn">Post</button>

    </form>
</body>

</html>