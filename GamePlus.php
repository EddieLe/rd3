<?php
class Game
{
    var $result = array();
    var $countt = 0;

    function create()
    {
        $time1 = microtime(true);

        for ($i = 0; $i < 3000; $i++) {
            $rand[] = $i + 1;
        }
        shuffle($rand);

        for ($i = 0; $i < 50; $i++) {
            for ($j = 0; $j < 60; $j++) {
                if ($rand[$i * 60 + $j] <= 1200) {
                    $rand[$i * 60 + $j] = "M";
                }
                $this->result[$i][$j] = $rand[$i * 60 + $j];
            }
        }

        for ($i = 0; $i < 50; $i++) {
            for ($j = 0; $j < 60; $j++) {
                if ($this->result[$i][$j] === "M") {
                    continue;
                } else {

                    if ($this->result[$i-1][$j-1] === "M") {
                        $this->countt ++;
                    }
                    if ($this->result[$i-1][$j] === "M") {
                        $this->countt ++;
                    }
                    if ($this->result[$i-1][$j+1] === "M") {
                        $this->countt ++;
                    }
                    if ($this->result[$i][$j-1] === "M") {
                        $this->countt ++;
                    }
                    if ($this->result[$i][$j+1] === "M") {
                        $this->countt ++;
                    }
                    if ($this->result[$i+1][$j-1] === "M") {
                        $this->countt ++;
                    }
                    if ($this->result[$i+1][$j] === "M") {
                        $this->countt ++;
                    }
                    if ($this->result[$i+1][$j+1] === "M") {
                        $this->countt ++;
                    }

                $this->result[$i][$j] = $this->countt;
                $this->countt = 0;
                }
            }
        }
        $time2 = microtime(true);
        // for ($j = 0 ; $j < 50; $j++) {
        //     echo "<tr>";
        //     for ($i = 0 ; $i < 60; $i++) {
        //         echo "<td>" . $this->result[$j][$i] . "</td>";
        //     }
        //     echo "</tr>";
        // }

        for ($j = 0 ; $j < 50; $j++) {
            for ($i = 0 ; $i <= 60; $i++) {
                $re .= $this->result[$j][$i];
            }
            if ($j != 49) {
                $re .= "N";
            }
        }
    // $time = $time2 - $time1;
    // echo  $time ."<br>";
    echo $re;
    }
}

$g = new Game();
// echo ' <table width="300" border="1"> ';
$g->create();
// echo ' </table> ';
