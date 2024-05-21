<?php
header("Content-type: application/json");
require "functions.php";

$request_method = $_SERVER['REQUEST_METHOD'];

switch($request_method){
    case "GET" : 
        if(!empty($_GET['id'])){
            $id = $_GET['id'];
            echo getAlbumList($id);
        }
        else{
            echo getAlbumList(null);
        }
        break;

    case "POST":
        echo postAlbum();
        break;

    case "PUT":
            //echo updateSongsList();
            break;
    case "DELETE":
            break;
}
?>