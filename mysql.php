<?php
$servername = "localhost:3306";
$username = "root";
$password = "123456";


try {
    $dbh = new PDO('mysql:host=mysql;dbname=test_db', 'root','123456');
    foreach($dbh->query('SELECT * from people') as $row) {
        print_r($row);
    }
    $dbh = null;
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}

?>