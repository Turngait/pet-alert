<?php

try {
    $db = new PDO('mysql:host=localhost;dbname=host1441155_petalert;', 'host1441155_user', 'user1');
    //$prod_all = $db -> query("SELECT * FROM `products`;");
}
catch(PDOException $e) {
    die("Error: ".$e->getMessage());
}

?>