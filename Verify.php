<?php
class Verify
{
    var $countt = 0;
    var $error = 0;

    function verify()
    {
        // $aCheckMap = array(
        //     '01M2M101M1N0123210111N001M100000N0011211000N11101M2110N1M11222M10N1111M22210N000123M100N00001M2100N0000111000',
        //     '0M112MMM20NM532M35M30NMMM2113M41NMM32113MM2NM422M13MM2N13M4334M52N02M4MM3M4MN133M4434M3NM4M5M4M5M3NM4MM3MMM3M',
        //     '2m33m102mmNm5mm4214mmN2mmmm43mm3N136mmmm321N24mm6m4100Nmmm44m2000Nmm6m321111N4mm4m113m2Nm5m4221mm3N2m22m1123m',
        //     '2M21MMMM32N4M435MM7MMNMM3MM5MMMMN4433M44M5MNMM2223M331N23M11M4M21N244333M33MNMMMM3M33M2N35M4M3M321N1M22122M19',
        //     'M223MM322MN35MM33MM32NMMM32344M1N24321MM432N24M2234MM1NMMM32M3232NMMM22M312MN4M43234M53NM6M4M2MMMMNMMMM223M42N',
        //     '1111100000N111m101121NM123311M2MN111MM22231N0125M32M20N01M3M33M20N24332M2110NMMM2221000N3433M32210N1M12M3MM10',
        //     '02MM4M4MM3N13MM5MM7MMN2M324MMMM3NM2213M5M31N333M534231NMM3MMM4M4MN443355MM5MNMM12MM423MN4422MM3011NMM113M%200',
        //     '3M32MMMM3MNMM4M4443M3N34M22M222MNM32223M333NM21M24M5MMN1234M3M5MMN23MM2213MMNMM5420025MNM5MM2002MMN2M4M2002MM',
        //     '4M4M211111N24MM22M33MN1MM533M3MMN235MM2234MN2M4M433M31N3M65M5MM41N3MMMMMMM4MNM6M5M55M42NMM4333M3M1N3M3M2M2214',
        //     '2M4M4MM311NM4MMM7M5M3NM324MMM5MMN22124MM56MN1M22M44MMMN123M33M34MN01M3M43333N01122MM3MMN0011334M4MN222M2M3221NMM2122M100'
        //     );
        // $result = $aCheckMap[0];
        $result = $_GET['map'];
        if (!preg_match('/^[NM0-8]+$/', $result)) {
            echo '不符合,因為輸入只能為數字0~8大寫英文NM組合';
            $this->error ++;
        }

        if (strpos($result, 'm')) {
            $TryStrpos=strpos($result, 'm');
            echo '不符合,因為 m 因該為大寫才可判斷為地雷輸入有誤';
        }

        if (strpos($result, 'n')) {
            $TryStrpos=strpos($result, 'n');
            echo '不符合,因為 n 因該為大寫才可判斷為換行輸入有誤';
        }

        if (!is_string($result)) {
            echo '不符合,因為輸入不為字串';
            $this->error ++;
        }

        if (substr_count($result,'M') != 40 ) {
            $total = substr_count($result,'M');

            if (substr_count($result,'M') < 40) {
                echo '不符合,因為地雷小於40 只有' . $total;
                $this->error ++;
            } else {
                echo '不符合,因為地雷大於40 地雷有' . $total;
                $this->error ++;
            }
        }

        if (strlen($result) != 109) {
            echo '不符合,因為輸入數量不對你的字串長度為' . strlen($result);
            $this->error ++;
        }

        if (substr($result, -1) == 'N') {
            echo '不符合,因為最後不需 +N 換行';
        }

        $rowArray = explode('N', $result);
        for ($i = 0; $i < 10; $i++) {

            if (strlen($rowArray[$i]) != 10) {
                $length = strlen($rowArray[$i]);
                echo '不符合,因為第' . $i . '行長度為' . $length;
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
                        echo '不符合,座標(' . $i . ',' . $j . ')' . '因該是' . $this->countt  .'不是' . $inputArray[$i][$j];
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