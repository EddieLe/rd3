<?php
require_once 'MyPDO.php';

class Api
{
    function create()
    {
        $mypdo = new MyPDO();
        $pdo = $mypdo->pdoConnect;
        $sql = "SELECT * FROM `accounts` WHERE `username` = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':username' => $_GET['username']]);
        $row = $stmt->fetchall(PDO::FETCH_ASSOC);

        if (count($row) == 0) {
            $sql = "INSERT INTO `accounts`(`username`, `total`) VALUES (:username, 0)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':username' => $_GET['username']]);
            $sql = "INSERT INTO `api`(`username`) VALUES (:username)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':username' => $_GET['username']]);

            $respose = [
                'result' => 'true',
                'data' => ['Message' => 'Create Success']
            ];
        } else {
            $respose = [
                'result' => 'false',
                'data' => ['Message' => 'Double Account']
            ];
        }

    echo json_encode($respose);
    }

    function transfer()
    {
        $mypdo = new MyPDO();
        $pdo = $mypdo->pdoConnect;
        $sql = "UPDATE `api` SET `username`=:username,`transid`=:transid,`amount`=:amount,`type`=:type WHERE `username`=:username";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':username' => $_GET['username'],
            ':transid' => $_GET['transid'],
            ':amount' => $_GET['amount'],
            ':type' => $_GET['type']
            ]);
        $respose = [
                'result' => 'true',
                'data' => ['Message' => 'Transfer Success']
            ];

    }

    function getUserBalance()
    {

    }

    function checkTransfer()
    {

    }
}
?>