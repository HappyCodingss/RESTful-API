<?php
header("Content-type: application/json");
require "functions.php";

$request_method = $_SERVER['REQUEST_METHOD'];

switch ($request_method) {
    case "GET":
        if (!empty($_GET['id'])) {
            $id = $_GET['id'];
            echo getSongsList($id);
        } else {
            echo getSongsList(null);
        }
        break;
    case "POST":
        echo postSongs();
        break;
    case "PUT":
            echo updateSongsList();
            break;
    case "DELETE":
        if (!empty($_GET['id'])) {
            $id = $_GET['id'];
            echo deleteSong($id);
        } else {
            echo json_encode(array("status" => 400, "message" => "Invalid song ID."));
        }
            break;
}

?>