<?php
class Zero
{
    var $porsition = array();

    function sreach()
    {
        session_start();
        for ($j = 0; $j < count($_SESSION['result']); $j++) {
            for ($i = 0; $i <count($_SESSION['result'][0]); $i++) {
                if ($_SESSION['result'][$j][$i] == 0 && $_SESSION['result'][$j][$i] !== "M") {
                    $this->read($j, $i);
                }
            }
        }
        // var_dump($this->porsition);
    }
    function read($j, $i)
    {
        // $this->porsition[] = array($j,$i);
        // array_push($this->porsition,array($j,$i));

        if ($_SESSION['result'][$j-1][$i] == 0 && $_SESSION['result'][$j][$i] !== "M") {
            $this->read($j-1, $i);
        }
        if ($_SESSION['result'][$j][$i-1] == 0 && $_SESSION['result'][$j][$i] !== "M") {
            $this->read($j, $i-1);
        }
        if ($_SESSION['result'][$j+1][$i] == 0 && $_SESSION['result'][$j][$i] !== "M") {
            $this->read($j+1, $i);
        }
        if ($_SESSION['result'][$j][$i+1] == 0 && $_SESSION['result'][$j][$i] !== "M") {
            $this->read($j, $i+1);
        }
    }

}

$z = new Zero();
$z->sreach();

?>