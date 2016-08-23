<?php
class Verify
{
    var $countt = 0;
    var $error = 0;

    function verify()
    {
        // $ch = curl_init();

        // curl_setopt($ch,CURLOPT_URL,"https://eddie-eddie-lee.c9users.io/Game.php");
        // curl_setopt($ch,CURLOPT_HEADER,0);
        // curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

        // $result = curl_exec($ch);
        // echo $result . '<br>';
        $result = $_GET['map'];
        if (!preg_match('/^[NM0-8]+$/', $result)) {
            echo '不符合,因為輸入只能為數字0~8大寫英文NM組合' . '<br>';
            $this->error ++;
        }

        if (!is_string($result)) {
            echo '不符合,因為輸入不為字串';
            $this->error ++;
        }

        if (substr_count($result,'M') != 40 ) {
            $total = substr_count($result,'M');

            if (substr_count($result,'M') < 40) {
                echo '不符合,因為地雷小於40 只有' . $total . '<br>';
                $this->error ++;
            } else {
                echo '不符合,因為地雷大於40 地雷有' . $total . '<br>';
                $this->error ++;
            }
        }

        if (strlen($result) != 109) {
            echo '不符合,因為數量不對' . '<br>';
            $this->error ++;
        }

        $rowArray = explode('N', $result);
        for ($i = 0; $i < 10; $i++) {

            if (strlen($rowArray[$i]) != 10) {
                $length = strlen($rowArray[$i]);
                echo '不符合,因為第' . $i . '行長度為' . $length . '<br>';
                $this->error ++;
            }
        }
        $removeResult = str_replace('N', '', $result);
        $onlyArray = preg_split('//', $removeResult, -1, PREG_SPLIT_NO_EMPTY);

        for ($i = 0; $i < 10; $i++) {
            for ($j = 0; $j < 10; $j++) {
                $inputArray[$i][$j] = $onlyArray[$i * 10 + $j];
            }
        }

        for ($i = 0; $i < 10; $i++) {
            for ($j = 0; $j < 10; $j++) {
                if ($inputArray[$i][$j] === "M") {
                    continue;
                } else {

                    if ($inputArray[$i-1][$j-1] === "M") {
                        $this->countt ++;
                    }
                    if ($inputArray[$i-1][$j] === "M") {
                        $this->countt ++;
                    }
                    if ($inputArray[$i-1][$j+1] === "M") {
                        $this->countt ++;
                    }
                    if ($inputArray[$i][$j-1] === "M") {
                        $this->countt ++;
                    }
                    if ($inputArray[$i][$j+1] === "M") {
                        $this->countt ++;
                    }
                    if ($inputArray[$i+1][$j-1] === "M") {
                        $this->countt ++;
                    }
                    if ($inputArray[$i+1][$j] === "M") {
                        $this->countt ++;
                    }
                    if ($inputArray[$i+1][$j+1] === "M") {
                        $this->countt ++;
                    }
                    if ($inputArray[$i][$j] != $this->countt) {
                        echo '不符合,座標(' . $i . ',' . $j . ')' . '因該是' . $this->countt  .'不是' . $inputArray[$i][$j] . '<br>';
                        $this->error ++;
                    }
                $this->countt = 0;
                }
            }
        }
        if ($this->error == 0) {
            echo '符合';
        }
    $this->error = 0;
    }
}
new Verify();