<?php
require_once 'GameV3.php';

function GameV()
{
    $g = new Game();
    $re = $g->create();
    echo $re;
}
GameV();

?>