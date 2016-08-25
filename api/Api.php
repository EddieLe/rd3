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
            $sql = "INSERT INTO `accounts`(`username`, `total`) VALUES (:username, 100000)";
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
        if ($_GET['username'] == null || $_GET['transid'] == null || $_GET['amount'] == null || $_GET['type'] == null) {
            $respose = [
                'result' => 'false',
                'data' => ['Message' => 'Lost Parameter']
            ];
            echo json_encode($respose);
            exit;
        }

        if ( $_GET['type'] != 'IN' && $_GET['type'] != 'OUT') {
            $respose = [
                'result' => 'false',
                'data' => ['Message' => 'Type Error']
            ];
            echo json_encode($respose);
            exit;
        }

        $mypdo = new MyPDO();
        $pdo = $mypdo->pdoConnect;
        $sql = "SELECT * FROM `api` WHERE `transid`=:transid";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':transid' => $_GET['transid']]);
        $row = $stmt->fetchall(PDO::FETCH_ASSOC);

        if (count($row) > 0) {
            $respose = [
                'result' => 'false',
                'data' => ['Message' => 'Double Transfer']
            ];
            echo json_encode($respose);
            exit;
        }

        $sql = "UPDATE `api` SET `username`=:username,`transid`=:transid,`amount`=:amount,`type`=:type WHERE `username`=:username";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':username' => $_GET['username'],
            ':transid' => $_GET['transid'],
            ':amount' => $_GET['amount'],
            ':type' => $_GET['type']
            ]);

        if ($stmt->rowCount() > 0) {
            $respose = [
                'result' => 'true',
                'data' => ['Message' => 'Transfer Success']
            ];
        } else {
            $respose = [
                'result' => 'false',
                'data' => ['Message' => 'Transfer Failed']
            ];
        }

    echo json_encode($respose);
    }

    function getUserBalance()
    {
        $mypdo = new MyPDO();
        $pdo = $mypdo->pdoConnect;
        $sql = "SELECT * FROM `accounts` WHERE `username`=:username";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':username' => $_GET['username']]);
        $row = $stmt->fetchall(PDO::FETCH_ASSOC);

        if (count($row) > 0) {
            $respose = [
                'result' => 'true',
                'data' => $row[0]['total']
            ];
        } else {
            $respose = [
                'result' => 'false',
                'data' => ['Message' => 'Not Found']
            ];
        }
    echo json_encode($respose);
    }

    function checkTransfer()
    {

    }
}
?>