<?php
class GameResult
{
    var $result = array();
    var $countt = 0;

    function create()
    {
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

        // for ($j = 0 ; $j < 10; $j++) {
        //     echo "<tr>";
        //     for ($i = 0 ; $i < 10; $i++) {
        //         $ans = $this->result[$j][$i];
        //         echo "<td>" . "<button id='value' value='$ans' onclick='valueCheck()' style='width:30px;height:30px;'>$ans</input>" . "</td>";
        //     }
        //     echo "</tr>";
        // }

        // for ($j = 0 ; $j < 10; $j++) {
        //     for ($i = 0 ; $i < 10; $i++) {
        //         $re .= $this->result[$j][$i];
        //     }
        //     if ($j != 9) {
        //         $re .= "N";
        //     }
        // }
    session_start();
    $_SESSION['result'] = $this->result;
    return $this->result;
    }

}
?>