<?php
require 'curl_helper.php';
require 'api/dbconn.php';

if (isset($_GET['id'])) {
    $songId = $_GET['id'];
    $url = "http://localhost/DARANG-LAB_ACTIVITY3/";
    $deleteSongResponse = curlCall($url, "DELETE", null, $songId, 'songs');

    if ($deleteSongResponse && isset($deleteSongResponse->status)) {
        echo json_encode($deleteSongResponse); 
        exit();
    }
}
echo json_encode(array("status" => 400, "message" => "Failed to delete song."));
exit();
?>
