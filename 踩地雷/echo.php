<?php

session_start();
$position = explode(',',$_POST['value']);
$checkPosition = $_SESSION['result'][$position[0]][$position[1]];
$checkPositionAll = array('position' => $checkPosition, 'y' => $position[0], 'x' => $position[1]);

echo json_encode($checkPositionAll);

?>