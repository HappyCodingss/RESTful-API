<?php
function curlCall($url, $method, $data = null, $id = null, $type) {
    $endpoint = strtolower($type) === 'albums' ? 'albums' : 'songs';
    $fullUrl = $url . "api/$endpoint/" . ($id ? $id : '');

    $ch = curl_init($fullUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    switch ($method) {
        case "GET":
            curl_setopt($ch, CURLOPT_HTTPGET, true);
            break;
        case "POST":
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
            break;
        case "PUT":
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            break;
        case "DELETE":
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
            break;
    }

    $response = curl_exec($ch); // execute
    $result = json_decode($response); // response with JSON
    curl_close($ch); // close

    return $result; // return
}
?>
