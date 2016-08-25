<?php
$aIn = "http://bm-dev.vir888.net/app/presenter.php/updateBalance?username=Eddie_Lee&transid=12343&type=IN&amount=1000";
$bOut = "http://bm-dev.vir888.net/app/presenter.php/transfer?username=Eddie_Lee&transid=12343&type=OUT&amount=1000";

$bIn = "http://bm-dev.vir888.net/app/presenter.php/transfer?username=Eddie_Lee&transid=1232&type=IN&amount=3000";
$aOut = "http://bm-dev.vir888.net/app/presenter.php/updateBalance?username=Eddie_Lee&transid=1232&type=OUT&amount=3000";

$ch=curl_init();
curl_setopt($ch,CURLOPT_URL,$aOut);
curl_setopt($ch,CURLOPT_HEADER,false);
// curl_setopt($ch, CURLOPT_TIMEOUT,5);

curl_exec($ch);

curl_setopt($ch,CURLOPT_URL,$bIn);
curl_setopt($ch,CURLOPT_HEADER,false);
// curl_setopt($ch, CURLOPT_TIMEOUT,5);

curl_exec($ch);