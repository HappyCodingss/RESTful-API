<?php
session_start();

if (isset($_POST['submit'])) {
    require 'curl_helper.php';

    $url = "http://localhost/DARANG-LAB_ACTIVITY3/";

    $data = array(
        "album_name" => $_POST['album'],
        "artist" => $_POST['artist'],
        "genre" => $_POST['genre'],
        "year_released" => $_POST['year']
    );

    $response = curlCall($url, "POST", $data, null, 'albums');

    if (isset($response) && $response->status == 201) {
        $_SESSION['album_id'] = $response->album_id;
        $_SESSION['album_name'] = $_POST['album'];
        $_SESSION['artist'] = $_POST['artist'];
        $_SESSION['genre'] = $_POST['genre'];
        $_SESSION['year_released'] = $_POST['year'];
        header("Location: addSongs.php");
        exit();
    } else {
        echo '<script>Swal.fire({
            title: "Cannot add album!",
            text: "Cannot add",
            icon: "error"
        });</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="sweetalert2.min.css">
    <title>SoundNEXUS</title>
    <style>
        .container {
            display: grid;
            place-items: center;
            margin-top: 200px;
            width: 700px;
        }
        form, .col-auto {
            width: 100%;
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="mb-4">Add Album</h1>
    <form class="form-floating" action="index.php" method="POST">
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="floatingInput" name="album" placeholder="Album Name" required>
            <label for="floatingInput">Album Name</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="artist" id="floatingArtists" placeholder="Artist Name" required>
            <label for="floatingArtists">Artists Name</label>
        </div>
        <div class="form-floating mb-3">
            <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="genre" required>
                <option value="" disabled selected>Select Genre...</option>
                <option value="Pop Music">Pop Music</option>
                <option value="Rock">Rock</option>
                <option value="Jazz">Jazz</option>
                <option value="Folk Music">Folk Music</option>
                <option value="Christian Music">Christian Music</option>
            </select>
            <label for="floatingSelect">Select Genre</label>
        </div>
        <div class="form-floating mb-3">
            <input type="date" class="form-control" id="floatingdate" name="year" required>
            <label for="floatingdate">Date Released</label>
        </div>
        <div class="col-auto">
            <button type="submit" name="submit" class="btn btn-primary p-3 mt-5" style="width:100%">Create Album</button>
        </div>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://kit.fontawesome.com/50d7261171.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
