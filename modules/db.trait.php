<?php

trait t_DB 
{
  public function getSimpleInfo($db, $table)
  {
    $query = "SELECT * FROM `$table`;";

    $check = $db->prepare($query);
    $check->execute();
    $info = $check->fetchAll();

    return $info;
  }

  public function getWhereIntInfo($db, $table, $by, $value, $isAll=false)
  {
    $value = (int) $value;
    $query = "SELECT * FROM `$table` WHERE $by=$value";

    $check = $db->prepare($query);
    $check->execute();

    if($isAll) {
        $info = $check->fetchAll(PDO::FETCH_ASSOC);

        return $info;
    }

    $info = $check->fetch(PDO::FETCH_ASSOC);

    return $info;
  }

  public function getWhereStrInfo($db, $table, $by, $value, $isAll=false)
  {
    $query = "SELECT * FROM `$table` WHERE $by=:value";

    $check = $db->prepare($query);
    $check->execute([':value' => $value]);

    if($isAll) {
        $info = $check->fetchAll(PDO::FETCH_ASSOC);

        return $info;
    }

    $info = $check->fetch(PDO::FETCH_ASSOC);

    return $info;
  }

  public function getSimpleInfoOrderByInt($db, $table, $orderby, $order='DESC')
  {
    $query = "SELECT * FROM `$table` ORDER BY $orderby $order;";

    $check = $db->prepare($query);
    $check->execute();
    $info = $check->fetchAll();

    return $info;
  }
}