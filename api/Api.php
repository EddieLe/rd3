<?php
require_once 'MyPDO.php';

class Api
{
    function create()
    {
        $compaison = md5($_GET['username'] . date("Y/m/d"));
        $result = substr($_GET['key'], -33, -1);
        if ($compaison != $result) {
            $respose = [
                'result' => 'false',
                'data' => ['Message' => 'Key Error']
            ];
            echo json_encode($respose);
            exit;
        }

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
        if ($_GET['amount'] < 0) {
            $respose = [
                'result' => 'false',
                'data' => ['Message' => 'amount < 0']
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

        //判斷入款帳號有無重複
        if (count($row) > 0) {
            $respose = [
                'result' => 'false',
                'data' => ['Message' => 'Double Transfer']
            ];
            echo json_encode($respose);
            exit;
        }

        $sql = "SELECT * FROM `accounts` WHERE `username`=:username";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':username' => $_GET['username']]);
        $row = $stmt->fetchall(PDO::FETCH_ASSOC);

        //判斷帳號有無
        if (count($row) == 0 ) {
            $respose = [
                'result' => 'false',
                'data' => ['Message' => 'Not Found Account']
            ];
            echo json_encode($respose);
            exit;
        }

        $sql = "INSERT INTO `api` (`username`, `transid`, `amount`, `type`) VALUES (:username, :transid, :amount, :type)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':username' => $_GET['username'],
            ':transid' => $_GET['transid'],
            ':amount' => $_GET['amount'],
            ':type' => $_GET['type']
            ]);

        if ($_GET['type'] == 'IN') {
            $sql = "UPDATE `accounts` SET `total` = `total` + :amount WHERE `username`=:username";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':amount' => $_GET['amount'], ':username' => $_GET['username']]);
        } else {
            $sql = "UPDATE `accounts` SET `total` = `total` - :amount WHERE `username`=:username";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':amount' => $_GET['amount'], ':username' => $_GET['username']]);
        }

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
                'data' => ['Money' => $row[0]['total']]
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
        if ($_GET['username'] == null || $_GET['count'] == null) {
            $respose = [
                'result' => 'false',
                'data' => ['Message' => 'Lost Parameter']
            ];
            echo json_encode($respose);
            exit;
        }
        $mypdo = new MyPDO();
        $pdo = $mypdo->pdoConnect;
        $sql = "SELECT * FROM `api` WHERE `username`=:username LIMIT 0 , $_GET[count]";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':username' => $_GET['username']]);
        $row = $stmt->fetchall(PDO::FETCH_ASSOC);

        if (count($row) > 0) {
            $respose = [
                'result' => 'true',
                'data' => $row
            ];
        } else {
            $respose = [
                'result' => 'false',
                'data' => ['Message' => 'Not Found']
            ];
        }
    echo json_encode($respose);
    }
}
