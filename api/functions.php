<?php
 require 'dbconn.php';


//this is for the album

function postAlbum(){
   global $conn;
    $name = $_POST['album_name'];
    $artist = $_POST['artist'];
    $genre = $_POST['genre'];
    $year_released = $_POST['year_released'];
    $sql = "INSERT INTO `album`(`album_name`, `artist`, `genre`, `year_released`) VALUES ('$name','$artist','$genre','$year_released')";
    $query = $conn->query($sql);
    if ($query){
        $album_id = $conn->insert_id;
        $response=[
          "status" => 201,
            "message" => "Record saved!",
            "album_id" => $album_id
        ];
    }else{
        $response=[
            "status" => 400,
            "message" => "Error: ",
        ];
    }
    return json_encode($response);

}


function getAlbumList($id){
    global $conn;
    
    if($id != null){
     $sql = "SELECT * FROM `album`";
    }
    else{
        $sql = "SELECT * FROM `album` WHERE album_id = $id or album_name = $id";
    }
     $query = $conn->query($sql);
     if ($query){
         $response=[
           "status" => 200,
             "message" => "Successful get the data",
         ];
     }else{
         $response=[
             "status" => 400,
             "message" => "Error: ",
         ];
     }
     return json_encode($response);
 }



function updateAlbumList($id){
    global $conn;
    $sql = "UPDATE `album` SET `album_id`='[value-1]',`album_name`='[value-2]',`artist`='[value-3]',`genre`='[value-4]',`year_released`='[value-5]' WHERE album_id = $id";
    $query = $conn->query($sql);
    if ($query){
        $response=[
          "status" => 201,
            "message" => "Record saved!",
        ];
    }else{
        $response=[
            "status" => 400,
            "message" => "Error: ",
        ];
    }
    return json_encode($response);

}
function deleteAlbum($id){
    global $conn;
    $sql = "DELETE FROM `album` WHERE album_id = $id";
    $query = $conn->query($sql);
    if ($query){
        $response=[
          "status" => 200,
            "message" => "Deleted!",
        ];
    }else{
        $response=[
            "status" => 400,
            "message" => "Error: ",
        ];
    }
    return json_encode($response);

}
    //This is for the songs

    //add to the database
    function postSongs(){
        global $conn;
        $album_id = $_POST['album_id'];
        $title = $_POST['title'];
        $url = $_POST['audio'];
    
        $sql = "INSERT INTO `songs`(`album_id`, `title`, `audio_file`) VALUES ('$album_id','$title','$url')";
        $query = $conn->query($sql);
        if($query){
            $response=[
                "status" => 201,
                  "message" => "Record saved!",
              ];
        }
        else{
            $response=[
                "status" => 400,
                "message" => "Error: ",
            ];
        }
        return json_encode($response); 
    }

    //get data from the database

    function getSongsList($album_id) {
        global $conn;
        
        if ($album_id != null) {
            $sql = "SELECT * FROM `songs` WHERE album_id = $album_id";
        } else {
            $sql = "SELECT * FROM `songs`";
        }
        $query = $conn->query($sql);
        
        if ($query) {
            $songs = [];
            while ($row = $query->fetch_assoc()) {
                $songs[] = $row;
            }
            $response = [
                "status" => 200,
                "data" => $songs
            ];
        } else {
            $response = [
                "status" => 400,
                "message" => "Error: " . $conn->error
            ];
        }
        return json_encode($response);
    }
    //update 

    function updateSongsList() {
        global $conn;
        parse_str(file_get_contents("php://input"), $input);
        $id = $input['id'];
        $title = $input['title'];
        $audio = $input['audio'];
        
        $sql = "UPDATE `songs` SET `title`='$title', `audio_file`='$audio' WHERE `song_id` = $id";
        
        $result = $conn->query($sql);
        if ($result) {
            $response = [
                "status" => 200,
                "message" => "Record updated!",
            ];
        } else {
            $response = [
                "status" => 400,
                "message" => "There's something wrong",
            ];
        }
        return json_encode($response);
    }
    
    
    
    //delete 
    function deleteSong($id){
        global $conn;
        $sql = "DELETE FROM `songs` WHERE song_id = $id";
        $query = $conn->query($sql);
        if ($query){
            $response=[
              "status" => 200,
                "message" => "Record saved!",
            ];
        }else{
            $response=[
                "status" => 400,
                "message" => "Error: ",
            ];
        }
        return json_encode($response);
    
    }
?>