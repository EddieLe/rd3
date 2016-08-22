<?php
class Game
{
    var $result = array();
    var $countt = 0;

    function create()
    {
        $count = 0;

        for ($i = 0; $i < 100; $i++) {
            $rand[] = $i + 1;
        }
        shuffle($rand);

        for ($i = 0; $i < 10; $i++) {
            for ($j = 0; $j < 10; $j++) {
                if ($rand[$i * 10 + $j] <= 40) {
                    $rand[$i * 10 + $j] = "M";
                }
                $this->result[$i][$j] = $rand[$i * 10 + $j];
            }
        }

        for ($i = 0; $i < 10; $i++) {
            for ($j = 0; $j < 10; $j++) {
                if ($this->result[$i][$j] == "M") {
                    $this->result[$i][$j] = "M";
                } else {

                    if ($this->result[$i-1][$j-1] == "M") {
                        $this->countt ++;
                    }
                    if ($this->result[$i-1][$j] == "M") {
                        $this->countt ++;
                    }
                    if ($this->result[$i-1][$j+1] == "M") {
                        $this->countt ++;
                    }
                    if ($this->result[$i][$j-1] == "M") {
                        $this->countt ++;
                    }
                    if ($this->result[$i][$j+1] == "M") {
                        $this->countt ++;
                    }
                    if ($this->result[$i+1][$j-1] == "M") {
                        $this->countt ++;
                    }
                    if ($this->result[$i+1][$j] == "M") {
                        $this->countt ++;
                    }
                    if ($this->result[$i+1][$j+1] == "M") {
                        $this->countt ++;
                    }

                $this->result[$i][$j] = $this->countt;
                $this->countt = 0;
                }
            }

        }

        // for ($j = 0 ; $j < 10; $j++) {
        //     echo "<tr>";
        //     for ($i = 0 ; $i < 10; $i++) {
        //         echo "<td>".$this->result[$j][$i]."</td>";
        //     }
        //     echo "</tr>";
        // }

        for ($j = 0 ; $j < 10; $j++) {
            for ($i = 0 ; $i <= 10; $i++) {
                if ($i == 10 && $j != 9) {
                    echo "N";
                }
                echo $this->result[$j][$i];
            }

        }


    }
}
$g = new Game();
// echo ' <table width="300" border="1"> ';
$g->create();
// echo ' </table> ';
