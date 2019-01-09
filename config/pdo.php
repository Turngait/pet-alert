<?php
mb_internal_encoding('UTF-8');
try {
    $db = new PDO('mysql:host=localhost;dbname=pet_alert;charset=utf8mb4', 'root', '');
    //$prod_all = $db -> query("SELECT * FROM `products`;");
}
catch(PDOException $e) {
    die("Error: ".$e->getMessage());
}

?>