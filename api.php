
<?php
    $curl = curl_init();
    curl_setopt ($curl, CURLOPT_URL, "http://www.amiiboapi.com/api/amiibo/");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec ($curl);
    curl_close ($curl);
    $data = json_decode($result,true);
    echo $result;

?>